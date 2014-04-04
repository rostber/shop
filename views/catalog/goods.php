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

<?php include('taxons_list'); ?>

<?php include('goods_list'); ?>
