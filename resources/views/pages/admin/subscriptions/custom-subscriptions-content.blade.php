@extends('layouts.admin.master')
@section('title', trans('admin.custom_subscriptions_page_title') .' < '. get_site_title())

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.custom_subscriptions_info_top_title') }}</h3>
        </div> 
        <div class="box-body">
          <table class="table table-bordered admin-data-table admin-data-list">
            <thead class="thead-dark">
              <tr>
                <th>{{ trans('admin.custom_subscriptions_info_email_id_title') }}</th>
                <th>{{ trans('admin.custom_subscriptions_info_name_title') }}</th>
                <th>{{ trans('admin.custom_subscriptions_info_date_title') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($custom_subscriber_data))
                @foreach($custom_subscriber_data as $row)
                <tr>
                    <td>{!! $row->email !!}</td>
                    <td>{!! $row->name !!}</td>
                    <td>{!! Carbon\Carbon::parse( $row->created_at )->format('F d, Y') !!}</td>
                </tr>
                @endforeach
              @else
              <tr><td colspan="3"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
              @endif
            </tbody>
            <tfoot class="thead-dark">
              <tr>
                <th>{{ trans('admin.custom_subscriptions_info_email_id_title') }}</th>
                <th>{{ trans('admin.custom_subscriptions_info_name_title') }}</th>
                <th>{{ trans('admin.custom_subscriptions_info_date_title') }}</th>
              </tr>
          </tfoot>
          </table>
            <br>
            <div class="products-pagination">{!! $custom_subscriber_data->appends(Request::capture()->except('page'))->render() !!}</div>
        </div>
      </div>
    </div>
  </div>
@endsection