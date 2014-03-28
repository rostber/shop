
<ul>

	<?php foreach ($groups as $group): ?>

		<li>
			<?=anchor('shop/goods/'.$group->id, $group->title, array('class' => ($group_current_id == $group->id) ? 'current' : false))?>
			<?php if ($group->childs): ?>
				<?=$this->load->view('shop/catalog/navi', array('groups' => $group->childs))?>
			<?php endif; ?>
		</li>

	<?php endforeach; ?>

</ul>
