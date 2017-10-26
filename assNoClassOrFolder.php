<?php

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
                

            }






    }
}

// create new folder in zip file named after $caseID
$newAssetsArchive -> addEmptyDir ($caseID);

$getThis = 'caseAssets/' . $caseID . '/';
echo $getThis . '<br>';

    $msg = 'There are some assets for this case.';
    // show that message
    echo $msg . '<br>';

    // add empty folder named after $caseID inside the archive
    // $newAssetsArchive -> addEmptyDir ($caseID);

    // start looking at items inside the original assets folder for $caseID
    $targetDir = opendir($getThis);

    // while there is at least one more file in the original folder
    while ( ($file = readdir($targetDir) ) !== false) {
        echo $file . '<br>';
        // add a copy of each item in original folder to the new $caseID folder in the archive
        $newAssetsArchive -> addFile ($file, $caseID . '/' . $file);
	}
	
	$newAssetsArchive -> close();
}

else {
    $msg = 'There are no assets for this case.';
    // show that message
    echo $msg . '<br>';
}

?>