<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 01:07
 */

class PdoDAO extends ModelRegister implements DAO
{
    private $pdo;
    private $fields = array();


    public function __construct()
    {
        $this->pdo = self::getPDO();
    }


    /**
     * Retorna Conexão PDO
     * @return mixed|PDO
     */
    protected function getPDO()
    {

        if (!isset($this->pdo)) {

            $database = include(ROOT . 'app/config/database.php');

            $this->pdo = new PDO(
                $database['dbdrive'] . ':dbname=' . $database['dbname'] . ';host=' . $database['hostname'],
                $database['username'],
                $database['passwd']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        return $this->pdo;
    }

    protected function getClassVars($model)
    {
        var_dump(get_class_vars(get_class($model)));
    }


//    /**
//     * @return array
//     */
//    public function getAll($model)
//    {
//        return $this->getAllBy($model);
//    }

    /**
     * @param array|NULL $where
     * @return PDOStatement
     */
    private function getExecute($model, array $where = NULL)
    {
        $q = "SELECT * FROM {$model->table}";
        $sth = self::prepareQuery($model, $q, $where ? array(self::getModelName($model) => $where) : NULL);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, strtolower(get_class($model)));
        $sth->execute();
        return $sth;
    }

    /**
     * @param $q
     * @param array|NULL $where
     * @return PDOStatement
     */
    private function prepareQuery($model, $q, array $where = NULL)
    {
        if ($where) {
            $modelName = self::getModelName($model);
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
    protected function getBindName($field)
    {
        return ":{$field}";
    }

    protected function setValues($model)
    {
        $model->schema = array('id' => PDO::PARAM_INT) + $model->schema;
        foreach ($model->schema as $name => $type) {
            $this->fields[$name] = array('value' => NULL, 'type' => $type);
        }

        foreach ($model as $key => $value) {
            if (array_key_exists($key, $this->fields)) {
                $this->fields[$key]['value'] = $value;
            }
        }
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

    public function insert($model)
    {
        $table = $model->table;
        $this->setValues($model);

        $cols = [];
        $binds = [];

        foreach ($this->fields as $key => $m) {
            $relations = null;
            if (is_array($m['value'])) {
                $relations = $m['value'];
            } else {
                if ($key != 'id' && $key != 'table') {
                    $cols[] = $this->getFieldName($key);
                    $binds[] = $this->getBindName($key);
                }
            }


        }
        $columns = implode(', ', $cols);
        $bindings = implode(', ', $binds);
        $q = "INSERT INTO {$table} ({$columns}) VALUES ({$bindings})";


        $sth = $this->pdo->prepare($q);
        foreach ($this->fields as $key => $m) {

            if ($m['value'] != NULL) {
                $sth->bindValue($this->getBindName($key), $m['value'], $m['type']);
            }
        }
        $result = $sth->execute();
        return $result;

    }

    /**
     * Method save, used create and update
     * @return bool
     */
    public function save($model, $update = [])
    {
        $table = $model->table;
        $this->setValues($model);

        if (count($update) > 0) {
            foreach ($this->fields as $field => $m) {
                $relations = null;
                if (is_array($m['value'])) {
                    $relations = $m['value'];
                } else {
                    if ($field != 'id' && $m['value'] != NULL) {
                        $sets[] = self::getEqualBind($field);
                    }
                }
            }

            $set = implode(', ', $sets);
            $where = "id = " . $update['id'];
            $q = "UPDATE {$table} SET {$set} WHERE {$where}";
        } else {

            $cols = [];
            $binds = [];

            foreach ($this->fields as $key => $m) {
                $relations = null;
                if (is_array($m['value'])) {
                    $relations = $m['value'];
                } else {
                    if ($key != 'id' && $key != 'table') {
                        $cols[] = $this->getFieldName($key);
                        $binds[] = $this->getBindName($key);
                    }
                }


            }
            $columns = implode(', ', $cols);
            $bindings = implode(', ', $binds);
            $q = "INSERT INTO {$table} ({$columns}) VALUES ({$bindings})";

        }

        $sth = $this->pdo->prepare($q);
        foreach ($this->fields as $key => $m) {

            if ($m['value'] != NULL && !is_array($m['value'])) {
                $sth->bindValue($this->getBindName($key), $m['value'], $m['type']);
            }
        }


        $result = $sth->execute();

        if ($result && $model->id == NULL)
            $id = $this->pdo->lastInsertId();
        else
            $id = $model->id;

        $sth->closeCursor();


        if ($relations) {

            $i = 0;
            foreach ($relations as $key => $relation) {

                if (count($update) > 0) {


                    $pdo = new PdoDAO();

                    if ($i == 0)
                        $pdo->delete($relation, ['curso_id' => (int)$update['id']]);

                    $relation->curso_id = $update['id'];
                } else {
                    $relation->curso_id = $id;
                }

                $pdo = new PdoDAO();
                $pdo->insert($relation);

                $i++;
            }
        }

        return $id;
    }

    /**
     * @return array
     */
    public function getAll($model)
    {
        $disciplina = new Disciplina();

        $sth = $this->getExecute($model);
        $data = $sth->fetchAll();

        $sth->closeCursor();


        foreach ($data as $key => $d) {

            foreach ($this->getAllBy($disciplina, ['curso_id' => $d->id]) as $k => $disciplina) {
                $data[$key]->disciplinas[$k] = ['nome' => $disciplina->nome, 'codigo' => $disciplina->codigo, 'objetivos' => $disciplina->programa, 'programa' => $disciplina->programa, 'bibliografia' => $disciplina->bibliografia];
            }
        }

        return $data;
    }

    /**
     * @param array|NULL $where
     * @return array
     */
    public function getAllBy($model, array $where = NULL)
    {
        $sth = self::getExecute($model, $where);
        $data = $sth->fetchAll();
        $sth->closeCursor();
        return $data;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function get($model)
    {
        return $this->getBy($model, array('id' => $model->id));
    }

    protected function getBy($model, array $where = NULL)
    {
        $disciplina = new Disciplina();

        $sth = $this->getExecute($model, $where);

        $data = $sth->fetch();
        $sth->closeCursor();

        foreach ($this->getAllBy($disciplina) as $key => $disciplina) {
            $data->disciplinas[$key] = ['nome' => $disciplina->nome, 'codigo' => $disciplina->codigo, 'objetivos' => $disciplina->programa, 'programa' => $disciplina->programa, 'bibliografia' => $disciplina->bibliografia];
        }

        return $data;
    }


    protected function getModelName($model)
    {
        return strtolower(get_class($model));
    }

    /**
     * @return bool|void
     */
    public function delete($model, $where = [])
    {
        $this->setValues($model);


        if (!count($where) > 0) {


            $id = $this->fields['id']['value'];
            if ($id == NULL) {
                return;
            }

            $pdo = new PdoDAO();
            $disciplina = new Disciplina();

            $pdo->delete($disciplina, ['curso_id' => $id]);
        }

        $table = $model->table;
        $q = "DELETE FROM {$table}";


        if (count($where) > 0) {
            $sth = self::prepareQuery($model, $q, array(self::getModelName($model) => $where));
        } else {
            $sth = self::prepareQuery($model, $q, array(self::getModelName($model) => array('id' => $id)));
        }


        $result = $sth->execute();

        if ($result) {
            foreach ($this->fields as $field => $f) {
                unset($f['value']);
            }
        }
        $sth->closeCursor();
        return $result;
    }


}