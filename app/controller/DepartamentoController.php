<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:47
 */

class DepartamentoController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function main(){
        $this->setView('departamento/main.html');
        $departamentos = new Departamento();
        $this->addToView('departamentos', $this->dao->getAll($departamentos));

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function create(){
        $this->setView('departamento/create.html');

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function edit()
    {
        $id = Request::getParam('id');
        $this->setView('departamento/edit.html');
        $departamento = new Departamento();
        $departamento->id = $id;

        $this->addToView('Departamento', $this->dao->get($departamento));

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function store(){
        $request = Request::all($this->validations());
        $departamento = new Departamento();
        $departamento->name = $request->name;

        $this->dao->save($departamento);

        $this->redirect($this->getContext()['base_url'] . '/departamento');
    }

    public function update()
    {
        $id = Request::getPost("id");
        $request = Request::all($this->validations());

        $departamento = new Curso();
        $departamento->name = $request->name;

        $this->dao->save($departamento, ["id" => $id]);

        $this->redirect($this->getContext()['base_url'] . '/departamento');
    }

    public function destroy()
    {
        $id = Request::getParam('id');
        $departamento = new Curso();
        $departamento->id = $id;

        $this->dao->delete($departamento);
        $this->redirect($this->getContext()['base_url'] . '/departamento');

    }

    public function validations(){
        return [
            'name',
        ];
    }
}