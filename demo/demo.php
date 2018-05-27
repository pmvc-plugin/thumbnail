<?php
include '../vendor/autoload.php';
\PMVC\Load::plug();
\PMVC\addPlugInFolders(['../../']);

$pThumb = \PMVC\plug('thumbnail', [
    'w'=>200,
    'h'=>100,
    'type'=>0,
    'fill'=>'#000'
]);
$pThumb->toThumb('face.jpg','face_new_0.png'); 
$pThumb['type'] = 1;
$pThumb->toThumb('face.jpg','face_new_1.png'); 
$pThumb['type'] = 2;
$pThumb->toThumb('face.jpg','face_new_2.png'); 
$pThumb['type'] = 3;
$pThumb->toThumb('face.jpg','face_new_3.png'); 
$pThumb['type'] = 4;
$pThumb->toThumb('face.jpg','face_new_4.png'); 
$pThumb['type'] = 5;
$pThumb->toThumb('face.jpg','face_new_5.png'); 
