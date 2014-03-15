
<ul>

<?php 
foreach ($groups as $group):
?>

	<li>
		<?=anchor('shop/goods/'.$group->id, $group->title)?>
	</li>

<?php endforeach; ?>

</ul>
