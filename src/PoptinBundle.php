<?php
namespace poptin\poptin;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class PoptinBundle extends AssetBundle
{
    public function init()
    {
        // define the path where your publishable resources live
        $this->sourcePath = '@poptin/poptin/resources';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/bootstrap.min.js',
            'js/poptin-admin.js'
        ];

        $this->css = [
            'css/bootstrap.min.css',
            'css/poptin-admin.css',
        ];

        parent::init();
    }
}