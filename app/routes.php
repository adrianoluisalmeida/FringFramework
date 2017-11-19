<?php

Route::set("/", "HomeController@main");
Route::set("/home", "HomeController@main");
Route::set("/about", "AboutController@main");

//exemplos
Route::set("/example", "ExampleController@main");
Route::set("/example/create", "ExampleController@create");
Route::set("/example/edit", "ExampleController@edit");
Route::set("/example/store", "ExampleController@store");
Route::set("/example/update", "ExampleController@update");
Route::set("/example/remove", "ExampleController@destroy");

//cursos
Route::set("/curso", "CursoController@main");
Route::set("/curso/create", "CursoController@create");
Route::set("/curso/edit", "CursoController@edit");
Route::set("/curso/store", "CursoController@store");
Route::set("/curso/update", "CursoController@update");
Route::set("/curso/remove", "CursoController@destroy");

//departamentos
Route::set("/departamento", "DepartamentoController@main");
Route::set("/departamento/create", "DepartamentoController@create");
Route::set("/departamento/edit", "DepartamentoController@edit");
Route::set("/departamento/store", "DepartamentoController@store");
Route::set("/departamento/update", "DepartamentoController@update");
Route::set("/departamento/remove", "DepartamentoController@destroy");

//Atuacao
Route::set("/atuacao", "DepartamentoController@main");
Route::set("/atuacao/create", "DepartamentoController@create");
Route::set("/atuacao/edit", "DepartamentoController@edit");
Route::set("/atuacao/store", "DepartamentoController@store");
Route::set("/atuacao/update", "DepartamentoController@update");
Route::set("/atuacao/remove", "DepartamentoController@destroy");

//Disciplinas
Route::set("/disciplina", "DisciplinaController@main");
Route::set("/disciplina/create", "DisciplinaController@create");
Route::set("/disciplina/edit", "DisciplinaController@edit");
Route::set("/disciplina/store", "DisciplinaController@store");
Route::set("/disciplina/update", "DisciplinaController@update");
Route::set("/disciplina/remove", "DisciplinaController@destroy");
