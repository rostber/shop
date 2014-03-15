<section class="title">
	<h4><?=lang('shop.items_lonely_list_label')?></h4>
</section>

<section class="item">
	<div class="content">

<?php if ($items): ?>

<?php echo form_open('admin/shop/delete');?>

	<div id="filter-stage">

	<table border="0" cellspacing="0" cellpadding="0">
		<col width="10" />
		<col width="70" />
		<col width="auto" />
		<col width="150" />
		<col width="240" />
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('shop.label_code'); ?></th>
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

		<?php foreach ($items as $item): ?>
		
				<tr>
					<td><?php echo form_checkbox('action_item_to[]', $item->id); ?></td>
					<td><?=$item->code?></td>
					<td><span class="file"><?=$item->title?></span></td>
					<td><?php echo format_date($item->updated_on); ?></td>
					<td>
						<?=anchor('admin/shop/create_group_item?item_id='.$item->id, '<span>Добавить в таксон</span>', array('class'=>'btn gray'))?>
						<?=anchor('admin/shop/published/'.$item->id, '&nbsp;', array('class'=>(($item->published) ? 'check' : 'not_check')))?>
						<?=anchor('admin/shop/manage_item/' 			. $item->id, '&nbsp;', array('class'=>'edit'))?>
						<?=anchor('admin/shop/delete_item/'		 	. $item->id, '&nbsp;', array('class'=>'delete confirm'))?>
					</td>
				</tr>
			
			<?php endforeach; ?>
		
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