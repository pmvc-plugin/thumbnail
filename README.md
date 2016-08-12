[![Latest Stable Version](https://poser.pugx.org/pmvc-plugin/thumbnail/v/stable)](https://packagist.org/packages/pmvc-plugin/thumbnail) 
[![Latest Unstable Version](https://poser.pugx.org/pmvc-plugin/thumbnail/v/unstable)](https://packagist.org/packages/pmvc-plugin/thumbnail) 
[![Build Status](https://travis-ci.org/pmvc-plugin/thumbnail.svg?branch=master)](https://travis-ci.org/pmvc-plugin/thumbnail)
[![License](https://poser.pugx.org/pmvc-plugin/thumbnail/license)](https://packagist.org/packages/pmvc-plugin/thumbnail)
[![Total Downloads](https://poser.pugx.org/pmvc-plugin/thumbnail/downloads)](https://packagist.org/packages/pmvc-plugin/thumbnail) 

thumbnail
===============

## How to use
   * https://github.com/pmvc-plugin/thumbnail/blob/master/demo.php

## Thumb type
   * type 0 (New size not equal defined size)
      * New image size auto fit by ratio
      * Canvans size same with new image size
   * type 1
      * New image size auto fit by ratio.
      * Canvans will fill with background color, and size same with defined.
   * type 2
      * New image will force to max one between width and height.
      * Canvans size same with defined size.
      * Auot change image location
   * type 3
      * Same with type2 but if image origin size smaller than new size, will keep origin size.
   * type 4
      * Same with type0 but if origin size same smaller than new size, will keep origin one.
   * type 5
      * For security issue, do 1:1 change. 


## Install with Composer
### 1. Download composer
   * mkdir test_folder
   * curl -sS https://getcomposer.org/installer | php

### 2. Install by composer.json or use command-line directly
#### 2.1 Install by composer.json
   * vim composer.json
```
{
    "require": {
        "pmvc-plugin/thumbnail": "dev-master"
    }
}
```
   * php composer.phar install

#### 2.2 Or use composer command-line
   * php composer.phar require pmvc-plugin/thumbnail

