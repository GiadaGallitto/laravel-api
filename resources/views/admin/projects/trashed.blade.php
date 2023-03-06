@extends('layouts.admin')

@include('partials.popup')

@section('content')
    <div class="container">

        {{-- @if (session('message'))
            <div class="alert alert-{{ session('message_class') }}">
                {{ session('message') }}
            </div>
        @endif --}}
        <div class="row justify-content-around">
            <div class="col-12 d-flex justify-content-end my-3">
                @if (count($projects))
                    <form class="d-inline delete double-confirm" action="{{ route('admin.projects.restore-all') }}"
                        method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" title="restore all">Restore all</button>
                    </form>
                @endif
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Author</th>
                        <th class="col">Concluded</th>
                        <th class="col text-center">Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <th scope="row" class="align-middle">{{ $project->id }}</th>
                            <td class="align-middle">{{ $project->title }}</td>
                            <td class="align-middle">{{ $project->start_date }}</td>
                            <td class="align-middle">{{ $project->user->name }}</td>
                            <td class="align-middle">
                                <form action="{{ route('admin.projects.toggle', $project->slug) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <button type="submit" title="{{ $project->concluded ? 'not-concluded' : 'concluded' }}"
                                        class="btn btn-outline"><i
                                            class="fa-2x fa-solid fas fa-fw {{ $project->concluded ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i></button>
                                </form>
                            </td>
                            <td class="text-center align-middle">
                                <form class="d-inline-block" action="{{ route('admin.projects.restore', $project->slug) }}"
                                    method="POST" data-element-name="{{ $project->title }}">
                                    @csrf
                                    <button type="submit" title="Restore" class="btn btn-sm btn-success"><i class="fa-solid fa-window-restore"></i></button>
                                </form>

                                <form class="d-inline-block form-delete double-confirm"
                                    action="{{ route('admin.projects.force-delete', $project->slug) }}" method="POST"
                                    data-element-name="{{ $project->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($projects->isEmpty())
                <div class="empty-message mt-3 text-muted">
                    <h5>No items in the bin</h5>
                </div>
            @endif
        </div>

    </div>
@endsection

@section('script')
    @vite('resources/js/delete.js')
@endsection
