@extends('layouts.admin')

@section('content')
    <div class="project">
        <div class="container">
            <div class="row justify-content-around">
                @foreach ($projects as $project)
                    <div class="col-12">
                        <div class="card mt-4 p-4 text-center">
                            <div class="card-header">
                                <strong>Author: </strong>{{ $project->user_id }}
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h2>{{ $project->title }}</h2>
                                </div>
                                <div class="card-subtitle">
                                    <h4>{{ $project->argument }}</h4>
                                </div>
                                <p><strong>Description: </strong><br>
                                    {{ $project->description }}
                                </p>
                            </div>
                            <div class="card-footer text-muted">
                                <span><strong>Start date: </strong>{{ $project->start_date }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $projects->links() }}
    </div>
@endsection
