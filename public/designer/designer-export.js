var designerExportCanvasObj;
var screenshot_ary = [];
var export_json_data;
var imageType = 'png';
var canvasWidth  = 0;
var canvasHeight = 0;
var customScale  = 1;
var screenshot_track = 'no';
var is_svg = 'no';

$(document).ready(function(){
  if($('#export_designer_canvas').length>0){
    designerExportCanvasObj = new fabric.Canvas('export_designer_canvas');

    if($('#export_design_json_data').length>0){
      export_design_json_data = JSON.parse( $('#export_design_json_data').val() );
    }

    //load first child design
    var get_first_child_id = $('.export-container .design-list ul li:first').data('id');
    loadDesignFromJson( get_first_child_id );

    exportDesignerList();
    exportData();
    outputTypeEvent();
    uploadedImagesDownload();
  }
});


var exportDesignerList = function(){
  if($('.export-container .design-list ul li').length>0){
    $('.export-container .design-list ul li').on('click', function(){
      $(this).parents('.design-list').find('.selected-export-design-list').removeClass('selected-export-design-list');
      $(this).addClass('selected-export-design-list');
      
      var get_selected_design_id = $(this).data('id');
      loadDesignFromJson( get_selected_design_id );
    });
  }
}

var loadDesignFromJson = function( design_id ){
  var selected_json_data = null;
  
  designerExportCanvasObj.clear();
  designerExportCanvasObj.renderAll();

  designerExportCanvasObj.setBackgroundImage('', designerExportCanvasObj.renderAll.bind(designerExportCanvasObj), {});
  designerExportCanvasObj.setOverlayImage('', designerExportCanvasObj.renderAll.bind(designerExportCanvasObj), {});
  
  $.each(export_design_json_data, function(key, val) { 
    if(key === design_id){
      selected_json_data = val.customdata;
      return false;
    }
  });
  
  if(selected_json_data){
    var parseJson = JSON.parse(selected_json_data);
   
    setExportCanvasDimension(parseJson.backgroundImage.width, parseJson.backgroundImage.height, function(status){
      if(status == 'done'){
        $('#custom_option_width').val( parseInt(parseJson.backgroundImage.width) + 100 );
        $('#custom_option_height').val( parseInt(parseJson.backgroundImage.height) + 100 );
        canvasWidth = parseInt(parseJson.backgroundImage.width) + 100;
        canvasHeight = parseInt(parseJson.backgroundImage.height) + 100;
        
        designerExportCanvasObj.loadFromJSON(selected_json_data, function (){
          var objLen = designerExportCanvasObj.getObjects().length;

          var renderIfAll = function (){
            if (--objLen == 0){
              designerExportCanvasObj.renderAll();
            }
          };

          designerExportCanvasObj.forEachObject(function(obj){
            if (obj.type === 'image' && obj.filters.length){
              obj.applyFilters(renderIfAll);
            }

            obj.selectable = false;
          });
          
          if(screenshot_track == 'yes'){
            screenshot_ary.push( createImageBlob(designerExportCanvasObj.toDataURL({ format: imageType, width: canvasWidth, height: canvasHeight, multiplier: customScale }), imageType) );
          }
          
          if(is_svg == 'yes'){
            screenshot_ary.push( Base64.encode(designerExportCanvasObj.toSVG()) );
          }
        }); 
      }
    });
  }
}

var exportData = function(){
  if($('.export-data').length>0){
    $('.export-data').on('click', function(){
      var obj = $(this);
      obj.css({'pointer-events': 'none' });
      
      var dataObj = {};
     
      dataObj.outputType =   jQuery("input[name='output_type']:checked").val();
      dataObj.imageType =    jQuery("input[name='image_type']:checked").val();
      dataObj.customWidth =  jQuery("#custom_option_width").val();
      dataObj.customHeight = jQuery("#custom_option_height").val();
      dataObj.customScale =  jQuery("#custom_option_scale").val();
      dataObj.customDpi =    jQuery("#custom_option_dpi").val();
      dataObj.screen =       jQuery("input[name='screen_type']:checked").val();
      
      if(dataObj.imageType){
        imageType = dataObj.imageType;
      }
      
      if(dataObj.customWidth){
        canvasWidth = dataObj.customWidth;
      }
      else{
        canvasWidth = designerExportCanvasObj.getWidth();
      }
      
      if(dataObj.customHeight){
        canvasHeight = dataObj.customHeight;
      }
      else{
        canvasHeight = designerExportCanvasObj.getHeight();
      }
      
      if(dataObj.customScale){
        customScale = dataObj.customScale;
      }
      
      if(dataObj.outputType == 'image' || dataObj.outputType == 'pdf'){
        screenshot_track = 'yes';
      }
      else if(dataObj.outputType == 'svg'){
        is_svg = 'yes';
      }
      
      if(dataObj.screen == 'current' && (dataObj.outputType == 'image' || dataObj.outputType == 'pdf')){
        screenshot_ary.push( createImageBlob(designerExportCanvasObj.toDataURL({ format: dataObj.imageType, width: canvasWidth, height: canvasHeight, multiplier: customScale }), dataObj.imageType) );
      }
      else if(dataObj.screen == 'all' && (dataObj.outputType == 'image' || dataObj.outputType == 'pdf' || dataObj.outputType == 'svg')){
        var count = $('.export-container .design-list ul li').length;
        var time = 1000;
        
        $('.export-container .design-list ul li').each(function(){
          var get_design_id = $(this).data('id');
          
          setTimeout(function(){ loadDesignFromJson( get_design_id ); }, time);
          time += 1000;
        })
      }
      else if(dataObj.screen == 'current' && dataObj.outputType == 'svg'){
        screenshot_ary.push( Base64.encode(designerExportCanvasObj.toSVG()) );
      }
      
      setTimeout(function(){  
        var formdata = new FormData();
        var i = 1;

        if(screenshot_ary.length > 0){
          for(var j = 0; j< screenshot_ary.length; j++){
            formdata.append('design_data_' + i, screenshot_ary[j]);
            i++;
          }
        }

        formdata.append('output_type', dataObj.outputType);
        formdata.append('image_type', dataObj.imageType);
        
        screenshot_track = 'no';
        screenshot_ary.length = 0; 
        is_svg = 'no';

        var xhrForm = new XMLHttpRequest();
        xhrForm.open("POST", $('#hf_base_url').val() + "/ajax/manage_designer_export_data");
        xhrForm.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        xhrForm.send(formdata);

        xhrForm.onreadystatechange = function () {
          if (xhrForm.readyState === 4 && xhrForm.status == 200) {
            var parseResponse = $.parseJSON(xhrForm.responseText);
            if(parseResponse.status == 'success'){
              window.open($('#download_file_url').val(), 'file_download', "height=700, width=900");
              obj.css({'pointer-events': '' });
            }
          }
        };
      }, (parseInt(count) * parseInt(1000)) + parseInt(800));
    });
  }
}

var createImageBlob = function( canvastoDataURL, image_type ){
  var blobBin = atob(canvastoDataURL.split(',')[1]);
  var array = [];
  for(var i = 0; i < blobBin.length; i++) {
      array.push(blobBin.charCodeAt(i));
  }
  var file = new Blob([new Uint8Array(array)], {type: 'image/' + image_type});

  return file;
}

var setExportCanvasDimension = function(width, height, callback){
  designerExportCanvasObj.setWidth( parseInt(width) + parseInt(100) );
  designerExportCanvasObj.setHeight( parseInt(height) + parseInt(100) );
  designerExportCanvasObj.renderAll();

  callback('done');
}

var outputTypeEvent = function(){
  if($('.output-type').length>0){
    $('.output-type').on('click', function(){
      if($(this).val() == 'svg'){
        $('.image-type, .custom-options').hide();
      }
      else{
        $('.image-type, .custom-options').show();
      }
    });
  }
}

var uploadedImagesDownload = function(){
  if($('.uploaded-files').length>0){
    $('.uploaded-files').on('click', function(){ 
      var obj = $(this);
      obj.css({'pointer-events': 'none' });
      
      if($('#export_design_json_data').val()){
        var formdata = new FormData();
        formdata.append('design_json', $('#export_design_json_data').val());
         
        var xhrForm = new XMLHttpRequest();
        xhrForm.open("POST", $('#hf_base_url').val() + "/ajax/uploaded_images_download");
        xhrForm.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        xhrForm.send(formdata);

        xhrForm.onreadystatechange = function () {
          if (xhrForm.readyState === 4 && xhrForm.status == 200) {
            var parseResponse = $.parseJSON(xhrForm.responseText);
            
            if(parseResponse.status == 'success'){
              window.open($('#download_file_url').val(), 'file_download', "height=700, width=900");
              obj.css({'pointer-events': '' });
            }
            else if(parseResponse.status == 'error'){
              alert('Uploaded data not available!');
            }
            
            obj.css({'pointer-events': '' });
          }
        };
      }
    });
  }
}