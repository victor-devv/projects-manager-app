@extends('layout')


@section('content')

    <h1 class="title" style = "margin-top: 3rem;">Create a New Project</h1>

    <form method="POST" action="/projects" style = "margin-top: 1rem; margin-bottom: 1rem;">

        <!--THIS IS REQUIRED AT THE TOP OF ALL FORMS. IT HAS A SPECIAL VALUE THAT LARAVEL CHECKS AT THE BACK END. IT IS SOME SORT OF SECURITY FEATURE-->

        <!--CSRF MEANS CROSS-SITE REQUEST FORGERY-->
        {{ csrf_field() }}

        <div class="control" style = "margin-bottom: 1rem;">
            <input type="text" class="input {{ $errors->has('title') ? 'is-danger' : '' }}" name="title" placeholder="Project title" value="{{ old('title') }}">
        </div>

        <div class="control" style = "margin-bottom: 1rem;">
            <textarea name="description" class="textarea {{ $errors->has('description') ? 'is-danger' : '' }}" placeholder="Project description" cols="30" rows="10">{{ old('description') }}</textarea>
        </div>

        <div class="control">
            <button type="submit" class="button is-link">Create Project</button>
        </div>
        
        <!--VALIDATION ERRORS-->
        @include('errors')
    </form>

@endsection