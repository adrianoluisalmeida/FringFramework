<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:47
 */

class ExampleController extends Controller
{

    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Example();
    }

    public function main()
    {
        $this->setView('example/main.html');
        $example = new Example();
        $this->addToView('examples', $this->dao->getAll($example));

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function create()
    {
        $this->setView('example/create.html');
        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function edit()
    {
        $id = Request::getParam('id');
        $this->setView('example/edit.html');
        $example = new Example();
        $example->id = $id;
        $this->addToView('example', $this->dao->get($example));

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function store()
    {
        $request = Request::all($this->validations());

        $example = new Example();
        $example->name = "teste";
        $example->email = $request->email;
        $example->phone = $request->phone;

        $this->dao->save($example);

        $this->redirect($this->getContext()['base_url'] . '/example');
    }

    public function update()
    {
        $id = Request::getPost("id");
        $request = Request::all($this->validations());

        $example = new Example();
        $example->name = $request->name;
        $example->email = $request->email;
        $example->phone = $request->phone;

        $this->dao->save($example, ["id" => $id]);

        $this->redirect($this->getContext()['base_url'] . '/example');
    }

    public function destroy()
    {
        $id = Request::getParam('id');
        $example = new Example();
        $example->id = $id;

        $this->dao->delete($example);
        $this->redirect($this->getContext()['base_url'] . '/example');

    }

    public function validations()
    {
        return [
            'name',
            'email',
            'phone'
        ];
    }

}