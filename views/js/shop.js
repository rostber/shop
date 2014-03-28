window.shop||(window.shop={})

window.shop = {

	add_cart: function(id, num, code, title, price)
	{
		var self = this;
		var data = self.get_list();
		var date = new Date();
		date.setTime(date.getTime() + (60 * 60 * 1000));

		var find = false;
		var i = 0;
		for (var v in data)
		{
			if (id == data[v][0]) 
			{
				find = v;
				break;
			}
		}
		if (find === false) data[data.length] = new Array(id, num, code, title, price);
		else data[find][1] = data[find][1] + 1;

		if (data.length == 0) $.cookie("cart", null, { path: '/' });
		else $.cookie("cart", JSON.stringify(data), { expires: date, path: '/' });
	},

	cart_delete: function(id)
	{
		var self = this;
		var data = self.get_list();
		var date = new Date();
		date.setTime(date.getTime() + (60 * 60 * 1000));
		
		var key = self.find_key(data, id);
		
		if (confirm('Удалить из корзины "'+data[key][3]+'"?') == true)
		{
			data_new = new Array();
			var i = 0;
			for (var v in data)
			{
				if (key != v[0])
				{
					data_new[i] = data[v];
					i++;
				}
			}
			data = data_new;
			
			if (data.length == 0) $.cookie("cart", null, { path: '/' });
			else $.cookie("cart", JSON.stringify(data), { expires: date, path: '/' });
			
			return true;
		}
		
		return false;
	},

	find_key: function(data, id)
	{
		var find = false;
		for (var v in data)
		{
			if (id == data[v][0]) 
			{
				find = v;
				break;
			}
		}
		return find;
	},

	value_cart: function(id, num, obj)
	{
		var self = this;
		var date = new Date();
		date.setTime(date.getTime() + (60 * 60 * 1000));

		var data = self.get_list();
		
		var key = self.find_key(data, id)
		
		if (num > 0) data[key][1] = num;
		else 
		{
			if ( self.cart_delete(id) ) $(obj).parent().parent().remove();
			return false;
		}

		if (data.length == 0) $.cookie('cart', null, { path: '/' });
		else $.cookie("cart", JSON.stringify(data), { expires: date, path: '/' });
	},

	init: function()
	{
		var self = this;
		
		$(".js-cart__delete").click(function() {
			if ( self.cart_delete( $(this).attr("data-id") ) ) $(this).parents('tr').eq(0).remove();
			self.show_cart();
		});

		$(".js-cart__add").click(function() {
			self.add_cart($(this).data("id"), 1, $(this).data("code"), $(this).data("title"), $(this).data("price"));
			self.show_cart();
		});
		
		$(".js-cart__list-num").change(function() {
			self.value_cart($(this).data("id"), $(this).val(), this);
			self.show_cart();
		});
		
		self.show_cart()
	},

	get_list: function()
	{
		var str = $.cookie("cart");
		if (!str) return [];
		else
		{
			var data = eval(str);
			if (data && data.length != 0) return data;
			else return [];
		}
	},

	show_cart: function()
	{
		var self = this;
		var data = self.get_list();
		var summ = 0;
		var num = 0;
		for (var v in data)
		{
			summ_row = data[v][1]*data[v][4];
			summ = summ + summ_row;
			num = (1*num) + (1*data[v][1]);
			$('.js-cart__summ-' + data[v][0]).html( self.number_format( Math.floor(summ_row*100)/100, 2, '.', ' ' ) );
			$('.js-cart__add-' + data[v][0]).addClass('js-cart__add_state_added');
		}
		if (num)
		{
			$(".js-cart__show").show();
			$(".js-cart__hide").hide();
			$(".js-cart__summ").html( self.number_format( Math.floor(summ*100)/100, 2, '.', ' ' ) );
			$(".js-cart__num").html(num);
		}
		else
		{
			$(".js-cart__show").hide();
			$(".js-cart__hide").show();
		}
	},

	number_format: function ( number, decimals, dec_point, thousands_sep ) 
	{
		var i, j, kw, kd, km;

		if( isNaN(decimals = Math.abs(decimals)) ){
			decimals = 2;
		}
		if( dec_point == undefined ){
			dec_point = ",";
		}
		if( thousands_sep == undefined ){
			thousands_sep = ".";
		}

		i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

		if( (j = i.length) > 3 ){
			j = j % 3;
		} else{
			j = 0;
		}

		km = (j ? i.substr(0, j) + thousands_sep : "");
		kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
		kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

		return km + kw + kd;
	}

}

$(function() {
	window.shop.init();
});