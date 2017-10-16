<?php

$caseID = '8';

$newAssetsArchive = new ZipArchive();

$newZIPfileName = $caseID . '.zip';

$newAssetsArchive -> open ('caseAssets/' . $newZIPfileName, ZipArchive::CREATE);

// create new folder in zip file named after $caseID
$newAssetsArchive -> addEmptyDir ($caseID);
        
$getThis = 'caseAssets/' . $caseID . '/';
echo $getThis . '<br>';


// if $getThis exists
if (is_dir($getThis)) {

    $msg = 'There are some assets for this case.';
    // show that message
    echo $msg . '<br>';

    // add empty folder named after $caseID inside the archive
    $newAssetsArchive -> addEmptyDir ($caseID);

    // start looking at items inside the original assets folder for $caseID
    $targetDir = opendir($getThis);

    // while there is at least one more file in the original folder
    while ( ($file = readdir($targetDir) ) !== false) {
        echo $file . '<br>';
        // add a copy of each item in original folder to the new $caseID folder in the archive
        $newAssetsArchive -> addFile ($caseID . '/' . $file);
    }
}

else {
    $msg = 'There are no assets for this case.';
    // show that message
    echo $msg . '<br>';
}

$newAssetsArchive -> close();

?>