<section class="title">
	<h4><?php if (!isset ($item->id)) echo lang('shop.create_gi_label'); else echo lang('shop.manage_gi_label'); ?></h4>
</section>

<section class="item">
	<div class="content">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	
	<div class="form_inputs" id="blog-content-tab">

		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="group_id"><?php echo lang('shop.label_parent_id'); ?></label>
				<div class="input"><?php echo form_dropdown('group_id', $post->group_parents_id, $post->group_id); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="item_id"><?php echo lang('shop.label_item_id'); ?></label>
				<div class="input"><?php echo form_dropdown('item_id', $items_id, $post->item_id); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="order"><?php echo lang('shop.order_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('order', htmlspecialchars_decode($post->order), 'maxlength="11" id="order"'); ?></div>
			</li>
			
		</ul>
		
	<?php echo form_close(); ?>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
	</div>

	</div>
</section>
