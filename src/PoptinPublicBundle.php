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

        $client_id = \Craft::$app->projectConfig->get('plugins.poptin.client_id');
        $poptin_url = \Craft::$app->projectConfig->get('plugins.poptin.poptin_url');

        if($client_id) {
            $this->js = [
                "{$poptin_url}/pixel.js?id={$client_id}",
            ];
        }else {
            $this->js = [
                //
            ];
        }

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