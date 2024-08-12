<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ url('/')}}/assets/"
  data-template="vertical-menu-template">
   @include('includes.admin_head')

  <body>
    <!-- Content -->

      @yield('content')

    <!-- / Content -->
 @include('includes.admin_footerjs')
  </body>
</html>
