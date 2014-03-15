<section class="title">
	<h4><?php if (!isset ($item->id)) echo lang('shop.create_group_label'); else echo lang('shop.manage_group_label'); ?></h4>
</section>

<section class="item">
	<div class="content">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	
	<div class="form_inputs" id="blog-content-tab">

		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="title"><?php echo lang('shop.label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="255" id="title"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="order"><?php echo lang('shop.order_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('order', htmlspecialchars_decode($post->order), 'maxlength="11" id="order"'); ?></div>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="published"><?php echo lang('shop.label_stat'); ?> <span>*</span></label>
				<div class="input"><?php echo form_dropdown('published', array('1'=>lang('shop.label_stat_on'), '0'=>lang('shop.label_stat_off')), $post->published) ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="parent_group_id"><?php echo lang('shop.label_parent_id'); ?></label>
				<div class="input"><?php echo form_dropdown('parent_group_id', $post->group_parents_id, $post->parent_group_id); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="title"><?php echo lang('shop.text_label'); ?></label>
				<div class="input"><?php echo form_textarea(array('id'=>'text', 'name'=>'text', 'value' => $post->text, 'rows' => 10, 'class' => 'wysiwyg-advanced')); ?></div>
			</li>
			
			<?php $id = $post->next_id; $input_file_name = 'file'; ?>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="<?=$input_file_name?>"><?php echo lang('shop.file_icon'); ?></label>
				<div class="input"><input type="file" name="<?=$input_file_name?>" id="<?=$input_file_name?>" />
					<?php if (!empty ($post->$input_file_name)): ?>
					<?=anchor($upload_groups_dir.$id.'/'.$post->$input_file_name, '<img src="/addons/shared_addons/modules/shop/views/admin/img/image_preview.gif" alt="preview" />', array('target'=>'_blank', 'class'=>'modal'))?>
					<span class="delete_image" data-key="<?=$input_file_name?>">&nbsp;</span>
				</div>
				<?php endif; ?>
			</li>
			
		</ul>
		
	<?php echo form_close(); ?>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
	</div>

	</div>
</section>
