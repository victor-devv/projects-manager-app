@extends('layout')

@section('content')

    <!-- NOTE THAT THE $project IS PASSED TO THIS VIEW FROM THE PROJECTS CONTROLLER SHOW FUNCTION. $project IS THE PROJECT MODEL WHICH WAS PASSED IN THE FUNCTION WIA ROUTE MODEL BINDING (Project $project) i.e (MODEL VARIABLE) 

    (Project $project) === $project = new App\Project in tinker  
    -->


    <h1 class = "title">{{ $project->title }}</h1>

    <!-- CONDITIONAL AUTHORIZATION EXAMPLE -->
<!--     
    @can('view', $project)

        <h1>AUTHORIZED</h1>

    @endcan
 -->
    <div class="content">{{ $project->description }}</div>

    <p style= "margin-bottom: 1rem;">
        <a href="/projects/{{ $project->id }}/edit">Edit</a>
    </p>


    <!-- DISPLAY TASKS -->
    <!-- $project->tasks utilizes the tasks method in the projecrt model to grab all tasks associated to a model -->

    <!-- THOUGH TASKS IS A METHOD, IT IS CALLED AS A PROPERTY HERE. IT IS QUITE NORMAL. HOWEVER, IF YOU WANNA BE SPECIFIC ON THE PARTICULAR TASK, THEN YOULL CALL TASKS AS A METHOD EG $project->tasks()->where... -->

    @if ($project->tasks->count())

        <div class="box">

            @foreach ($project->tasks as $task)

                <div>

                    <form method = "POST" action="/tasks/{{ $task->id }}">
                        @method('PATCH')
                        @csrf
                        <label class= "checkbox {{ $task->completed ? 'is-complete' : '' }}" for="completed">
                            <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                            {{ $task->description }}
                        </label>

                    </form>
                
                </div>

            @endforeach

        </div>

    @endif

    <!-- ADD NEW TASKS -->

    <form class="box" style= "margin-top: 1rem;" method="POST" action="/projects/{{ $project->id }}/tasks">

        @csrf

        <div class="field">

            <label for="description" class="label">New Task</label>

            <div class="control">

                <input type="text" class="input" name="description" placeholder="New Task" required>  

            </div>   

        </div>

        <div class="field">

            <div class="control">

                <button type="submit" class="button is-link">Add Task</button>

            </div>

        </div>

        <!--VALIDATION ERRORS-->
        @include('errors')

    </form>



@endsection