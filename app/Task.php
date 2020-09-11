<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [

        'completed', 'description', 'project_id'

    ];

    //JUST LIKE WE BUILT A METHOD WHICH GRABS EVERY TASKS THAT BELONGS TO A PROJECT THROUGH THE ELOQUENT RELATIONSHIP 'hasMany',  WE WILL CREATE A METHOD IN THE TASK MODEL THAT WILL GET THE PROJECT IN WHICH A TASK BELONGS TO

    //TO DO THAT, WE WILL USE THE ELOQUENT RELATIONSHIP 'belongsTo'

    public function project(){

        return $this->belongsTo(Project::class);

    }


    //COMPLETE A TASK

    //NOTE: THE PARAMETER FOR THE COMPLETE METHOD IS PASSED FROM THE PROJECTTASKSCONTROLLER.

    //THE METHOD WILL ONLY RUN IF THE VALUE OF THE PARAMETER IS TRUE i.e $completed = true

    public function complete($completed = true){

        $this->update(compact('completed'));

    }
}
