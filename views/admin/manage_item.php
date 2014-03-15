<section class="title">
	<h4><?php if (!isset ($post->id)) echo lang('shop.create_label'); else echo lang('shop.manage_label'); ?></h4>
</section>

<section class="item">
	<div class="content">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
	<div class="tabs">

		<ul class="tab-menu">
			<li><a href="#content-tab-1"><span><?php echo lang('shop.tab_1'); ?></span></a></li>
			<li><a href="#content-tab-2"><span><?php echo lang('shop.tab_2'); ?></span></a></li>
		</ul>
		
		<div class="form_inputs" id="content-tab-1">
		
			<fieldset>

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
					<label for="show_home"><?php echo lang('shop.show_home_label'); ?></label>
					<?php echo form_checkbox('show_home', true, $post->show_home) ?>
				</li>
				
					
				
				<?php
				foreach($rows_trim as $v=>$required):
				?>
				
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="<?=$v?>">
						<?php echo lang('shop.'.$v.'_label'); ?>
						<?php if ($required): ?> <span>*</span><?php endif; ?>
					</label>
					<div class="input"><?php echo form_input($v, htmlspecialchars_decode($post->$v), 'maxlength="255" id="'.$v.'"'); ?></div>
				</li>
				
				<?php endforeach; ?>
				
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="title"><?php echo lang('shop.text_label'); ?></label>
					<div class="input"><?php echo form_textarea(array('id'=>'text', 'name'=>'text', 'value' => $post->text, 'rows' => 10, 'class' => 'wysiwyg-advanced')); ?></div>
				</li>
				
			</ul>
			
			</fieldset>
		
		</div>
		
		<div class="form_inputs" id="content-tab-2">
		
			<fieldset>
			
				<ul id="file_list">
				
<?php foreach($gallery as $gallery_item): ?>

					<li>
						<label><?php echo lang('shop.file'); ?></label>
						<div class="input">						
							<input type="hidden" name="file_id[<?=$gallery_item->id?>]" value="<?=$gallery_item->id?>" />
							<input type="file" name="file[<?=$gallery_item->id?>]" />
							<?='<a href="'.$upload_dir.$gallery_item->id.'/'.$gallery_item->file.'" target="_blank" class="modal"><img src="/addons/shared_addons/modules/shop/views/admin/img/image_preview.gif" alt="preview" /></a>'?>
							<span class="del_file"><img src="/addons/shared_addons/modules/shop/views/admin/img/image_delete.gif" alt="preview" /></span>
						</div>
					</li>

<?php endforeach; ?>

				</ul>
				
				<ul>
				
					<li>
						<div class="input"><?=form_button('add', '+', 'id="add_file"')?></div>
					</li>

				</ul>
				
				<ul id="new_photo" style="display: none;">
					<li>
						<label><?php echo lang('shop.file'); ?></label>
						<div class="input">
							<input type="hidden" name="file_id[]" value="" />
							<input type="file" name="file[]" />
							<span class="del_file"><img src="/addons/shared_addons/modules/shop/views/admin/img/image_delete.gif" alt="preview" /></span>
						</div>
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
	
	$("#add_file").click(function() { 
		$("#file_list").append( $("#new_photo").html() );
		addDelEvent();
		return false;
	});

});

function addDelEvent()
{
	$(".del_file").click(function(event) { 
		$(this).parents("li").eq(0).slideUp(250, function() {
			$(this).remove();
		})
	});
}

</script>
