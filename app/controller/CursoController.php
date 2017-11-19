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


        $this->addToView('departamentos', [['id' => 1, 'nome' => 'informatica']]); //parametros que passam pra view + consulta

        return $this->twig->render($this->getView(), $this->getContext());
    }

    public function edit()
    {
        $id = Request::getParam('id');
        $this->setView('curso/edit.html');
        $departamento = new Departamento();

//        $this->addToView('departamentos', $this->dao->getAll($departamento)); //parametros que passam pra view + consulta
        $this->addToView('departamentos', ['id' => 'informatica']); //parametros que passam pra view + consulta
        $curso = new Curso();
        $curso->id = $id;

//        var_dump('<pre>', $this->dao->get($curso), '</pre>');
//        die;

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
        $curso->departamento_id = (int)$request->departamento_id;
        $curso->apresentacao = $request->apresentacao;

        $disciplina[0] = new Disciplina();
        $disciplina[0]->nome = "teste22";
        $disciplina[0]->codigo = "teste_Desc";
        $disciplina[0]->objetivos = "teste_Desc";
        $disciplina[0]->programa = "teste_Desc";

        $disciplina[1] = new Disciplina();
        $disciplina[1]->nome = "teste333";
        $disciplina[1]->codigo = "teste_Desc2";
        $disciplina[1]->objetivos = "teste_Desc";
        $disciplina[1]->programa = "teste_Desc";

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
        $curso->departamento_id = (int)$request->departamento_id;
        $curso->apresentacao = $request->apresentacao;

        $disciplina[0] = new Disciplina();
        $disciplina[0]->nome = "teste22";
        $disciplina[0]->codigo = "teste_Desc";
        $disciplina[0]->objetivos = "teste_Desc";
        $disciplina[0]->programa = "teste_Desc";

        $disciplina[1] = new Disciplina();
        $disciplina[1]->nome = "teste31";
        $disciplina[1]->codigo = "teste_Desc2";
        $disciplina[1]->objetivos = "teste_Desc";
        $disciplina[1]->programa = "teste_Desc";
        $curso->disciplinas = $disciplina;

        $this->dao->save($curso, ["id" => $id]);
        $this->redirect($this->getContext()['base_url'] . '/curso');
    }

    public function destroy()
    {
        $id = Request::getParam('id');
        $curso = new Curso();
        $curso->id = $id;

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
            'departamento_id',
            'apresentacao',
//            'disciplinas'
        ];
    }
}