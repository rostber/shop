
<ul class="shop-list">

<?php 
foreach ($groups as $group):
?>

	<li class="shop_list_item">
		<?php if (isset($group->file)): ?>		
			<?=anchor(site_url().'shop/goods/'.$group->id, '<img src="'.$upload_groups_dir.$group->id.'/'.$group->file.'" alt="" />', array('class'=>'shop-list__image', 'alt'=>$group->title))?>
		<?php endif; ?>
		<div class="shop-list__title">
			<?=anchor('shop/goods/'.$group->id, $group->title)?>
		</div>
	</li>

<?php endforeach; ?>

</ul>
