<?php

use App\Services\Twitter;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// app()->singleton('example', function(){

//     return new \App\Example;

// }); 

// app()->singleton('twitter', function(){

//     //THE USUAL THING WOULD BE TO GRAB THE API KEY FROM THE CONFIG SERVICES FILE. THIS WOULD HAVE BEEN SET IN THE .ENVFILE AS SHOWN BELOW
//     // return new Twitter(config('services.twitter.api_key'));

//     //BUT WE WILL INSERT THE KEY MANUALLY
//     return new \App\Services\Twitter('afhkhgfsnnjglfga');

//     //SO FROM THE ABOVE, WHENEVER WE REQUEST TWITTER OUT OF THE SERVICE CONTAINER, IT RETURNS A NEW INSTANCE OF THE TWITTER CLASS THAT ACCEPTS THE API KEY THROUGH A CONSTRUCTOR
// }); 



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});


//ROUTING CONVENTIONS

//GET => TO GET DATA FROM A RESOURCE
//POST => TO POST DATA TO A RESOURCE
//PATCH => TO UPDATE A RESOURCE
//DELETE => TO DELETE OR DESTROY THE RESOURCE

/*

DIFFERENT WAYS WE CAN INTERACT WITH A PROJECT

GET /projects (index) => TO SHOW ALL PROJECTS

GET /projects/create (create) => TO SHOW A FORM TO CREAETE A NEW PROJECT

GET /projecs/1 (show) => TO SHOW A SINGLE PROJECT

POST /projects (store) => TO PERSIST/STORE A PROJECT

GET /projects/1/edit (edit) => TO SHOW A FORM TO EDIT A PROJECT

PATCH /projects/1 (update) => TO UPDATE A PROJECT

DELETE /projects/1 (destroy) => TO DELETE A PROJECT

*/

/*
//FETCH ALL PROJECTS
Route::get('/projects', 'ProjectsController@index');

//FETCH A FORM TO CREATE A NEW PROJECT
Route::post('/projects', 'ProjectsController@store');

//DISPLAY A PARTICULAR PROJECT
Route::get('/projects/{project}', 'ProjectsController@show');

//STORE THE PROJECT FROM THE SUBMITTED FORM 
Route::get('/projects/create', 'ProjectsController@create');

//DISPLAY A PROJECT TO BE EDITED
Route::get('/projects/{project}/edit', 'ProjectsController@edit');

//UPDATE THE EXISTING FORM FROM THE SUBMITTED DATA
Route::patch('/projects/{project}', 'ProjectsController@update');

//DELETE AN EXISTING PROJECT
Route::delete('projects/{project}', 'ProjectsController@destroy');

*/


//L A R A V E L   H A S   A   S H O R T C U T   T O   T H E   A B O V E

//MIDDLEWARE ADDED FOR AUTHENTICATION
Route::resource('projects', 'ProjectsController');
// ->middleware('can:view,project')

//WITH THIS, WHEN YOU RUN php artisan route:list to show all the routes it displays all the routes we initially set(note that all the routes above follow the normal routing convention thats why theyll all have the same name)

//SO ALL WE NEED TO DO IS GO TO THE CONTROLLER AND RUN THE ROUTING METHODS ABOVE.

//FOR COMPLETTING THE PROJECT TASKS ON TICK
// Route::patch('tasks/{task}', 'TasksController@update');

//OR

//PROJECTTASKS (name of controller) FOR A CLEARER APPROACH AS TO WHICH TASKS WERE TO UPDATE

//DIFFERENCE BETWEEN THIS AND THE ABOVE IS THE CONTROLLER NAME
//NOTE: IT IS JUST A NAMING CONVENTION OF PERSONAL CHOICE TO MAKE IDENTIFICATION EASIER
Route::patch('tasks/{task}', 'ProjectTasksController@update');

//ROUTE TO CREATE A NEW TASK
Route::post('projects/{project}/tasks', 'ProjectTasksController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
