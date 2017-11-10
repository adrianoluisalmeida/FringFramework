<?php

Route::set("/", "HomeController@main");
Route::set("/home", "HomeController@main");
Route::set("/about", "AboutController@main");

Route::set("/example", "ExampleController@main");
Route::set("/example/create", "ExampleController@create");
Route::set("/example/edit", "ExampleController@edit");
Route::set("/example/store", "ExampleController@store");
Route::set("/example/update", "ExampleController@update");
Route::set("/example/remove", "ExampleController@destroy");

Route::set("/pagina2/create}", "PaginaController@create");