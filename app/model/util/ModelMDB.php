<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 02:10
 */

abstract class ModelMDB
{
    private static $db;
    private $fields = array();

    public function __construct(array $schema)
    {
        foreach ($schema as $name => $type) {
            $this->fields[$name] = NULL;
        }
    }

    protected static function getPDO()
    {
        if (!isset(self::$db)) {

            $database = include(ROOT . 'app/config/database.php');

            $m = new MongoClient();
            self::$db = $m->$database['dbname'];

        }
    }



    /**
     * @return mixed
     */
    public function createCollection()
    {
        self::getPDO();
        return self::$db->createCollection(self::getModelName());
    }

    /**
     * Retorna get field name
     * @return string
     */
    protected static function getFieldName($field)
    {
        return "{$field}";
    }


    /**
     * @param $field
     * @return string
     */
    protected static function getBindName($field)
    {
        return "{$field}";
    }

    /**
     * @return mixed
     */
    public function save($update = [])
    {
        self::getPDO();
        $modelName = self::getModelName();
        $collection = self::$db->$modelName;

        if(count($update) > 0){

            $dataUpdate = [];
            foreach ($this->fields as $field => $f) {
                if ($field != 'id' && $f != NULL) {
                    if(!empty($f))
                        $dataUpdate[self::getFieldName($field)] = self::getBindName($f);
                }
            }
            $collection->update($update, array('$set'=>$dataUpdate));

        }else{
            return $collection->insert($this->fields);
        }

    }


    /**
     * Delete register Collection
     */
    public function delete(){
        self::getPDO();
        $modelName = self::getModelName();
        $collection = self::$db->$modelName;

        $data = [];
        foreach ($this->fields as $key => $f) {
            if(!empty($f))
                $data[$key] = $f;
        }

        $collection->remove($data);
    }

    /**
     * @return string
     */
    protected static function getModelName()
    {
        return strtolower(get_called_class());
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        return self::getAllBy();
    }

    /**
     * @param array|NULL $where
     * @return array
     */
    protected static function getAllBy(array $where = NULL)
    {
        self::getPDO();
        $modelName = self::getModelName();
        $collection = self::$db->$modelName;
        $cursor = $collection->find();


        $document = [];
        foreach ($cursor as $key => $value) {
            $document[$key] = $value;
        }

        return $document;
    }


    /**
     * @param $name
     * @return bool|string
     */

    protected static function getPropertyName($name)
    {
        return substr($name, strlen(self::getModelName()) + 1);
    }

    /**
     * @param $name
     * @return bool
     */
    protected static function isFieldName($name)
    {
        $modelName = self::getModelName();
        return substr($name, 0, strlen($modelName) + 1) === "{$modelName}_";
    }


    public function __set($name, $value)
    {
        if (self::isFieldName($name)) {
            $name = self::getPropertyName($name);
        }
        if (array_key_exists($name, $this->fields)) {
            $this->fields[$name] = $value;
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name]['value'];
        }
    }

    public function __isset($name)
    {
        if (array_key_exists($name, $this->fields)) {
            return isset($this->fields[$name]['value']);
        }
    }

    public function __unset($name)
    {
        if (array_key_exists($name, $this->fields)) {
            unset($this->fields[$name]['value']);
        }
    }
}