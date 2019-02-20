@extends('layouts.frontend.master')
@section('title', trans('frontend.frontend_user_forgot_password') .' - '. get_site_title())
@section('content')
<div class="container"><br>  
  <div class="row justify-content-center">
    <div class="col-md-6 text-center">
      <div class="panel panel-login">
        <div class="panel-heading">
          <div class="row justify-content-center">
            <div class="col-xs-12 text-center">
              <h3>{{ trans('frontend.forgot_password') }}</h3>
              <p>{{ trans('frontend.reset_password_msg') }}</p>
            </div>
          </div>
          <hr>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              @include('pages-message.notify-msg-error')
              @include('pages-message.form-submit')
              
              <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                
                <div class="form-group has-feedback">
                  <input type="email" placeholder="{{ ucfirst( trans('frontend.email') ) }}" class="form-control" id="user_forgot_pass_email_id"name="user_forgot_pass_email_id">
                  <span class="fa fa-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                  <input type="password" placeholder="{{ ucfirst(trans('frontend.enter_new_password')) }}" class="form-control" id="user_forgot_new_password" name="user_forgot_new_password">
                  <span class="fa fa-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                  <input type="text" placeholder="{{ ucfirst(trans('frontend.secret_key')) }}" class="form-control" id="user_forgot_secret_key" name="user_forgot_secret_key">
                  <span class="fa fa-lock form-control-feedback"></span>
                </div>

                <div class="form-group">
                  <div class="row justify-content-center">
                    <div class="col-sm-6 text-center">
                      <input name="user_forgot_pass_submit" id="user_forgot_pass_submit" class="form-control btn btn-secondary" value="{{ trans('frontend.reset_my_password') }}" type="submit">
                    </div>
                  </div>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
@endsection  