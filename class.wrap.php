<?php


class collection {

    private $collection;

    public function __construct ($assetName, $putHere) {
        $this -> collection = new ZipArchive ();

    }

    public function collectCaseFolder ($caseIDfolder) {
        if (is_dir($caseIDfolder)) {
            // create the archive
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