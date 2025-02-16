// edit.blade.php
@extends('backend.layouts.main')
@section('title', 'Edit Contact Info')
@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header">Edit Contact Information</div>
        <div class="card-body">
            <form action="{{ route('contact.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ $contactInfo->address }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $contactInfo->phone }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Second Phone</label>
                    <input type="text" name="phone_2" class="form-control" value="{{ $contactInfo->phone_2 }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $contactInfo->email }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Second Email </label>
                    <input type="email" name="email_2" class="form-control" value="{{ $contactInfo->email_2 }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Social Links</label>
                    @php
                        $socialLinks = is_array($contactInfo->social_links) ? $contactInfo->social_links : json_decode($contactInfo->social_links, true);
                    @endphp
                    @foreach ($socialLinks as $key => $link)
                        <div class="d-flex mb-2">
                            <input type="text" name="social_links[{{ $key }}][name]" class="form-control me-2" placeholder="Platform Name" value="{{ $link['name'] }}">
                            <input type="text" name="social_links[{{ $key }}][link]" class="form-control me-2" placeholder="URL" value="{{ $link['link'] }}">
                            <input type="text" name="social_links[{{ $key }}][icon]" class="form-control" placeholder="Icon Class" value="{{ $link['icon'] }}">
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
