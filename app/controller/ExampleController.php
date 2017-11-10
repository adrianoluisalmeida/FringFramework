<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:47
 */

class ExampleController extends Controller
{

    public function main()
    {
        $this->setView('example/main.html');
        $this->addToView('examples', Example::getAll());

//        var_dump( $this->getContext());
        return $this->twig->render($this->getView(), $this->getContext());

    }

    public function create()
    {
        $this->setView('example/create.html');
        var_dump('<pre>', $this->getContext(), '</pre>');
        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function store()
    {

        $request = Request::all($this->validations());

        $example = new Example();
        $example->name = $request->name;
        $example->email = $request->email;
        $example->phone = $request->phone;

        $example->save();

        $this->redirect($this->getContext()['base_url'] . '/example');
    }

    public function destroy()
    {
        $id = Request::getParam('id');
        $example = new Example();
        $example->id = $id;
        $example->delete();

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