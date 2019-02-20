@extends('layouts.admin.master')
@section('title', trans('admin.request_product_page_title') .' < '. get_site_title())

@section('content')
<div class="row">
  <div class="col-12">
    <h5>{!! trans('admin.request_products_list') !!}</h5>
  </div>
</div>    
<br>
<div class="row">
  <div class="col-12">
    <h3></h3>  
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered admin-data-table admin-data-list">
          <thead class="thead-dark">
            <tr>
              <th>{{ trans('admin.request_product_table_header_name_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_email_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_tele_number_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_source_name_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_desc_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_date_title') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($request_product_data) > 0)  
              @foreach($request_product_data as $row )
                <tr>
                  <td>{{ $row->name}}</td>  
                  <td>{{ $row->email}}</td>
                  <td>{{ $row->phone_number}}</td>
                  <td><a target="_blank" href="{{ route('details-page', $row->slug) }}"> {{ $row->title }} </a></td>
                  <td>{{ $row->description}}</td>
                  <td>{{ Carbon\Carbon::parse(  $row->created_at )->format('F d, Y') }}</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                      <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a class="remove-selected-data-from-list" data-track_name="request_product_list" data-id="{{ $row->id }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              @endforeach
            @else
            <tr><td colspan="7"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
            @endif
          </tbody>
          <tfoot class="thead-dark">
            <tr>
              <th>{{ trans('admin.request_product_table_header_name_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_email_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_tele_number_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_source_name_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_desc_title') }}</th>
              <th>{{ trans('admin.request_product_table_header_date_title') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </tfoot>
        </table>
          <br>
        <div class="products-pagination">{!! $request_product_data->appends(Request::capture()->except('page'))->render() !!}</div>  
      </div>
    </div>
  </div>
</div>
@endsection