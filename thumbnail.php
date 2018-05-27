<?php
namespace PMVC\PlugIn\thumbnail;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\thumbnail';

/**
 * @parameters int w thumbnail width 
 * @parameters int h thumbnail height
 * @parameters string fill thumbnail hex color. default #ffffff 
 * @parameters string type thumbnail canvans type 
 */
class thumbnail extends \PMVC\PlugIn
{

    public function init()
    {
        if (!isset($this['fill'])) {
            $this['fill']='#fff';
        }
    }

    public function toThumb($fileIn, $fileOut=null, $params=[])
    {
        $params = array_replace(
            $this->getDefault(),
            $params
        );
        return $this->by_gd($fileIn, $fileOut, $params);
    }

    public function getDefault()
    {
        return [
            'w'=>$this['w'],
            'h'=>$this['h'],
            'fill'=>$this['fill'],
            'type'=>$this['type']
        ];
    }
}
