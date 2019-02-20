<a href="" class="main show-mini-cart" data-id="2"> <span class="d-none d-md-inline">{!! trans('frontend.menu_my_cart') !!}</span> <span class="fa fa-shopping-cart"></span> <span class="cart-count"><span id="total_count_by_ajax">{!! Cart::count() !!}</span></span></a>

<div class="mini-cart-dropdown">
  <div class="dropdown-menu slide-from-top">
    <div class="container">
      <a href="#" class="close-cart"><i class="fa fa-close"></i></a>
      @if( Cart::count() >0 )
      <div class="top-title">{!! trans('frontend.mini_cart_top_label') !!}</div>
      <ul>
        @foreach(Cart::items() as $index => $items)
        <li class="item">
          <div class="img">
            @if($items->img_src)  
            <a href="{{ route('details-page', get_product_slug($items->id)) }}"><img src="{{ get_image_url($items->img_src) }}" alt="product"></a>
            @else
            <a href="{{ route('details-page', get_product_slug($items->id)) }}"><img src="{{ default_placeholder_img_src() }}" alt="no_image"></a>
            @endif
          </div>
          <div class="info">
            <div class="title-col">
              <h2 class="title">
                <a href="{{ route('details-page', get_product_slug($items->id)) }}">{!! $items->name !!}</a>
              </h2>
              <div class="details">
                <?php $count = 1; ?>
                @if(count($items->options) > 0)
                <p>
                  @foreach($items->options as $key => $val)
                    @if($count == count($items->options))
                      {!! $key .' &#8658; '. $val !!}
                    @else
                      {!! $key .' &#8658; '. $val. ' , ' !!}
                    @endif
                    <?php $count ++ ; ?>
                  @endforeach
                </p>
                @endif
              </div>
            </div>
            <div class="price">
            {!! price_html( get_product_price_html_by_filter( $items->price ), get_frontend_selected_currency() ) !!}
            </div>
            <div class="qty">
              <div class="qty-label">{!! trans('frontend.qty_label') !!}:</div>
              <div class="style-2 input-counter">
                <span class="minus-btn"></span>
                <input value="{{ $items->quantity }}" size="100" type="text">
                <span class="plus-btn"></span>
              </div>
            </div>
          </div>
          <div class="item-control">
          <div class="delete"><a href="{{ route('removed-item-from-cart', $index)}}" class="icon icon-delete" title="Delete"><i class="fa fa-trash-o"></i></a></div>
          </div>
        </li>
        @endforeach
      </ul>
      <div class="cart-bottom">
        <div class="float-right checkout">
          <div class="float-left">
            <div class="cart-total">{!! trans('frontend.total') !!}:  <span> {!! price_html( get_product_price_html_by_filter(Cart::getTotal()) ) !!}</span></div>
          </div>
          <a href="{{ route('checkout-page') }}" class="btn btn-light icon-btn-left"><span class="fa fa-check-circle-o"></span> {!! trans('frontend.check_out') !!}</a>
        </div>
        <div class="pull-left cart">
          <a href="{{ route('cart-page') }}" class="btn btn-light icon-btn-left"><span class="fa fa-shopping-bag"></span> {!! trans('frontend.view_cart_label') !!}</a>
        </div>
      </div>
      @else
      <h4 class="empty-cart-js">{!! trans('frontend.empty_cart_msg') !!}</h4>
      @endif
    </div>
  </div>
</div>