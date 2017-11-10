<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:47
 */

class PaginaController extends Controller
{

    public function main(){
        $this->setView('pagina2.html');
        $this->addToView('teste', 'teste');

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function create(){
        $this->setView('pagina2.html');
        $this->addToView('teste', 'teste');

        return $this->twig->render($this->getView(), $this->getContext());
    }

}