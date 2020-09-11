<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

//IMPORT PROJECT MODEL
use App\Project;


class ProjectTasksController extends Controller
{

    //C  R  E  A  T  E    N  E  W    T  A  S  K  S 

    
    // (Project $project) === $project = new App\Project in tinker
    // (Project $project) IS CALLED (IMPLICIT) ROUTE MODEL BINDING
    // IT IS LARAVEL'S SIMPLE WAY OF INSTANTIATING THE PROJECT MODEL CLASS INTO A $project variable

    public function store(Project $project){
        
        //METHOD 1

        // Task::create([

        //     'project_id' => $project->id,

        //     'description' => request('description')
        // ]);

        //METHOD 2

        // L O G I C   E N C A P S U L A T I O N

        //INSTEAD OF CREATING THE TASK DIRECTLY IN THE CONTROLLER USING ::CREATE, WE ENCAPSULATE THE LOGIC AND CALL A METHOD PRESENT IN THE MODEL, THAT DOES THE SAME THING

        //ENAPSULATION BY CALLING METHODS MAKES IT MORE READABLE AND UNDERSTANDABLE ESPECIALLY TO BEGINNERS. 

        // $project->addTask(request('description'));

        //INPUT VALIDATION
        $attributes = request()->validate([
            'description' => 'required'
        ]);

        $project->addTask($attributes);


        //NEXT STEP IS TO ADD THE addTask FUNCTION TO THE PROJECT MODEL


        return back();


    }

    // M A R K   T A S K S   A S   C O M P L E T E D   O R   I N C O M P L E T E

    // (Task $task) === $project = new App\Project in tinker
    // (Task $task) IS CALLED (IMPLICIT) ROUTE MODEL BINDING
    // IT IS LARAVEL'S SIMPLE WAY OF INSTANTIATING THE PROJECT MODEL CLASS INTO A $task OBJECT

    public function update(Task $task){
       
        // $task->update([
        //     'completed' => request()->has('completed')
        // ]);

        // L O G I C   E N C A P S U L A T I O N
        
        //NOTE: THE PARAMETER FOR THE COMPLETE METHOD WILL RETURN TRUE IF THE BOX FOR COMPLETED IS TICKED
        //THE 'TRUE' WILL BE PASSED TO THE METHOD IN THE MODEL. THE METHOD WILL ONLY COMPLETE THE TASK IF TRUE

        $task->complete(request()->has('completed'));
        
        return back();
    }



}
