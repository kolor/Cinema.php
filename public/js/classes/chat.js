var Chat = {
	current: 0,
	box: null,

	init: function()
	{
		$('#inbox .friends .person').click(Chat.load);
		$('#inbox .chat textarea').keyup(function(e){
			
			if (e.which == 13 && e.shiftKey === false) {
				var str = $(this).val().trim();
				if (str !== "" && Chat.current !== 0) {
					console.log(Chat.box.data('last'));
					console.log(Chat.box.attr('last'));
					Chat.send(str, Chat.current, Chat.box.data('last'));	
				}
				$(this).val('');
				return false;
			}
		});
		Chat.box = $('#inbox .chat .messages');
	},

	load: function()
	{
		Chat.box.empty();
		var id = $(this).data('id');
		$('#inbox .friends .person.active').removeClass('active');
		$(this).addClass('active');
		Chat.current = id;
		Chat.box.data('with', id);
		// show spinning stuff
		$.get('/account/message/'+id+'/last', Chat.append);
	},

	append: function(json)
	{
		Chat.box.data('last', parseFloat(json.last));
		for(var i in json.data) {
			var o = json.data[i];
			$('<div/>').addClass(o.class).text(o.message).prependTo(Chat.box);
		}
	},

	send: function(txt, to, last) 
	{
		$.post('/account/message', {txt:txt, to:to, last:last}, Chat.append);
	}


}