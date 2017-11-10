<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:47
 */

class HomeController extends Controller
{

    public function main()
    {
        $this->setView('home.html');
        $this->addToView('teste', 'teste');

//        $user = new User();
//        $user->email = "testeq3332@teste.com.br";
//
//        if (!$user->delete()) {
//            return;
//        }

        return $this->twig->render($this->getView(), $this->getContext());

    }

}