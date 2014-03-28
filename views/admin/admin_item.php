<?php if (isset ($data_item)): $item = $data_item; ?>
			<tr>
				<td><?php echo form_checkbox('action_to[]', $item->group_item_id); ?></td>
				<td><?php for($i = 0; $i < $level; $i++) echo '&mdash;&nbsp;'; ?><span class="file"><?=anchor('admin/shop/manage_item/'.$item->id, $item->title.'&nbsp;-&nbsp;'.$item->code)?></span></td>
				<td><?php echo format_date($item->updated_on); ?></td>
				<td style="text-align:right;">
					<span class="sort" data-id="<?=$item->group_item_id?>" data-table="shop_group_items">&nbsp;</span>
					<?=anchor('admin/shop/manage_group_item/' 			. $item->group_item_id, '&nbsp;', array('class'=>'edit'))?>
					<?=anchor('admin/shop/delete/'		 	. $item->group_item_id, '&nbsp;', array('class'=>'delete confirm'))?>
				</td>
			</tr>
<?php endif; ?>