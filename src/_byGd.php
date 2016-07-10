<?php
namespace PMVC\PlugIn\thumbnail;

use PMVC\PlugIn\image\ImageFile;
use PMVC\PlugIn\image\ImageSize;
use PMVC\PlugIn\image\ImageRatio;
use PMVC\PlugIn\image\ImageOutput;
use PMVC\PlugIn\image\Coord2D;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ByGd';

class ByGd
{
    function __invoke(
        ImageFile $fileIn,
        $exportFilePath = null
    ) {
        $caller = $this->caller;
        $dstSize = new ImageSize($caller['w'],$caller['h']);
        $newImage = $this->_cookNewSize(
            $fileIn,
            $dstSize,
            $caller['type']
        );
        $io = new ImageOutput($newImage);
        if (empty($exportFilePath)) {
            $io->dump();
        } else {
            $tmpFile = $io->save();
            copy($tmpFile, $exportFilePath);
        }
        ImageDestroy($newImage);
    }

    private function _cookNewSize(
        ImageFile $fileIn,
        ImageSize $dstSize,
        $canvasType
    )
    {
        $ratio = new ImageRatio(
           $fileIn,
           clone $dstSize
        );
        switch ($canvasType) {
            default:
            case 0:
                return $this->create(
                    $fileIn,
                    $ratio->newSize,
                    $ratio->newSize,
                    new Coord2D(0,0)
                );
            case 1:
                return $this->create(
                    $fileIn,
                    $dstSize,
                    $ratio->newSize,
                    $ratio->locForNewSize
                );
                break;
            case 2:
                $orgSize = $ratio->origSize; 
                return $this->create(
                    $fileIn,
                    $dstSize,
                    $ratio->maxSize,
                    $ratio->locForSameSize
                );
                break;
        }
    }
    
    function create(
        ImageFile $fileIn,
        ImageSize $canvasSize,
        ImageSize $dstSize,
        Coord2D $dstLoc
    ) {
        $imOut = \PMVC\plug('image')->create($canvasSize);
        $caller = $this->caller;
        $pColor = \PMVC\plug('color');
        $pColor->fill($imOut, $pColor->hexToRgb($caller['color']));
        $srcSize = $fileIn->getSize();
        
        imagecopyresized(
            $imOut,
            $fileIn->toGd(),
            $dstLoc->x,
            $dstLoc->y,
            0,
            0,
            $dstSize->w,
            $dstSize->h,
            $srcSize->w,
            $srcSize->h
        );
        return $imOut;
    }
}
