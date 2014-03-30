<?php if (!empty($group_current)): ?>
	
	<div class="shop-group">
		
		<h1><?=$group_current->title?></h1>
	
		<?php if (!empty($group_current->file)):?>
			<img src="<?=$upload_groups_dir.$group_current->id.'/'.$group_current->file?>" alt="" class="shop-group__image" />
		<?php endif; ?>
		
		<div class="shop-group__text">
			<?=$group_current->text?>
		</div>
	
	</div>

<?php else: ?>

	<h1><?=lang('shop.h1')?></h1>

<?php endif; ?>

<?php if (!empty($groups)) $this->load->view('shop/catalog/taxons_list', array('groups' => $groups, 'upload_group_dir' => $upload_dir)); ?>

<?php if (!empty($items)) $this->load->view('shop/catalog/goods_list', array('items' => $items, 'upload_dir' => $upload_dir)); ?>
