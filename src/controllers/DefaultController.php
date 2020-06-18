<?php
namespace poptin\poptin\controllers;

use Craft;
use craft\web\Controller;
use craft\web\Request;

class DefaultController extends Controller
{
    protected $allowAnonymous = ['config'];

    public function actionConfig()
    {
        $this->requireLogin();

        $params = (new Request())->getBodyParams();

        $projectConfig = Craft::$app->projectConfig;

        $projectConfig->set('plugins.poptin.user_id', $params['user_id']);
        $projectConfig->set('plugins.poptin.token', $params['token']);
        $projectConfig->set('plugins.poptin.login_url', $params['login_url']);

        return $this->asJson([
            'success' => true,
        ]);
    }
}
