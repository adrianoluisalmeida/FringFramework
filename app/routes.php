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
Route::set("/curso", "CourseController@main");
Route::set("/curso/create", "CourseController@create");
Route::set("/curso/edit", "CourseController@edit");
Route::set("/curso/store", "CourseController@store");
Route::set("/curso/update", "CourseController@update");
Route::set("/curso/remove", "CourseController@destroy");

