jQuery(function(){
    jQuery('#friends .person').click(function(){
        var id = $(this).data('id');
        location.href = "/account/view/"+id; 
    }); 
});