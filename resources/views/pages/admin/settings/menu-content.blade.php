@extends('layouts.admin.master')
@section('title', trans('admin.manage_menu_content') .' < '. get_site_title())

@section('content')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">{{ trans('admin.menu_settings') }}</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-primary pull-right update_menu btn-sm" type="button">{!! trans('admin.save') !!}</button>
    </div>
  </div>
</div>
<p>{!! trans('admin.menu_to_label_message') !!}</p>

<div class="box box-solid">
  <div class="row">
    <div class="col-md-12">
      <div class="box-body"> 
        <ul id="menu_sortable">
        {!! $menu_html !!}  
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection