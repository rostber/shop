<?php if (!empty($groups)): ?>

	<ul class="shop-list">

		<?php 
		foreach ($groups as $group):
		?>

			<li class="shop-list__item">
				<?php if (isset($group->photo->id)): ?>
					<?=anchor('shop/goods/'.$group->id, '<img src="'.$upload_group_dir.$group->photo->id.'/small'.$group->photo->file.'" alt="" />', array('class'=>'goods-list__img', 'alt'=>$group->title))?>
				<?php endif; ?>
				<div class="shop-list__info">
					<div class="shop-list__title">
						<?=anchor('shop/goods/'.$group->id, $group->title)?>
					</div>
					<div class="shop-list__text">
						<?php 
						$text = mb_substr($group->text, 0, 100, 'utf-8');
						echo $text;
						echo (strlen($text) > 100) ? '...' : false;
						?>
					</div>
				</div>
			</li>

		<?php endforeach; ?>

	</ul>

<?php endif; ?>
