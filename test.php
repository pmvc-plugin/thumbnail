<?php
namespace PMVC\PlugIn\thumbnail;

use PHPUnit_Framework_TestCase;

\PMVC\Load::plug();
\PMVC\addPlugInFolders(['../']);

const DEMO_PIC = __DIR__.'/vendor/pmvc-plugin/image/tests/resource/demo.jpg';

class ThumbnailTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'thumbnail';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testMakeThumbnail()
    {
       $pThumb = \PMVC\plug($this->_plug, [
        'w'=>300,
        'h'=>100,
        'type'=>2
       ]);
       $output = \PMVC\plug('tmp')->file();
       $pThumb->toThumb(DEMO_PIC,$output ); 
       $image = \PMVC\plug('image')->create($output);
       $this->assertEquals('png', $image->getExt());
    }

}
