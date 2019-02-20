@extends('layouts.admin.master')
@section('title', trans('admin.products_list') .' < '. get_site_title())

@section('content')
<div class="row">
  <div class="col-6">
    <h5>{!! trans('admin.products_list') !!}</h5>
  </div>
  <div class="col-6">
    <div class="pull-right">
      <a href="{{ route('admin.add_product') }}" class="btn btn-primary pull-right btn-sm">{!! trans('admin.add_new_product') !!}</a>
    </div>  
  </div>
</div>

<div class="row">
  <div class="col-12">
				<div class="clearfix">
						<div class="products-export-import-options">
        <ul style="padding: 0px;">
          <li><div class="btn btn-primary btn-sm" data-toggle="modal" data-target="#productImport"><i class="fa fa-download"></i> {!! trans('admin.import_label') !!}</div></li>
										<li><div class="btn btn-primary btn-sm" data-toggle="modal" data-target="#productExport"><i class="fa fa-upload"></i> {!! trans('admin.export_label') !!}</div></li>
								</ul>
						</div>
						
						<div class="modal fade" id="productImport" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
								<div class="modal-dialog">
										<form enctype="multipart/form-data" id="product_csv_import" method="POST">
												<div class="modal-content">
              <div class="modal-header">
                <p class="no-margin">{!! trans('admin.import_title_label') !!}</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>   
														<div class="modal-body">   
                <input type="file" name="csvFileImport" id="csvFileImport" /><br>
                <div class="sample-csv-download"><a href="{{ url('/'). '/public/extra-files/products_import.csv' }}" download="">[ {!! trans('admin.sample_csv_file_label') !!} ]</a></div>
														</div>
              <div class="modal-footer" style="position:relative;">
																<input type="submit" name="upload_product_file" id="upload_product_file" value="{{ trans('admin.upload_lang_zip_file') }}" class="btn btn-default attachtopost upload-btn-action" /> 
																<button  type="button" class="btn btn-default attachtopost upload-btn-action" data-dismiss="modal">{!! trans('admin.close') !!}</button>
														</div>
												</div>
										</form>		
								</div>
						</div>
				
						<div class="modal fade" id="productExport" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
								<div class="modal-dialog">
										<div class="modal-content">
            <div class="modal-header">
              <p class="no-margin">{!! trans('admin.export_title_label') !!}</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
												<div class="modal-body">     
              <a href="{{ route('export-products') }}" class="btn btn-default export-csv-file">{!! trans('admin.export_csv_file_label') !!}</a>
												</div>
												<div class="modal-footer">
														<button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{!! trans('admin.close') !!}</button>
												</div>
										</div>
								</div>
						</div>
				</div>		
				
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.product_list', 'all') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_product" class="search-query form-control" placeholder="Enter product name to search" value="{{ $search_value }}" />
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
              <th>{!! trans('admin.product_image') !!}</th>
              <th>{!! trans('admin.product_name') !!}</th>
              <th>{!! trans('admin.product_sku') !!}</th>
              <th>{!! trans('admin.product_type') !!}</th>
              <th>{!! trans('admin.product_price') !!}</th>
              <th>{!! trans('admin.product_status') !!}</th>
              <th>{!! trans('admin.vendor_name_label') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </thead>
          <tbody>
            @if($product_all_data->count() > 0)  
              @foreach($product_all_data as $row)
              <tr>
                @if(!empty($row->image_url))
                  <td><img src="{{ get_image_url($row->image_url) }}" alt="{{ basename ($row->image_url) }}"></td>
                @else
                  <td><img src="{{ default_placeholder_img_src() }}" alt=""></td>
                @endif

                <td>{!! $row->title !!}</td>

                <td>{!! $row->sku !!}</td>

                @if($row->type == 'simple_product')
                  <td>{!! trans('admin.simple_product') !!}</td>
                @elseif($row->type == 'configurable_product')
                  <td>{!! trans('admin.configurable_product') !!}</td>
                @elseif($row->type == 'downloadable_product')  
                  <td>{!! trans('admin.downloadable_product') !!}</td>
                @else
                  <td>{!! trans('admin.customizable_product') !!}</td>
                @endif

                <td>{!! price_html( $row->price ) !!}</td>

                @if($row->status == 1)
                <td>{!! trans('admin.enable') !!}</td>
                @else
                <td>{!! trans('admin.disable') !!}</td>
                @endif
                
                <td>{!! get_vendor_name( $row->author_id ) !!}</td>
                
                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{!! trans('admin.action') !!}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a target="_blank" href="{{ route( 'details-page', $row->slug ) }}"><i class="fa fa-edit"></i>{!! trans('admin.view') !!}</a></li>
                      @if(in_array('add_edit_delete_product', $user_permission_list)) 
                        <li><a href="{{ route('admin.update_product_content', $row->slug) }}"><i class="fa fa-edit"></i>{!! trans('admin.edit') !!}</a></li>
                      @endif
                      @if(in_array('add_edit_delete_product', $user_permission_list)) 
                        <li><a class="remove-selected-data-from-list" data-track_name="product_list" data-id="{{ $row->id }}" href="#"><i class="fa fa-remove"></i>{!! trans('admin.delete') !!}</a></li>
                      @endif
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
              <th>{!! trans('admin.product_image') !!}</th>
              <th>{!! trans('admin.product_name') !!}</th>
              <th>{!! trans('admin.product_sku') !!}</th>
              <th>{!! trans('admin.product_type') !!}</th>
              <th>{!! trans('admin.product_price') !!}</th>
              <th>{!! trans('admin.product_status') !!}</th>
              <th>{!! trans('admin.vendor_name_label') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </tfoot>
        </table>
          <br>
        <div class="products-pagination">{!! $product_all_data->appends(Request::capture()->except('page'))->render() !!}</div>  
      </div>
    </div>
  </div>
</div>
@endsection