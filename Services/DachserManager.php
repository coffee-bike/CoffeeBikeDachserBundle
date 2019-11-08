<?php


namespace CoffeeBike\DachserBundle\Services;

use CoffeeBike\DachserBundle\Entity\Response;
use CoffeeBike\DachserBundle\Entity\ResponseMessage;
use phpseclib\Net\SFTP;

class DachserManager
{
    const HTTPS_URL = 'https://myedi.dachser.com:443';

    private $sftp = null;

    private $credentials = array(
        "dachser_branch_number" => null,
        "dachser_gln_number" => null,
        "dachser_branch_number_full" => null,
        "dachser_sftp_host" => null,
        "dachser_sftp_port" => null,
        "dachser_sftp_username" => null,
        "dachser_sftp_password" => null,
        "dachser_sftp_remote_in_path" => null,
        "dachser_sftp_remote_out_path" => null,
        "dachser_sftp_remote_in_save_path" => null,
        "dachser_sftp_local_in_path" => null,
        "dachser_sftp_local_out_path" => null,
        "dachser_sftp_local_in_save_path" => null,
    );

    public function __construct(
        $dachser_branch_number,
        $dachser_gln_number,
        $dachser_branch_number_full,
        $dachser_sftp_host,
        $dachser_sftp_port,
        $dachser_sftp_username,
        $dachser_sftp_password,
        $dachser_sftp_remote_in_path,
        $dachser_sftp_remote_out_path,
        $dachser_sftp_remote_in_save_path,
        $dachser_sftp_local_in_path,
        $dachser_sftp_local_out_path,
        $dachser_sftp_local_in_save_path
    ) {
        $this->credentials["dachser_branch_number"] = $dachser_branch_number;
        $this->credentials["dachser_gln_number"] = $dachser_gln_number;
        $this->credentials["dachser_branch_number_full"] = $dachser_branch_number_full;
        $this->credentials["dachser_sftp_host"] = $dachser_sftp_host;
        $this->credentials["dachser_sftp_port"] = $dachser_sftp_port;
        $this->credentials["dachser_sftp_username"] = $dachser_sftp_username;
        $this->credentials["dachser_sftp_password"] = $dachser_sftp_password;
        $this->credentials["dachser_sftp_remote_in_path"] = $dachser_sftp_remote_in_path;
        $this->credentials["dachser_sftp_remote_out_path"] = $dachser_sftp_remote_out_path;
        $this->credentials["dachser_sftp_remote_in_save_path"] = $dachser_sftp_remote_in_save_path;
        $this->credentials["dachser_sftp_local_in_path"] = $dachser_sftp_local_in_path;
        $this->credentials["dachser_sftp_local_out_path"] = $dachser_sftp_local_out_path;
        $this->credentials["dachser_sftp_local_in_save_path"] = $dachser_sftp_local_in_save_path;

        $this->sftp = new SFTP($dachser_sftp_host);
    }

    public function test() {
        return "abc";
    }

    public function prepareData($data)
    {
        $strCSV = "";
        if (is_array($data)) {
            foreach ($data as $obj) {
                $data = $obj->getData();
                foreach ($data  as $key => $field) {
                    $strCSV .= '"' . $field . '"' . ";";
                }
                $strCSV .= "\n";
            }
            $strCSV = substr($strCSV, 0, -2); // Delete \n from CSV
        } else {
            foreach ($data->getData() as $field) {
                $strCSV .= '"' . $field . '"' . ";";
            }
        }

        return utf8_decode($strCSV);
    }

    public function send($request, $saveFile)
    {
        $tmpHandle = fopen($saveFile, 'a');
        fwrite($tmpHandle, $this->prepareData($request));
        fclose($tmpHandle);

        return true;

        $curl = cURL_init(
            //"https://www.collmex.de/cgi-bin/cgi.exe?" . $this->credentials['customerId'] . ",0,data_exchange"
            $this::HTTPS_URL
        );
        cURL_setopt($curl, CURLOPT_POST, 1);
        cURL_setopt($curl, CURLOPT_POSTFIELDS, $this->prepareData($request->getData()));
        cURL_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/csv"));
        cURL_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        cURL_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $message = curl_exec($curl); //returns true or false
        cURL_close($curl);

        $message = utf8_encode($message);
        // TODO: Better handling of csv file!
        $tmpHandle = tmpfile();
        fwrite($tmpHandle, $message);
        rewind($tmpHandle);
        $responseObjects = array();
        $responseMessages = array();
        $responseNewObjectIds = array();
        while ($line = fgetcsv($tmpHandle, 0, ';', '"')) {
            if ($line[0] == "MESSAGE") {
                $responseMessages[] = $line;
            } elseif ($line[0] == "NEW_OBJECT_ID") {
                $responseNewObjectIds[] = $line;
            } else {
                $responseObjects[] = $line;
            }
        }

        fclose($tmpHandle);

        try {
            $response = new Response();

            foreach ($responseMessages as $responseMessage) {
                $message = new ResponseMessage();

                $message->setTypeIdentifier($responseMessage[0]);
                $message->setStatus($responseMessage[1]);
                $message->setCode($responseMessage[2]);
                $message->setText($responseMessage[3]);

                if (array_key_exists(4, $responseMessage)) {
                    $message->setLine($responseMessage[4]);
                }

                $response->addMessage($message);
            }

            foreach ($responseObjects as $object) {
                $response->addObject($object);
            }

            foreach ($responseNewObjectIds as $newObjectId) {
                $response->addNewObjectId($newObjectId);
            }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function containsOnlyObjects($data)
    {

        foreach ($data as $element) {
            if (is_object($element)) {
                return true;
            }
            return false;
        }
    }
}
