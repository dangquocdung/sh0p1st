<h3>{!! trans('admin.emails_notifications_user_account_label') !!}</h3><hr>
<p>{!! trans('admin.new_account_mail_msg') !!}</p>
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="email_type" value="new_customer_account">
  
  <div class="box box-solid">
    <div class="box-body">
      <div class="form-group">
        <div class="row">    
          <label class="col-sm-4 control-label" for="inputEnableDisable">{{ trans('admin.email_enable_disable_label') }}</label>
          <div class="col-sm-8">
            @if($emails_notification_data['new_customer_account']['enable_disable'] == true)
              <input type="checkbox" checked="checked" name="new_customer_account_enable_disable" class="shopist-iCheck"> &nbsp;{!! trans('admin.enable_notify_msg_label') !!}
            @else
              <input type="checkbox" name="new_customer_account_enable_disable" class="shopist-iCheck"> &nbsp;{!! trans('admin.enable_notify_msg_label') !!}
            @endif
          </div>
        </div>  
      </div>
      <div class="form-group">
        <div class="row">    
          <label class="col-sm-4 control-label" for="inputSubject">{{ trans('admin.subject') }}</label>
          <div class="col-sm-8">
            <input type="text" name="new_customer_account_subject" class="form-control" value="{{ $emails_notification_data['new_customer_account']['subject'] }}">
          </div>
        </div>  
      </div> 
    </div>
    <div class="clearfix">
      <div class="pull-right">
        <button style="margin:0px 15px 15px 0px;" class="btn btn-primary pull-right btn-sm" type="submit">{{ trans('admin.save') }}</button>
      </div>
    </div>
  </div>		
</form>    