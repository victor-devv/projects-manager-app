@extends('layout')


@section('content')

    <h1 class="title" style = "margin-top: 3rem;">Edit Project</h1>


    <form method="POST" action="/projects/{{ $project->id }}" style = "margin-top: 1rem; margin-bottom: 1rem;">

        <!--THIS IS DONE BECAUSE BROWSERS DO NOT UNDERSTAND PATCH REQUESTS (WELL AS AT THE TIME OF THE RECORDING OF THE VIDEO LEARNED WITH). SO WE SET THE METHOD TO POST  BUT TELL LARAVEL THE ACTUAL METHOD WHICH IS PATCH -->
        {{ method_field('PATCH') }}

        {{ csrf_field() }}

        <div class="field">
            <label class="label" for="title">Title</label>

            <div class="control">
                <input type="text" class="input" name="title" placeholder="Title" value="{{ $project->title }}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="description">Description</label>

            <div class="control">
                <textarea name="description" class="textarea" cols="30" rows="10">{{ $project->description }}</textarea>
            </div>
        </div>

        <div class="field">

            <div class="control">
                <button type="submit" class="button is-link">Update Project</button>
            </div>

        </div>

    </form>

    @include('errors')

    <form method="POST" action="/projects/{{ $project->id }}">

        <!--QUICK BLADE METHODS FOR SPECIFYING THE MATHOD AND CSRF FIELD-->

        @method('DELETE')

        @csrf
        

        <div class="field">

            <div class="control">
                <button type="submit" class="button">Delete Project</button>
            </div>
            
        </div>

    </form>

@endsection