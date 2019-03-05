<!doctype html>
<html>
<head>
    @include('includes.admin.head')
</head>
<body id="admin_panel" class="skin-blue sidebar-mini wysihtml5-supported">
  <div class="wrapper">
    @include('includes.admin.header')
    @include('includes.admin.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content-header">
        @yield('content-header')
      </section>
      <section class="content">
        @yield('content')
      </section>
    </div><!-- /.content-wrapper -->
    <input type="hidden" name="hf_base_url" id="hf_base_url" value="{{ url('/') }}">
    <input type="hidden" name="lang_code" id="lang_code" value="{{ $default_lang_code }}">
    <input type="hidden" name="site_name" id="site_name" value="admin">
    <div class="ajax-request-response-msg" style="display: none; background-color: #333;padding:20px 0px;position:fixed;width:100%;color:#DDD;bottom: 0px;z-index: 999;text-align: center;left: 0px; font-size:16px;"></div>
  </div><!-- ./wrapper -->
</body>
</html>