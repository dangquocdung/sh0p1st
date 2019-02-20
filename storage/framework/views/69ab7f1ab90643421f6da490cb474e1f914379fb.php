<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $__env->yieldContent('title'); ?></title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link rel="stylesheet" href="<?php echo e(URL::asset('bootstrap/css/bootstrap.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(URL::asset('font-awesome/css/font-awesome.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(URL::asset('dist/css/Admin.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(URL::asset('plugins/iCheck/square/blue.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(URL::asset('css/admin/shopist.css')); ?>" />
</head>
<body class="hold-transition register-page">
  <?php echo $__env->yieldContent('content'); ?>
  
  <script type="text/javascript" src="<?php echo e(URL::asset('jquery/jquery-1.10.2.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(URL::asset('bootstrap/js/bootstrap.min.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(URL::asset('plugins/iCheck/icheck.min.js')); ?>"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
      });
    });
  </script>
</body>
</html>