@extends('layouts.admin.master')
@section('title', trans('admin.update_post_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.update_post_page_title') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-sm" href="{{ route('admin.testimonial_post_list_content') }}">{{ trans('admin.posts_list') }}</a>&nbsp;&nbsp;<a class="btn btn-default btn-sm" href="{{ route('admin.testimonial_post_content') }}">{{ trans('admin.add_new_post_top_title') }}</a>&nbsp;&nbsp;<a class="btn btn-default btn-sm" target="_blank" href="{{ route('testimonial-single-page', $testimonial_update_data['post_slug']) }}">{{ trans('admin.view') }}</a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary btn-block btn-sm" type="submit">{{ trans('admin.update') }}</button>
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
          <input type="text" placeholder="{{ trans('admin.post_title_placeholder') }}" class="form-control" name="testimonial_post_title" id="testimonial_post_title" value="{{ $testimonial_update_data['post_title'] }}">
        </div>
      </div>
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{{ trans('admin.post_description') }}</h3>
        </div>
        <div class="box-body">
            <textarea id="testimonial_description_editor" name="testimonial_description_editor" class="dynamic-editor" placeholder="{{ trans('admin.post_description_placeholder') }}">{!! $testimonial_update_data['post_content'] !!}</textarea>
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-upload"></i>
          <h3 class="box-title">{{ trans('admin.featured_image') }}</h3>
          <div class="box-tools pull-right">
            <div data-toggle="modal" data-dropzone_id="testimonial_dropzone_file_uploader" data-target="#testimonialUploader" class="icon product-uploader">{{ trans('admin.upload_image') }}</div>
          </div>
        </div>
        <div class="box-body testimonial-content">
          <div class="uploaded-testimonial-image">
            @if($testimonial_update_data['testimonial_image_url'])
            <div class="testimonial-sample-img" style="display: none;"><img class="upload-icon img-responsive" src="{{ default_upload_sample_img_src() }}"></div>
            <div class="testimonial-uploaded-image" style="display:block;"><img class="img-responsive" src="{{ get_image_url($testimonial_update_data['testimonial_image_url']) }}"><div class="remove-img-link"><button type="button" data-target="testimonial_image" class="btn btn-default attachtopost">{{ trans('admin.remove_image') }}</button></div></div>
            @else
              <div class="testimonial-sample-img" style="display:block;"><img class="upload-icon img-responsive" src="{{ default_upload_sample_img_src() }}"></div>
              <div class="testimonial-uploaded-image" style="display: none;"><img class="img-responsive"><div class="remove-img-link"><button type="button" data-target="testimonial_image" class="btn btn-default attachtopost">{{ trans('admin.remove_image') }}</button></div></div>
            @endif
          </div>
            
          <div class="modal fade" id="testimonialUploader" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <p class="no-margin">{!! trans('admin.you_can_upload_1_image') !!}</p>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>    
                <div class="modal-body">             
                  <div class="uploadform dropzone no-margin dz-clickable testimonial_dropzone_file_upload" id="testimonial_dropzone_file_upload" name="testimonial_dropzone_file_upload">
                    <div class="dz-default dz-message">
                      <span>{{ trans('admin.drop_your_cover_picture_here') }}</span>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{{ trans('admin.close') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{{ trans('admin.testimonial_more_details_title') }}</h3>
        </div>
        
        <div class="box-body">
          <div class="form-group">
            <div class="row">
              <label class="col-sm-3 control-label" for="inputClientName">{{ trans('admin.testimonial_client_name_title') }}</label>
              <div class="col-sm-9">
                <input type="text" placeholder="{{ trans('admin.testimonial_client_name_placeholder') }}" class="form-control" name="testimonial_client_name" id="testimonial_client_name" value="{{ $testimonial_update_data['testimonial_client_name'] }}">
              </div>
            </div>    
          </div>
          
          <div class="form-group">
            <div class="row">
              <label class="col-sm-3 control-label" for="inputJobTitle">{{ trans('admin.testimonial_job_title') }}</label>
              <div class="col-sm-9">
                <input type="text" placeholder="{{ trans('admin.testimonial_job_title_placeholder') }}" class="form-control" name="testimonial_job_title" id="testimonial_job_title" value="{{ $testimonial_update_data['testimonial_job_title'] }}">
              </div>
            </div>  
          </div>
          
          <div class="form-group">
            <div class="row">  
              <label class="col-sm-3 control-label" for="inputCompanyName">{{ trans('admin.testimonial_company_name_title') }}</label>
              <div class="col-sm-9">
                <input type="text" placeholder="{{ trans('admin.testimonial_company_name_placeholder') }}" class="form-control" name="testimonial_company_name" id="testimonial_company_name" value="{{ $testimonial_update_data['testimonial_company_name'] }}">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <div class="row">  
              <label class="col-sm-3 control-label" for="inputUrl">{{ trans('admin.testimonial_url') }}</label>
              <div class="col-sm-9">
                <input type="text" placeholder="{{ trans('admin.testimonial_url_placeholder') }}" class="form-control" name="testimonial_url" id="testimonial_url" value="{{ $testimonial_update_data['testimonial_url'] }}">
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
                <select class="form-control select2" name="testimonial_post_visibility" style="width: 100%;">
                  @if($testimonial_update_data['post_status'] == 1)
                  <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
                  @else
                  <option value="1">{{ trans('admin.enable') }}</option>
                  @endif

                  @if($testimonial_update_data['post_status'] == 0)
                  <option selected="selected" value="0">{{ trans('admin.disable') }}</option>          
                  @else
                  <option value="0">{{ trans('admin.disable') }}</option>
                  @endif      
                </select>       
              </div>
            </div>  
          </div>
        </div>
      </div> 
    </div>  
  </div>
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="update">
  <input type="hidden" name="image_url" id="image_url" value="{{ $testimonial_update_data['testimonial_image_url'] }}">
</form>

@endsection