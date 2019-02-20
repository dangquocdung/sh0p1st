@extends('layouts.admin.master')
@section('title', trans('admin.product_tags_list') .' < '. get_site_title())

@section('content')
<div class="row">
  <div class="col-6">
    <h5>{!! trans('admin.tags_list') !!}</h5>
  </div>
  <div class="col-6">
    <div class="pull-right">
      <button data-toggle="modal" data-target="#addDynamicTags" class="btn btn-primary custom-event-tags btn-sm" type="button">{!! trans('admin.add_new_tag') !!}</button>
    </div>  
  </div>
</div>
<br>

<div class="modal fade" id="addDynamicTags" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
  <div class="modal-dialog add-tag-dialog">
    <div class="ajax-overlay"></div>
    
    <div class="modal-content">
      <div class="modal-header">
        <p class="no-margin">{!! trans('admin.create_new_product_tag') !!}</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  
      <div class="modal-body">
        <div class="custom-model-row">
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputTagName">{!! trans('admin.name') !!}</label></div>
            <div class="custom-input-element"><input type="text" placeholder="{{ trans('admin.name') }}" id="inputTagName" name="inputTagName" class="form-control"></div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputTagDescription">{!! trans('admin.description') !!}</label></div>
            <div class="custom-input-element">
              <textarea class="form-control" name="inputTagDescription" id="inputTagDescription" placeholder="{{ trans('admin.description') }}"></textarea>
            </div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputTagStatus">{!! trans('admin.status') !!}</label></div>
            <div class="custom-input-element">
              <select name="tag_status" id="tag_status" class="form-control select2" style="width: 100%;">
                <option value="1">{!! trans('admin.enable') !!}</option>
                <option value="0">{!! trans('admin.disable') !!}</option>
              </select>
            </div>
          </div>
        </div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default attachtopost create-tag">{!! trans('admin.create_tag') !!}</button>
        <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{!! trans('admin.close') !!}</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.product_tags_list') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_tag" class="search-query form-control" placeholder="Enter your tag name to search" value="{{ $search_value }}" />
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
        <table class="table table-bordered admin-data-table admin-data-list">
          <thead class="thead-dark">
            <tr>
              <th>{!! trans('admin.name') !!}</th>
              <th>{!! trans('admin.status') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($tag_list_data)>0)
              @foreach($tag_list_data as $row)
              <tr>
                <td>{!! $row['name'] !!}</td>

                @if($row['status'] == 1)
                  <td>{!! trans('admin.enable') !!}</td>
                @else
                  <td>{!! trans('admin.disable') !!}</td>
                @endif

                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{!! trans('admin.action') !!}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="#" class="edit-data" data-track_name="tag_list" data-id="{{ $row['term_id'] }}"><i class="fa fa-edit"></i>{!! trans('admin.edit') !!}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="tag_list" data-id="{{ $row['term_id'] }}" href="#"><i class="fa fa-remove"></i>{!! trans('admin.delete') !!}</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            @else
            <tr><td colspan="3"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>
            @endif
          </tbody>
          <tfoot class="thead-dark">
            <tr>
              <th>{!! trans('admin.name') !!}</th>
              <th>{!! trans('admin.status') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </tfoot>
        </table>
        <br>  
        <div class="products-pagination">{!! $tag_list_data->appends(Request::capture()->except('page'))->render() !!}</div>  
      </div>
    </div>
  </div>
</div>
<div class="eb-overlay"></div>
<div class="eb-overlay-loader"></div>

<input type="hidden" name="hf_from_model" id="hf_from_model" value="">
<input type="hidden" name="hf_update_id" id="hf_update_id" value="">

@endsection