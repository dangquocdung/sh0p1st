@extends('layouts.admin.master')
@section('title', trans('admin.update_currency') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.update_currency') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-sm" href="{{ route('admin.custom_currency_settings_list_content') }}">{{ trans('admin.currency_list') }}</a> &nbsp;&nbsp; <a href="{{ route('admin.custom_currency_settings_add_content') }}" class="btn btn-default btn-sm">{{ trans('admin.add_new_currency') }}</a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary btn-block btn-sm" type="submit">{{ trans('admin.update') }}</button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-body">
          <div class="form-group">
            <div class="row">  
              <label class="col-sm-3 control-label" for="inputCurrencyName">{{ trans('admin.currency_name_label') }}</label>
              <div class="col-sm-9">
                  <input type="text" placeholder="{{ trans('admin.currency_name_label') }}" class="form-control" name="currency_name" id="currency_name" value="{{ $currency_update_data->currency_name }}">
              </div>
            </div>  
          </div>
          
          <div class="form-group">
            <div class="row">  
              <label class="col-sm-3 control-label" for="selectCurrency">{{ trans('admin.select_currency_label') }}</label>
              <div class="col-sm-9">
                <select class="form-control select2" name="select_currency" style="width: 100%;"> 
                  @if(count(get_available_currency_name())>0)
                    @foreach(get_available_currency_name() as $currency_code => $currency_name)
                      @if($currency_update_data->currency_code == $currency_code)
                      <option selected="selected" value="{{ $currency_code }}">{!! $currency_name !!}</option>
                      @else
                      <option value="{{ $currency_code }}">{!! $currency_name !!}</option>
                      @endif
                    @endforeach
                  @endif
                </select>
              </div>
            </div>  
          </div>
          
          <div class="form-group">
            <div class="row">  
              <label class="col-sm-3 control-label" for="inputCurrencyValue">{{ trans('admin.currency_value_label') }}</label>
              <div class="col-sm-9">
                <input type="number" placeholder="{{ trans('admin.currency_value_label') }}" class="form-control" name="currency_value" id="currency_value" value="{{ $currency_update_data->currency_value }}" step="any">
                [ {!! trans('admin.currency_value_msg') !!} ]
              </div>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection