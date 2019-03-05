@extends('layouts.admin.master')
@section('title', trans('admin.announcement_label') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')
@include('pages-message.notify-msg-error')
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.add_new_post_top_title') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-sm" href="{{ route('admin.announcement_list_content') }}">{{ trans('admin.posts_list') }}</a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary btn-block btn-sm" type="submit">{{ trans('admin.save') }}</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{{ trans('admin.post_title') }}</h3>
        </div>
        <div class="box-body">
          <input type="text" placeholder="{{ trans('admin.post_title_placeholder') }}" class="form-control" name="vendor_announcement_post_title" id="vendor_announcement_post_title" value="{{ old('vendor_announcement_post_title') }}">
        </div>
      </div>
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{{ trans('admin.post_description') }}</h3>
        </div>
        <div class="box-body">
          <textarea id="announcement_description_editor" name="announcement_description_editor" class="dynamic-editor" placeholder="{{ trans('admin.post_description_placeholder') }}"></textarea>
        </div>
      </div>  
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{{ trans('admin.announcement_settings_label') }}</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <div class="row">
              <label class="col-sm-5 control-label" for="inputSendAnnouncement">{{ trans('admin.send_announcement_to_label') }}</label>
              <div class="col-sm-7">
                <select id="send_announcement" name="send_announcement" class="form-control select2" style="width: 100%;">
                  <option selected="selected" value="">{!! trans('admin.select_option_label') !!}</option>
                  <option value="all_vendor">{!! trans('admin.all_vendor_label') !!}</option>
                  <option value="selected_vendor">{!! trans('admin.selected_vendor_label') !!}</option>
                </select>   
              </div>
            </div>    
          </div>
          <div id="send_selected_vendor" class="form-group" style="display:none;">
            <div class="row">  
              <label class="col-sm-5 control-label" for="inputSelectVendor">{{ trans('admin.select_vendor_label') }}</label>
              <div class="col-sm-7">
                <input type="text" name="vendor_lists" placeholder="{{ trans('admin.vendor_search_placeholder_label') }}" class="typeahead vendor-lists-typeahead tm-input vendor-lists-input form-control tm-input-info"/>
              </div>
            </div>  
          </div>  
        </div>
      </div>    
    </div>
    <div class="col-md-4">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-eye"></i>
          <h3 class="box-title">{{ trans('admin.visibility') }}</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <div class="row">  
              <label class="col-sm-3 control-label" for="inputVisibility">{{ trans('admin.status') }}</label>
              <div class="col-sm-9">
                <select class="form-control select2" name="announcement_post_visibility" style="width: 100%;">
                  <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
                  <option value="0">{{ trans('admin.disable') }}</option>                  
                </select>                                         
              </div>
            </div>  
          </div>
        </div>
      </div> 
    </div>
  </div>
  <input type="hidden" name="selected_vendors" id="selected_vendors"> 
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
</form>
@endsection