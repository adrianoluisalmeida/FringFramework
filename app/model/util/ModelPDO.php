<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 01:07
 */

abstract class ModelPDO
{

    private static $pdo;

    protected static function getPDO()
    {

        if (!isset(self::$pdo)) {

            $database = include(ROOT . 'app/config/database.php');

            self::$pdo = new PDO(
                $database['dbdrive'] . ':dbname='.$database['dbname'].';host=' . $database['hostname'],
                $database['username'],
                $database['passwd']
            );
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        return self::$pdo;
    }

    protected static function getModelName()
    {
        return strtolower(get_called_class());
    }

    /**
     * Retorna get name table
     * @return string
     */
    protected static function getTableName()
    {
        $modelName = self::getModelName();
        return "{$modelName}s";
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
        return ":{$field}";
    }

    /**
     * @param $field
     * @return string
     */
    protected static function getEqualBind($field)
    {
        $fieldName = self::getFieldName($field);
        $bindName = self::getBindName($field);
        return "{$fieldName} = {$bindName}";
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

    /**
     * @param $name
     * @return bool|string
     */

    protected static function getPropertyName($name)
    {
        return substr($name, strlen(self::getModelName()) + 1);
    }

    /**
     * @param array $models
     * @param int $depth
     * @return string
     */

    public static function encodeAllJSON(array $models, $depth = 0)
    {
        $data = array();
        foreach ($models as $model) {
            $data[] = $model->getData($depth);
        }
        return json_encode($data);
    }

    /**
     * @param $id
     * @return mixed
     */

    public static function get($id)
    {
        return self::getBy(array('id' => $id));
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
     * @return mixed
     */
    protected static function getBy(array $where = NULL)
    {
        $sth = self::getExecute($where);

        $data = $sth->fetch();
        $sth->closeCursor();
        return $data;
    }

    /**
     * @param array|NULL $where
     * @return array
     */
    protected static function getAllBy(array $where = NULL)
    {
        $sth = self::getExecute($where);
        $data = $sth->fetchAll();
        $sth->closeCursor();
        return $data;
    }

    /**
     * @param array|NULL $where
     * @return PDOStatement
     */
    private static function getExecute(array $where = NULL)
    {
        $table = self::getTableName();
        $q = "SELECT * FROM {$table}";
        $sth = self::prepareQuery($q, $where ? array(self::getModelName() => $where) : NULL);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::getModelName());
        $sth->execute();
        return $sth;
    }

    public static function countAll()
    {
        return self::countBy();
    }

    /**
     * Count all registers
     * @param array|NULL $where
     * @return mixed
     */
    protected static function countBy(array $where = NULL)
    {
        $table = self::getTableName();
        $q = "SELECT COUNT(*) FROM {$table}";
        $sth = self::prepareQuery($q, $where);
        $sth->execute();
        return $sth->fetchColumn();
    }

    /**
     * @param $q
     * @param array|NULL $where
     * @return PDOStatement
     */
    private static function prepareQuery($q, array $where = NULL)
    {
        if ($where) {
            $modelName = self::getModelName();
            foreach ($where as $model => $value) {
                if ($modelName != $model) {
                    $q .= ", {$model}s";
                }
            }
            $q .= ' WHERE ';
            $wheres = array();
            foreach ($where as $model => $field) {
                if (is_array($field)) {
                    foreach ($field as $f => $value) {
                        $bindName = self::getBindName($f);
                        $wheres[] = "{$f} = {$bindName}";
                    }
                } else {
                    $wheres[] = "{$field} = {$field}";
                }
            }
            $q .= implode(' AND ', $wheres);
        }
        $sth = self::getPDO()->prepare($q);
        if ($where) {
            foreach ($where as $table => $field) {
                if (is_array($field)) {
                    foreach ($field as $f => $value) {
                        $sth->bindParam(self::getBindName($f), $value);
                    }
                }
            }
        }
        return $sth;
    }


    private $fields = array();

    public function __construct(array $schema)
    {
        $schema = array('id' => PDO::PARAM_INT) + $schema;
        foreach ($schema as $name => $type) {
            $this->fields[$name] = array('value' => NULL, 'type' => $type);
        }
    }

    /**
     * Method save, used create and update
     * @return bool
     */
    public function save($update = [])
    {
        $table = self::getTableName();
        if (count($update) > 0) {
            foreach ($this->fields as $field => $f) {
                if ($field != 'id' && $f['value'] != NULL) {
                    $sets[] = self::getEqualBind($field);
                }
            }
            $set = implode(', ', $sets);
//            $where = self::getEqualBind('id');
            $where = "id = " . $update['id'];
            $q = "UPDATE {$table} SET {$set} WHERE {$where}";
        } else {
            foreach ($this->fields as $field => $f) {
                if ($field != 'id' && $f['value'] != NULL) {
                    $cols[] = self::getFieldName($field);
                    $binds[] = self::getBindName($field);
                }
            }
            $columns = implode(', ', $cols);
            $bindings = implode(', ', $binds);
            $q = "INSERT INTO {$table} ({$columns}) VALUES ({$bindings})";
        }
        $sth = ModelPDO::getPDO()->prepare($q);
        foreach ($this->fields as $field => $f) {
            if ($f['value'] != NULL) {
                $sth->bindValue(self::getBindName($field), $f['value'], $f['type']);
            }
        }
        $result = $sth->execute();
        if ($result && $this->fields['id']['value'] == NULL) {
            $this->fields['id']['value'] = self::getPDO()->lastInsertId();
        }
        $sth->closeCursor();
        return $result;
    }

    /**
     * @return bool|void
     */
    public function delete()
    {
        $id = $this->fields['id']['value'];
        if ($id == NULL) {
            return;
        }
        $table = self::getTableName();
        $q = "DELETE FROM {$table}";
        $sth = self::prepareQuery($q, array(self::getModelName() => array('id' => $id)));
        $result = $sth->execute();
        if ($result) {
            foreach ($this->fields as $field => $f) {
                unset($f['value']);
            }
        }
        $sth->closeCursor();
        return $result;
    }

    public function __set($name, $value)
    {
        if (self::isFieldName($name)) {
            $name = self::getPropertyName($name);
        }
        if (array_key_exists($name, $this->fields)) {
            $this->fields[$name]['value'] = $value;
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