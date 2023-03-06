@extends('layouts.admin')

@section('content')
    <div class="project">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-12">
                    @include('admin.projects.partials.form',
                    ['route'=> 'admin.projects.store',
                    'method'=>'POST', 
                    'project'=> $project ])
                </div>
            </div>
        </div>
    </div>
@endsection
