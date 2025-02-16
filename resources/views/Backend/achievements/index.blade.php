@extends('backend.layouts.main')

@section('title', 'Achievements')

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-lg-12">
                <h2>Achievements</h2>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="text-primary">Achievement List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table border-top">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($achievements as $index => $achievement)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $achievement->title }}</td>
                                        <td>{{ $achievement->count }}</td>
                                        <td>
                                            <a href="{{ route('achievements.edit', $achievement->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
