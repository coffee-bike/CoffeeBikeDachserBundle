<?php


namespace CoffeeBike\DachserBundle\Services;

use CoffeeBike\DachserBundle\Entity\Response;
use CoffeeBike\DachserBundle\Entity\ResponseMessage;
use Symfony\Component\HttpKernel\KernelInterface;
use phpseclib\Net\SFTP;

class DachserManager
{
    private $sftp = null;

    private $credentials = array(
        "dachser_customer_number_warehouse" => null,
        "dachser_storage_customer_number" => null,
        "dachser_customer_number_principal" => null,
        "dachser_sftp_host" => null,
        "dachser_sftp_port" => null,
        "dachser_sftp_username" => null,
        "dachser_sftp_password" => null,
        "dachser_sftp_remote_in_path" => null,
        "dachser_sftp_remote_out_path" => null,
        "dachser_sftp_remote_in_save_path" => null,
        "dachser_sftp_local_dir" => null,
        "dachser_sftp_local_in_path" => null,
        "dachser_sftp_local_in_tmp" => null,
        "dachser_sftp_local_in_save_path" => null,
        "dachser_sftp_local_out_path" => null,
        "dachser_sftp_local_out_tmp" => null,
    );

    private $projectDir = null;

    /**
     * DachserManager constructor.
     * @param $dachser_customer_number_warehouse
     * @param $dachser_storage_customer_number
     * @param $dachser_customer_number_principal
     * @param $dachser_sftp_host
     * @param $dachser_sftp_port
     * @param $dachser_sftp_username
     * @param $dachser_sftp_password
     * @param $dachser_sftp_remote_in_path
     * @param $dachser_sftp_remote_out_path
     * @param $dachser_sftp_remote_in_save_path
     * @param $dachser_sftp_local_dir
     * @param $dachser_sftp_local_in_path
     * @param $dachser_sftp_local_in_tmp
     * @param $dachser_sftp_local_in_save_path
     * @param $dachser_sftp_local_out_path
     * @param $dachser_sftp_local_out_tmp
     * @param $projectDir
     * @throws \Exception
     */
    public function __construct(
        $dachser_customer_number_warehouse,
        $dachser_storage_customer_number,
        $dachser_customer_number_principal,
        $dachser_sftp_host,
        $dachser_sftp_port,
        $dachser_sftp_username,
        $dachser_sftp_password,
        $dachser_sftp_remote_in_path,
        $dachser_sftp_remote_out_path,
        $dachser_sftp_remote_in_save_path,
        $dachser_sftp_local_dir,
        $dachser_sftp_local_in_path,
        $dachser_sftp_local_in_tmp,
        $dachser_sftp_local_in_save_path,
        $dachser_sftp_local_out_path,
        $dachser_sftp_local_out_tmp,
        $projectDir
    ) {
        $this->credentials["dachser_customer_number_warehouse"] = $dachser_customer_number_warehouse;
        $this->credentials["dachser_storage_customer_number"] = $dachser_storage_customer_number;
        $this->credentials["dachser_customer_number_principal"]   = $dachser_customer_number_principal;
        $this->credentials["dachser_sftp_host"] = $dachser_sftp_host;
        $this->credentials["dachser_sftp_port"] = $dachser_sftp_port;
        $this->credentials["dachser_sftp_username"] = $dachser_sftp_username;
        $this->credentials["dachser_sftp_password"] = $dachser_sftp_password;
        $this->credentials["dachser_sftp_remote_in_path"] = $dachser_sftp_remote_in_path;
        $this->credentials["dachser_sftp_remote_out_path"] = $dachser_sftp_remote_out_path;
        $this->credentials["dachser_sftp_remote_in_save_path"] = $dachser_sftp_remote_in_save_path;
        $this->credentials["dachser_sftp_local_dir"] = $dachser_sftp_local_dir;
        $this->credentials["dachser_sftp_local_in_path"] = $dachser_sftp_local_in_path;
        $this->credentials["dachser_sftp_local_in_tmp"] = $dachser_sftp_local_in_tmp;
        $this->credentials["dachser_sftp_local_in_save_path"] = $dachser_sftp_local_in_save_path;
        $this->credentials["dachser_sftp_local_out_path"] = $dachser_sftp_local_out_path;
        $this->credentials["dachser_sftp_local_out_tmp"] = $dachser_sftp_local_out_tmp;

        $this->projectDir = $projectDir;

        $this->sftp = new SFTP($dachser_sftp_host);

        if (!$this->sftp->login($dachser_sftp_username, $dachser_sftp_password)) {
            throw new \Exception(sprintf("Login %s failed with user %s", $dachser_sftp_host, $dachser_sftp_username));
        }

        if (!$this->checkAndCreateLocalDirectories()) {
            throw new \Exception("Directories for SFTP cannot created");
        }
    }

    /**
     * Destructer for SFTP class
     */
    public function __destruct()
    {
        unset($this->sftp);
    }


    /**
     * Get single Credential for key
     *
     * @param $credential
     * @return string
     */
    public function getCredential($credential)
    {
        if (isset($this->credentials[$credential])) {
            return $this->credentials[$credential];
        }
        return null;
    }

    /**
     * Makes data array to csv string
     *
     * @param $data
     * @return string
     */
    public function prepareData(array $data): string
    {
        $strCSV = "";
        if (is_array($data)) {
            foreach ($data as $obj) {
                $data = $obj->getData();
                foreach ($data  as $key => $field) {
                    $strCSV .= $field . ";";
                }
                $strCSV .= "\n";
            }
            $strCSV = substr($strCSV, 0, -2); // Delete \n from CSV
        } else {
            foreach ($data->getData() as $field) {
                $strCSV .= $field . ";";
            }
        }

        return utf8_decode($strCSV);
    }

    /**
     * Send deliverydata csv to remote server
     *
     * @param $deliveries
     * @return bool
     * @throws \Exception
     */
    public function send($deliveries)
    {
        $this->createFileAndSendToSftpServer($this->prepareData($deliveries));

        return $deliveries;
    }

    /**
     * Fetch file from sftp server and create response objects
     *
     * @throws \Exception
     */
    public function fetch()
    {
        $files = $this->fetchFilesFromSftpToTmp();

        if (empty($files)) {
            return false;
        }

        $response = new Response();

        foreach ($files as $file) {
            $responseObjects = array();
            $handle = fopen($file['filepath'],'r');
            $counter = 0;
            while ($line = fgetcsv($handle, 0, ';', '"')) {
                // Skip header of csv
                if (!$counter) {
                    continue;
                }
                $responseObjects[] = $line;
                $counter++;
            }
            fclose($handle);

            foreach ($responseObjects as $responseObject) {
                $response->addObject($file['type'], $responseObject);
            }
        }

        return $response;
    }

    /**
     * Check and create local directories for the API files
     *
     * @return bool
     * @throws \Exception
     */
    public function checkAndCreateLocalDirectories(): bool
    {
        $directories = [
            'dachser_sftp_local_dir' => $this->getCredential('dachser_sftp_local_dir'),
            'dachser_sftp_local_in_path' => $this->getCredential('dachser_sftp_local_dir') . $this->getCredential('dachser_sftp_local_in_path'),
            'dachser_sftp_local_out_path' => $this->getCredential('dachser_sftp_local_dir') . $this->getCredential('dachser_sftp_local_out_path'),
            'dachser_sftp_local_out_tmp' => $this->getCredential('dachser_sftp_local_dir') . $this->getCredential('dachser_sftp_local_out_tmp'),
            'dachser_sftp_local_in_save_path' => $this->getCredential('dachser_sftp_local_dir') . $this->getCredential('dachser_sftp_local_in_save_path'),
            'dachser_sftp_local_in_tmp' => $this->getCredential('dachser_sftp_local_dir') . $this->getCredential('dachser_sftp_local_in_tmp'),
        ];
        // default dir ist ./bin
        // But the logic wants into project dir
        chdir($this->projectDir);

        foreach ($directories as $directoryKey => $directory) {
            if (empty($directoryKey)) {
                throw new \Exception(sprintf("Settings key %s is empty. Please set!", $directoryKey));
            }
            $this->createDirIfNotExists($directory);
        }
        return true;
    }

    /**
     * Check if a directory already exists, if not create it
     *
     * @param string $directoryName
     * @return bool
     */
    private function createDirIfNotExists(string $directoryName): bool
    {
        //Check if the directory already exists.
        if(!is_dir($directoryName)){
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755, true);
        }

        return true;
    }

    /**
     * Create temp file for Dachser CSV API and copy it to remote server
     *
     * @param $data
     * @return string
     * @throws \Exception
     */
    private function createFileAndSendToSftpServer($data): bool
    {
        // Change to projectDir
        chdir($this->projectDir);

        $filename = sprintf("LAGER%s.CSV", date('YmdHis'));
        $filepathTmp = $this->getCredential('dachser_sftp_local_dir') . $this->getCredential('dachser_sftp_local_in_tmp') . '/' . $filename;
        $filepathIn = $this->getCredential('dachser_sftp_local_dir') . $this->getCredential('dachser_sftp_local_in_path') . '/' . $filename;
        $filePathRemoteIn = $this->getCredential('dachser_sftp_remote_in_path') . '/' . $filename;

        // put delivery contents to temp file
        if (!file_put_contents($filepathTmp, $data)) {
            throw new \Exception(sprintf("File %s cannot written to %s", $filename, $filepathTmp));
        }

        // put the generated temp file to remote directory
        if (!$this->sftp->put($filePathRemoteIn, $filepathTmp, SFTP::SOURCE_LOCAL_FILE)) {
            throw new \Exception(sprintf("Upload file from %s to %s failed", $filepathTmp, $filePathRemoteIn));
        }

        // put the generated temp file to remote directory
        if (!rename($filepathTmp, $filepathIn)) {
            throw new \Exception(sprintf("Failed to copy tempfile %s to %s", $filepathTmp, $filepathIn));
        }

        return true;
    }

    /**
     * Fetching Files from sftp remote Folder
     *
     * @return array
     * @throws \Exception
     */
    private function fetchFilesFromSftpToTmp(): array
    {
        // Change to projectDir
        chdir($this->projectDir);

        $localTmpFiles = [];
        $remoteOutPath = $this->getCredential('dachser_sftp_remote_out_path');
        $localOutTmp = $this->getCredential('dachser_sftp_local_dir') . '/' . $this->getCredential('dachser_sftp_local_out_tmp');

        if (!$this->sftp->chdir($remoteOutPath)) {
            throw new \Exception(sprintf("Failed to change directory to %s", $remoteOutPath));
        }

        $files = $this->sftp->nlist();

        foreach ($files as $file) {
            $this->sftp->get($remoteOutPath . '/' . $file, $localOutTmp . '/' . $file);
            $fileType = preg_match('/([a-z]{5})+[a-z0-9]{0,}\.csv/i', $file);
            $localTmpFiles[] = [
                'filepath' => $localOutTmp . '/' . $file,
                'type' => $fileType[1],
                'filename' => $file,
            ];
        }

        return $localTmpFiles;
    }

    public function moveProcessedOutFile($filepath) {
        // TODO: CHECK
        $processedOutFilePath = str_replace($this->getCredential('dachser_sftp_local_out_tmp'), $this->getCredential('dachser_sftp_local_out_path'), $filepath);
        if (!rename($filepath, $processedOutFilePath)) {
            throw new \Exception(sprintf("Failed to move processed tmp file %s to %s", $filepath, $processedOutFilePath));
        }

        return true;
    }
}
