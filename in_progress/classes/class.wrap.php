<?php


class collection {

    private $collection;

    public $caseIDfolder = 'caseAssets/' . $caseID . '/';

    public $putHere = 'caseAssets/';

    public function __construct ($caseID, $putHere) {
        $this -> collection = new ZipArchive ();

    }

    public function collectCaseFolder ($caseIDfolder) {
        if (is_dir($caseIDfolder)) {

            $targetDir = opendir($caseIDfolder);

            $this -> collection -> addEmptyDir ($caseID);

            while ( ($file = readdir($targetDir) ) !== false) {
                $this -> add_file ($targetDir . '/' . $file);
            }
        }

        else {
            $msg = 'There are no assets for this case.';
            // show that message
        }
    }

    public function wrap() {
        $this -> collection -> close();
    }

}



?>