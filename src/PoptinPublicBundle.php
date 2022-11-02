<?php
namespace poptin\poptin;

use craft\web\AssetBundle;

class PoptinPublicBundle extends AssetBundle
{
    public function init()
    {
        // define the path where your publishable resources live
        $this->sourcePath = '@poptin/poptin/resources';

        $client_id = \Craft::$app->projectConfig->get('plugins.poptin.client_id');
        $pixel_url = \Craft::$app->projectConfig->get('plugins.poptin.pixel_url');

        if($client_id) {
            $this->js = [
                "{$pixel_url}/pixel.js?id={$client_id}",
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

        parent::init();
    }
}