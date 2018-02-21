var add_images = function(){
    var trigger_input_file = function(){
	$('button[name=image_add_btn]').click(function(){
	    $('input[type=file]').trigger('click');
	});
    };
    var add_image = function(){
	$('.image').on('change', function(){
	    
	    //get file and pull attributes
	    var input = $(this)[0], i, type, file,
	    length = input.files.length;
	    for (i = 0; i < length; i++)
	    {
		file = input.files[i];
		type = file.type;
                size = file.size;
                
		if (type === 'image/jpeg' || type === 'image/png' || type === 'image/gif'){
		    //load file into preview pane
                    if(size > 204800)
                    {
                        alert('画像のサイズ < 200 kbs');
                        return ;
                    }
                    var reader = new FileReader();
                    reader.onload = function(e)
                    {
                        var image = new Image();
                        image.src = e.target.result ;
                        image.onload = function()
                        {
                            var tmp = 'data:'+type+';base64,';
                            var result = e.target.result;
                            var html =  '<div class = "image-box pull-left image_panel">'
                            + '<a href="#" target="_blank">'
                            + '<img src="'+ e.target.result +'" width="200" height="200"/>'
                            + '</a>'
                            + '<button type="button" class="btn btn-danger btn-sm remove-btn delete_image">'
                            +   '<i class="glyphicon glyphicon-remove"></i>'
                            + '</button>'
                            + '<p class="image-caption">'
                            +   '<input type="text" class="form-control" size="30" value="" name="alt[]" maxlength="30">'
                            + '</p>'
                            + '<input type="hidden" value="'+result.replace(tmp,'')+'" name="content[]">'
                            + '<input type="hidden" value="'+image.width+'" name="width[]">'
                            + '<input type="hidden" value="'+image.height+'" name="height[]">'
                            + '<input type="hidden" value="'+file.type+'" name="mine_type[]">'
                            + '<input type="hidden" value="" name="m_image_id[]">'
                            + '</div>';
                            $(html).appendTo($('.image').closest('tr').find('#image_append'));
                        };
                    };
                    reader.readAsDataURL(file);
                    
		} else 
		    alert('画像を入力して下さい ！(.jpg .png .gif)');
	    }
	});
    };
    
    //remove image
    var delete_image = function(){
	$(document).on('click', '.delete_image', function(){
	    $(this).closest('.image_panel').remove();
	});
    };
    return {
	init: function(){  
	    trigger_input_file();
	    add_image();
	    delete_image();
	}
    };
}();
$(function(){
    add_images.init();
});
