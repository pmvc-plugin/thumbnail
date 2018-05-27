<?php

namespace PMVC\PlugIn\thumbnail;

use PMVC\PlugIn\image\ImageFile;
use PMVC\PlugIn\image\ImageSize;
use PMVC\PlugIn\image\ImageOutput;
use PMVC\PlugIn\image\Coord2D;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ByGd';

class ByGd
{
    public function __invoke(
        $inputFile,
        $exportFilePath = null,
        array $params
    ) {
        $inputFile = new ImageFile($inputFile);
        $expectedChangeSize = new ImageSize($params['w'], $params['h']);
        $newSizeInfo = $this->caller->get_new_size(
            $inputFile->getSize(),
            $expectedChangeSize,
            $params['type']
        );
        $newImage = $this->_createNewImage(
            $inputFile,
            $newSizeInfo['canvasSize'],
            $newSizeInfo['toSize'],
            $newSizeInfo['toLoc'],
            $params['fill']
        );
        $io = new ImageOutput($newImage);
        if (empty($exportFilePath)) {
            $io->dump();
        } else {
            $tmpFile = $io->save();
            copy($tmpFile, $exportFilePath);
        }
    }
    
    private function _createNewImage(
        ImageFile $fileIn,
        ImageSize $finalCanvasSize,
        ImageSize $toSize,
        Coord2D $toLoc,
        $fill
    ) {
        $imageOut = \PMVC\plug('image')->create($finalCanvasSize);
        $pColor = \PMVC\plug('color');
        $pColor->fill(
            $imageOut,
            $pColor->hexToRgb($fill)
        );
        $srcSize = $fileIn->getSize();
        
        // http://php.net/manual/en/function.imagecopyresized.php
        imagecopyresized(
            $imageOut->toGd(),
            $fileIn->toGd(),
            $toLoc->x,
            $toLoc->y,
            0,
            0,
            $toSize->w,
            $toSize->h,
            $srcSize->w,
            $srcSize->h
        );
        return $imageOut;
    }
}
