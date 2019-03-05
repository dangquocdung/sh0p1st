@extends('layouts.frontend.master')
@section('title',  trans('frontend.brand_details_page_label') .' < '. get_site_title() )

@section('content')
<br>
<div class="container new-container">
  <div id="brand_single_page_main">
    <div class="row">
      <div class="col-md-4">
        <div class="brand-details">
          <div class="brand-info">
            <div class="brand-logo">
              @if($brand_details_by_slug['brand_details']['brand_logo_img_url'])
              <img src="{{ get_image_url($brand_details_by_slug['brand_details']['brand_logo_img_url']) }}" alt="brand-logo">
              @else
              <img src="{{ default_placeholder_img_src() }}" alt="no-brand-logo">
              @endif
            </div>
            <div class="brand-name">{!! $brand_details_by_slug['brand_details']['name'] !!},</div>
            <div class="brand-country"> {!! $brand_details_by_slug['brand_details']['brand_country_name'] !!}</div>
          </div>
          <div class="brand-description">
            <p>{!! string_decode($brand_details_by_slug['brand_details']['brand_short_description']) !!}</p>
          </div>
        </div>
      </div> 
      <div class="col-md-8">
          <div class="brand-products">
            @if(!empty($brand_details_by_slug['products']) && $brand_details_by_slug['products']->count() > 0)
            <div class="product-content">
              <div class="row">
                @foreach($brand_details_by_slug['products'] as $products)
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 extra-padding">
                    <div class="hover-product">
                      <div class="hover">
                        @if(get_product_image($products->id))
                        <img class="img-responsive" src="{{ get_image_url(get_product_image($products->id)) }}" alt="{{ basename(get_product_image($products->id)) }}" />
                        @else
                        <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                        @endif

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="{{ $products->id }}">{{ trans('frontend.quick_view_label') }}</button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3>{!! get_product_title($products->id) !!}</h3>

                        @if(get_product_type($products->id) == 'simple_product')
                          <p>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($products->id, $products->price)), get_frontend_selected_currency()) !!}</p>
                        @elseif(get_product_type($products->id) == 'configurable_product')
                          <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products->id) !!}</p>
                        @elseif(get_product_type($products->id) == 'customizable_product' || get_product_type($products->id) == 'downloadable_product')
                          @if(count(get_product_variations($products->id))>0)
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products->id) !!}</p>
                          @else
                            <p>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($products->id, $products->price)), get_frontend_selected_currency()) !!}</p>
                          @endif
                        @endif

                        <div class="title-divider"></div>
                        <div class="single-product-add-to-cart">
                          @if(get_product_type($products->id) == 'simple_product')
                            <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                            <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif(get_product_type($products->id) == 'configurable_product')
                            <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                            <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif(get_product_type($products->id) == 'customizable_product')
                            @if(is_design_enable_for_this_product($products->id))
                              <a href="{{ route('customize-page', $products->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                              <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @else
                              <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                              <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif
                          @elseif(get_product_type( $products->id ) == 'downloadable_product') 
                            @if(count(get_product_variations( $products->id ))>0)
                            <a href="{{ route( 'details-page', $products->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                            <a href="{{ route('details-page', $products->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @else
                            <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                            <a href="{{ route('details-page', $products->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif                           
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>  
            <div class="products-pagination">{!! $brand_details_by_slug['products']->appends(Request::capture()->except('page'))->render() !!}</div>
          @else
          <br><p>{{ trans('frontend.no_product_for_brands_label') }}</p>
          @endif
          </div>
          </div>
      </div> 
    </div>
  </div>
</div>    
@endsection