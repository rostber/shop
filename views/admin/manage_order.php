<section class="title">
	<h4><?=lang('shop.manage_order_label')?></h4>
</section>

<section class="item">
	<div class="content">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	
<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#content-tab-1"><span><?php echo lang('shop.tab_1'); ?></span></a></li>
		<li><a href="#content-tab-2"><span><?php echo lang('shop.tab_3'); ?></span></a></li>
	</ul>
	
	<div class="form_inputs" id="content-tab-1">
	
		<fieldset>

		<ul>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label>
					<?php echo lang('shop.user_label'); ?>
				</label>
				<div class="input">
					<?php if ($post->user_id): ?>
						<?=anchor('admin/users/edit/'.$post->user_id, $post->first_name.' '.$post->last_name.' ('.$post->display_name.')')?><br />
					<?php else: ?>
						<?=$post->name?><br />
					<?php endif; ?>
					<a href="mailto:<?=$post->email?>"><?=$post->email?></a><br />
					<?=$post->phone?><br />
					<?=$post->address?><br />
					<?=$post->text?>
				</div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label>
					<?php echo lang('shop.date_label'); ?>
				</label>
				<div class="input"><?=format_date($post->created_on)?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label>
					<?php echo lang('shop.payment_label'); ?>
				</label>
				<div class="input">
					<?=$post->payment?>
					<?php if ($post->blank): ?>
						<?=anchor('shop/show_blank/'.$post->id, '('.lang('shop.blank_label').')', array('target'=>'_blank'))?>
					<?php endif; ?>
				</div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label>
					<?php echo lang('shop.delavery_label'); ?>
				</label>
				<div class="input"><?=$post->delavery?></div>
			</li>
			
		</ul>
		
		</fieldset>
	
	</div>
	
	<div class="form_inputs" id="content-tab-2">
	
			<fieldset>
			
				<table id="items_list">
					<tr>
						<th width="50">Код товарва</th>
						<th>Наименование</th>
						<th>Цена</th>
						<th>Кол-во</th>
						<th width="10"></th>
					</tr>
				
<?php foreach($orders as $order): ?>

					<tr>
						<td><?=$order->code?></td>
						<td><?=$order->title?></td>
						<td><?=$order->price?></td>
						<td><?=form_input('item_num[]', $order->num, 'maxlength="11"')?></td>
						<td>
							<input type="hidden" name="item_id[]" value="<?=$order->id?>" />
							<span class="delete">&nbsp;</span>
						</td>
					</tr>

<?php endforeach; ?>

				</table>
				
				<ul>
				
					<li>
						<div class="input"><?=form_button('add', '+', 'id="add_item"')?></div>
					</li>

				</ul>
				
			</fieldset>
		
	</div>
	
</div>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
	</div>
		
	<?php echo form_close(); ?>

	</div>
</section>

<script type="text/javascript">

jQuery(function($) {

	addDelEvent();
	
	$("#add_item").click(function() { 
		$("#items_list").append( '<tr><td colspan="3"><select name="item_new_id[]"><?php foreach($items_options as $k=>$v) echo '<option value="'.$k.'">'.$v.'</option>'; ?></td><td><input type="text" name="item_new_num[]" value="1" maxlength="11" /></td><td><span class="delete">&nbsp;</span></td></tr>' );
		addDelEvent();
		//pyro.chosen();
		return false;
	});

});

function addDelEvent()
{
	$(".delete").click(function(event) {

		pyro.chosen();
	
		$(this).parent().parent().remove();
		event.preventDefault();
	});
}

</script>
