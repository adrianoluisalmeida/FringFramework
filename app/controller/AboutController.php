<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:47
 */

class AboutController extends Controller
{

    public function main()
    {
        $this->setView('about/main.html');
        $this->addToView('teste', 'teste');

        return $this->twig->render($this->getView(), $this->getContext());

    }

}