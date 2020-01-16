<?php


namespace App\controllers;

use App\models\User;
use App\models\Event;
use App\services\TmplRenderService;

abstract class Controller implements IController
{
    protected $defaultControllerName = "user";
    protected $defaultActionName = "default";
    protected static $mainTemplate = "layouts/main";

    /**
     * @var $data (array) дополнительные параметры, которые необходимо передать для получения html-кода
     */
    protected $data = [];

    protected $action;

    /**
     * метод запуска класса после создания,
     * определяет существует ли класс по
     * заданному действию и запускает метод
     * @param $action
     */
    public function run($action, $tableName = '', $id = 0, $unitData = [])
    {
        $this->action = $action ?: $this->defaultActionName;
//        $this->unitData = $unitData;
//        $this->data = $this->getData();

        $method = $this->action . 'Action';
        if (method_exists($this, $method)) {
            $this->$method($id);
        } else {
            echo '404';
        }
    }

    public function defaultAction()
    {
        $events = (new EventController())->getUserEvents(1);

        $this->loginAction();
//        $this->regAction();
    }

    public function loginAction(){
        echo $this->render(['tmpl' => 'forms/login', 'siteTitle'=>'Добро пожаловать!']);
    }
    public function regAction(){
        echo $this->render(['tmpl' => 'forms/reg', 'siteTitle'=>'Регистрция']);
    }

    /**
     * метод получения параметров для отображения данных
     * @return array
     */
    public function getData()
    {
        $ClassName = $this->getClassName();
        return [
            'imgSrc' => $this->defaultImageUser,
            'tableName' => $this->tableName,
//            'htmlScripts' => $this->getHTMLScripts()
        ];
    }

    /**
     * метод получения имения класса для модели
     */
    protected function getClassName()
    {
        $str = ucfirst($this->getTableName());
        if ($str[mb_strlen($str) - 1] === "s") {
            $str = mb_substr($str, 0, mb_strlen($str) - 1);
        }
        $className = "App\\models\\" . $str;
        if (class_exists($className)) {
            return $className;
        } else {
            return null;
        }
    }

    /**
     * метод отображения одной позиции данных
     * @param $id
     */
    public function showOneAction($id)
    {
        $ClassName = $this->getClassName();
        $params = [
            'unit' => $ClassName::getOne($id)
        ];
        $params = array_merge($params, $this->data);
        echo $this->render($params);
    }

    /**
     * метод отображения всех позиций данных
     */
    public function showAllAction()
    {
        $ClassName = $this->getClassName();
        $params = [
            'units' => $ClassName::getAll()
        ];
        $params = array_merge($params, $this->data);
        echo $this->render($params);
    }

    public function deleteAction($id)
    {
        $ClassName = $this->getClassName();
        $unit = new $ClassName;
        $unit->id = $id;
        $unit->delete();
        header("Location:login.php?action=showAll");
    }

    public function addAction()
    {
        $ClassName = $this->getClassName();
        $unit = new $ClassName;
        var_dump($unit);
        $unit->insert();
        header("Location:login.php?action=showAll");
    }

    public function updateAction()
    {
        $ClassName = $this->getClassName();
        $unit = new $ClassName;
        foreach ($this->unitData as $prop => $value) {
            $unit->$prop = $value;
        }
        $unit->update();
        header("Location:login.php?action=showAll&table={$this->tableName}");
    }

    /**
     * метод рендеризации
     * @param $params
     * @return false|string
     */
    public function render($params = [])
    {
        $render = new TmplRenderService();
        if (isset($params['tmpl'])) {
            $tmpl = $params['tmpl'];
            unset($params['tmpl']);
            return $render->Render($tmpl, $params);
        }
        return $render->Render(Controller::$mainTemplate, $params);
    }
}