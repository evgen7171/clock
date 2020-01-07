<?php

namespace App\services;

use App\traits\TSingleton;
use PDO;

class DB implements IDB
{
    private $config;

    use TSingleton;

    /**
     * метод получения конфигурационных данных для подключения к базе данных
     * @return void массив из файла конфигурации
     */

    private function getConfig()
    {
        $this->config =
            (include $_SERVER['DOCUMENT_ROOT'] . '/main/config.php')['components']['db']['config'];
    }

    /**
     * метод получения имен таблиц из базы данных определенной в файле конфигурации
     * @return array массив имен таблиц базы данных
     */
    public function getTableNames()
    {
        $config =
            (include $_SERVER['DOCUMENT_ROOT'] . '/main/config.php')['components']['db']['config'];
        $result = [];
        $dsn = sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $config['driver'],
            $config['host'],
            $config['db'],
            $config['charset']
        );
        $connect = new PDO(
            $dsn,
            $config['user'],
            $config['pass']
        );
        $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '{$config['db']}'";
        $PDOStatement = $connect->prepare($sql);
        $PDOStatement->execute();
        $arr = $PDOStatement->fetchAll();
        foreach ($arr as $item) {
            $result[] = $item['table_name'];
        }
        return $result;

    }

    /**
     * метод получения последнего вставленного в таблицу базы данных id
     * @return string id
     */
    public function lastInsertId()
    {
        return $this->getConnect()->lastInsertId();
    }

    /**
     * @var PDO|null
     */
    protected $connect = null;

    /**
     * Возвращает только один коннект с базой - объект PDO
     * @return PDO|null
     */
    protected function getConnect()
    {
        $this->config =
            (include $_SERVER['DOCUMENT_ROOT'] . '/main/config.php')['components']['db']['config'];
        if (empty($this->connect)) {
            $this->connect = new PDO(
                $this->getDSN(),
                $this->config['user'],
                $this->config['password']
            );
            $this->connect->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );
        }
        return $this->connect;
    }

    /**
     * Создание строки - настройки для подключения
     * @return string
     */
    private function getDSN()
    {
        $this->getConfig();
        //'mysql:host=localhost;dbname=DB;charset=UTF8'
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $this->config['driver'],
            $this->config['host'],
            $this->config['db'],
            $this->config['charset']
        );
    }

    /**
     * Выполнение запроса
     *
     * @param string $sql 'SELECT * FROM users WHERE id = :id'
     * @param array $params [':id' => 123]
     * @return \PDOStatement
     */
    private function query($sql, array $params = [])
    {
        $connect = $this->getConnect();
        $PDOStatement = $connect->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * Получение одного объекта
     *
     * @param string $sql
     * @param array $params
     * @return array|mixed
     */
    public function queryObject(string $sql, $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(
            PDO::FETCH_CLASS,
            $class);
        return $PDOStatement->fetch();
    }

    /**
     * Получение в виде объектов
     *
     * @param string $sql
     * @param array $params
     * @return array|mixed
     */
    public function queryObjects(string $sql, $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(
            PDO::FETCH_CLASS,
            $class);
        return $PDOStatement->fetchALL();
    }

    /**
     * Получение одной строки
     *
     * @param string $sql
     * @param array $params
     * @return array|mixed
     */
    public function find(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Получение всех строк
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function findAll(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Выполнение безответного запроса
     *
     * @param string $sql
     * @param array $params
     */
    public function execute(string $sql, array $params = [])
    {
        $this->query($sql, $params);
    }

    public function getAll(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function getOne(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * метод получения всех свойств из базы данных
     */
    public function getProperties($tableName)
    {
        $result = [];
        $sql = "SHOW COLUMNS FROM {$tableName}";
        $arr = DB::getInstance()->getAll($sql);
        foreach ($arr as $item) {
            $result[] = $item['Field'];
        }
        return $result;
    }

    /**
     * метод получения всех unit-данных в виде массива
     */
    public function getUnitsAllTables()
    {
        $units = [];
        $tableNames = DB::getTableNames();
        foreach ($tableNames as $tableName) {
            $ClassNames = DB::getClassFromTableNames($tableName);
            $sql = "SELECT * FROM {$tableName}";
            $arr = DB::getInstance()->getAll($sql);
            foreach ($arr as $item) {
                $units[$tableName][] = [
                    'actionOne' => strtolower($ClassNames['nameShort']),
                    'id' => $item['id']
                ];
            }
        }
        return $units;
    }

    /**
     * метод получения названия класса из имени таблицы из базы данных
     * @param $tableNames
     * @return string
     */
    public function getClassFromTableNames($tableNames)
    {
        $str = $tableNames;
        if ($str[mb_strlen($str) - 1] === 's') {
            $str = mb_substr($str, 0, mb_strlen($str) - 1);
        }
        $ClassName = ucfirst($str);
        $ClassNameFull = 'App\\models\\' . $ClassName;
        return [
            'nameShort' => $ClassName,
            'nameFull' => $ClassNameFull
        ];
    }
}
