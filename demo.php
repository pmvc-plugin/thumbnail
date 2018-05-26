<?php
include 'vendor/autoload.php';
\PMVC\Load::plug();
\PMVC\addPlugInFolders(['../']);

$pThumb = \PMVC\plug('thumbnail', [
'w'=>180,
'h'=>180,
'type'=>2
]);
$pThumb->toThumb('face.jpg','face_new.png'); 
