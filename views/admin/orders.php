<section class="title">
	<h4><?=lang('shop.orders_list_label')?></h4>
</section>

<section class="item">
	<div class="content">

<?php if (!empty ($items)): ?>

<?php echo form_open('admin/shop/delete_order');?>

	<div id="filter-stage">

	<table border="0" cellspacing="0" cellpadding="0">
		<col width="10" />
		<col width="10" />
		<col width="auto" />
		<col width="140" />
		<col width="60" />
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th>#</th>
				<th><?php echo lang('shop.label_user'); ?></th>
				<th><?php echo lang('shop.label_data_created'); ?></th>
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

<?php foreach($items as $item): ?>
			<tr>
				<td><?=form_checkbox('action_order_to[]', $item->id)?></td>
				<td><?=$item->id?></td>
				<td><span class="file"><?php if ($item->user_id): ?><?=$item->first_name.' '.$item->last_name.' ('.$item->display_name.')'?><?php else: ?><?=$item->name?><?php endif; ?></span></td>
				<td><?=format_date($item->created_on)?></td>
				<td>
					<?=anchor('admin/shop/manage_order/' 			. $item->id, '&nbsp;', array('class'=>'info'))?>
					<?=anchor('admin/shop/delete_order/'		 	. $item->id, '&nbsp;', array('class'=>'delete confirm'))?>
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