<?php

namespace App\main;

use App\services\DB;
use App\services\TmplRenderService;
use App\traits\TSingleton;

/**
 * Class App
 * @package App\main
 * @property DB db
 */
class App
{
    use TSingleton;

    private static $config;
    private $componentsData;
    private $components = [];

    public static function getPublicConfig()
    {
        return App::$config['public'];
    }

    public static function getHTMLstyles()
    {
        $links = '';
        $arr = App::getPublicConfig()['css'];
        if (!$arr) {
            return;
        }
        foreach ($arr as $item) {
            $links .= '<link rel="stylesheet" href="/' . $item . '">';
        }
        return $links;
    }

    public static function getHTMLscripts()
    {
        $scripts = '';
        $arr = App::getPublicConfig()['js'];
        if (!$arr) {
            return;
        }
        foreach ($arr as $item) {
            $scripts .= '<script src="/' . $item . '"></script>';
        }
        return $scripts;
    }

    static public function call(): App
    {
        static::$config = include($_SERVER['DOCUMENT_ROOT'] . '/main/config.php');
        return static::getInstance();
    }

    //todo app->auth
    public function auth()
    {
        return (new \App\services\Authorization())->check();

    }

    public function run()
    {
//        $this->config = $config;
        $this->componentsData = App::$config['components'];
        $this->runController();
    }

    public function getConfig($key)
    {
        if ($key == 'components') {
            return [];
        }

        return array_key_exists($key, $this->config)
            ? $this->config[$key]
            : [];
    }

    private function runController()
    {
        $request = new \App\services\Request();

        $defaultControllerName = static::$config['defaultControllerName'];

        $controllerName = $request->getControllerName() ?: $defaultControllerName;
        $actionName = $request->getActionName();

        $params = compact($controllerName, $actionName, $id, $postParams);

        $controllerClass = 'App\\controllers\\' .
            ucfirst($controllerName) . 'Controller';
        if (class_exists($controllerClass)) {
            /**@var \App\controllers\Controller $controller */
            $controller = new $controllerClass(
                new TmplRenderService(),
                $request
            );
            $controller->run($params);
        }
    }

    /**
     * метод, который срабатывает когда вызывается свойство, которого нет
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->components)) {
            return $this->components[$name];
        }

        if (array_key_exists($name, $this->componentsData)) {
            $class = $this->componentsData[$name]['class'];
            if (!class_exists($class)) {
                return null;
            }

            if (array_key_exists('config', $this->componentsData[$name])) {
                $config = $this->componentsData[$name]['config'];
                $component = new $class($config);
            } else {
                $component = new $class();
            }
            $this->components[$name] = $component;
            return $component;
        }
        return null;
    }
}