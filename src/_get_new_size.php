<?php

namespace PMVC\PlugIn\thumbnail;

use PMVC\PlugIn\image\ImageRatio;
use PMVC\PlugIn\image\ImageSize;
use PMVC\PlugIn\image\Coord2D;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\GetNewSize';

class GetNewSize
{
    /**
     * @param ImageSize $origSize   The original size.
     * @param ImageSize $dstSize    The size what your expected.
     * @param int       $canvasType Different canvas type will effect your really finial image size.
     *
     * @see https://github.com/pmvc-plugin/thumbnail#thumb-type
     *
     */
    public function __invoke (
        ImageSize $origSize,
        ImageSize $dstSize,
        $canvasType
    )
    {
        $ratio = new ImageRatio(
           $origSize,
           $dstSize
        );

        // https://github.com/pmvc-plugin/thumbnail#thumb-type
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
        return [
            'canvasSize' => $canvasSize,
            'toSize' => $toSize,
            'toLoc' => $toLoc
        ];
    }
}
