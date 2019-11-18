<?php


namespace CoffeeBike\DachserBundle\Services;

use CoffeeBike\DachserBundle\Entity\Response;
use phpseclib\Net\SFTP;

class DachserManager
{
    protected $sftp = null;

    protected $credentials = array(
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

    protected $projectDir = null;

    // Init local path variables
    protected $localDir = null;
    protected $localInDir = null;
    protected $localInTmpDir = null;
    protected $localInSaveDir = null;
    protected $localOutDir = null;
    protected $localOutTmpDir = null;

    // init remote path variables
    protected $remoteInDir = null;
    protected $remoteInSaveDir = null;
    protected $remoteOutDir = null;

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

        $this->sftp = new SFTP($dachser_sftp_host);

        if (!$this->sftp->login($dachser_sftp_username, $dachser_sftp_password)) {
            throw new \Exception(sprintf("Login %s failed with user %s", $dachser_sftp_host, $dachser_sftp_username));
        }

        // Setting project root dir where the folders for Dachser are in it
        $this->projectDir = $projectDir;

        // Setting local path variables
        $this->localDir = $projectDir . '/' . $dachser_sftp_local_dir;
        $this->localInDir = $this->localDir . $dachser_sftp_local_in_path;
        $this->localInTmpDir = $this->localDir . $dachser_sftp_local_in_tmp;
        $this->localInSaveDir = $this->localDir . $dachser_sftp_local_in_save_path;
        $this->localOutDir = $this->localDir . $dachser_sftp_local_out_path;
        $this->localOutTmpDir = $this->localDir . $dachser_sftp_local_out_tmp;

        // Setting remote path variables
        $this->remoteInDir = $dachser_sftp_remote_in_path;
        $this->remoteInSaveDir = $dachser_sftp_remote_in_save_path;
        $this->remoteOutDir = $dachser_sftp_remote_out_path;

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
     * Group Dachser Response File by reference and add DachserId DachserNve and DachserShippmentId to it
     *
     * @param Response $responses
     * @return array
     */
    public function groupDeliveryResponseByReference(Response $responses): array
    {
        $groupedResponse = [];

        // Parse response objects
        foreach ($responses->getObjects() as $object) {
            // Get reference, DachserId, DachserNve and DachserShippmentId
            $reference = $object->getField('auftrraggeber_referenz_1');
            $dachserId = $object->getField('lieferauftragsnummer_mikado');
            $dachserNve = $object->getField('versand_nve');
            $dachserShippmentId = $object->getField('sendungsnummer_dachser');

            // Check if group in array exists, if not create new group and initiate with placeholder items
            if (!isset($groupedResponse[$reference])) {
                $groupedResponse[$reference] = [
                    'dachserId' => [],
                    'dachserNve' => [],
                    'dachserShippmentId' => [],
                ];
            }

            // Add DachserId, DachserNve and DachserShippmentId to group
            $groupedResponse[$reference]['dachserId'][$dachserId] = $dachserId;
            $groupedResponse[$reference]['dachserNve'][$dachserNve] = $dachserNve;
            $groupedResponse[$reference]['dachserShippmentId'][$dachserShippmentId] = $dachserShippmentId;
        }

        return $groupedResponse;
    }

    /**
     * Fetch file from sftp server and create response objects
     *
     * @throws \Exception
     */
    public function fetchFileToDachserResponses(array $fileInformations)
    {
        if (!file_exists($fileInformations['filepath'])) {
            throw new \Exception(sprintf("File %s not exists!", $fileInformations['filepath']));
        }

        $response = new Response();

        $handle = fopen($fileInformations['filepath'],'r');

        // Setting skip for first line of csv (header line) to true and later if skipped to false
        $skip = true;

        while ($line = fgetcsv($handle, 0, ';')) {
            // Skip header of csv
            if ($skip) {
                $skip = false;
                continue;
            }
            $response->addObject($fileInformations['type'], $line);
        }

        fclose($handle);

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
            'localInDir' => $this->localInDir,
            'localInTmpDir' => $this->localInTmpDir,
            'localInSaveDir' => $this->localInSaveDir,
            'localOutDir' => $this->localOutDir,
            'localOutTmpDir' => $this->localOutTmpDir,
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
    protected function createDirIfNotExists(string $directoryName): bool
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
    protected function createFileAndSendToSftpServer($data): bool
    {
        // Change to projectDir
        chdir($this->projectDir);

        $filename = sprintf("LAGER%s.CSV", date('YmdHis'));
        $filepathTmp = $this->localInTmpDir . '/' . $filename;
        $filepathIn = $this->localInDir . '/' . $filename;
        $filePathRemoteIn = $this->remoteInDir . '/' . $filename;

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
    public function fetchFilesFromSftpToTmp(): array
    {
        // Change to projectDir
        chdir($this->projectDir);

        $downloadedFiles = [];
        $remoteOutPath = $this->remoteOutDir;
        $localOutTmp = $this->localOutTmpDir;
        $localOutPath = $this->localOutDir;

        if (!$this->sftp->chdir($remoteOutPath)) {
            throw new \Exception(sprintf("Failed to change directory to %s", $remoteOutPath));
        }

        $files = $this->sftp->nlist();

        foreach ($files as $file) {
            if (in_array($file, [".", ".."])) {
                continue;
            }
            $remoteFilePath = $remoteOutPath . '/' . $file;
            $localTmpFilePath = $localOutTmp . '/' . $file;
            $localOutFilePath = $localOutPath . '/' . $file;

            // Check if file is already downloaded to out/temp directory
            if (file_exists($localTmpFilePath)) {
                dump(sprintf("File %s already exists in %s", $file, $localTmpFilePath));
                continue;
            }

            // Check if file is already exists in out directory -> is already processed
            if (file_exists($localOutFilePath)) {
                dump(sprintf("File %s already exists in %s", $file, $localTmpFilePath));
                continue;
            }

            // get file from SFTP and save to tmp dir
            if (!$this->sftp->get($remoteFilePath, $localTmpFilePath)) {
                throw new \Exception(sprintf("Cannot get file %s from SFTP-Server to %s", $remoteFilePath, $localTmpFilePath));
            }

            // save filename for return
            $downloadedFiles[] = $file;

            // delete from remote SFTP Server if transfered
            if (!$this->sftp->delete($remoteFilePath, false)) {
                throw new \Exception(sprintf("Cannot remove file %s from SFTP-Server", $remoteFilePath));
            }
        }

        return $downloadedFiles;
    }

    /**
     * Move processed temporary file to final out file
     *
     * @param $file
     * @return bool
     * @throws \Exception
     */
    public function moveProcessedTmpFileToOutFile($file): bool
    {
        $fromFilePath = $this->localOutTmpDir.'/'.$file;
        $toFilePath = $this->localOutDir.'/'.$file;

        // Move file to out directory for backup and further check if file already downloaded
        if (!rename($fromFilePath, $toFilePath)) {
            throw new \Exception(sprintf("Failed to move processed tmp file %s to %s", $fromFilePath, $toFilePath));
        }

        return true;
    }

    /**
     * Process Dachser files in temporary directory and return type, name and path of the file in an array
     *
     * @return array
     * @throws \Exception
     */
    public function fetchDachserTmpFiles(): array
    {
        $localOutTmp = $this->localOutTmpDir;

        $fileInformations = [];

        $files = glob($localOutTmp . '/*');

        if (false === $files) {
            throw new \Exception(sprintf("Unable to parse %s directory. Check existence and permission if directory!", $localOutTmp));
        }

        foreach ($files as $file) {
            $filename = basename($file);
            $fileInformations[] = [
                'filepath' => $file,
                'type' => $this->parseTypeFromFileName($filename),
                'filename' => $filename,
            ];
        }

        return $fileInformations;
    }

    protected function parseTypeFromFileName($file)
    {
        preg_match('/([a-z]{5})+[a-z0-9]{0,}\.csv/i', $file, $fileType);
        if (!empty($fileType[1])) {
            return $fileType[1];
        }
        return "";
    }

    /**
     * Process Dachser files in temporary directory and return type, name and path of the file in an array
     *
     * @return array
     * @throws \Exception
     */
    protected function parseResponseFromFile($file): array
    {
        $localOutTmp = $this->localOutTmpDir;

        $fileInformations = [];

        $files = glob($localOutTmp . '/*');

        if (false === $files) {
            throw new \Exception(sprintf("Unable to parse %s directory. Check existence and permission if directory!", $localOutTmp));
        }

        foreach ($files as $file) {
            $localOutTmpFilePath = $localOutTmp . '/' . $file;
            $fileType = preg_match('/([a-z]{5})+[a-z0-9]{0,}\.csv/i', $file);
            $fileInformations[] = [
                'filepath' => strtoupper($localOutTmpFilePath),
                'type' => $fileType[1],
                'filename' => $file,
            ];
        }

        return $fileInformations;
    }

    /**
     * Check if there files in the tmp directory
     *
     * @return bool
     * @throws \Exception
     */
    protected function hasTmpFiles(): bool
    {
        $localOutTmp = $this->localOutTmpDir;

        $files = glob($localOutTmp . '/*');

        if (false === $files) {
            throw new \Exception(sprintf("Unable to parse %s directory. Check existence and permission if directory!", $localOutTmp));
        }

        if (!empty($files)) {
            return true;
        }

        return false;
    }
}
