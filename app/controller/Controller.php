<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:48
 */

abstract class Controller
{
    public $twig;
    public $template;
    public $templateContext = [];
    public $errors = [];
    protected $dao;

    public function __construct(){
        session_start();
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem('app/view');
        $this->twig = new Twig_Environment($loader, [
            'cache' => 'lib/view/cache',
            'strict_variables' => false
        ]);
        $this->twig->setCache(false);

        $host = $_SERVER['HTTP_HOST'];
        $host_upper = strtoupper($host);
        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $baseurl = "http://" . $host . $path;

        $this->templateContext['base_url'] = $baseurl; //em qualquer view carrega a variavel $base_url

        $this->initDao();
    }

    public function initDao(){
        $database = include(ROOT . 'app/config/database.php');
        $this->dao = $database['dbdrive'] == "mysql" ? new PdoDAO : new MongoDAO; //se é mysql usa o driver mysql, senao usa do mongodb
    }

    /**
     * Main default
     */
    public function main(){}

    /**
     * Add errors in application
     * @param $error
     */
    public function addError($error){
        $this->errors[] = $error;
    }


    /**
     * Set the view current
     * @param $template
     */
    public function setView($template){
        $this->template = $template; //adiciona template (view)
    }

    public function getView(){
        return $this->template;
    }


    /**
     * Add context variables to view
     * @param $name
     * @param $value
     */
    public function addToView($name, $value){
        $this->templateContext[$name] = $value; //adiciona contexto igual compact do laravel
    }

    public function getContext(){
        return $this->templateContext;
    }

    /**
     * Redirect Pages
     * @param $page
     */
    public function redirect($page){
        header("Location: {$page}"); //redirect
    }
}