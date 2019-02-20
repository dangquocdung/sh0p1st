@section('vendors-categoty-products-page-content')
<?php if(isset($vendor_products['breadcrumb_html'])){?>
  <div class="categories-products-list">
    @include('pages.frontend.frontend-pages.vendor-categories-products')
    @yield('vendor-categories-products-content')
  </div>
<?php }?>
@endsection 