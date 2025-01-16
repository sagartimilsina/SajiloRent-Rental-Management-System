@extends('backend.layouts.main')

@section('title', isset($faq) ? 'Edit faq' : 'Create faq')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($faq) ? 'Edit FAQ' : 'Create FAQ' }}</h5>
                        <div class="d-flex align-items-center">
                            <small class="text-muted">Fill in faq details</small>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form id="faq-form"
                            action="{{ isset($faq) ? route('faqs.update', $faq->id) : route('faqs.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($faq))
                                @method('PUT')
                            @endif

                            <!-- Name Input -->
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <div class="input-group">
                                            <select id="category_id" name="category_id"
                                                class="form-select @error('category_id') is-invalid @enderror">
                                                <option value="" selected>Select a category</option>
                                                <option value="0" {{ old('category_id') == 0 ? 'selected' : '' }}>
                                                    Pricing</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ (isset($faq) && $faq->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="question" class="form-label">Question</label>
                                    <input type="text" id="question" name="question"
                                        class="form-control @error('question') is-invalid @enderror"
                                        value="{{ old('question', isset($faq) ? $faq->question : '') }}" required autofocus
                                        placeholder="Enter question">
                                    @error('question')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- answer Textarea -->
                            <div class="mb-3">
                                <label for="answer" class="form-label">Answer</label>
                                <textarea id="answer" name="answer" class="form-control @error('answer') is-invalid @enderror">{{ old('answer', isset($faq) ? $faq->answer : '') }}</textarea>
                                @error('answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
         
            // Summernote Initialization
            $('#answer').summernote({
                placeholder: 'Enter a detailed answer...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endsection
