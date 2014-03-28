jQuery(function ($) {

	pyro.published = {
		init: function () {
			$(".check, .not_check").click(function(event) {
				event.preventDefault();
				if ( $(this).hasClass("not_check") ) $(this).removeClass('not_check').addClass('check');
				else $(this).removeClass('check').addClass('not_check');
				$.ajax($(this).attr("href"), {});
			});
		}
	};
	
	pyro.image_delete = {
		init: function () {
			$(".delete").click(function(event) {
				event.preventDefault();
				$(this).parent().html('<input type="hidden" name="delete_image" value="'+$(this).attr("data-key")+'" />');
			});
		}
	};

	pyro.published.init();	
	pyro.image_delete.init();

});