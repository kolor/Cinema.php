Dropzone.autoDiscover = false;

jQuery(function(){
    var dropzone = new Dropzone(".dropzone", { url: "/account/avatar"});
	Dropzone.options.avatarUpload = {
	    previewsContainer: null,
	    uploadMultiple: false,
	    previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-details"><img data-dz-thumbnail /></div></div>'
	}
	dropzone.on("thumbnail", function(fileInfo, dataUrl) {
        $('.dropzone').attr('src', dataUrl);
    });
});