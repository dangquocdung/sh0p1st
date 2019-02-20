@extends('layouts.admin.master')
@section('title', trans('admin.currency_list') .' < '. get_site_title())

@section('content')
<div class="row">
  <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
    <h4>{!! trans('admin.currency_list') !!}</h4>
  </div>
  <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
    <div class="pull-right">
      <a href="{{ route('admin.custom_currency_settings_add_content') }}" class="btn btn-primary pull-right btn-sm">{{ trans('admin.add_new_currency') }}</a>
    </div>  
  </div>
</div>
<br>
<div class="row">
  <div class="col-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.custom_currency_settings_list_content') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_currency_name" class="search-query form-control" placeholder="{{ trans('admin.searchbox_currency_label') }}" value="{{ $search_value }}" />
                  <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                      <span class="fa fa-search"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>  
        </div>      
        <table id="table_for_manufacturers_list" class="table table-bordered admin-data-table admin-data-list">
          <thead class="thead-dark">
            <tr>
              <th>{{ trans('admin.list_currency_name_label') }}</th>
              <th>{{ trans('admin.list_currency_code_label') }}</th>
              <th>{{ trans('admin.list_currency_value_label') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($custom_currency_list)>0)
              @foreach($custom_currency_list as $row)
              <tr>
                <td>{!! $row['currency_name'] !!}</td>
                <td>{!! $row['currency_code'] !!} ({!! get_currency_symbol_by_code( $row['currency_code'] ) !!})</td>
                <td>{!! $row['currency_value'] !!}</td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="{{ route('admin.custom_currency_settings_update_content', $row['id']) }}"><i class="fa fa-edit"></i>{{ trans('admin.edit') }}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="currency_list" data-id="{{ $row['id'] }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                      
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            @else
            <tr><td colspan="4"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>
            @endif
          </tbody>
          <tfoot class="thead-dark">
            <th>{{ trans('admin.list_currency_name_label') }}</th>
            <th>{{ trans('admin.list_currency_code_label') }}</th>
            <th>{{ trans('admin.list_currency_value_label') }}</th>
            <th>{{ trans('admin.action') }}</th>
          </tfoot>
        </table>
          <br>
        <div class="products-pagination">{!! $custom_currency_list->appends(Request::capture()->except('page'))->render() !!}</div>  
      </div>
    </div>
  </div>
</div>
@endsection