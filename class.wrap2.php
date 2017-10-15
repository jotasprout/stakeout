<?php


class collection {

    private $newCollection;

    public function __construct ($caseID) {
        $newCollection = new ZipArchive();
        $putHere = 'caseAssets/' . $caseID . '.zip';
        $newCollection -> open ($putHere, ZipArchive::CREATE);
    }

    public function add_directory ($caseID) {

        public $getThis = 'caseAssets/' . $caseID . '/';

        // if $getThis exists
        if (is_dir($getThis)) {

            // add empty folder named after $caseID inside the archive
            $newDir = $newCollection -> addEmptyDir ($caseID);

            // start looking at items inside the original assets folder for $caseID
            $targetDir = opendir($getThis);

            // while there is at least one more file in the original folder
            while ( ($file = readdir($targetDir) ) !== false) {
                // add a copy of each item in original folder to the new $caseID folder in the archive
                $newCollection -> addFile ($newDir . '/' . $file);
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