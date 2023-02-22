<?php 

namespace app\models;

use app\core\DbModel;
use app\core\Session;
use ZipArchive;

class Import extends DbModel
{
    private string $importFolder;

    // Map XML fields to DB fields | Person
    private array $mapIndvlFields = [
        'last_name' => 'lastNm',
        'first_name' => 'firstNm',
        'middle_name' => 'midNm',
        'suffix' => 'sufNm',
        'number' => 'indvlPK',
    ];

    // Map XML fields to DB fields | Company
    private array $mapCmpFields = [
        'name' => 'orgNm',
        'number' => 'orgPK',
        'city' => 'city',
        'state' => 'state',
        'zip' => 'postlCd'
    ];

    private array $mimeAllowed = ['xml' => ['text/xml', 'application/xml'], 'zip' => ['application/zip', 'application/x-zip-compressed', 'multipart/x-zip']];


    public function __construct()
    {
        $this->importFolder = base_path('public/storage/import/');
    }


    public function getXmlFilesList() : array
    {
        $files = scandir($this->importFolder . 'processing/');
        $xmlFiles = [];
        foreach ($files as $file) {
            if (str_ends_with($file, '.xml')) {
                $xmlFiles[] = ['name' => $file, 'size' => filesize($this->importFolder . 'processing/' . $file)];
            }
        }
        
        usort($xmlFiles, fn($a, $b) => $a['name'] <=> $b['name']); // Sort multidimensional array by 'name' key

        return $xmlFiles;
    }


    public function getDbStat() : array
    {
        $data = [];
        
        $sql = "SELECT COUNT(*) FROM persons";
        $data['persons'] = self::db()->query($sql)->fetchColumn();

        $sql = "SELECT COUNT(*) FROM companies";
        $data['companies'] = self::db()->query($sql)->fetchColumn();

        return $data;
    }



    public function download($fileLink) : string|bool
    {
        $file = $this->copyRemote($fileLink);
        
        if ($file === false) return false;

        $mime = mime_content_type($file);

        if (!in_array($mime, array_merge($this->mimeAllowed['xml'], $this->mimeAllowed['zip']))) {
            Session::set('downloadError', 'File is not XML or ZIP');
            return false;
        }

        if (in_array($mime, $this->mimeAllowed['zip'])) {
            $file = $this->unzip($file);
            if ($file === false) {
                return false;
            }
        }

        return $file;
    }


    public function copyRemote($remoteFile) : string|bool
    {
        $localFile = $this->importFolder . 'processing/' . basename($remoteFile);

        $remoteContent = file_get_contents($remoteFile);
        
        if ($remoteContent === false) {
            Session::set('downloadError', 'Remote file not found');
            return false;
        }

        $res = file_put_contents($localFile, $remoteContent);

        if ( $res === 0) {
            Session::set('downloadError', 'Error downloading file');
            return false;
        }
        
        return $localFile;
    }


    public function unzip($zipFile) : bool
    {
        $zip = new ZipArchive();
        if ($zip->open($zipFile) === true) {
            $zip->extractTo($this->importFolder . 'processing/');
            $zip->close();
            unlink($zipFile);
            return true;
        }

        Session::set('downloadError', 'Error unzipping file');
        return false;
    }


    public function deleteFile($file) : void
    {
        unlink($this->importFolder . 'processing/' . $file);
    }


    public function parse($file)
    {
        $fileFullPath = $this->importFolder . 'processing/' . $file;
        if (file_exists($fileFullPath) === false) {
            Session::set('parseError', 'File not found');
            return false;
        }
        $xml = simplexml_load_file($fileFullPath); // load xml file to SimpleXMLElement object
        $arr = json_decode(json_encode($xml), true); // trick to convert SimpleXMLElement object to array
        
        $persons = [];
        foreach ($arr['Indvls']['Indvl'] as $indvl) {
            $persons[] = $this->parseIndvl($indvl);
        }
    }

    private function parseIndvl($data)
    {
        $fieldsPerson = [];
        foreach ($this->mapIndvlFields as $sqlField => $xmlField) {
            $fieldsPerson[$sqlField] = $data['Info']['@attributes'][$xmlField] ?? '';
        }
        
        $fieldsCompany = [];
        $data_emp = $data['CrntEmps']['CrntEmp'];
        if (!isset($data['CrntEmps']['CrntEmp']['@attributes']))
            $data_emp = $data_emp[0];
        
        foreach ($this->mapCmpFields as $sqlField => $xmlField) {
            $fieldsCompany[$sqlField] = $data_emp['@attributes'][$xmlField] ?? '';
        }

        $companyId = $this->insertCompany($fieldsCompany);
        $fieldsPerson['company_id'] = $companyId;

        $personId = $this->insertPerson($fieldsPerson);

        return $fieldsPerson;

    }

    private function insertCompany($fields)
    {
        // check if company exists by number field
        $result = self::getOne('companies', 'number', $fields['number']);
        if ($result !== false) {
            return $result['id'];
        }

        $id = self::insert('companies', $fields);
        return $id;
    }

    private function insertPerson($fields)
    {
        // check if person exists by number field
        $result = self::getOne('persons', 'number', $fields['number']);
        if ($result !== false) {
            return $result['id'];
        }

        $id = self::insert('persons', $fields);
        return $id;
    }

    public function dbEmpty()
    {
        $sql = "TRUNCATE TABLE persons";
        self::db()->query($sql);

        $sql = "TRUNCATE TABLE companies";
        self::db()->query($sql);
        
    }

}