
@include('layouts.partials.header')

@include('layouts.partials.topbar')
<div class="d-flex">
    @include('layouts.partials.sidebar')
    <div class="content p-4" style="">
        @yield('content')
    </div>
</div>

@include('layouts.partials.footer')