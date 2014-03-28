<?php if (isset ($data_group)): $item = $data_group; ?>
			<tr>
				<td><?php echo form_checkbox('action_group_to[]', $item->id); ?></td>
				<td><?php for($i = 0; $i < $level; $i++) echo '&mdash;&nbsp;'; ?><span class="folder"><?=anchor('/admin/shop/group/'.$item->id, $item->title)?></span></td>
				<td><?php echo format_date($item->updated_on); ?></td>
				<td style="text-align:right;">
					<span class="sort" data-id="<?=$item->id?>" data-table="shop_groups">&nbsp;</span>
					<?=anchor('admin/shop/published_group/'.$item->id, '&nbsp;', array('class'=>(($item->published) ? 'check' : 'not_check')))?>
					<?=anchor('admin/shop/manage_group/' 			. $item->id, '&nbsp;', array('class'=>'edit'))?>
					<?=anchor('admin/shop/delete_group/'		 	. $item->id, '&nbsp;', array('class'=>'delete confirm'))?>
				</td>
			</tr>
<?php endif; ?>