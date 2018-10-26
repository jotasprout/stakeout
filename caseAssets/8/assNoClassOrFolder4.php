<?php

// This works with a single file and the following variable
// $fileID = '64295.jpg';

$newAssetsArchive = new ZipArchive();

$newZIPfileName = 'singleFileZip2.zip';

$newAssetsArchive -> open ($newZIPfileName, ZipArchive::CREATE);

// $newAssetsArchive -> addFile ($fileID, $fileID);
// Trying this with just a file name instead. Then I'll try that with multiple files

$newAssetsArchive -> addFile ('64295.jpg', '64295.jpg');

$newAssetsArchive -> close();

?>