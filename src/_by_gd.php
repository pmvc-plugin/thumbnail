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
                $toSize = $ratio->newSize;
                $toLoc = new Coord2D(0,0);
                $canvasSize = $ratio->newSize;
                break;
            case 1:
                $toSize = $ratio->newSize;
                $toLoc = $ratio->locForNewSize;
                $canvasSize = $dstSize;
                break;
            case 2:
                $toSize = $ratio->maxSize;
                $toLoc = $ratio->locForMaxSize;
                $canvasSize = $dstSize;
                break;
            case 3:
                $toSize = $ratio->maxSize;
                $toLoc = $ratio->locForMaxSize;
                $canvasSize = $dstSize;
                if ($ratio->origSize->h <= $dstSize->h &&
                    $ratio->origSize->w <= $dstSize->w
                ) {
                    $toSize = $ratio->origSize;
                    $toLoc = $ratio->locForOrigSize;
                }
                break;
            case 4:
                $toSize = $ratio->newSize;
                $toLoc = new Coord2D(0,0);
                $canvasSize = $ratio->newSize;
                if ($ratio->origSize->h <= $dstSize->h &&
                    $ratio->origSize->w <= $dstSize->w
                ) {
                    $toSize = $ratio->origSize;
                    $canvasSize = $ratio->origSize;
                }
                break;
            case 5:
                $toSize = $ratio->origSize;
                $toLoc = new Coord2D(0,0);
                $canvasSize = $ratio->origSize;
                break;
        }
        return $this->create(
            $fileIn,
            $canvasSize,
            $toSize,
            $toLoc
        );
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
            $imOut->toGd(),
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
