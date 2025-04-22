<!doctype html>
<html lang="en">
    @include('admin.layouts.head')

  <body >




        @include('admin.layouts.header')

        @include('admin.layouts.sidebar')




            @yield('content')








    @include('admin.layouts.script')
  </body>
</html>
