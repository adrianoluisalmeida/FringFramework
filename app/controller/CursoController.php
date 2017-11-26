<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 21:47
 */

class CursoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function main()
    {
        $this->setView('curso/main.html');//view
        $curso = new Curso();//classe do model
        $this->addToView('cursos', $this->dao->getAll($curso)); //parametros que passam pra view + consulta

        return $this->twig->render($this->getView(), $this->getContext()); //une addToView + setView para exibir a view com os parametros
    }

    public function create()
    {
        $this->setView('curso/create.html');
        $this->addToView('departamentos', ['Informática', 'Saúde','Engenharia','Rurais','Exatas','Artes','Educação', 'Sociais e Humanas']); //parametros que passam pra view + consulta

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function edit()
    {
        $id = Request::getParam('id');
        $this->setView('curso/edit.html');

        $this->addToView('departamentos', ['Informática', 'Saúde','Engenharia','Rurais','Exatas','Artes','Educação', 'Sociais e Humanas']); //parametros que passam pra view + consulta
        $curso = new Curso();
        $curso->id = $id;
        $this->addToView('curso', $this->dao->get($curso));

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function store()
    {
        $request = Request::all($this->validations());


        $this->initDao();
        $curso = new Curso();
        $curso->nome = $request->nome;
        $curso->semestres = (int)$request->semestres;
        $curso->vagas = (int)$request->vagas;
        $curso->departamento = $request->departamento;
        $curso->apresentacao = $request->apresentacao;

        foreach ($_POST['disciplinas'] as $key => $disc) {
            $disciplina[$key] = new Disciplina();
            $disciplina[$key]->nome = $disc['nome'];
            $disciplina[$key]->codigo = $disc['codigo'];
            $disciplina[$key]->objetivos = $disc['objetivos'];
            $disciplina[$key]->programa = $disc['programa'];
        }

        $curso->disciplinas = $disciplina;

        $id = $this->dao->save($curso);


        $this->redirect($this->getContext()['base_url'] . '/curso');
    }

    public function update()
    {
        $id = Request::getPost("id");
        $request = Request::all($this->validations());

        $this->initDao();


        $curso = new Curso();
        $curso->nome = $request->nome;
        $curso->semestres = (int)$request->semestres;
        $curso->vagas = (int)$request->vagas;
        $curso->departamento = $request->departamento;
        $curso->apresentacao = $request->apresentacao;

        foreach ($_POST['disciplinas'] as $key => $disc) {
            $disciplina[$key] = new Disciplina();
            $disciplina[$key]->nome = $disc['nome'];
            $disciplina[$key]->codigo = $disc['codigo'];
            $disciplina[$key]->objetivos = $disc['objetivos'];
            $disciplina[$key]->programa = $disc['programa'];
        }
        $curso->disciplinas = $disciplina;


        $this->dao->save($curso, ["id" => $id]);



        $this->redirect($this->getContext()['base_url'] . '/curso');
    }

    public function destroy()
    {
        $id = Request::getParam('id');
        $curso = new Curso();
        $curso->id = (int) $id;

        $this->dao->delete($curso);
        $this->redirect($this->getContext()['base_url'] . '/curso');

    }

    public function validations()
    {
        return [
            'nome',
            'semestres',
            'modalidade',
            'vagas',
            'departamento',
            'apresentacao'
        ];
    }
}