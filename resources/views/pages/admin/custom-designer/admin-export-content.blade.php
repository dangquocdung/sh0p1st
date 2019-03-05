@extends('layouts.admin.master')
@section('title', trans('admin.page_title_design_export') .' < '. get_site_title())

@section('content')
<style type="text/css">
   @if(count($fonts_list) > 0)
    @foreach($fonts_list as $row)
    <?php $parse_ext = explode('.', $row['url']);?>
      @font-face {
        font-family: {!! $row['post_slug'] !!};
        src: url("{{ url('public').'/'. $row['url'] }}") format("{{ $parse_ext[1] }}");
        font-weight: normal;
        font-style: normal;
      }
    @endforeach
   @endif
</style>
<div class="export-container">
  <h4>{!! trans('admin.export_title_label') !!}</h4><hr>
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-10">
          <div class="export-designer-canvas-container">
            <canvas id="export_designer_canvas"></canvas>
          </div>
        </div>
        <div class="col-md-2">
          <div class="design-list">
            @if(!empty($design_data))
            <?php $count = 1;?>
            <ul>
              @foreach($design_data as $key => $design)
              <?php if($count == 1){?>
              <li class="selected-export-design-list" data-id="{{ $key }}">{!! trans('admin.only_design_label') !!} {!! $count !!}</li>
              <?php } else {?>
              <li data-id="{{ $key }}">{!! trans('admin.only_design_label') !!} {!! $count !!}</li>
              <?php }?>
              <?php $count ++;?>
              @endforeach
            </ul>  
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="form-horizontal">
    <div class="box box-solid">
      
       
          <div class="box-body">
            <h4>{!! trans('admin.export_option_label') !!}</h4><hr>
            <div class="form-group">
              <div class="row">  
                <label class="col-sm-4 control-label" for="output_type">{!! trans('admin.export_output_type_label') !!}</label>
                <div class="col-sm-8">
                  <input type="radio" class="output-type" name="output_type" id="output_type_image" checked="checked" value="image"> {!! trans('admin.export_output_type_image_label') !!} &nbsp;&nbsp;&nbsp;
                  <input type="radio" class="output-type" name="output_type" id="output_type_pdf" value="pdf"> {!! trans('admin.export_output_type_pdf_label') !!} &nbsp;&nbsp;&nbsp;
                  <input type="radio" class="output-type" name="output_type" id="output_type_svg" value="svg"> {!! trans('admin.export_output_type_svg_label') !!}
                </div>
              </div>  
            </div>
            <div class="form-group image-type">
              <div class="row">    
                <label class="col-sm-4 control-label" for="image_type">{!! trans('admin.image_type_label') !!}</label>
                <div class="col-sm-8">
                  <input type="radio" name="image_type" id="image_type_png" checked="checked" value="png"> {!! trans('admin.image_type_png_label') !!} &nbsp;&nbsp;&nbsp;
                  <input type="radio" name="image_type" id="image_type_jpg" value="jpeg"> {!! trans('admin.image_type_jpeg_label') !!}
                </div>
              </div>  
            </div>
            <div class="form-group custom-options">
              <div class="row">    
                <label class="col-sm-4 control-label" for="custom_option">{!! trans('admin.export_output_custom_option_label') !!}</label>
                <div class="col-sm-8">
                  <div><input type="number" id="custom_option_width" class="form-control" placeholder="{{ trans('admin.export_output_custom_option_width_label') }}" min="1"><i>{!! trans('admin.export_output_custom_option_width_label') !!}</i></div><br>
                  <div><input type="number" id="custom_option_height" class="form-control" placeholder="{{ trans('admin.export_output_custom_option_height_label') }}" min="1"><i>{!! trans('admin.export_output_custom_option_height_label') !!}</i></div><br>
                  <div><input type="number" id="custom_option_scale" class="form-control" placeholder="{{ trans('admin.export_output_custom_option_scale_label') }}" min="1" value="1"><i>{!! trans('admin.export_output_custom_option_scale_label') !!}</i></div><br>
                </div>
              </div>  
            </div>
            <div class="form-group">
              <div class="row">    
                <label class="col-sm-4 control-label" for="screen">{!! trans('admin.export_output_custom_option_screen_label') !!}</label>
                <div class="col-sm-8">
                  <input type="radio" name="screen_type" id="current_screen" checked="checked" value="current"> {!! trans('admin.export_output_custom_option_current_screen_label') !!} &nbsp;&nbsp;&nbsp;
                  <input type="radio" name="screen_type" id="all_screen" value="all"> {!! trans('admin.export_output_custom_option_all_screen_label') !!} &nbsp;&nbsp;&nbsp;
                </div>
              </div>  
            </div>
            <br>
            <div class="export-btn">
              <input type="button" class="btn btn-primary export-data" value="{{ trans('admin.only_export_label') }}" />
              <input type="button" class="btn btn-primary uploaded-files" value="{{ trans('admin.download_images_label') }}" />
            </div>
          </div>
        
      
    </div>
  </div>  
</div>
<input type="hidden" name="export_design_json_data" id="export_design_json_data" value="{{ json_encode($design_data) }}">
<input type="hidden" name="download_file_url" id="download_file_url" value="{{ route('force-designer') }}">
@endsection