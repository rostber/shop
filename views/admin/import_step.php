<section class="title">
	<h4><?=lang('shop.import_step_label').($step+1)?></h4>
</section>

<section class="item">
	<div class="content">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	
	<div class="form_inputs" id="blog-content-tab">

		<div class="buttons float-right padding-top">
			<button class="btn blue" value="save" name="btnAction" type="submit">
				<span><?=lang('shop.next_label')?></span>
			</button>
		</div>

	</div>
	
	<?php echo form_close(); ?>
</section>
