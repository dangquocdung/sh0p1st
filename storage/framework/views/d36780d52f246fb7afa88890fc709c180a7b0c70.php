<meta charset="UTF-8">
<title><?php echo $__env->yieldContent('title'); ?></title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<?php if((Request::is('product/details/*') || Request::is('product/customize/*')) && !empty($single_product_details['meta_keywords'])): ?>
<meta name="keywords" content="<?php echo e($single_product_details['meta_keywords']); ?>">

<?php elseif( Request::is('blog/*') && !empty($blog_details_by_slug['meta_keywords'])): ?>
<meta name="keywords" content="<?php echo e($blog_details_by_slug['meta_keywords']); ?>">

<?php elseif((Request::is('store/details/home/*') || Request::is('store/details/products/*') || Request::is('store/details/reviews/*') || Request::is('store/details/cat/products/*')) && !empty($store_seo_meta_keywords)): ?>
<meta name="keywords" content="<?php echo e($store_seo_meta_keywords); ?>">

<?php elseif(!empty($seo_data) && $seo_data['meta_tag']['meta_keywords']): ?>
<meta name="keywords" content="<?php echo e($seo_data['meta_tag']['meta_keywords']); ?>">
<?php endif; ?>

<?php if(!empty($seo_data) && $seo_data['meta_tag']['meta_description']): ?>
<meta name="description" content="<?php echo e($seo_data['meta_tag']['meta_description']); ?>">
<?php endif; ?>

<?php if((Request::is('product/details/*') || Request::is('product/customize/*')) && !empty($single_product_details['_product_seo_description'])): ?>
<meta name="description" content="<?php echo e($single_product_details['_product_seo_description']); ?>">
<?php endif; ?>

<?php if((Request::is('product/details/*') || Request::is('product/customize/*')) && !empty($single_product_details['post_slug'])): ?>
<link rel="canonical" href="<?php echo e(route('details-page', $single_product_details['post_slug'])); ?>">
<?php endif; ?>

<?php if(Request::is('blog/*') && !empty($blog_details_by_slug['blog_seo_description'])): ?>
<meta name="description" content="<?php echo e($blog_details_by_slug['blog_seo_description']); ?>">
<?php endif; ?>

<?php if(Request::is('blog/*') && !empty($blog_details_by_slug['blog_seo_url'])): ?>
<link rel="canonical" href="<?php echo e(route('blog-single-page', $blog_details_by_slug['blog_seo_url'])); ?>">
<?php endif; ?>

<?php if((Request::is('store/details/home/*') || Request::is('store/details/products/*') || Request::is('store/details/reviews/*') || Request::is('store/details/cat/products/*')) && !empty($store_seo_meta_description)): ?>
<meta name="description" content="<?php echo e($store_seo_meta_description); ?>">
<?php endif; ?>

<link rel="stylesheet" href="<?php echo e(URL::asset('bootstrap/css/bootstrap.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('font-awesome/css/font-awesome.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('plugins/datatable/dataTables.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('plugins/datatable/responsive.bootstrap4.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('sweetalert/sweetalert.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('plugins/select2/select2.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('dropzone/css/dropzone.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('designer/designer.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('designer/scroll/jquery.mCustomScrollbar.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('plugins/ionslider/ion.rangeSlider.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('plugins/ionslider/ion.rangeSlider.skinModern.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('plugins/bootstrap-slider/slider.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('frontend/css/common.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('frontend/css/price-range.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('plugins/iCheck/square/purple.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('modal/css/modal.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('modal/css/modal-extra.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('slick/slick.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(URL::asset('slick/slick-theme.css')); ?>" />

<link rel="stylesheet" href="<?php echo e(URL::asset('templates-assets/footer/black-crazy/style.css')); ?>" />

<!--load header style-->
<link rel="stylesheet" href="<?php echo e(URL::asset('templates-assets/header/'. $appearance_settings['header'] .'/style.css')); ?>" />

<!--load home style-->
<link rel="stylesheet" href="<?php echo e(URL::asset('templates-assets/home/'. $appearance_settings['home'] .'/style.css')); ?>" />

<!--load blogs style-->
<link rel="stylesheet" href="<?php echo e(URL::asset('templates-assets/blog/'. $appearance_settings['blogs'] .'/style.css')); ?>" />

<!--load products style-->
<link rel="stylesheet" href="<?php echo e(URL::asset('templates-assets/product/'. $appearance_settings['products'] .'/style.css')); ?>" />

<!--load single products style-->
<link rel="stylesheet" href="<?php echo e(URL::asset('templates-assets/single-product/'. $appearance_settings['single_product'] .'/style.css')); ?>" />


<script type="text/javascript" src="<?php echo e(URL::asset('jquery/jquery-1.10.2.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('jquery/jquery-ui-1.11.4.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('dropzone/dropzone.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('bootstrap/js/popper.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('bootstrap/js/bootstrap.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('plugins/datatable/jquery.dataTables.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('plugins/datatable/dataTables.bootstrap4.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('plugins/datatable/dataTables.responsive.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('plugins/datatable/responsive.bootstrap4.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('frontend/js/jquery.scrollUp.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('sweetalert/sweetalert.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('plugins/select2/select2.full.min.js')); ?>"></script>

<?php if(Request::is('product/customize/*')): ?>
<script type="text/javascript" src="<?php echo e(URL::asset('designer/fabric-1.5.0.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('designer/customiseControls.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('designer/fabric.curvedText.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('designer/jsPDF.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('designer/designer.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('designer/designerControl.js')); ?>"></script>
<?php endif; ?>

<script type="text/javascript" src="<?php echo e(URL::asset('designer/colorpicker/jscolor.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('designer/scroll/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('plugins/ionslider/ion.rangeSlider.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('plugins/bootstrap-slider/bootstrap-slider.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('frontend/js/products-variation.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('frontend/js/products-add-to-cart.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('frontend/js/price-range.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('plugins/iCheck/icheck.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('modal/js/modal.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('frontend/js/jquery.validate.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(URL::asset('templates-assets/footer/black-crazy/script.js')); ?>"></script>

<!--load header scripts-->
<script type="text/javascript" src="<?php echo e(URL::asset('templates-assets/header/'. $appearance_settings['header'] .'/script.js')); ?>"></script>

<!--load home scripts-->
<script type="text/javascript" src="<?php echo e(URL::asset('templates-assets/home/'. $appearance_settings['home'] .'/script.js')); ?>"></script>

<!--load blogs scripts-->
<script type="text/javascript" src="<?php echo e(URL::asset('templates-assets/blog/'. $appearance_settings['blogs'] .'/script.js')); ?>"></script>

<!--load products scripts-->
<script type="text/javascript" src="<?php echo e(URL::asset('templates-assets/product/'. $appearance_settings['products'] .'/script.js')); ?>"></script>

<!--load single products scripts-->
<script type="text/javascript" src="<?php echo e(URL::asset('templates-assets/single-product/'. $appearance_settings['single_product'] .'/script.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('templates-assets/single-product/'. $appearance_settings['single_product'] .'/jquery.elevatezoom.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(URL::asset('frontend/js/common.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('frontend/js/social-network.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('slick/slick.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::asset('common/base64.js')); ?>"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
