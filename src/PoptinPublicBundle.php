<?php
namespace poptin\poptin;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class PoptinPublicBundle extends AssetBundle
{
    public function init()
    {
        // define the path where your publishable resources live
        $this->sourcePath = '@poptin/poptin/resources';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        $user_id = \Craft::$app->projectConfig->get('plugins.poptin.user_id');

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            "https://dev.popt.in/pixel.js?id={$user_id}",
            "js/test.js",
        ];

        $this->jsOptions = [
            'id' => 'pixel-script-poptin',
            'async' => 'true'
        ];

        $this->css = [
            //
        ];

        parent::init();
    }
}