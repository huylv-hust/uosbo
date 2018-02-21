var add_images = function(){
    var trigger_input_file = function(){
	$('button[name=image_add_btn]').off('click').click(function(){ 
            $(this).parent().find('input[type=file]').trigger('click');            
	});
    };
    var add_image = function(){
	$('.image').off('change').on('change', function(){
	    var order_id = $(this).attr('id');
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
                            var result = e.target.result;
                            var tmp = 'data:'+type+';base64,';
                            $.post(baseUrl+'ajax/common/upload_img',
                            {
                                'order_id': order_id,
                                'content_image':result.replace(tmp,''),
                                'width':image.width,
                                'height':image.height,
                                'mine_type':file.type
                            },
                            function(data)
                            {
                                if(data == 'failed'){
                                    window.location = baseUrl+'job/orders?lost=true';
                                    return false;
                                }
								if(return_url_search)
								{
									window.location.href = return_url_search;
									return false;
								}
                                window.location = baseUrl+'job/orders';
                            }
                            );
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
