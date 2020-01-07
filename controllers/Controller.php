<?php


namespace App\controllers;

use App\services\render\TvigRenderTemplate;
use App\services\BD;

abstract class Controller implements IController
{
    protected $defaultAction = "showAll";
    protected $defaultTableName = "users";
    protected $defaultImageUser = "/img/user.png";
    protected static $mainTemplate = "layouts/main";
    protected $unitData;
    protected $tableName;

    /**
     * @var $data (array) дополнительные параметры, которые необходимо передать для получения html-кода
     */
    protected $data;

    protected $action;

    /**
     * метод запуска класса после создания,
     * определяет существует ли класс по
     * заданному действию и запускает метод
     * @param $action
     */
    public function run($action, $tableName, $id, $unitData = [])
    {
        $this->action = $action ?: $this->defaultAction;
        $this->tableName = $tableName ?: $this->defaultTableName;
        $this->unitData = $unitData;
        $this->data = $this->getData();

        $method = $this->action . 'Action';
        if (method_exists($this, $method)) {
            $this->$method($id);
        } else {
            echo '404';
        }
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
            'htmlScripts' => $this->getHTMLScripts()
        ];
    }

    /**
     * метод получения html-скрипта для подключения js-файлов
     * @return string
     */
    public function getHTMLScripts()
    {
        $htmlText = '';
        $scriptNames = scandir(PATCH_JS);
        foreach ($scriptNames as $fileName) {
            if ($fileName === '.' || $fileName === '..') {
                continue;
            }
            $htmlText .= "<script src='/js/{$fileName}'></script>";
        }
        return $htmlText;
    }

    /**
     * метод получения имения класса для модели
     */
    protected function getClassName()
    {
        $str = ucfirst($this->tableName);
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
        header("Location:index.php?action=showAll");
    }

    public function addAction()
    {
        $ClassName = $this->getClassName();
        $unit = new $ClassName;
        var_dump($unit);
        $unit->insert();
        header("Location:index.php?action=showAll");
    }

    public function updateAction()
    {
        $ClassName = $this->getClassName();
        $unit = new $ClassName;
        foreach ($this->unitData as $prop=>$value){
            $unit->$prop=$value;
        }
        $unit->update();
        header("Location:index.php?action=showAll&table={$this->tableName}");
    }

    /**
     * метод рендеризации
     * @param $params
     * @return false|string
     */
    public function render($params)
    {
        $params['menuUnits'] = BD::getUnitsAllTables();
        $render = new TvigRenderTemplate();
        return $render->Render(Controller::$mainTemplate, $params);
    }
}