<?php

// This works with a single file and the following variable
// $fileID = '64295.jpg';

$newAssetsArchive = new ZipArchive();

$newZIPfileName = 'singleFileZip4.zip';

$newAssetsArchive -> open ($newZIPfileName, ZipArchive::CREATE);

// $newAssetsArchive -> addFile ($fileID, $fileID);
// Also works with just a file name 
// Now trying that with multiple files

$newAssetsArchive -> addFile ('64295.jpg', '64295.jpg');
$newAssetsArchive -> addFile ('395428.jpg', '395428.jpg');
$newAssetsArchive -> addFile ('399860.jpg', '399860.jpg');
$newAssetsArchive -> addFile ('410524.jpg', '410524.jpg');
$newAssetsArchive -> addFile ('681185.png', '681185.png');

$newAssetsArchive -> close();

// Last version (same as this) didn't get that last file. Why not?

?>

