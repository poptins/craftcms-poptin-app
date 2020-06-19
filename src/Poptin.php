<?php
namespace poptin\poptin;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

class Poptin extends Plugin
{
    public static $plugin;

    public $schemaVersion = '1.0.0';

    public $hasCpSettings = false;

    public $hasCpSection = true;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register our site routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['POST poptin/config'] = 'poptin/default/config';
                $event->rules['poptin/redirect'] = 'poptin/default/redirect';
            }
        );

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

        Craft::info(
            Craft::t(
                'poptin',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

        $this->name = 'Poptin';

        $request = Craft::$app->getRequest();
        if (
            $this->isInstalled
            && !$request->isCpRequest
            && !$request->isConsoleRequest
        ) {
            Craft::$app->getView()->registerAssetBundle('poptin\poptin\PoptinPublicBundle');
        }

        $projectConfig = Craft::$app->projectConfig;
        $projectConfig->get('plugins.poptin.client_id') ?? $projectConfig->set('plugins.poptin.client_id', "");
        $projectConfig->get('plugins.poptin.user_id') ?? $projectConfig->set('plugins.poptin.user_id', "");
        $projectConfig->get('plugins.poptin.token') ?? $projectConfig->set('plugins.poptin.token', "");
        $projectConfig->get('plugins.poptin.login_url') ?? $projectConfig->set('plugins.poptin.login_url', "");
        $projectConfig->get('plugins.poptin.poptin_url') ?? $projectConfig->set('plugins.poptin.poptin_url', "https://app.popt.in");
    }
    public function getCpNavItem()
    {
        $item = parent::getCpNavItem();
        $item['icon'] = '@poptin/poptin/icon.svg';
        return $item;
    }

}
