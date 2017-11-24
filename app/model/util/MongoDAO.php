<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 16/11/17
 * Time: 09:10
 */

class MongoDAO extends ModelRegister implements DAO
{
    private $mongo;
    private $table;
    private $fields = array();


    public function __construct()
    {
        $this->mongo = self::getMongo();
    }

    protected function getMongo()
    {
        if (!isset($this->mongo)) {

            $database = include(ROOT . 'app/config/database.php');

            $m = new MongoClient();
            $this->mongo = $m->$database['dbname'];

        }
    }


    /**
     * Retorna get field name
     * @return string
     */
    protected static function getBindName($field)
    {
        return "{$field}";
    }

    /**
     * Retorna get field name
     * @return string
     */
    protected static function getValueName($field)
    {
        return $field;
    }


    /**
     * @param $model
     * @return mixed
     */

    public function get($model)
    {
        return $this->getAllBy($model, array('id' => (int)$model->id));
    }


    /**
     * @return array
     */
    public function getAll($model)
    {
        return $this->getAllBy($model);
    }

    /**
     * @param array|NULL $where
     * @return array
     */
    public function getAllBy($model, array $where = NULL)
    {
        self::getMongo();
        $modelName = $model->table;
        $collection = $this->mongo->$modelName;


        if (is_null($where))
            $cursor = $collection->find();
        else
            $cursor = $collection->find($where);

        $document = [];
        foreach ($cursor as $key => $value) {
            $document[$key] = $value;
        }

        return is_null($where) ? $document : $document[$key];
    }

    public function getNextSequence($name = "cursoid")
    {
        $collection = $this->mongo->counters;

        $retval = $collection->findAndModify(
            array('_id' => $name),
            array('$inc' => array("seq" => 1)),
            null,
            array(
                "new" => true,
                "upsert" => true
            )
        );
        return $retval['seq'];

    }


    /**
     * @return mixed
     */
    public function save($model, $update = [])
    {
        self::getMongo();
        $this->setValues($model);

        $modelName = $model->table;


        $collection = $this->mongo->$modelName;
        if (array_key_exists('id', $update))
            $update['id'] = (int)$update['id'];

        if (count($update) > 0) {


            $dataUpdate = [];
            foreach ($this->fields as $field => $f) {
                if ($field != 'id' && $f != NULL) {
                    if (!empty($f)) {
                        if (is_array($f)) {

                            foreach ($f as $key => $item) {
                                foreach ($item as $k => $i) {
                                    if ($k != 'schema' && $k != 'table') {
                                        $dataUpdate[$this->getBindName($field)][$key][$k] = $item->$k;
                                    }
                                }
                            }
                        } else {
                            $dataUpdate[$this->getBindName($field)] = $f;
                        }
                    }
                }
            }


            $collection->update($update, array('$set' => $dataUpdate));
        } else {

            $this->fields['id'] = $this->getNextSequence();

//            $i = 0;
            $dataInsert = [];
            foreach ($this->fields as $key => $field) {
                if (is_array($field)) {

                    foreach ($field as $ke => $item) {
                        foreach ($item as $k => $i) {
                            if ($k != 'schema' && $k != 'table') {
                                $dataInsert[$key][$ke][$k] = $item->$k;
                            }
                        }
                    }
                } else {
                    $dataInsert[$this->getBindName($key)] = $field;
                }

            }
        }
        return $collection->insert($dataInsert);
    }


    /**
     * Delete register Collection
     */
    public function delete($model)
    {
        self::getMongo();
        $this->setValues($model);
        $modelName = $model->table;
        $collection = $this->mongo->$modelName;

        $data = [];

        foreach ($this->fields as $key => $f) {
            if (!is_null($f)) {
                if ($key == 'id')
                    $data[$key] = (int)$f;
                else
                    $data[$key] = $f;
            }
        }

        return $collection->remove($data);
    }


    protected
    function setValues($model)
    {
        $model->schema = array('id' => NULL) + $model->schema;
        foreach ($model->schema as $name => $type) {
            $this->fields[$name] = NULL;
        }

        foreach ($model as $key => $value) {
            if (array_key_exists($key, $this->fields)) {
                $this->fields[$key] = $value;
            }
        }
    }


}