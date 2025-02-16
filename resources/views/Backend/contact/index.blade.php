// index.blade.php
@extends('backend.layouts.main')
@section('title', 'Contact Info')
@section('content')
    <div class="container py-5">
        <div class="card">
            <div class="card-header">Contact Information</div>
            <div class="card-body">
                <p><strong>Address:</strong> {{ $contactInfo->address }}</p>
                <p><strong>Primary Phone:</strong> {{ $contactInfo->phone }}</p>
                <p><strong>Secondary Phone:</strong> {{ $contactInfo->phone_2 }}</p>
                <p><strong>Primary Email:</strong> {{ $contactInfo->email }}</p>
                <p><strong>Secondary Email:</strong> {{ $contactInfo->email_2 }}</p>
                <p><strong>Social Links:</strong></p>
                <ul>
                    @php
                        $socialLinks = is_array($contactInfo->social_links)
                            ? $contactInfo->social_links
                            : json_decode($contactInfo->social_links, true);
                    @endphp

                    @foreach ($socialLinks as $link)
                        <li><i class="{{ $link['icon'] }}"></i> <a href="{{ $link['link'] }}">{{ $link['name'] }}</a></li>
                    @endforeach
                </ul>
                <a href="{{ route('contact.edit') }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection
