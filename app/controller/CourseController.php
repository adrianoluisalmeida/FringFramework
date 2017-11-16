<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:47
 */

class CourseController extends Controller
{

    private $model;

    public function __construct(){
        parent::__construct();
//        $this->model = new Course();
    }

    public function main(){
        $this->setView('course/main.html');//view
        $course = new Course();//classe do model
        $this->addToView('courses', $this->dao->getAll($course));//parametros que passam pra view + consulta

        return $this->twig->render($this->getView(), $this->getContext()); //une addToView + setView para exibir a view com os parametros
    }

    public function create(){
        $this->setView('course/create.html');

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function edit()
    {
        $id = Request::getParam('id');
        $this->setView('course/edit.html');
        $course = new Course();
        $course->id = $id;
        var_dump($this->dao->get($course));
        $this->addToView('course', $this->dao->get($course));

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function store(){
        $request = Request::all($this->validations());
        $course = new Course();
        $course->name = $request->name;

        $this->dao->save($course);

        $this->redirect($this->getContext()['base_url'] . '/curso');
    }

    public function update()
    {
        $id = Request::getPost("id");
        $request = Request::all($this->validations());

        $course = new Course();
        $course->name = $request->name;

        $this->dao->save($course, ["id" => $id]);

        $this->redirect($this->getContext()['base_url'] . '/curso');
    }

    public function destroy()
    {
        $id = Request::getParam('id');
        $course = new course();
        $course->id = $id;

        $this->dao->delete($course);
        $this->redirect($this->getContext()['base_url'] . '/curso');

    }

    public function validations(){
        return [
            'name',
        ];
    }
}