<?php

namespace app\controllers;

use app\core\View;
use app\core\Router;
use app\core\Session;
use app\models\Import;

class ImportController
{

    public static function index() : string
    {
        $import = new Import();

        $data = [
            'downloadError' => Session::getAndUnset('downloadError'),
            'parseError' => Session::getAndUnset('parseError'),
            'xmlFiles' => $import->getXmlFilesList(),
            'dbStat' => $import->getDbStat()
        ];
        
        return View::render('import/index', $data);
    }


    public static function download() : void
    {
        if (isset($_POST['fileLink']) && !empty($_POST['fileLink'])) {
            $import = new Import();
            $file = $import->download($_POST['fileLink']);
        }
        Router::redirect('/import');
    }


    public static function dbempty() : void
    {
        $import = new Import();
        $import->dbEmpty();
        Router::redirect('/import');
    }



    // public static function download($fileLink) : void
    // {
    //     if (isset($_POST['ziplink']) && !empty($_POST['ziplink'])) {
    //         $import = new Import();
    //         $zipFile = $import->download($_POST['ziplink']);
    //         if ($zipFile === false) {
    //             Router::redirect('/import');
    //         }
    //         if ($import->unzip($zipFile) === false) {
    //             Router::redirect('/import');
    //         }
    //     }
    //     Router::redirect('/import');
    // }



    public static function deletefile() : void
    {
        if (isset($_GET['file']) && !empty($_GET['file'])) {
            $import = new Import();
            $import->deleteFile($_GET['file']);
        }
        Router::redirect('/import');
    }

    public static function parse() : void
    {
        if (isset($_GET['file']) && !empty($_GET['file'])) {
            $import = new Import();
            $import->parse($_GET['file']);
        }
        Router::redirect('/import');
    }

}