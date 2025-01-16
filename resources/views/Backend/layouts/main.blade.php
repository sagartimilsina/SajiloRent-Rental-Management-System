{{-- @include('backend.layouts.header')
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    @include('backend.layouts.navbar')
    <div class="app-main">
        @include('backend.layouts.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                @yield('content')
            </div>
            {{-- <div class="create-ticket d-flex justify-content-end mr-5 mb-5  z-index-1">
                <a href=""> <span><i class="fa fa-question-circle-o fa-3x " title="Create Ticket"
                            aria-hidden="true"></i></span></a>
            </div> 

        </div>
    </div>
</div>
@include('backend.layouts.footer') --}}

@include('backend.layouts.header')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('backend.layouts.sidebar')
        <div class="layout-page">
            @include('backend.layouts.navbar')
            <div class="content-wrapper">
                @yield('content')
                @include('backend.layouts.footer')
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
@include('backend.layouts.script')
