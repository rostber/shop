jQuery(function ($) {

	pyro.sortable = {

		init: function () {
			$('#filter-stage').find('tbody').livequery(function () {
				$(this).sortable({
					handle: 'span.sort',
					stop: function () {
						var $table_body = $('#filter-stage').find('tbody');
						$table_body.children('tr').removeClass('alt');
						$table_body.children('tr:nth-child(even)').addClass('alt');

						var order = [];

						$table_body.children('tr').find('.sort').each(function () {
							order.push([ $(this).attr("data-id"), $(this).attr("data-table") ]);
						});

						order = JSON.stringify(order);

						$.post(SITE_URL + '/shop/admin/sort', { order: order });
					}
				});
			});

		}
	};

	pyro.sortable.init();

});