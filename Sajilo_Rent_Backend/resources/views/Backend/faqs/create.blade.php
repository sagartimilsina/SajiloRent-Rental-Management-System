@extends('backend.layouts.main')

@section('title', isset($faq) ? 'Edit FAQ' : 'Create FAQ')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($faq) ? 'Edit FAQ' : 'Create FAQ' }}</h5>
                        <div class="d-flex align-items-center">
                            <small class="text-muted">Fill in the details below</small>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success mb-3">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form id="faq-form"
                            action="{{ isset($faq) ? route('faqs.update', $faq->id) : route('faqs.store') }}" method="POST">
                            @csrf
                            @if (isset($faq))
                                @method('PUT')
                            @endif

                            <!-- Question Input -->
                            <div class="mb-3">
                                <label for="question" class="form-label">Question</label>
                                <input type="text" id="question" name="question"
                                    class="form-control @error('question') is-invalid @enderror"
                                    value="{{ old('question', isset($faq) ? $faq->question : '') }}" required
                                    placeholder="Enter the FAQ question">
                                @error('question')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Answer Textarea -->
                            <div class="mb-3">
                                <label for="answer" class="form-label">Answer</label>
                                <textarea id="answer" name="answer"
                                    class="form-control @error('answer') is-invalid @enderror" required
                                    placeholder="Provide a detailed answer">{{ old('answer', isset($faq) ? $faq->answer : '') }}</textarea>
                                @error('answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Publish Status -->
                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input" id="faq_publish_status" name="faq_publish_status"
                                    value="1"
                                    {{ old('faq_publish_status', isset($faq) && $faq->faq_publish_status ? 'checked' : '') }}>
                                <label for="faq_publish_status" class="form-check-label">Publish this FAQ</label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">
                                {{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}
                            </button>
                            <a href="{{ route('faqs.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Summernote
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
