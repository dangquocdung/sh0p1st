@include('includes.frontend.header-content-custom-css')

<div id="header_content" class="header-before-slider header-background">
  <div class="container">
    <div class="row">
      <div class="col-5 col-md-6">
        <div class="currency-lang">
          <div class="dropdown change-multi-currency">
            @if(get_frontend_selected_currency())
            <a class="dropdown-toggle" href="#" data-hover="dropdown" data-toggle="dropdown">
              <span class="d-none d-md-inline">{!! get_currency_name_by_code( get_frontend_selected_currency() ) !!}</span>
              <span class="d-md-none d-xs-inline  fa fa-money"></span>
              @if(count(get_frontend_selected_currency_data()) >0)
              <span class="caret"></span>
              @endif
            </a>
            @endif
            <div class="dropdown-content">
              @if(count(get_frontend_selected_currency_data()) >0)
                @foreach(get_frontend_selected_currency_data() as $val)
                  <a href="#" data-currency_name="{{ $val }}">{!! get_currency_name_by_code( $val ) !!}</a>
                @endforeach
              @endif
            </div>
          </div>
          
          <div class="dropdown language-list">
            @if(count(get_frontend_selected_languages_data()) > 0)
              @if(get_frontend_selected_languages_data()['lang_code'] == 'en')
                <a class="dropdown-toggle" href="#" data-hover="dropdown" data-toggle="dropdown">
                  <img src="{{ asset('public/images/'. get_frontend_selected_languages_data()['lang_sample_img']) }}" alt="lang"> <span class="d-none d-md-inline"> &nbsp; {!! get_frontend_selected_languages_data()['lang_name'] !!}</span> <span class="caret"></span>
                </a>
              @else
                <a class="dropdown-toggle" href="#" data-hover="dropdown" data-toggle="dropdown">
                  <img src="{{ get_image_url(get_frontend_selected_languages_data()['lang_sample_img']) }}" alt="lang"> <span class="d-none d-md-inline"> &nbsp; {!! get_frontend_selected_languages_data()['lang_name'] !!}</span> <span class="caret"></span>
                </a>
              @endif
            @endif
            <?php $available_lang = get_available_languages_data_frontend();?>  

            @if(is_array($available_lang) && count($available_lang) >0)
              <div class="dropdown-content">
                @foreach(get_available_languages_data_frontend() as $key => $val)
                  @if($val['lang_code'] == 'en')
                    <a href="#" data-lang_name="{{ $val['lang_code'] }}"><img src="{{ asset('public/images/'. $val['lang_sample_img']) }}" alt="lang"> &nbsp;{!! ucwords($val['lang_name']) !!}</a>
                  @else
                    <a href="#" data-lang_name="{{ $val['lang_code'] }}"><img src="{{ get_image_url($val['lang_sample_img']) }}" alt="lang"> &nbsp;{!! ucwords($val['lang_name']) !!}</a>
                  @endif
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
      
      <div class="col-7 col-md-6">
        <div class="float-right">
          <ul class="right-menu top-right-menu">
            <li class="wishlist-content">
              <a class="main" href="{{ route('my-saved-items-page') }}">
                <i class="fa fa-heart"></i> 
                <span class="d-none d-md-inline">{!! trans('frontend.frontend_wishlist') !!}</span> 
              </a>    
            </li>  

            <li class="users-vendors-login dropdown"><a href="#" class="main selected dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user" aria-hidden="true"></i> <span class="d-none d-md-inline">{!! trans('frontend.menu_my_account') !!}</span><span class="caret"></span></a>
              <div class="dropdown-menu dropdown-content my-account-menu">
                @if (Session::has('shopist_frontend_user_id'))
                <a href="{{ route('user-account-page') }}">{!! trans('frontend.user_account_label') !!}</a>
                @else
                <a href="{{ route('user-login-page') }}">{!! trans('frontend.frontend_user_login') !!}</a>
                @endif

                @if (Session::has('shopist_admin_user_id') && !empty(get_current_vendor_user_info()['user_role_slug']) && get_current_vendor_user_info()['user_role_slug'] == 'vendor')
                 <a target="_blank" href="{{ route('admin.dashboard') }}">{!! trans('frontend.vendor_account_label') !!}</a>
                @else
                 <a target="_blank" href="{{ route('admin.login') }}">{!! trans('frontend.frontend_vendor_login') !!}</a>
                @endif

                <a href="{{ route('vendor-registration-page') }}">{!! trans('frontend.vendor_registration') !!}</a>
              </div>
            </li>

            <li class="mini-cart-content">
              @include('pages.ajax-pages.mini-cart-html')
            </li>
          </ul>
        </div> 
      </div> 
    </div>    
      
    <div class="row new-extra-margin">  
      <div class="col-12 col-md-12 col-lg-3">
        @if(get_site_logo_image())
          <div class="logo d-none d-lg-inline"><img src="{{ get_site_logo_image() }}" alt="{{ trans('frontend.your_store_label') }}"></div>
        @endif
      </div> 
      <div class="col-8 col-md-8 col-lg-6">
        <form id="search_option" action="{{ route('shop-page') }}" method="get">
          <div class="input-group">
            <input type="text" id="srch_term" name="srch_term" class="form-control" placeholder="{{ trans('frontend.search_for_label') }}">
            <span class="input-group-btn">
              <button id="btn-search" type="submit" class="btn btn-default search-btn">
                <span class="fa fa-search"></span>
              </button>
            </span>
          </div>
        </form>
      </div> 
      <div class="col-4 col-md-4 col-lg-3"> 
        <a href="{{ route('product-comparison-page') }}" class="btn btn-light btn-compare"><i class="fa fa-exchange"></i> <span class="d-none d-lg-inline"> &nbsp; {!! trans('frontend.compare_label') !!}</span> <span class="compare-value"> (<?php echo $total_compare_item;?>)</span></a>
      </div>
    </div>
    
    <div class="row new-extra-margin">  
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <nav class="navbar navbar-expand-lg navbar-dark header-menu-nav" role="navigation">
          <div class="nav-control">
            <div class="nav-controler">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header_navbar_collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
              </button>
            </div>    
            <div class="nav-img">
              <img class="navbar-brand d-md-inline d-sm-inline d-lg-none d-xl-none" src="{{ get_site_logo_image() }}" alt="{{ trans('frontend.your_store_label') }}">
            </div>
          </div>  
          
          <div class="collapse navbar-collapse" id="header_navbar_collapse">
            <ul class="all-menu nav navbar-nav">
              @if(Request::is('/'))
                <li><a href="{{ route('home-page') }}" class="main selected">{!! trans('frontend.home') !!}</a></li>
              @else
                <li><a href="{{ route('home-page') }}" class="main">{!! trans('frontend.home') !!}</a></li>
              @endif
              
              <li class="dropdown mega-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{!! trans('frontend.shop_by_cat_label') !!}  <span class="caret"></span></a>
                <ul class="dropdown-menu mega-dropdown-menu mega-menu-cat row clearfix">
                  @if(count($productCategoriesTree) > 0)
                    <?php $i = 1; $j = 0;?>
                    @foreach($productCategoriesTree as $cat)
                      @if($i == 1)
                      <?php $j++; ?>
                      <li class="col-xs-12 col-sm-4">  
                      @endif
                      
                      <ul>
                        @if(isset($cat['parent']) && $cat['parent'] == 'Parent Category')  
                        <li class="dropdown-header">
                            @if( $cat['img_url'] )
                            <img src="{{ get_image_url($cat['img_url']) }}"> 
                            @else
                            <img src="{{ default_placeholder_img_src() }}"> 
                            @endif
                            
                            {!! $cat['name'] !!}
                        </li>
                        @endif
                        @if(isset($cat['children']) && count($cat['children']) > 0)
                          @foreach($cat['children'] as $cat_sub)
                            <li class="product-sub-cat22"><a href="{{ route('categories-page', $cat_sub['slug']) }}">{!! $cat_sub['name'] !!}</a></li>
                            @if(isset($cat_sub['children']) && count($cat_sub['children']) > 0)
                              @include('pages.common.category-frontend-loop-home', $cat_sub)
                            @endif
                          @endforeach
                        @endif
                      </ul>
                      
                      @if($i == 1)
                      </li>
                      <?php $i = 0;?>
                      @endif
                      
                      @if($j == 3 || $j == 4)
                      <div class="clear-both"></div>
                      <?php $j = 0; ?>
                      @endif
                      
                      <?php $i ++;?>
                    @endforeach
                  @endif
                </ul>
              </li>
              
              @if(Request::is('shop'))
                <li><a href="{{ route('shop-page') }}" class="main selected">{!! trans('frontend.all_products_label') !!}</a></li>
              @else
                <li><a href="{{ route('shop-page') }}" class="main">{!! trans('frontend.all_products_label') !!}</a></li>
              @endif

              @if(Request::is('checkout'))
                <li><a href="{{ route('checkout-page') }}" class="main selected">{!! trans('frontend.checkout') !!}</a></li>
              @else
                <li><a href="{{ route('checkout-page') }}" class="main">{!! trans('frontend.checkout') !!}</a></li>
              @endif

              @if(Request::is('cart'))
                <li><a href="{{ route('cart-page') }}" class="main selected">{!! trans('frontend.cart') !!}</a></li>
              @else
                <li><a href="{{ route('cart-page') }}" class="main">{!! trans('frontend.cart') !!}</a></li>
              @endif

              @if(Request::is('blogs'))
                <li><a href="{{ route('blogs-page-content') }}" class="main selected">{!! trans('frontend.blog') !!}</a></li>
              @else
                <li><a href="{{ route('blogs-page-content') }}" class="main">{!! trans('frontend.blog') !!}</a></li>
              @endif

              @if(count($pages_list) > 0)
              <li>
                <div class="dropdown custom-page">
                  <a class="dropdown-toggle" href="#" data-hover="dropdown" data-toggle="dropdown"> {!! trans('frontend.pages_label') !!} 
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    @foreach($pages_list as $pages)
                    <li> <a href="{{ route('custom-page-content', $pages['post_slug']) }}">{!! $pages['post_title'] !!}</a></li>
                    @endforeach
                  </ul>
                </div>
              </li>
              @endif
              
              @if(Request::is('stores'))
                <li><a href="{{ route('store-list-page-content') }}" class="main selected menu-name">{!! trans('frontend.vendor_account_store_list_title_label') !!}</a></li>
              @else
                <li><a href="{{ route('store-list-page-content') }}" class="main menu-name">{!! trans('frontend.vendor_account_store_list_title_label') !!}</a></li>
              @endif
            </ul>
          </div>
        </nav>
      </div>  
    </div>    
  </div>
</div>

@if($appearance_all_data['header_details']['slider_visibility'] == true && Request::is('/'))
  <?php $count = count(get_appearance_header_settings_data());?>
  @if($count > 0)
  <div class="header-with-slider">
    <div id="slider_carousel" class="carousel slide" data-ride="carousel">
      <a class="carousel-control-prev" href="#slider_carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#slider_carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

      <?php $numb = 1; ?>
      <div class="carousel-inner">
        @foreach(get_appearance_header_settings_data() as $img)
          @if($numb == 1)
            <div class="carousel-item active">
              @if($img->img_url)
                <img src="{{ get_image_url($img->img_url) }}" class="d-block w-100" alt="slide" />
              @endif
            </div>
          @else
            <div class="carousel-item">
              @if($img->img_url)
                <img src="{{ get_image_url($img->img_url) }}" class="d-block w-100" alt="slide" />
              @endif
            </div>
          @endif
          <?php $numb++ ; ?>
        @endforeach
      </div>
    </div>
  </div>
  @else
  <div class="header-with-slider">
    <div id="slider_carousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{ asset('public/images/sunglass.jpg') }}" class="d-block w-100" alt="slide" />
        </div>
      </div>
    </div>
  </div>
  @endif
@endif