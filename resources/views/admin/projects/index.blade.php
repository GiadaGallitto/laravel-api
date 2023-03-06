@extends('layouts.admin')

@section('content')
    <div class="container">

        @include('partials.popup')
        {{-- @if (session('message'))
            <div class="alert alert-{{ session('message_class') }}">
                {{ session('message') }}
            </div>
        @endif --}}

        <div class="row justify-content-around">
            <div class="col-12 d-flex justify-content-end my-3">
                @if ($trashed)
                    <a class="btn btn-danger me-3" href="{{ route('admin.projects.trashed') }}"><b>{{ $trashed }}</b>
                        item/s in
                        recycled bin</a>
                @endif
                <a class="btn btn-primary" href="{{ route('admin.projects.create') }}">
                    Add new Project
                </a>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Author</th>
                        <th scope="col">Technology</th>
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
                            <td class="align-middle">{{ $project->user_id }}</td>
                            <td class="align-middle">
                                @forelse ($project->technologies as $technology)
                                    <span class="me-1">
                                        {{ $technology->name }}
                                    </span>
                                @empty
                                    No technologies
                                @endforelse
                            </td>
                            <td class="align-middle">
                                <form action="{{ route('admin.projects.toggle', $project->slug) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <button type="submit" title="{{ $project->concluded ? 'concluded' : 'not-concluded' }}"
                                        class="btn btn-outline"><i
                                            class="fa-2x fa-solid fas fa-fw {{ $project->concluded ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i></button>
                                </form>
                            </td>
                            </td>
                            <td class="align-middle text-center">
                                <a title="Show" class="btn btn-dark"
                                    href="{{ route('admin.projects.show', $project->slug) }}"><i class="fa-solid fa-eye"></i></a>
                                <a title="Edit" class="btn btn-dark"
                                    href="{{ route('admin.projects.edit', $project->slug) }}"><i class="fa-solid fa-pencil"></i></a>

                                <form class="d-inline-block form-delete"
                                    action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST"
                                    data-element-name="{{ $project->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Delete" class="btn btn-dark"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $projects->links() }}
    </div>
@endsection

@section('script')
    @vite('resources/js/delete.js')
@endsection
