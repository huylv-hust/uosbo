var add_images = function(){
    var trigger_input_file = function(){
	$('button[name=image_add_btn]').off('click').on('click',function(){
            var bt_id = $(this).attr('id');
	    $('input[id="'+bt_id+'"]').trigger('click');
	});
    };
    var add_image = function(){
	$('.image').off('change').on('change', function(){
            var id = $(this).attr('id');
	    var attr_id = $(this).attr('attr_id');
	    //get file and pull attributes
	    var input = $(this)[0], i, type, file,
	    length = input.files.length;
            file = input.files[0];
            type = file.type;
            size = file.size;
            if (type === 'image/jpeg' || type === 'image/png' || type === 'image/gif'){
                //load file into preview pane
                if(size > 1024 * 1024 * 2)
                {
                    alert('画像のサイズ < 2 MB');
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
                        var html = '<img onclick="view_img(this)" src="'+ e.target.result +'" width="200" />'
                        + '<button type="button" class="btn btn-danger btn-sm remove-btn delete_image" id="'+attr_id+'">'
                        +   '<i class="glyphicon glyphicon-remove"></i>'
                        + '</button>'
                        + '<div><input type="hidden" value="'+result.replace(tmp,'')+'" name="content['+attr_id+']">'
                        + '<input type="hidden" value="'+attr_id+'" name="attr_id['+attr_id+']">'
                        + '</div>';
                        $('#image-'+attr_id).html(html);
                    };
                    $('#show_'+attr_id).removeClass('show');
                    $('#show_'+attr_id).hide();
                   // $('button#'+attr_id).attr('disabled','disabled');
                    $('#img-data'+attr_id).remove();

                };
                reader.readAsDataURL(file);

            }
            else
            {
                alert('画像を入力して下さい ！(.jpg .png .gif)')
            }
	});
    };

    //remove image
    var delete_image = function(){
	$(document).on('click', '.delete_image', function(){
            var attr_id = $(this).attr('id');
            $('#image-'+attr_id).html('');
            $('#show_'+attr_id).removeClass('hide');
            $('#show_'+attr_id).show();
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
