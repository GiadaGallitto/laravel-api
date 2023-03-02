@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header"><h4>Welcome {{$user->name}}!</h4></div>

                <div class="card-body">
                    <h6>You are logged in!</h6>
                    <p>Visit the site through the buttons to be able to view and manage your projects in your database directly from here!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
