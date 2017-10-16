<?php

class ASSETSARCHIVE {

    private $newAssetsArchive;

    public function __construct ($caseID) {

        // create new object
        $this -> $newAssetsArchive = new ZipArchive();

        // name for the final zip file
        $newZIPfileName = $caseID . '.zip';
        
        // create new zip file in the object
        $newZIPfile = $newAssetsArchive -> open ($newZIPfileName, ZipArchive::CREATE);

        // create new folder in zip file named after $caseID
        $newAssetsArchive -> addEmptyDir ($caseID)
        
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