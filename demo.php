<?php
include 'vendor/autoload.php';
\PMVC\Load::plug();
\PMVC\addPlugInFolders(['../']);

$pThumb = \PMVC\plug('thumbnail', [
'w'=>180,
'h'=>180,
'type'=>2
]);
$pThumb->toThumb('face.png','face_new.png'); 
