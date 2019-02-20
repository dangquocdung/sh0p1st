<div class="variations-content-main" data-is_login="{{ $single_product_details['is_user_login'] }}" data-login_user_slug="{{ $single_product_details['login_user_slug'] }}" data-current_currency_value="{{ get_product_price_html_by_filter(1) }}" data-variations_details="{{ json_encode( $variations_data ) }}">
  <div class="variations-data row">
    @foreach($attr_lists as $row)
      <div class="col-sm-12 col-md-12 variations-line">
        <div class="variation-attr-name">{!! $row['attr_name'] !!}</div>
        <div class="variation-attr-value">
          <div class="variation-choose-option"><i class="fa fa-hand-o-up"></i> {{ trans('frontend.choose_an_options') }}</div>
          @foreach( explode(',', $row['attr_values']) as $val )
            <div class="variation-options-lists"><input  type="radio" name="{{ string_slug_format( $row['attr_name'] ) }}" data-value="{{ $val }}" value="{{ string_slug_format( $val ) }}"> &nbsp;&nbsp; {!! ucwords($val) !!}</div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
  
  <div class="product-add-to-cart-content add-to-cart-content" style="display:none;">
    <div class="variation-price-label"></div>
    <div class="variation-stock-label"></div>
    <input type="hidden" name="available_stock_val" id="available_stock_val">
    <input type="hidden" name="backorder_val" id="backorder_val" value="">
    <ul>
      <li>
        <div class="input-group">
          <span class="input-group-btn">
            <button type="button" class="btn btn-light btn-number minus-control" disabled="disabled" data-type="minus" data-field="quant[1]">
              <span class="fa fa-minus"></span>
            </button>
          </span>
          <input type="text" id="quantity" name="quant[1]" class="form-control input-number" value="1" min="1" max=""/>
          <span class="input-group-btn">
            <button type="button" class="btn btn-light btn-number plus-control" data-type="plus" data-field="quant[1]">
              <span class="fa fa-plus"></span>
            </button>
          </span>
        </div>
      </li>
      @if(Request::is('product/customize/*'))
      <li>
        <a href="" class="btn btn-sm btn-style cart customize-page-add-to-cart" data-id="{{ $single_product_details['id'] }}"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; {{ trans('frontend.add_to_cart') }}</a>
      </li>
      @else
      <li>
        <a href="" class="btn btn-sm btn-style cart single-page-add-to-cart" data-id="{{ $single_product_details['id'] }}"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; {{ trans('frontend.add_to_cart') }}</a>
      </li>
      @endif
    </ul>
  </div>  
</div><br>