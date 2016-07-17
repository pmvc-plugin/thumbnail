<?php
namespace PMVC\PlugIn\thumbnail;

use PMVC\PlugIn\image\ImageFile;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\thumbnail';

/**
 * @parameters int w thumbnail width 
 * @parameters int h thumbnail height
 * @parameters string color thumbnail hex color such as #ffffff 
 * @parameters string type thumbnail canvans type 
 */
class thumbnail extends \PMVC\PlugIn
{

    function init()
    {
        if (!isset($this['color'])) {
            $this['color']='#fff';
        }
    }

    function toThumb($fileIn, $fileOut=null)
    {
        $fIn = new ImageFile($fileIn);
        return $this->byGd($fIn, $fileOut);
    }
}
