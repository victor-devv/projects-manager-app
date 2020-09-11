@extends('layout')


@section('content')

    <h1 class="title" style = "margin-top: 3rem;">PROJECTS</h1>

    <ul>
        @foreach ($projects as $project)

            <li>

                <a href="/projects/{{ $project->id }}">
                    {{$project->title}}
                </a>
                
            </li>

        @endforeach

    </ul>

@endsection