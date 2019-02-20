<!doctype html>
<html>
<head>
    <?php echo $__env->make('includes.admin.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body id="admin_panel" class="skin-blue sidebar-mini wysihtml5-supported">
  <div class="wrapper">
    <?php echo $__env->make('includes.admin.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('includes.admin.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content-header">
        <?php echo $__env->yieldContent('content-header'); ?>
      </section>
      <section class="content">
        <?php echo $__env->yieldContent('content'); ?>
      </section>
    </div><!-- /.content-wrapper -->
    <input type="hidden" name="hf_base_url" id="hf_base_url" value="<?php echo e(url('/')); ?>">
    <input type="hidden" name="lang_code" id="lang_code" value="<?php echo e($default_lang_code); ?>">
    <input type="hidden" name="site_name" id="site_name" value="admin">
    <div class="ajax-request-response-msg" style="display: none; background-color: #333;padding:20px 0px;position:fixed;width:100%;color:#DDD;bottom: 0px;z-index: 999;text-align: center;left: 0px; font-size:16px;"></div>
  </div><!-- ./wrapper -->
</body>
</html>