@include('frontend.layouts.header')
@include('frontend.layouts.navbar')
<div id="main-content">
    @yield('content')
</div>
@include('frontend.layouts.script')

@include('frontend.layouts.footer')
