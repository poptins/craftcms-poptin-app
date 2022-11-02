<?php
namespace poptin\poptin\controllers;

use Craft;
use craft\utilities\ClearCaches;
use craft\web\Controller;
use craft\web\Request;

class DefaultController extends Controller
{
    protected array|int|bool $allowAnonymous = ['config'];

    public function actionConfig()
    {
        $this->requireLogin();

        Craft::$app->elements->invalidateAllCaches();

        $params = (new Request())->getBodyParams();

        $projectConfig = Craft::$app->projectConfig;

        if(array_key_exists('client_id', $params)){
            $projectConfig->set('plugins.poptin.client_id', $params['client_id']);
        }

        if(array_key_exists('user_id', $params)){
            $projectConfig->set('plugins.poptin.user_id', $params['user_id']);
        }

        if(array_key_exists('token', $params)){
            $projectConfig->set('plugins.poptin.token', $params['token']);
        }

        if(array_key_exists('login_url', $params)){
            $projectConfig->set('plugins.poptin.login_url', $params['login_url']);
        }

        return $this->asJson([
            'success' => true,
        ]);
    }

    public function actionRedirect()
    {
        $projectConfig = Craft::$app->projectConfig;
        $client = new \GuzzleHttp\Client();

        $body = [
            "user_id" => $projectConfig->get('plugins.poptin.user_id'),
            "token" => $projectConfig->get('plugins.poptin.token'),
        ];

        try {
            $response = $client->request("POST", $projectConfig->get('plugins.poptin.poptin_url') . '/api/marketplace/auth', [
                "form_params" => ($body)
            ]);

            if($response->getStatusCode() == 200) {
                return $this->redirect(json_decode($response->getBody()->getContents())->login_url . '&utm_source=craftcms');
            }
        }catch (\Exception $e) {
            return $this->redirect($projectConfig->get('plugins.poptin.poptin_url'));
        }
    }
}
