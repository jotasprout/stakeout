<?php

$getThis = 'caseAssets/' . $caseID . '/';
echo $getThis . '<br>';

// if $getThis exists
if (is_dir($getThis)) {
    
    $msg = $getThis . ' is a directory.';
    // show that message
    echo $msg . '<br>';

    if (is_writable($getThis)) {

        $msg = $getThis . ' is writable.';
        // show that message
        echo $msg . '<br>';

        $caseID = '8';

        $newAssetsArchive = new ZipArchive();

        $newZIPfileName = $caseID . '.zip';

        $newZIPpath = 'caseAssets/' . $newZIPfileName;

        touch ($newZIPpath);

        $package = $newAssetsArchive -> open ($newZIPpath, ZipArchive::CREATE);

        if ($package === true) {
            $msg = 'package is true.';
            // show that message
            echo $msg . '<br>';

            $targetDir = opendir($getThis);
            
            // while there is at least one more file in the original folder
            while ( ($file = readdir($targetDir) ) !== false) {
                echo $file . '<br>';
                // add a copy of each item in original folder to the new $caseID folder in the archive
                $newAssetsArchive -> addFile ($file, $file);
            }
            
            $newAssetsArchive -> close();
            
        }
    }
}

?>