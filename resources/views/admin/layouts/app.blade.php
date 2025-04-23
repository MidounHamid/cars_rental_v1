<!doctype html>
<html lang="en">
@include('admin.layouts.head')

<body>



    @include('admin.layouts.header')

    @include('admin.layouts.sidebar')

    <div class="main-content">
             @yield('content')
    </div>








    @include('admin.layouts.script')
</body>

</html>
