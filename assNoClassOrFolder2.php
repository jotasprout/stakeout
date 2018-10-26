<?php

$fileID = '64295.jpg';

$newAssetsArchive = new ZipArchive();

$newZIPfileName = 'singleFileZip.zip';

$newAssetsArchive -> open ($newZIPfileName, ZipArchive::CREATE);

$newAssetsArchive -> addFile ($fileID, $fileID);

$newAssetsArchive -> close();

?>