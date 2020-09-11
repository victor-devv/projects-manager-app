<?php

namespace App\Http\Controllers;

use \App\Project;

use App\Mail\ProjectCreated;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{

    public function __construct(){

        $this->middleware('auth');

        //IF YOU WANNA APPLY THE MIDDLEWARE ONLY TO SOME ACTIONS

        // $this->middleware('auth')->only(['store', 'update']);


        //IF YOU WANNA APPLY TO EVERYTHING EXCEPT

        // $this->middleware('auth')->except(['show']);
    }

    public function index(){
        //THIS FUNCTION WILL LOAD THE INDEX.BLADE.PHP FILE LOCATED IN THE PROJECTS FOLDER IN THE VIEWS FOLDER


        //THIS INSTANCE OF THE PROJECTS MODEL CLASS WILL PULL ALL THE PROJECTS' INFO FROM THE DB
        // $projects = Project::all();

        // IN A REAL LIFE PROJECT, YOU WOULD RARELY DISPLAY ALL. INSTEAD, YOU WOLD ONLY DISPLAY THE PROJECTS FOR THAT USER

        // $projects = Project::where('owner_id', auth()->id())->get();
         //i.e select * from projects where owner_id = authenticated users id

        // NOTE
        // auth()->id() == user id or null for guest
        // auth()->user() == user instance
        // auth()->check() == boolean true for available user or false for guest

        // if (auth()->guest){} == check if user is a guest

        // FOR EASY READABILITY

        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));

    }

    public function create(){
        //RETURNS VIEW TO CREATE A NEW PROJECT

        //THIS FUNCTION WILL LOAD THE CREATE.BLADE.PHP FILE LOCATED IN THE PROJECTS FOLDER IN THE VIEWS FOLDER
        return view('projects.create');

    }


    // (Project $project) === $project = new App\Project in tinker
    // (Project $project) IS CALLED (IMPLICIT) ROUTE MODEL BINDING
    // IT IS LARAVEL'S SIMPLE WAY OF INSTANTIATING THE PROJECT MODEL CLASS INTO A $project variable

    //ONE CAN ALSO INSTANTIATE THE CLASS BY RESOLEVING IT USING app() or resolve()

    //$project = app('App\Project');

    //YOU CAN AS WELL BIND/SINGLETON THE CLASS TO THE SERVICE CONTAINER THEN RESOLVE IT USING JUST THE CLASS NAME

    // app()->bind('project', function(){

    //     return new \App\Project;

    // }); 

    // app()->singleton('project', function(){

    //     return new \App\Project;

    // }); 

        //$project = app('project');


    //THIS IS QUITE USEFUL WHEN YOU WANNA INSTANTIATE ANOTHER CLASS IN A FUNCTION WHEN YOU HAV EALREADY INSTANTIATED ONE USING ROUTE MODEL BINDING

    public function show(Project $project){

        //==SERVICE CONTAINER EXAMPLE
        //LETS REQUEST TWITTER OUT OF THE SERVICE CONTAINER WHICH WAS BOUND IN WEB.PHP
        // $twitter = app('twitter');

        // dd($twitter);

        //RETURNS VIEW DISPLAYING EXISTING PROJECTS

        //SINCE WE ARE NOT PASSING THE WILD-CARD $ID IN THE FUNCTION, WE WILL NO LONGER HAVE TO FIRST FIND THE EXACT PROJECT BY THE ID. LARAVEL WILL DO THE WORK AT THE BACKEND FOR YOU

        //RESEARCH LARAVEL ROUTE-MODEL-BINDING

        //$project = Project::findOrFail($id);

        //THIS FUNCTION WILL LOAD THE SHOW.BLADE.PHP FILE LOCATED IN THE PROJECTS FOLDER IN THE VIEWS FOLDER AND PASS THE PROJECT OBJECT TO THE VIEW TO USE WHATEVER PROPERTY OR METHOD NEEDED
        
        // A   U   T   H   E   N   T   I   C   A   T   I   O   N


        //CURRENTLY ANY USER CAN VIEW ANY OTHER USER'S PROJECT IF HE KNOWS THE RIGHT URI. WE WILL FIX THIS

        // METHOD 1

        // if($project->owner_id !== auth()->id()){
        //     abort(403);
        // }

        // METHOD 2
        
        // abort_if($project->owner_id !== auth()->id(), 403);

        // METHOD 3
        // MAKE POLICY
        // $this->authorize('view', $project);

        // METHOD 4
        // LARAVEL'S GATE FACADE
        // if (\Gate::denies('view', $project)) {
        //    abort(403);
        // }

        // OR

        // abort_if(\Gate::denies('view', $project), 403);

        // OR

        abort_unless(\Gate::allows('view', $project), 403);

        // METHOD 5
        // THROUGH THE MIDDLEWARE. THE MIDDLEWARE WILL BE INCLUDED IN THE ROUTES FILE, FOR THE PROJECTSCONTROLLER
        
        return view('projects.show', compact('project'));

    }



    public function store(){


        //THIS FUNCTION WILL GRAB THE USER INPUTED DATA IN PROJECTS.CREATE
        //return request()->all(); //DISPLAY ALL USER INPUT

        //==  BEFORE STORING USER INPUTED DATA, WE MUST VALIDATE THE INPUTS. THIS IS A NOTHER SECURITY FEATURE FROM  

        //USING THE DATA COLLECTED FROM THE REQUEST, WE'LL CRATE A NEW PROJECT. HOWEVER, IT IS IMPORTANT TO NOTE THAT THERE ARE BETTER WAYS OF DOING THIS
        // $project = new Project();

        // $project->title = request('title');
        // $project->description = request('description');

        // $project->save();

        //NOTE: IN CASES WHERE THE USER LEAVES OUT ANY INPUT FIELD EMPTY, LARAVEL THROWS AN ERROR. TO AVOID THIS, TWO LAYERS OF VALIDATION ARE NEEDED, ONE ON THE CLIENT SIDE; ADDING REQUIRED AS AN ATTRIBUTE TO THE FIELDS. THE SERVER SIDE VALIDATIOIN IS AS THUS

        //TO AVOID REPEATING THE ATTRIBUTES, ITS EASIER TO ASSIGN THE VALIDATED ATTRIBUTES TO A VARIABLE THEN PASS IT TO THE MODEL BELOW

        // $attributes = request()->validate([
        //     //MIN AND MAX CHARACTER SET AS WELL
        //     'title' => ['required', 'min:3', 'max:30'],
        //     'description' => ['required', 'min:10', 'max:150']

        // ]);

        $attributes = $this->validateAttributes();

        //return $attributes;
        //THE ABOVE WILL REDIRECT BACK TO THE CURRENT PAGE AND SEND THE VALIDATION ERRORS. NOW YOU NEED TO GO TO THE CLIENT SIDE TO SET UP A NOTIFICATION DIV FOR ERRORS SO THE USER CAN FIX ALL EMPTY FIELDS

        //LARAVEL HAS A CREATE FUNCTION TO HELP CREATE A VAR FOR THAT MODEL CLASS. WE WILL USE THIS INSTEAD OF THE ABOVE METHOD

        // Project::create(request(['title', 'description']));

        //OR

        // Project::create([

        //     'title' => request('title'),
        //     'description' => request('description')

        // ]);

        //INSTEAD OF PASSING THE ATTRIBUTES FROM THE REQUEST AS SEEN ABOVE, WE WILL PASS THE VALIDATED ATTRIBUTES VARIABLE INSTEAD, TO MAKE OUR LINES OF CODE SHORTER

        //A  U  T  H  E  N  T  I  C  A  T  I  O  N
        //BEFORE CREATING A PROJECT WE HAVE TO PASS IN THE PROJECT OWNER_ID. 
        //TO PASS IT, WE HAVE TO INCLUDE THE OWNER ID IN TE ATTRIBUTES

        $attributes['owner_id'] = auth()->id();
        
        // OR
        // Project::create($attributes + ['owner_id' => auth()->id()]);

       $project = Project::create($attributes);

        //TO MAKE IT EVEN SHORTER

        /*

            Project::create(

                request()->validate([

                    'title' => ['required', 'min:3', 'max:30'],
                    'description' => ['required', 'min:10', 'max:150']

                ])

            );

        */

        //FOR THE ABOVE TO WORK, WE NEED TO SET THE ABOVE FIELDS TO THE FILLABLE PROPERTY IN THE PROJECT MODEL
        //THE GUARDED PROPERTIES ARE THOSE YOU DONT WANT TO BE FILLABLE FROMI THE CONTROLER(OR THE FORM) 

        //THIS IS A GREAT SECURITY FEATURE FROM LARAVEL AS USERS CAN EDIT HTML FROM INSPECT TOOLS AND SEND IN HIDDEN INPUTS BY GUESSING NAMES OF YOUR COLUMNS AND THEN AFFECTING YOUR DATABASE SERIOUSLY. 
        //THEREFORE THIS FILLABLE PROPERTY ONLY ALLOWS CERTAIN INPUTS THAT YOU ALLOW

        //SO HERE IN THE FRONTEND, WE CAN JUST SAY

        //Project::create(request()->all());

        // TO SEND AN EMAIL AFTER A PROJECT HAS BEEN CREATED

        \Mail::to('vheecthurikuomola@gmail.com')->send(
            new ProjectCreated($project)
        );

        //AFTER SAVING THE PROJECT, IT WOULD BE NICE TO REDIRECT TO THE PAGE THAT DISPLAYS ALL PROJECTS

        //note: redirect is a get request by default
        return redirect('/projects');

    }

    public function edit(Project $project){
        //RETURNS VIEW TO EDIT OR DELETE A PROJECT

        //WHAT IF THE USER INPUTS AN ID THAT ISN'T PRESENT IN THE DB

        //USE findorFail instead of find
        //IF THE ID DOESNT EXIST, IT REDIRECTS TO A 404 PAGE

        //SINCE WE ARE NOT PASSING THE WILD-CARD $ID IN THE FUNCTION, WE WILL NO LONGER HAVE TO FIRST FIND THE EXACT PROJECT BY THE ID. LARAVEL WILL DO THE WORK AT THE BACKEND FOR YOU
        //RESEARCH LARAVEL ROUTE-MODEL-BINDING

        //$project = Project::findOrFail($id);

        return view('projects.edit', compact('project'));


        //VALIDATION


    }

    public function update(Project $project){

        //DD STANDS FOR DUMP AND DIE. IT IS USEFUL FOR QUICK DEBUGGING

        //IT IS SIMILAR TO VAR_DUMP IN REGULAR PHP

        //LETS FETCH ALL THE SUBMITTED FIELDS WITH DD
        //dd(request()->all());

        //SINCE WE ARE NOT PASSING THE WILD-CARD $ID IN THE FUNCTION, WE WILL NO LONGER HAVE TO FIRST FIND THE EXACT PROJECT BY THE ID. LARAVEL WILL DO THE WORK AT THE BACKEND FOR YOU
        //RESEARCH LARAVEL ROUTE-MODEL-BINDING

        //$project = Project::findOrFail($id);

        // $project->title = request()->title;
        // $project->description = request()->description;

        // $project->save();

        //FOR CLEANER CODE

        // $attributes = request()->validate([
        //     //MIN AND MAX CHARACTER SET AS WELL
        //     'title' => ['required', 'min:3', 'max:30'],
        //     'description' => ['required', 'min:10', 'max:150']

        // ]);

        // $project->update($attributes);
        
        $project->update($this->validateAttributes());

        return redirect('/projects');
    }

    public function destroy(Project $project){
    
        //SINCE WE ARE NOT PASSING THE WILD-CARD $ID IN THE FUNCTION, WE WILL NO LONGER HAVE TO FIRST FIND THE EXACT PROJECT BY THE ID. LARAVEL WILL DO THE WORK AT THE BACKEND FOR YOU
        //RESEARCH LARAVEL ROUTE-MODEL-BINDING

        //$project = Project::findOrFail($id)->delete();

        $project->delete();
        return redirect('/projects');

    }

    //INSTEAD OF HAVING TO VAIDATE ATTRIBUTES EVERYTIME FOR METHODS, WHY NOT HAVE A METHOD THAT DOES ALL VALIDATIONS AND YOU CALL THE METHOD

    protected function validateAttributes(){

       return request()->validate([
            //MIN AND MAX CHARACTER SET AS WELL
            'title' => ['required', 'min:3', 'max:30'],
            'description' => ['required', 'min:10', 'max:150']

        ]);

    }


}
