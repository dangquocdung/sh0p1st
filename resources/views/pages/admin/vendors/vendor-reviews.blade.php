@extends('layouts.admin.master')
@section('title', trans('admin.vendor_reviews_title_label') .' < '. get_site_title())

@section('content')
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title">{!! trans('admin.reviews_list_top_title') !!}</h3>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="box box-solid">
      <div class="box-body">
        <table id="table_for_products_list" class="table table-bordered admin-data-table admin-data-list">
          <thead class="thead-dark">
            <tr>
              <th>{!! trans('admin.user_image') !!}</th>
              <th>{!! trans('admin.user_display_name') !!}</th>
              <th>{!! trans('admin.user_contents') !!}</th>
              <th>{!! trans('admin.user_rating_val') !!}</th>
              <th>{!! trans('admin.comment_status') !!}</th>
              <th>{!! trans('admin.comment_added') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($vendor_reviews) > 0)  
              @foreach($vendor_reviews as $row)
              <tr>
                @if(!empty($row->user_photo_url))
                  <td><img src="{{ get_image_url($row->user_photo_url) }}" alt="{{ $row->user_photo_url }}"></td>
                @else
                  <td><img src="{{ default_placeholder_img_src() }}" alt=""></td>
                @endif

                <td>{!! $row->display_name !!}</td>
                <td>{!! $row->content !!}</td>
                <td>{!! $row->rating !!}</td>

                @if($row->status == 1)
                  <td>{!! trans('admin.enable') !!}</td>
                @else
                  <td>{!! trans('admin.disable') !!}</td>
                @endif

                <td>{{ Carbon\Carbon::parse(  $row->created_at )->format('d, M Y') }}</td>

                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{!! trans('admin.action') !!}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      @if($row->status == 1)
                        <li><a href="" class="reviews-status-change" data-target="vendor" data-id="{{ $row->id }}" data-status="disable"><i class="fa fa-close"></i>{!! trans('admin.disable') !!}</a></li>
                      @else
                        <li><a href="" class="reviews-status-change" data-target="vendor" data-id="{{ $row->id }}" data-status="enable"><i class="fa fa-check-circle"></i>{!! trans('admin.enable') !!}</a></li>
                      @endif
                      <li><a class="remove-selected-data-from-list" data-track_name="vendor_reviews_list" data-id="{{ $row->id }}" href="#"><i class="fa fa-remove"></i>{!! trans('admin.delete') !!}</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            @else
              <tr><td colspan="8"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
            @endif
          </tbody>
          <tfoot class="thead-dark">
            <tr>
              <th>{!! trans('admin.user_image') !!}</th>
              <th>{!! trans('admin.user_display_name') !!}</th>
              <th>{!! trans('admin.user_contents') !!}</th>
              <th>{!! trans('admin.user_rating_val') !!}</th>
              <th>{!! trans('admin.comment_status') !!}</th>
              <th>{!! trans('admin.comment_added') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </tfoot>
        </table>
          <br>
        <div class="products-pagination">{!! $vendor_reviews->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>
@endsection