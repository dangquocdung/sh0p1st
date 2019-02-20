@extends('layouts.admin.master')
@section('title', trans('admin.user_role_list_title') .' < '. get_site_title())

@section('content')
<div class="row">
  <div class="col-6">
    <h5>{!! trans('admin.user_role_list_title') !!}</h5>
  </div>
  <div class="col-6">
    <div class="pull-right">
      <a href="{{ route('admin.add_roles') }}" class="btn btn-primary pull-right btn-sm">{{ trans('admin.add_new_role_title') }}</a>
    </div>  
  </div>
</div>
<br>

<div class="row">
  <div class="col-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.users_roles_list') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_user_role" class="search-query form-control" placeholder="Enter user role to search" value="{{ $search_value }}" />
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
        <table id="table_for_user_list" class="table table-bordered admin-data-table admin-data-list">
          <thead class="thead-dark">
            <tr>
              <th>{{ trans('admin.user_role_list_table_header_title_1') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($user_role_list_data)>0)
            @foreach($user_role_list_data as $row)
            <tr>
              <td>{!! $row['role_name'] !!}</td> 
              <td>
                @if(($row['slug'] == 'vendor') || ($row['slug'] == 'site-user')) 
                  {!! trans('admin.no_permission_label') !!}
                @else
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="{{ route('admin.update_roles', $row['id']) }}"><i class="fa fa-edit"></i>{{ trans('admin.edit') }}</a></li>
                      @if($row['slug'] != 'administrator')
                      <li><a class="remove-selected-data-from-list" data-track_name="user_roles" data-id="{{ $row['id'] }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                      @endif
                    </ul>
                  </div>
                @endif
              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
          <tfoot class="thead-dark">
            <tr>
              <th>{{ trans('admin.user_role_list_table_header_title_1') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </tfoot>
        </table>
          <br>
        <div class="products-pagination">{!! $user_role_list_data->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>
<div class="eb-overlay"></div>
<div class="eb-overlay-loader"></div>

<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
@endsection