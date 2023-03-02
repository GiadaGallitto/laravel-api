@extends('layouts.admin')

@section('content')
    <div class="project">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-12 text-center mb-3">
                    <h6>Enter the data of the project and press the button to send it to the database</h6>
                </div>
                <div class="col-12">
                    @include('admin.projects.partials.form',
                    ['route'=> 'admin.projects.update', 'method'=> 'PUT', "project"=> $project])
                </div>
            </div>
        </div>
    </div>
@endsection
