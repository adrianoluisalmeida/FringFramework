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
     * @param $model
     * @return mixed
     */

    public function get($model)
    {
        return self::getAllBy($model, array('id' => (int)$model->id));
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
    protected function getAllBy($model, array $where = NULL)
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

    public function counters($model)
    {

        self::getMongo();
        $this->setValues($model);

        $modelName = $model->table;
        $collection = $this->mongo->counters;

//        $insert = [
//            "_id" => $model->table,
//            "seq" => new NumberLong(1)
//        ];
//        $collection->insert($insert);

//        $seq = $collection->co(
//            array(
//                'findandmodify' => 'counters',
//                'query' => array('_id' => $model->table),
//                'update' => array(
//                    '$inc' => array(
//                        'seq' => 1
//                    )
//                ),
//                'new' => TRUE)
//        );
//
//        var_dump($seq['value']['seq']);
//die;
//        db.seq.insert({"_id":"users", "seq":new NumberLong(1)});

    }


    /**
     * @return mixed
     */
    public function save($model, $update = [])
    {
        self::getMongo();
        $this->setValues($model);

//        $this->counters($model);
//        die;

        $modelName = $model->table;
        $collection = $this->mongo->$modelName;


        if (array_key_exists('id', $update))
            $update['id'] = (int)$update['id'];

        if (count($update) > 0) {

            $dataUpdate = [];
            foreach ($this->fields as $field => $f) {
                if ($field != 'id' && $f != NULL) {
                    if (!empty($f))
                        $dataUpdate[$this->getBindName($field)] = $this->getBindName($f);
                }
            }
            $collection->update($update, array('$set' => $dataUpdate));

        } else {

            $this->fields['id'] = 1;
            return $collection->insert($this->fields);
        }

    }


    /**
     * Delete register Collection
     */
    public function delete($model)
    {
        self::getMongo();
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


    protected function setValues($model)
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