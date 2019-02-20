<?php
namespace shopist\Library;

use shopist\Http\Controllers\OptionController;
use shopist\Http\Controllers\CMSController;
use shopist\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use shopist\Models\Role;
use Cookie;
use Session;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use shopist\Models\OrdersItem;
use shopist\Models\DownloadExtra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use shopist\Models\UsersDetail;
use Anam\Phpcart\Cart;
use Illuminate\Support\Facades\URL;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\Request;
use shopist\Models\CustomCurrencyValue;

class CommonFunction
{
  public $cart;
  public $catHTML = '';
  
  public function __construct() {
    $this->cart =  new Cart();
  }
  public function get_currency_symbol( $currency = '' ){
    switch ( $currency ) {
		case 'AED' :
			$currency_symbol = 'د.إ';
			break;
		case 'AUD' :
		case 'ARS' :
		case 'CAD' :
		case 'CLP' :
		case 'COP' :
		case 'HKD' :
		case 'MXN' :
		case 'NZD' :
		case 'SGD' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
		case 'CNY' :
		case 'JPY' :
		case 'RMB' :
			$currency_symbol = '&yen;';
			break;
		case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
		case 'DKK' :
			$currency_symbol = 'DKK';
			break;
		case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
		case 'EGP' :
			$currency_symbol = 'EGP';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'GBP' :
			$currency_symbol = '&pound;';
			break;
		case 'HRK' :
			$currency_symbol = 'Kn';
			break;
		case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
		case 'IDR' :
			$currency_symbol = 'Rp';
			break;
		case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
		case 'INR' :
			$currency_symbol = 'Rs.';
			break;
		case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
		case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
		case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
		case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
		case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
		case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
		case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
		case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
		case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
		case 'RON' :
			$currency_symbol = 'lei';
			break;
		case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
		case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'THB' :
			$currency_symbol = '&#3647;';
			break;
		case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
		case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
		case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
		case 'VND' :
			$currency_symbol = '&#8363;';
			break;
		case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
		default :
			$currency_symbol = '';
			break;
    }

    return $currency_symbol;
  }
  
  public function is_item_already_exists_in_array($index, $data = array()){
    $is_exists = false;
    
    if(count($data) > 0){
      foreach($data as $count){
        if(isset($count['id'])){
          if($index == $count['id']){
            $is_exists = true;
            break;
          }
          else{
            $is_exists = false;
          }
        }
      }
    }
    else{
      $is_exists = false;
    }
    
    return $is_exists;
  }
  
  /**
   * convert given price using currency
   *
   * @param currency from, currency to, convert amount
   * @return string
   */ 
  public function convertCurrency($from, $to, $amount){
    $convert_amount = null;
    $option  =  new OptionController();
    $get_settings_option = $option->getSettingsData();
    
    if(isset($get_settings_option['general_settings']['currency_options']['currency_conversion_method']) && $get_settings_option['general_settings']['currency_options']['currency_conversion_method'] == 'fixer_api'){
      $endpoint = 'convert';
      $access_key = $get_settings_option['general_settings']['fixer_config_option']['fixer_api_access_key'];

      // initialize CURL:
      $ch = curl_init('https://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');   
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // get the JSON data:
      $json = curl_exec($ch);
      curl_close($ch);

      // Decode JSON response:
      $conversionResult = json_decode($json, true);
      if(isset($conversionResult['success']) && $conversionResult['success'] && isset($conversionResult['result'])){
        $convert_amount = $conversionResult['result'];
      }
    }
    elseif(isset($get_settings_option['general_settings']['currency_options']['currency_conversion_method']) && $get_settings_option['general_settings']['currency_options']['currency_conversion_method'] == 'custom'){
      
      $from_currency = CustomCurrencyValue::where(['currency_code' => $from])->first();
      $to_currency = CustomCurrencyValue::where(['currency_code' => $to])->first();
      
      if(!empty($from_currency) && !empty($to_currency)){
        if(!empty($from_currency->currency_value) && !empty($to_currency->currency_value)){
          $convert_amount =  (($to_currency->currency_value / $from_currency->currency_value) * $amount );
        }
      }
    }

    return $convert_amount;
	}
  
  public function get_dynamic_frontend_content_data(){
    $data_ary = array();
    $product =  new ProductsController();
    $CMS     =  new CMSController();
    $option  =  new OptionController();
    
    //set language
    $this->set_frontend_lang();
    
    $get_settings_option = $option->getSettingsData();
    $get_cat_tree = $product->get_categories(0, 'product_cat');

    $data_ary['_currency_symbol']              =  $this->get_currency_symbol( $get_settings_option['general_settings']['currency_options']['currency_name'] );
    $data_ary['currency_symbol']              =   $get_settings_option['general_settings']['currency_options']['currency_name'];
    $data_ary['appearance_settings']          =   current_appearance_settings();
    $data_ary['appearance_all_data']          =   get_appearance_settings();
    $data_ary['dynamic_menu']                 =   $this->frontendMenuHTML( $get_cat_tree );
    $data_ary['blogs_data']                   =   $CMS->get_latest_blogs();
    $data_ary['popular_tags_list']            =   $product->getTermData( 'product_tag', false, null, 1 );
    $data_ary['productCategoriesTree']        =   $get_cat_tree;
    
    if(Request::is('/')){
      $data_ary['dynamic_vertical_megamenu']  =   $this->frontendVerticalMenuHTML();
    }
    else{
      $data_ary['dynamic_vertical_megamenu']  =  '';
    }
    
    $get_frontend_selected_lang = get_frontend_selected_languages_data();
    $data_ary['selected_lang_code']    =    $get_frontend_selected_lang['lang_code'];
    $data_ary['subscriptions_data'] = get_subscription_settings_data();

    $is_subscribe_cookie_exists = false;
    if(Cookie::has('subscribe_popup_not_needed') && Cookie::get('subscribe_popup_not_needed') == 'no_need'){
      $is_subscribe_cookie_exists = true;
    }

    $data_ary['is_subscribe_cookie_exists'] = $is_subscribe_cookie_exists;

    if(Session::has('shopist_selected_compare_product_ids') && count(Session::get('shopist_selected_compare_product_ids')) > 0){
      $data_ary['total_compare_item'] = count(Session::get('shopist_selected_compare_product_ids'));
    }
    else{
      $data_ary['total_compare_item'] = 0;
    }

    //$data_ary['appearance_settings_data'] = get_appearance_settings();
    $data_ary['current_parent_cat'] = get_product_parent_categories();
    $data_ary['pages_list'] = $CMS->get_pages(false, null, 1);
    $data_ary['seo_data'] = get_seo_data();
    
    return $data_ary;
  }
  
  /**
  * frontend menu html
  *
  * @param null
  * @return string
  */
  
  public function frontendMenuHTML( $get_cat_tree ){
    $option  =  new OptionController();
    $product =  new ProductsController();
    $CMS     =  new CMSController();
    
    $get_menu   = $option->getMenuData();
    $pages_list = $CMS->get_pages(false, null, 1);
    $get_categories_tree = $get_cat_tree;
    
    $html = '';
    
    if(is_array($get_menu) && count($get_menu) > 0){
      foreach($get_menu as $menu){
        $name = '';
        $route = '';
        
        $label1 = explode('|', $menu->label);
        $label2 = explode('##', $label1[1]);
        
        if($label2[0] == 'simple'){
          if($label1[0] == 'home'){
            $name = Lang::get('frontend.home');
            $route = route('home-page');
          }
          elseif ($label1[0] == 'collection') {
            $name = Lang::get('frontend.shop_by_cat_label');
          }
          elseif ($label1[0] == 'products') {
            $name = Lang::get('frontend.all_products_label');
            $route = route('shop-page');
          }
          elseif ($label1[0] == 'checkout') {
            $name = Lang::get('frontend.checkout');
            $route = route('checkout-page');
          }
          elseif ($label1[0] == 'cart') {
            $name = Lang::get('frontend.cart');
            $route = route('cart-page');
          }
          elseif ($label1[0] == 'blog') {
            $name = Lang::get('frontend.blog');
            $route = route('blogs-page-content');
          }
          elseif ($label1[0] == 'store_list') {
            $name = Lang::get('frontend.vendor_account_store_list_title_label');
            $route = route('store-list-page-content');
          }
          elseif ($label1[0] == 'pages') {
            $name = Lang::get('frontend.pages_label');
          }
          
          if($menu->status == 'enable' && ($label1[0] == 'home' || $label1[0] == 'products' || $label1[0] == 'checkout' || $label1[0] == 'cart' || $label1[0] == 'blog' || $label1[0] == 'store_list')){
            $html .= '<li class="nav-item"><a href="'. $route .'" class="nav-link">'. $name .'</a></li>';
          }
          elseif ($menu->status == 'enable' && $label1[0] == 'collection') {
            $html .= '<li class="nav-item dropdown">';
            $html .= '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'. $name .'</a>';
            $html .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
            
            $i = 1;
            if(is_array($get_categories_tree) && count($get_categories_tree) > 0){
              foreach($get_categories_tree as $cat){
                if($i == 1){
                  $html .= '<div class="row">';
                }
                
                if($i == 1 || $i == 2){
                  $html .= '<div class="col">';
                  $html .= '<div class="cat-content">';
                    if(!empty($cat['img_url'])){
                      $html .= '<img src="'. get_image_url( $cat['img_url'] ) .'">';
                    }
                    else{
                      $html .= '<img src="'. default_placeholder_img_src() .'">';
                    }
                  $html .= '</div>';
                  $html .= '<div class="cat-content">';
                    $html .= '<h5><a href="'. route('categories-page', $cat['slug']) .'">'. $cat['name'] .'</a></h5><hr>';
                    if(isset($cat['children']) && count($cat['children']) > 0){
                      $html .= '<ul>';
                      foreach($cat['children'] as $childCat){
                        $html .= '<li class="product-sub-cat"><a href="'. route('categories-page', $childCat['slug']) .'">'. $childCat['name'] .'</a></li>';
                        if(isset($childCat['children']) && count($childCat['children']) > 0){
                          $html .= view('pages.common.category-frontend-loop-home')->with(['cat_sub' => $childCat])->render();
                        }
                      }
                      $html .= '</ul>';
                    }
                  $html .= '</div>';
                  $html .= '</div>';
                }
                
                if($i == 2){
                  $html .= '</div>';
                }
                
                $i++;
                
                if($i == 3){
                  $i = 1;
                }
              }
            }
            else{
              $html .= '<p>' . Lang::get('frontend.no_categories_yet') .'</p>';
            }
            
            $html .= '</div>';
            $html .= '</li>';
          }
          elseif ($menu->status == 'enable' && $label1[0] == 'pages' && count($pages_list) > 0) {
            $html .= '<li class="nav-item">';
            $html .= '<div class="dropdown custom-page">';
            $html .= '<a class="dropdown-toggle menu-name nav-link" href="#" data-hover="dropdown" data-toggle="dropdown">'. $name .' <span class="caret"></span></a>';
            $html .= '<ul class="dropdown-content">';
            
            foreach($pages_list as $pages){
              $html .= '<li><a href="'. route('custom-page-content', $pages['post_slug']) .'">'. $pages['post_title'] .'</a></li>';
            }    
            
            $html .= '</ul>';
            $html .= '</div>';
            $html .= '</li>';
          }
        }
        elseif (isset($label2[0]) && $label2[0] == 'cat' && isset($label2[1]) && $menu->status == 'enable') {
          $get_term = $product->getTermDataById( $label2[1] );
          $get_categories = $product->get_categories($label2[1], 'product_cat');
          
          if(count($get_term) > 0){
            $html .= '<li class="nav-item dropdown">';
            $html .= '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown_'. $get_term[0]['slug'] .'" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'. $get_term[0]['name'] .'</a>';
            $html .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown_'. $get_term[0]['slug'] .'">';
            $html .= '<div class="row specific-menu-cat">';
            $html .= '<div class="col-8 text-center">';
            $html .= '<h4>'. $get_term[0]['name'] .'</h4>';
            $html .= '<ul>';
            $html .= '<li><a href="'. route('categories-page', $get_term[0]['slug']) .'">'. Lang::get('frontend.sort_filter_all_label') .'</a></li>';
              if(is_array($get_categories) && count($get_categories) >0){
                foreach($get_categories as $subCat){
                  $html .= '<li><a href="'. route('categories-page', $subCat['slug']) .'">'. $subCat['name'] .'</a></li>';
                  
                  if(isset($subCat['children']) && count($subCat['children']) > 0){
                    $html .= view('pages.common.category-frontend-loop-home')->with(['cat_sub' => $subCat])->render();
                  }
                }
              }
            $html .= '</ul>';  
            $html .= '</div>';
            $html .= '<div class="col-4 text-right">';
              if(!empty($get_term[0]['category_img_url'])){
                $html .= '<img class="img-fluid" src="'. get_image_url( $get_term[0]['category_img_url'] ) .'">';
              }
              else{
                $html .= '<img class="img-fluid" src="'. default_placeholder_img_src() .'">';
              }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</li>';
          }
        }
      }
    }
    
    return $html;
  }
  
  /**
  * Create vertical mega menu
  *
  * @param null
  * @return string
  */
  public function frontendVerticalMenuHTML(){
    $product =  new ProductsController();
    $get_categories_tree = $product->get_categories(0, 'product_cat');
    $html = '';
    
    if(is_array($get_categories_tree) && count($get_categories_tree) >0){
      $html .= '<div id="accordion_plus">';
      $html .= '<div class="box-aside">';
      $html .= '<div class="cop-menu-vertical">';
      $html .= '<nav><ul>';

      $i = 1;  
      foreach($get_categories_tree as $cat){
        if($i <= 7){
          $html .= '<li class="dropdown">';
          $html .= '<a href="'. route('categories-page', $cat['slug']) .'">'. $cat['name'] .'</a>';
          $html .= '<div class="dropdown-menu">';
          $html .= '<div class="sub-cat-list">';
          
          $html .= '<ul>';
          if(is_array($cat['children']) && count($cat['children'])>0){
            foreach($cat['children'] as $childCat){
              $html .= '<li class="product-sub-cat"><a href="'. route('categories-page', $childCat['slug']) .'"> <span class="fa fa-chevron-right"> '. $childCat['name'] .'</span></a></li>';
              
              if(isset($childCat['children']) && count($childCat['children']) > 0){
                $html .= view('pages.common.category-frontend-loop-home')->with(['cat_sub' => $childCat])->render();
              }
            }
          }
          $html .= '</u>';
          
          $html .= '</div>';
          $html .= '<div class="parent-cat-img-holder">';
          
          if(!empty($cat['img_url'])){
            $html .= '<img src="'. get_image_url( $cat['img_url'] ) .'">';
          }
          else{
            $html .= '<img src="'. default_placeholder_img_src() .'">';
          }
          
          $html .= '</div>';
          $html .= '</div>';
          $html .= '</li>';
        }
        
        $i ++;
      }  

      $html .= '</nav></ul>';
      $html .= '</div>';
      $html .= '</div>';
      $html .= '</div>';
    }
    
    return $html;
  }

  /**
  * Set admin default language
  *
  * @param null
  * @return string
  */
  
  public function set_admin_lang(){
    $get_current_default_lang = get_default_languages_data();
    if(count($get_current_default_lang) > 0){
      App::setLocale( $get_current_default_lang['lang_code'] ); 
    }
  }
  
  /**
  * Set frontend default language
  *
  * @param null
  * @return string
  */
  
  public function set_frontend_lang(){
    $get_current_frontend_lang = get_frontend_selected_languages_data();
    $get_current_default_lang  = get_default_languages_data();
     
    if(count($get_current_frontend_lang) > 0 && !empty($get_current_frontend_lang['status']) && $get_current_frontend_lang['status'] == 1){
      App::setLocale( $get_current_frontend_lang['lang_code'] ); 
    }
    else{
      App::setLocale( $get_current_default_lang['lang_code'] );
    }
  }
  
  public function is_shopist_admin_installed(){
    $roleArray      =   ['slug' => 'administrator'];
    $get_user_role  =   Role::where($roleArray)->get()->count();
    
    if(!empty($get_user_role) && $get_user_role >0){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }
  
  /**
  * Get order details by order id
  *
  * @param order id
  * @return array
  */
  public function get_order_details_by_order_id($order = array()){
				$order_data = array();
    $option  =  new OptionController();
    $order_id = $order['order_id'];
    $order_process_id = $order['order_process_id'];
    
    $get_post_by_order_id     =   Post::where(['id' => $order_id])->first();
    $get_postmeta_by_order_id =   PostExtra::where(['post_id' => $order_id])->get();
    $get_process_key          =   PostExtra::where(['post_id' => $order_id, 'key_name' => '_order_process_key'])->first();
    $get_orders_items         =   OrdersItem::where(['order_id' => $order_id])->first();
    
    if(!empty($get_post_by_order_id) && $get_post_by_order_id ->count() > 0 && !empty($get_postmeta_by_order_id) && $get_postmeta_by_order_id ->count() > 0 && !empty($get_orders_items) && $get_orders_items->count() >0 && !empty($get_process_key) && $get_process_key->key_value == $order_process_id){
      
      $order_date_format = new Carbon( $get_post_by_order_id->created_at);
      $order_data['customer_address'] = get_customer_order_billing_shipping_info( $get_post_by_order_id->id );
      $order_data['order_id']    = $get_post_by_order_id->id;
      $order_data['order_date']  = $order_date_format->toDayDateTimeString();
 
      foreach($get_postmeta_by_order_id as $postmeta_row_data){
        if($postmeta_row_data->key_name === '_order_shipping_method'){
          $order_data[$postmeta_row_data->key_name] = $this->get_shipping_label($postmeta_row_data->key_value);
        }
        elseif($postmeta_row_data->key_name == '_order_currency' || $postmeta_row_data->key_name == '_customer_ip_address' || $postmeta_row_data->key_name == '_customer_user_agent' || $postmeta_row_data->key_name == '_customer_user' || $postmeta_row_data->key_name == '_order_shipping_cost' || $postmeta_row_data->key_name == '_order_shipping_method' || $postmeta_row_data->key_name == '_payment_method' || $postmeta_row_data->key_name == '_payment_method_title' || $postmeta_row_data->key_name == '_order_tax' || $postmeta_row_data->key_name == '_order_total' || $postmeta_row_data->key_name == '_order_notes' || $postmeta_row_data->key_name == '_order_status' || $postmeta_row_data->key_name == '_order_discount' || $postmeta_row_data->key_name == '_order_coupon_code' || $postmeta_row_data->key_name == '_is_order_coupon_applyed' || $postmeta_row_data->key_name == '_final_order_shipping_cost' || $postmeta_row_data->key_name == '_final_order_tax' || $postmeta_row_data->key_name == '_final_order_total' || $postmeta_row_data->key_name == '_final_order_discount'){
          $order_data[$postmeta_row_data->key_name] = $postmeta_row_data->key_value;
        }
      } 
      
      $order_data['ordered_items']  = json_decode( $get_orders_items->order_data, TRUE );
      
      if(isset($order_data['_payment_method']) && $order_data['_payment_method']){
        $payment_data = $option->getPaymentMethodData();
        $order_data['_payment_details']  = $payment_data[$order_data['_payment_method']];
      }
    }
    
    return $order_data;
  }
		
		/**
  * Get sub orders details by order id
  *
  * @param order id
  * @return array
  */
		
		public function get_sub_orders_details_by_order_id($order = array()){
				$order_data = array();
    $option  =  new OptionController();
				$order_id = $order['order_id'];
    $order_process_id = $order['order_process_id'];
				
				$get_post_by_order_id     =   Post::where(['id' => $order_id])->first();
				
				if(!empty($get_post_by_order_id)){
						$get_postmeta_by_order_id =   PostExtra::where(['post_id' => $get_post_by_order_id->parent_id])->get();
						$get_process_key          =   PostExtra::where(['post_id' => $order_id, 'key_name' => '_order_process_key'])->first();
						$get_orders_items         =   OrdersItem::where(['order_id' => $order_id])->first();
						
						if(!empty($get_postmeta_by_order_id) && $get_postmeta_by_order_id ->count() > 0 && !empty($get_orders_items) && $get_orders_items->count() >0 && !empty($get_process_key) && $get_process_key->key_value == $order_process_id){
								$order_date_format = new Carbon( $get_post_by_order_id->created_at);
								$order_data['customer_address'] = get_customer_order_billing_shipping_info( $get_post_by_order_id->parent_id );
								$order_data['order_id']    = $get_post_by_order_id->id;
								$order_data['order_date']  = $order_date_format->toDayDateTimeString();
								
								foreach($get_postmeta_by_order_id as $postmeta_row_data){
										if($postmeta_row_data->key_name === '_order_shipping_method'){
												$order_data[$postmeta_row_data->key_name] = $this->get_shipping_label($postmeta_row_data->key_value);
										}
										elseif($postmeta_row_data->key_name == '_order_currency' || $postmeta_row_data->key_name == '_customer_ip_address' || $postmeta_row_data->key_name == '_customer_user_agent' || $postmeta_row_data->key_name == '_customer_user' || $postmeta_row_data->key_name == '_order_shipping_cost' || $postmeta_row_data->key_name == '_order_shipping_method' || $postmeta_row_data->key_name == '_payment_method' || $postmeta_row_data->key_name == '_payment_method_title' || $postmeta_row_data->key_name == '_order_tax' || $postmeta_row_data->key_name == '_order_total' || $postmeta_row_data->key_name == '_order_notes' || $postmeta_row_data->key_name == '_order_status' || $postmeta_row_data->key_name == '_order_discount' || $postmeta_row_data->key_name == '_order_coupon_code' || $postmeta_row_data->key_name == '_is_order_coupon_applyed' || $postmeta_row_data->key_name == '_final_order_shipping_cost' || $postmeta_row_data->key_name == '_final_order_tax' || $postmeta_row_data->key_name == '_final_order_total' || $postmeta_row_data->key_name == '_final_order_discount'){
												$order_data[$postmeta_row_data->key_name] = $postmeta_row_data->key_value;
										}
								} 
								
								$order_data['ordered_items']  = json_decode( $get_orders_items->order_data, TRUE );
								
								if(isset($order_data['_payment_method']) && $order_data['_payment_method']){
										$payment_data = $option->getPaymentMethodData();
										$order_data['_payment_details']  = $payment_data[$order_data['_payment_method']];
								}
						}
				}
				
				return $order_data;
		}
  
  /**
   * Get function for shipping label
   *
   * @param Shipping name
   * @return string
   */
  public function get_shipping_label($name = ''){
    $option  =  new OptionController();
    $get_shipping = $option->getShippingMethodData();
    
    if(isset($get_shipping[$name])){
      return $get_shipping[$name]['method_title'];
    }
  }
  
  /**
   * save control for frontend account data
   *
   * @param array
   * @return boolean
   */  
  public function frontendUserAccountDataProcess( $data = array() ){
    $get_current_user_id = get_current_frontend_user_info();
    
    if(isset($get_current_user_id['user_id']) && $get_current_user_id['user_id']){
      $account_data_details   =   array();
      $user_details           =   new UsersDetail;
      $get_data_by_user_id    =   array();
      
      $get_data_by_user_id = get_user_account_details_by_user_id( $get_current_user_id['user_id'] );
      
      if( count($get_data_by_user_id) == 0){
        $account_data_details = array('address_details' => '', 'wishlists_details' => '');
        
        $user_details->user_id      =       $get_current_user_id['user_id'];
        $user_details->details      =       json_encode( $account_data_details );

        $user_details->save();
        
        $get_data_by_user_id = get_user_account_details_by_user_id( $get_current_user_id['user_id'] );
      }
      
      if(count($get_data_by_user_id) > 0){
        $array_shift   = array_shift($get_data_by_user_id );
        $parse_details = json_decode($array_shift['details'], true);
        
        if(isset($data['post_type']) && $data['post_type'] == 'address'){
          $parse_details['address_details'] = $data['details'];
        }
        
        if(isset($data['post_type']) && $data['post_type'] == 'wishlist'){
          if(isset($data['post_action']) && $data['post_action'] == 'delete' ){
            $parse_details['wishlists_details'] = $data['details'];
          }
          else{
            if(!empty($parse_details['wishlists_details'])){
              $get_wishlist = $parse_details['wishlists_details'];
              
              if(!array_key_exists(key($data['details']), $get_wishlist)){
                $parse_details['wishlists_details'] = $get_wishlist + $data['details'];
              }
            }
            else{
              $parse_details['wishlists_details'] = $data['details'];
            }
          }
        }
        
        $final_data = array(
                    'details' =>  json_encode($parse_details)
        );
        
        if( $user_details::where('user_id', $get_current_user_id['user_id'])->update($final_data)){
          return true;
        }
      }
    }
  }
		
		/**
   * Get function for variable products
   *
   * @param Products Id
   * @return obj
   */
  public function get_variation_by_product_id($product_id){
    $get_variation_data = null;
    
    $get_variation_data = DB::table('posts')
                          ->where(['posts.parent_id' => $product_id, 'posts.post_type' => 'product_variation', 'post_extras.key_name' => '_variation_post_data'])
													->join('post_extras', 'post_extras.post_id', '=', 'posts.id')
													->select('posts.*', 'post_extras.key_value')     
													->get();
				
    return $get_variation_data;
  }
		
		/**
   * Get function for variable products
   *
   * @param Products Id
   * @return array
   */
  public function get_variation_and_data_by_product_id($product_id){
    $get_variation = '';
    $variation_array = array();
    
    $get_variation = $this->get_variation_by_product_id($product_id);
    
    if($get_variation && count($get_variation)>0){
      foreach ($get_variation as $data){
        $get_meta_by_id  =  PostExtra::where('post_id', $data->id)->get();
        $data_array      =  array();
        
        $data_array['id']             =  $data->id;
        $data_array['author_id']      =  $data->post_author_id;
        $data_array['description']    =  $data->post_content;
        $data_array['title']          =  $data->post_title;
        $data_array['parent_id']      =  $data->parent_id;
        $data_array['status']         =  $data->post_status;
        $data_array['post_type']      =  $data->post_type;
        
        foreach($get_meta_by_id as $row){
          if($row->key_name == '_variation_post_data'){
            $data_array['_variation_array_data'] = json_decode($row->key_value);
          }
										
          if ($row->key_name == '_role_based_pricing') {
            $data_array['_role_based_pricing_array'] = unserialize($row->key_value);
          }
										
          $data_array[$row->key_name]  =  $row->key_value;
        }
        
        if(count($data_array)>0){
          array_push($variation_array, $data_array);
        }
      }
    }
    
    return $variation_array;
  }
		
		/**
   * Get function for variable products
   *
   * @param Post Id
   * @return array
   */
  public function get_variation_and_data_by_post_id($post_id){
    $data = array();
    $get_post_by_id  =  Post::where('id', $post_id)->first();
    $get_meta_by_id  =  PostExtra::where('post_id', $post_id)->get();
    
    $data['id']                   =   $get_post_by_id->id;
    $data['post_author_id']       =   $get_post_by_id->post_author_id;
    $data['post_content']         =   $get_post_by_id->post_content;
    $data['post_title']           =   $get_post_by_id->post_title;
    $data['parent_id']            =   $get_post_by_id->parent_id;
    $data['post_status']          =   $get_post_by_id->post_status;
    $data['post_type']            =   $get_post_by_id->post_type;
    
    foreach($get_meta_by_id as $row){
      $data[$row->key_name]   =   $row->key_value;
    }
        
    return $data;
  }
  
  
  /**
   * Get function for products data
   *
   * @param Product id
   * @return array
   */
  public function get_product_data_by_product_id( $product_id = 0 ){
    $_this = new self;
    $product_data = array();
    $product =  new ProductsController();
    
    if($product_id>0){
      $get_data = $product->getProductDataById( $product_id );
       
      $product_data['id']                                =  $get_data['id'];
      $product_data['author_id']                         =  $get_data['author_id'];
      $product_data['post_title']                        =  $get_data['post_title'];
      $product_data['post_status']                       =  $get_data['post_status'];
      $product_data['post_type']                         =  $get_data['post_type'];
      $product_data['product_image']                     =  $get_data['post_image_url'];
      $product_data['product_type']                      =  $get_data['post_type'];
      $product_data['product_sku']                       =  $get_data['post_sku'];
      $product_data['product_price']                     =  $get_data['post_price'];
      $product_data['product_sale_price_start_date']     =  $get_data['_product_sale_price_start_date'];
      $product_data['product_sale_price_end_date']       =  $get_data['_product_sale_price_end_date'];
      $product_data['product_manage_stock']              =  $get_data['_product_manage_stock'];
      $product_data['product_manage_stock_qty']          =  $get_data['post_stock_qty'];
      $product_data['product_manage_stock_availability'] =  $get_data['post_stock_availability'];
      $product_data['product_stock_back_to_order']       =  $get_data['_product_manage_stock_back_to_order'];  
      $product_data['product_enable_as_custom_design']   =  $get_data['_product_enable_as_custom_design'];
      $product_data['product_enable_taxes']              =  $get_data['_product_enable_taxes'];
      $product_data['is_role_based_pricing_enable']      =  $get_data['_is_role_based_pricing_enable'];
      $product_data['role_based_pricing']                =  $get_data['_role_based_pricing'];
      
      return $product_data;
    }
  }
  
  /**
   * Get function for products variations data
   *
   * @param Variations id
   * @return array
   */
  public function get_product_variation_data_by_variation_id( $variation_id = 0 ){
    $_this = new self;
    $variations_data  = array();
    
    if($variation_id >0){
      $get_variations_data = $_this->get_variation_and_data_by_post_id( $variation_id );
      
      $variations_data['variation_id'] = $get_variations_data['id'];
      $variations_data['variation_author_id'] = $get_variations_data['post_author_id'];
      $variations_data['variation_parent_id'] = $get_variations_data['parent_id'];
      $variations_data['variation_post_status'] = $get_variations_data['post_status'];
      $variations_data['variation_post_type'] = $get_variations_data['post_type'];
      $variations_data['variation_product_image'] = $get_variations_data['_variation_post_img_url'];
      $variations_data['variation_product_sku'] = $get_variations_data['_variation_post_sku'];
      $variations_data['variation_product_price'] = $get_variations_data['_variation_post_price'];
      $variations_data['variation_product_sale_price_start_date'] = $get_variations_data['_variation_post_sale_price_start_date'];
      $variations_data['variation_product_sale_price_end_date'] = $get_variations_data['_variation_post_sale_price_end_date'];
      $variations_data['variation_product_manage_stock'] = $get_variations_data['_variation_post_manage_stock'];
      $variations_data['variation_product_manage_stock_qty'] = $get_variations_data['_variation_post_manage_stock_qty'];
      $variations_data['variation_product_manage_stock_availability'] = $get_variations_data['_variation_post_stock_availability'];
      $variations_data['variation_product_manage_back_to_order'] = $get_variations_data['_variation_post_back_to_order'];
      $variations_data['variation_product_enable_taxes'] = $get_variations_data['_variation_post_enable_tax'];
      $variations_data['variation_data'] = $get_variations_data['_variation_post_data'];
      $variations_data['is_role_based_pricing_enable'] = $get_variations_data['_is_role_based_pricing_enable'];
      $variations_data['role_based_pricing'] = unserialize( $get_variations_data['_role_based_pricing'] );
      
      return $variations_data;
    }
  }
  
  
  /**
   * Products add to cart
   *
   * @param products id, quantity, variations id, design access token
   * @return void
   */
  public function add_to_cart($product_id = 0, $qty = 1, $variation_id = 0, $options = null, $accessToken = 0, $design_data = null){
    //check this product vendor already in cart start
    $cart_vendor_id = null;
    $new_vendor_id  = null;
    
    if(!empty($this->cart->items())){
      foreach($this->cart->items() as $item){
        $cart_vendor_id = get_author_id_by_product_id( $item->product_id );
        break;
      }
    }
    
    $new_vendor_id = get_author_id_by_product_id( $product_id );
    if(!is_null($cart_vendor_id) && !is_null($new_vendor_id)){
      if($cart_vendor_id !== $new_vendor_id){
        echo 'vendor_not_same';
        die();
      }
    }
    //check this product vendor already in cart end
    
    $_this = new self;
    $product_id   = intval( $product_id );
	   $variation_id = intval( $variation_id );
    $quantity     = intval( $qty );

    $product_data             =  array();
    $product_variation_data   =  array();
    $product_cart_line_data   =  array();
    
    if($product_id > 0){
      $product_data = $_this->get_product_data_by_product_id( $product_id );
    }
    
    if($variation_id > 0){
      $product_variation_data = $_this->get_product_variation_data_by_variation_id( $variation_id );
    }
    
    if(count($product_data) > 0){
      $product_cart_line_data = $product_data;
    }
    
    if(count($product_variation_data) > 0){
      $product_cart_line_data['product_variation_data'] = $product_variation_data;
    }
    
    if($quantity > 0){
      $product_cart_line_data['product_line_quantity'] = $quantity;
    }
    
    if($accessToken){
      $product_cart_line_data['product_line_access_token'] = $accessToken;
    }
    
    if(!empty($design_data)){
      $product_cart_line_data['designer_all_data'] = $design_data;
    }
    
    if(!empty($options)){
      $product_cart_line_data['selected_option'] = $options;
    }
    
    if( count($product_cart_line_data) >0 ){
      $_this->set_cart_data( $product_cart_line_data );
    }
  }
  
  /**
   * Products add to cart set 
   *
   * @param Cart data
   * @return string
   */
  public function set_cart_data( $cart_data = array() ){ 
    if( count($cart_data) > 0 ){      
      $price = 0;
      $options = array();
      $variation_id = null;
      $img_src = '/public/images/no-image.png';
      $stock_availability = false;
      $tax = false;
      $access_token = '';
      $designer_data = '';
      $is_qty_available = true;
      
      if(isset($cart_data['product_line_access_token']) && $cart_data['product_line_access_token']){
        $access_token = $cart_data['product_line_access_token'];
      }
      
      if(isset($cart_data['designer_all_data']) && $cart_data['designer_all_data']){
        $designer_data = $cart_data['designer_all_data'];
      }
      
      if(isset($cart_data['product_variation_data']) && count( $cart_data['product_variation_data'] ) >0 && isset($cart_data['product_variation_data']['variation_product_price'])){
       $get_pricing  = $this->getPricing($cart_data['product_variation_data']); 
       
       if(!is_null($get_pricing)){
         $price = $get_pricing;
       }
       else{
         $price  =  $cart_data['product_variation_data']['variation_product_price'];
       }
       
       $variation_id = $cart_data['product_variation_data']['variation_id'];
       
       if(count($cart_data['selected_option']) >0){
         foreach($cart_data['selected_option'] as $key => $vals){
           $options[$key] = $vals;
         }
       }
       
       if($cart_data['product_variation_data']['variation_product_image']){
         $img_src = $cart_data['product_variation_data']['variation_product_image'];
       }
       
       if($cart_data['product_variation_data']['variation_product_manage_stock_availability'] == 'variation_in_stock'){
         $stock_availability = TRUE;
       }
       
       if($cart_data['product_variation_data']['variation_product_enable_taxes']){
         $tax = true;
       }
            
       if($cart_data['product_variation_data']['variation_product_manage_stock'] == 1){
         if(isset($this->cart->get($cart_data['id'])->quantity)){
          $cat_qty = $this->cart->get($cart_data['id'])->quantity + 1;
           
          if($cart_data['product_variation_data']['variation_product_manage_back_to_order'] == 'variation_not_allow' && $cart_data['product_variation_data']['variation_product_manage_stock_qty'] > 0 && $cat_qty > $cart_data['product_variation_data']['variation_product_manage_stock_qty']){
            $is_qty_available = false;
          }
         }
       }
      }
      else {
       $get_pricing  = $this->getPricing($cart_data); 
       
       if(!is_null($get_pricing)){
         $price = $get_pricing;
       }
       else{
         $price  = $cart_data['product_price'];
       }

       if($cart_data['product_image']){
         $img_src = $cart_data['product_image'];
       }
       
       if($cart_data['product_manage_stock_availability'] == 'in_stock'){
         $stock_availability = TRUE;
       }
       
       if($cart_data['product_enable_taxes'] == 'yes'){
         $tax = true;
       }
       
       if($cart_data['product_manage_stock'] == 'yes'){
         if(isset($this->cart->get($cart_data['id'])->quantity)){
           $cat_qty = $this->cart->get($cart_data['id'])->quantity + 1;
           
          if($cart_data['product_stock_back_to_order'] == 'not_allow' && $cart_data['product_manage_stock_qty'] > 0 && $cat_qty > $cart_data['product_manage_stock_qty']){
            $is_qty_available = false;
    }
         }
       }
      }
      
      if( !$stock_availability ){
        echo 'out_of_stock';
        die();
      }
      
      if(!$is_qty_available){
        echo 'stock_over';
        die();
      }
      
      $product_id = 0;
      
      if(!empty($variation_id) && $variation_id > 0 && ( get_product_type($cart_data['id']) == 'configurable_product' || get_product_type($cart_data['id']) == 'downloadable_product')){
        $product_id = $variation_id;
      }
      else{
        $product_id = $cart_data['id'];
      }
      
      
      $this->cart->add([
        'id'            =>  $product_id,
        'product_id'    =>  $cart_data['id'],
        'name'          =>  $cart_data['post_title'],
        'quantity'      =>  $cart_data['product_line_quantity'],
        'price'         =>  $price,
        'order_price'   =>  get_product_price_html_by_filter($price),
        'img_src'       =>  $img_src,  
        'variation_id'  =>  $variation_id,
        'options'       =>  $options,
        'tax'           =>  $tax,
        'product_type'  =>  get_product_type( $cart_data['id'] ),
        'acces_token'   =>  $access_token,
        'designer_data' =>  json_encode($designer_data)
      ]);
      
      if($this->cart->count() > 0){
        echo 'item_added';
      }
    }
  }
  
  /**
   * Get role pricing after check some required 
   *
   * @param array
   * @return float number, integer number
   */
  function getPricing($data = array()){
    $price = null;
    
    if(count($data) > 0){
      $get_current_user_data  =  get_current_frontend_user_info();
      
      if(is_frontend_user_logged_in() && isset($get_current_user_data['user_role_slug']) && ($data['is_role_based_pricing_enable'] == 'yes' || $data['is_role_based_pricing_enable'] == 1)){
        if( isset($data['role_based_pricing'][$get_current_user_data['user_role_slug']]) ){
          $regular_price = $data['role_based_pricing'][$get_current_user_data['user_role_slug']]['regular_price'];
          $sale_price = $data['role_based_pricing'][$get_current_user_data['user_role_slug']]['sale_price'];
          
          if(isset($regular_price) && $regular_price && isset($sale_price) && $sale_price && $regular_price > $sale_price){
            $price = $sale_price;
          }
          elseif(isset($regular_price) && $regular_price){
            $price = $regular_price;
          }
        }
      }
    }
    
    return $price;
  }
  
  
  /**
   * Products add to cart set 
   *
   * @param Cart data
   * @return string
   */
  function sortBy($array, $key, $sort, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
      if (!empty($key)) {
        $mapping = array();
        foreach ($array as $k => $v) {
          $sort_key = '';
          if (!is_array($key)) {
            $sort_key = $v[$key];
          } else {
            foreach ($key as $key_key) {
              $sort_key .= $v[$key_key];
            }
            $sort_flags = SORT_STRING;
          }
          $mapping[$k] = $sort_key;
        }
        
        if($sort == 'asc'){
          asort($mapping, $sort_flags); //ascending 
        }
        elseif($sort == 'desc'){
          arsort($mapping, $sort_flags); //descending 
        }
     
        $sorted = array();
        foreach ($mapping as $k => $v) {
          $sorted[] = $array[$k];
        }
        return $sorted;
      }
    }
    return $array;
  }
		
  /**
  * Check product cats are same for some reason
  *
  * @param array, array
  * @return boolean
  */
  public function is_product_cat_in_selected_cat($array1, $array2){
    $filter_ary  = array();
    $normal_ary  = array();
    $matched_ary = array();
    $is_matched  = false;
    
    if(count($array1) > 0 && isset($array1['term_id'])){
      $filter_ary = $array1['term_id'];
    }

    if(count($array2) > 0){
      foreach($array2 as $cat){
        array_push($normal_ary, $cat['id']);
      }
    }

    if(count($filter_ary) > 0 && count($normal_ary)){
      $matched_ary = array_intersect($filter_ary, $normal_ary);
    }

    if(count($matched_ary) > 0){
      $is_matched = true;
    }
    
    return $is_matched;
  }
  
  /**
  * create zoom image url for product gallery 
  *
  * @param product url
  * @return string url
  */
  public function createZoomImageUrl( $product_url ){
    $old_file_name = basename($product_url);
    $new_file_name = 'large-'.$old_file_name;
    $file_new_url = str_replace($old_file_name, $new_file_name, $product_url);
    
    return $file_new_url;
  }
  
  /**
  * This check what is required for the downloadable product download 
  *
  * @param post_id
  * @return boolean
  */
  public function checkDownloadRequired($data, $order_id, $file_name){
    $today = date("Y-m-d");
    $condition = false;
     
    $count_download = DownloadExtra::where(['order_id' => $order_id, 'file_name' => $file_name])->get()->toArray();
 
    if( ((!empty($data['downloadable_product_download_expiry']) &&  $today <= $data['downloadable_product_download_expiry']) || (empty($data['downloadable_product_download_expiry'])) ) && ( (!empty($data['downloadable_product_download_limit']) && count($count_download) < $data['downloadable_product_download_limit']) || (empty($data['downloadable_product_download_limit']))) ){
      $condition = true;
    }
    
    return $condition;
  }
  
  /**
  * Object to array conversion
  *
  * @param object, array
  * @return array
  */
  public function objToArray($obj){
    if (!is_object($obj) && !is_array($obj)) {
        return $obj;
    }

    foreach ($obj as $key => $value) {
        $arr[$key] = $this->objToArray($value);
    }

    return $arr;
  }
  
  /**
  * Send SMS to the admin
  *
  * @param null
  * @return void
  */
  public function sendSMSToAdmin(){
    $nexmo_data = get_nexmo_data();
    
    if(!empty($nexmo_data['number_to']) && !empty($nexmo_data['number_from']) && !empty($nexmo_data['message'])){
      Nexmo::message()->send([
          'to'   =>   $nexmo_data['number_to'],
          'from' =>   $nexmo_data['number_from'],
          'text' =>   $nexmo_data['message']
      ]);
    }
  }
  
  /**
  * Common data for admin all pages 
  *
  * @param null
  * @return void
  */
  public function commonDataForAllPages(){
    $data = array();
    $parm = 'all';
    $user_permission = array();
    
    //set lang
    $this->set_admin_lang();
    
    //check vendor expired
    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      if(is_vendor_expired(Session::get('shopist_admin_user_id'))){
        return view('errors.vendor_expired');
      }
    }
      
    $get_user_data = get_current_admin_user_info();
    $get_role_data = get_roles_details_by_role_id( $get_user_data['user_role_id'] );
    
    if(!empty($get_role_data)){
      $user_permission  =  $get_role_data->permissions;
    }
 
    if(is_vendor_login()){
      $parm = Session::get('shopist_admin_user_id');
    }
    
    $get_default_lang = get_default_languages_data();
    
    $data['user_data']              =   $get_user_data;
    $data['user_permission_list']   =   $user_permission;
    $data['product_parm']           =   $parm;
    $data['default_lang_code']      =   $get_default_lang['lang_code'];
    
    return $data;
  }
}