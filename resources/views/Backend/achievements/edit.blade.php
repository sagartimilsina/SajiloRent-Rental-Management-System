@extends('backend.layouts.main')

@section('title', 'Edit Achievement')

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="text-primary">Edit Achievement</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('achievements.update', $achievement->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $achievement->title) }}">
                            </div>

                            <div class="mb-3">
                                <label for="count" class="form-label">Count</label>
                                <input type="number" class="form-control" id="count" name="count"
                                    value="{{ old('count', $achievement->count) }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('achievements.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
