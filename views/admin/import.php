<section class="title">
	<h4><?=lang('shop.import_label')?></h4>
</section>

<section class="item">
	<div class="content">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	
	<div class="form_inputs" id="blog-content-tab">

		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="course"><?php echo lang('shop.course_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('course', $course, 'maxlength="11" id="course"'); ?></div>
			</li>
			<?php $input_file_name = 'file_xls'; ?>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="<?=$input_file_name?>"><?php echo lang('shop.file_import'); ?></label>
				<div class="input">
					<input type="file" name="<?=$input_file_name?>" id="<?=$input_file_name?>" />
				</div>
			</li>
			
		</ul>
		
	<?php echo form_close(); ?>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
	</div>

	</div>
</section>
