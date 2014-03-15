<section class="title">
<?php if (count ($bk) == 0): ?>
	<h4><?=lang('shop.shop')?></h4>
<?php else: ?>
	<h4>
		<?=anchor('/admin/shop', lang('shop.shop'))?>
		<?php foreach ($bk as $v): ?>
		<span>&rarr;</span>
		<?=anchor('/admin/shop/group/'.$v->id, $v->title)?><?php endforeach; ?>
	</h4>
<?php endif; ?>
</section>

<section class="item">
	<div class="content">
	
	
	<? /* ?>
	<?php echo form_open('admin/shop/upload_url');?>
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="url">Адрес категории с сайта Практика</label>
				<div class="input"><?php echo form_input('url', '', 'maxlength="255" id="url"'); ?></div>
			</li>
			<input type="hidden" name="redirect" value="/admin/shop/group/<?=$current_group?>" />
			<input type="hidden" name="group_id" value="<?=$current_group?>" />
		</ul>
		<div class="buttons align-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save'))); ?>
		</div>
	<?php echo form_close(); ?>
	<hr />
	<? */ ?>
	
	

<?php if (!empty ($html)): ?>

<?php echo form_open('admin/shop/delete');?>

	<div id="filter-stage">

	<table border="0" cellspacing="0" cellpadding="0">
		<col width="10" />
		<col width="auto" />
		<col width="150" />
		<col width="110" />
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('shop.label'); ?></th>
				<th><?php echo lang('shop.label_data'); ?></th>
				<th><?php echo lang('shop.label_operations'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>

<?=$html?>
		
		</tbody>
	</table>
	
	</div>
	
	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
	</div>
	
<?php echo form_close(); ?>
	
<?php else: ?>
	
	<div class="blank-slate">
		<h2><?php echo lang('shop.no_shop_error'); ?></h2>
	</div>
	
<?php endif; ?>

	</div>
</section>