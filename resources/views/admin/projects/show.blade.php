@extends('layouts.admin')

@section('content')
    <div class="project">
        <div class="container">
            <div class="card mt-4 p-4 text-center">
                <div class="card-header mb-2">
                    <h4>
                        <strong>Author: </strong>{{ $project->author }}
                    </h4>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <div class="type">
                        <p>
                            <strong>Type: </strong>{{$project->type->name}}
                        </p>
                    </div>
                    <div class="buttons">
                        <a href="{{ route('admin.projects.edit', $project->slug) }}" class="me-2 btn btn-warning d-inline-block">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form class="d-inline-block form-delete" action="{{route('admin.projects.destroy', $project->slug)}}" method="POST" data-element-name="{{$project->title}}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-title mb-3">
                        <h2>{{ $project->title }}</h2>
                    </div>
                    <div>
                        <p>
                            <strong>Technology: </strong> 
                            @foreach ($project->technologies as $technology)
                                <span class="badge rounded-pill" style="background-color: {{ $technology->color }}">
                                    {{ $technology->name }}
                                </span>
                            @endforeach
                        </p>
                    </div>
                    <div class="card-image mb-3">
                        @if (str_starts_with($project->image, 'http'))
                        <img src="{{$project->image}}" alt="project-image" class="img-fluid">
                        @else
                        <img src="{{asset('storage/' . $project->image)}}" alt="project-image" class="img-fluid">
                        @endif
                    </div>
                    <div class="card-subtitle mb-4">
                        <h4>{{ $project->argument }}</h4>
                    </div>
                    <p><strong>Description: </strong><br>
                        {{ $project->description }}
                    </p>
                </div>
                <div class="card-footer text-muted">
                    <span><strong>Start date: </strong>{{ $project->start_date }}</span>
                </div>
                <div class="buttons d-flex justify-content-between mt-3">
                    @if (isset($previousButton))                        
                        <a href="{{ route('admin.projects.show', $previousButton->slug) }}" class="btn btn-primary d-inline-block">
                    @else
                        <a href="" class="btn btn-primary d-inline-block disabled">
                    @endif
                            Previous
                        </a>

                    @if(isset($nextButton))                        
                        <a href="{{ route('admin.projects.show', $nextButton->slug) }}" class="btn btn-primary d-inline-block">
                    @else
                        <a href="" class="btn btn-primary d-inline-block disabled">
                    @endif
                            Next
                        </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite('resources/js/delete.js')
@endsection
