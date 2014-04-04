
<ul>
	<?php foreach ($groups as $group): ?>

		<li class="<?=(($group_current_id == $group->id) ? ' current' : false)?>">
			<?=anchor('shop/goods/'.$group->id, $group->title)?>
			<?php if ($group->childs): ?>
				<?=$this->load->view('shop/catalog/sidebar', array('groups' => $group->childs, 'level' => $level+1))?>
			<?php endif; ?>
		</li>

	<?php 
	endforeach; 
	?>

</ul>
