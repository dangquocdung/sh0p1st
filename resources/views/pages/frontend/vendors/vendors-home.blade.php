@section('vendors-home-page-content')
<style type="text/css">
.slick-dots li.slick-active button::before, .slick-dots li button::before{
  color:#1FC0A0;
}
</style>

<div id="vendor_home_content">
  <h2 class="cat-box-top">{!! trans('frontend.shop_by_cat_label') !!} <span class="responsive-accordian"></span></h2>
  @if(count($vendor_home_page_cats) > 0)  
  <div class="vendor-categories">
    <div class="row">
      <div class="col-md-12">
        <div class="vendor-top-collection">
          @foreach($vendor_home_page_cats as $cats)
          <div>
            <div class="vendor-category-content clearfix">
              <div class="vendor-category-name">
                <h2>{!! $cats['parent_cat']['name'] !!} <span class="responsive-accordian"></span></h2>
                <div class="vendor-categories-list">
                  @if(count($cats['child_cat']) > 0)  
                    <ul>
                      @foreach($cats['child_cat'] as $child_cat)
                      <li><a href="{{ route('store-products-cat-page-content', array($child_cat['slug'], $vendor_info->name)) }}">{!! $child_cat['name'] !!}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </div>
              <div class="vendor-category-image">
                @if(!empty(get_image_url($cats['parent_cat']['category_img_url'])))
                  <img class="img-fluid" src="{{ get_image_url($cats['parent_cat']['category_img_url']) }}">
                @else
                  <img class="img-fluid" src="{{ default_placeholder_img_src() }}">
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>  
      </div>
    </div>
  </div>
  @else
  <p style="text-align:center;padding-top:25px;">{!! trans('frontend.product_not_available') !!}</p>
  @endif
  
  <div class="row">
    <div class="col-12">
      <div class="vendor-special-products">
        <div id="latest_items">
          <h2 class="cat-box-top">{!! trans('frontend.only_latest_label') !!} <span class="responsive-accordian"></span></h2>   
          @if(count($vendor_advanced_items['latest_items']) > 0)  
          <div class="latest-items special-items">
            @foreach($vendor_advanced_items['latest_items'] as $latest)
            
            <?php $reviews  = get_comments_rating_details($latest->id, 'product');?>
            <div>
              <div class="hover-product">
                <div class="hover">
                  @if(!empty($latest->image_url))  
                  <img src="{{ get_image_url($latest->image_url) }}" alt="">
                  @else
                  <img src="{{ default_placeholder_img_src() }}" alt="">
                  @endif
                  <div class="overlay">
                    <button class="info quick-view-popup" data-id="{{ $latest->id }}">{!! trans('frontend.quick_view_label') !!}</button>
                  </div>
                </div> 
                <div class="single-product-bottom-section">
                  <a href="{{ route('details-page', $latest->slug) }}"><h3>{!! get_product_title( $latest->id ) !!}</h3></a>
                  @if(get_product_type($latest->id) == 'simple_product')
                    <p><strong>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($latest->id, $latest->price)), get_frontend_selected_currency()) !!}</strong></p>
                  @elseif(get_product_type($latest->id) == 'configurable_product')
                    <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest->id) !!}</strong></p>
                  @elseif(get_product_type($latest->id) == 'customizable_product' || get_product_type($latest->id) == 'downloadable_product')
                    @if(count(get_product_variations($latest->id))>0)
                      <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest->id) !!}</strong></p>
                    @else
                      <p><strong>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($latest->id, $latest->price)), get_frontend_selected_currency()) !!}</strong></p>
                    @endif
                  @endif
                  <div class="text-center rating-content">
                    <div class="star-rating">
                      <span style="width:{{ $reviews['percentage'] }}%"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          @else
          <p style="text-align:center;">{!! trans('frontend.product_not_available') !!}</p>
          @endif
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12">
      <div class="vendor-special-products">
        <div id="best_sales_items">
          <h2 class="cat-box-top">{!! trans('frontend.best_sales_label') !!} <span class="responsive-accordian"></span></h2>   
          @if(count($vendor_advanced_items['best_sales']) > 0)  
          <div class="best-sales-items special-items">
            @foreach($vendor_advanced_items['best_sales'] as $best_sales)
            
            <?php $reviews  = get_comments_rating_details($best_sales['id'], 'product');?>
            <div>
              <div class="hover-product">
                <div class="hover">
                  @if(!empty($best_sales['post_image_url']))  
                  <img src="{{ get_image_url($best_sales['post_image_url']) }}" alt="">
                  @else
                  <img src="{{ default_placeholder_img_src() }}" alt="">
                  @endif
                  <div class="overlay">
                    <button class="info quick-view-popup" data-id="{{ $best_sales['id'] }}">{!! trans('frontend.quick_view_label') !!}</button>
                  </div>
                </div> 
                <div class="single-product-bottom-section">
                  <a href="{{ route('details-page', $best_sales['post_slug']) }}"><h3>{!! get_product_title( $best_sales['id'] ) !!}</h3></a>
                  @if(get_product_type($best_sales['id']) == 'simple_product')
                    <p><strong>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($best_sales['id'], $best_sales['post_price'])), get_frontend_selected_currency()) !!}</strong></p>
                  @elseif(get_product_type($best_sales['id']) == 'configurable_product')
                    <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales['id']) !!}</strong></p>
                  @elseif(get_product_type($best_sales['id']) == 'customizable_product' || get_product_type($best_sales['id']) == 'downloadable_product')
                    @if(count(get_product_variations($best_sales['id']))>0)
                      <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales['id']) !!}</strong></p>
                    @else
                      <p><strong>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($best_sales['id'], $best_sales['post_price'])), get_frontend_selected_currency()) !!}</strong></p>
                    @endif
                  @endif
                  <div class="text-center rating-content">
                    <div class="star-rating">
                      <span style="width:{{ $reviews['percentage'] }}%"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            </div>
          @else
          <br>
          <p style="text-align:center;">{!! trans('frontend.product_not_available') !!}</p>
          @endif
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12">
      <div class="vendor-special-products">
        <div id="featured_items">
          <h2 class="cat-box-top">{!! trans('frontend.featured_products_label') !!} <span class="responsive-accordian"></span></h2>
          @if(count($vendor_advanced_items['features_items']) > 0)  
            <div class="featured-items special-items">
              @foreach($vendor_advanced_items['features_items'] as $features_items)
              
              <?php $reviews  = get_comments_rating_details($features_items->id, 'product');?>
              <div>
                <div class="hover-product">
                  <div class="hover">
                    @if(!empty($features_items->image_url))  
                    <img src="{{ get_image_url( $features_items->image_url ) }}" alt="">
                    @else
                    <img src="{{ default_placeholder_img_src() }}" alt="">
                    @endif
                    <div class="overlay">
                      <button class="info quick-view-popup" data-id="{{ $features_items->id }}">{!! trans('frontend.quick_view_label') !!}</button>
                    </div>
                  </div> 
                  <div class="single-product-bottom-section">
                    <a href="{{ route('details-page', $features_items->slug) }}"><h3>{!! get_product_title( $features_items->id ) !!}</h3></a>
                    @if(get_product_type($features_items->id) == 'simple_product')
                      <p><strong>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($features_items->id, $features_items->price)), get_frontend_selected_currency()) !!}</strong></p>
                    @elseif(get_product_type($features_items->id) == 'configurable_product')
                      <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_items->id) !!}</strong></p>
                    @elseif(get_product_type($features_items->id) == 'customizable_product' || get_product_type($features_items->id) == 'downloadable_product')
                      @if(count(get_product_variations($features_items->id))>0)
                        <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_items->id) !!}</strong></p>
                      @else
                        <p><strong>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($features_items->id, $features_items->price)), get_frontend_selected_currency()) !!}</strong></p>
                      @endif
                    @endif
                    <div class="text-center rating-content">
                      <div class="star-rating">
                        <span style="width:{{ $reviews['percentage'] }}%"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
            @else
            <p style="text-align:center;">{!! trans('frontend.product_not_available') !!}</p>
            @endif
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12">
      <div class="vendor-special-products">
        <div id="recommended_items">
          <h2 class="cat-box-top">{!! trans('frontend.recommended_items') !!} <span class="responsive-accordian"></span></h2>
          @if(count($vendor_advanced_items['recommended_items']) > 0)  
            <div class="recommended-items special-items">
              @foreach($vendor_advanced_items['recommended_items'] as $recommended_items)
              
              <?php $reviews  = get_comments_rating_details($recommended_items->id, 'product');?>
              <div>
                <div class="hover-product">
                  <div class="hover">
                    @if(!empty($recommended_items->image_url))  
                    <img src="{{ get_image_url( $recommended_items->image_url ) }}" alt="">
                    @else
                    <img src="{{ default_placeholder_img_src() }}" alt="">
                    @endif
                    <div class="overlay">
                      <button class="info quick-view-popup" data-id="{{ $recommended_items->id }}">{!! trans('frontend.quick_view_label') !!}</button>
                    </div>
                  </div> 
                  <div class="single-product-bottom-section">
                    <a href="{{ route('details-page', $recommended_items->slug) }}"><h3>{!! get_product_title( $recommended_items->id ) !!}</h3></a>
                    @if(get_product_type($recommended_items->id) == 'simple_product')
                      <p><strong>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($recommended_items->id, $recommended_items->price)), get_frontend_selected_currency()) !!}</strong></p>
                    @elseif(get_product_type($recommended_items->id) == 'configurable_product')
                      <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_items->id) !!}</strong></p>
                    @elseif(get_product_type($recommended_items->id) == 'customizable_product' || get_product_type($recommended_items->id) == 'downloadable_product')
                      @if(count(get_product_variations($recommended_items->id))>0)
                        <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_items->id) !!}</strong></p>
                      @else
                        <p><strong>{!! price_html( get_product_price_html_by_filter(get_role_based_price_by_product_id($recommended_items->id, $recommended_items->price)), get_frontend_selected_currency()) !!}</strong></p>
                      @endif
                    @endif
                    <div class="text-center rating-content">
                      <div class="star-rating">
                        <span style="width:{{ $reviews['percentage'] }}%"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
            @else
            <p style="text-align:center;">{!! trans('frontend.product_not_available') !!}</p>
            @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection