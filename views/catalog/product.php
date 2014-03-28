<div class="shop-detail">

	<h1><?=$item->title?></h1>

	<div class="shop-detail__image">
		<?php foreach ($item->photos as $k=>$v): ?>
			<?=anchor($upload_dir.$v->id.'/'.$v->file, '<img src="'.$upload_dir.$v->id.'/small'.$v->file.'" class="preview">', array('title'=>$item->title, 'rel'=>'photos', 'target'=>'_blank'))?>
		<?php endforeach; ?>
	</div>
	
	<div class="shop-detail__info">
	
		<span class="js-cart__add js-cart__add-<?=$item->id?>" data-id="<?=$item->id?>" data-price="<?=$item->price?>" data-title="<?=$item->title?>" data-num="1" data-code="<?=$item->code?>">Добавить в корзину</span>
		
		<p class="shop-detail__item">
			<b>Артикул:</b>
			<?=$item->code?>
		</p>
		<p class="shop-detail__item">
			<b>Статус:</b>
			<?=($item->availability) ? 'В наличии' : 'Под заказ' ?>
		</p>
		<p class="shop-detail__item">
			<b>Модель:</b>
			<?=$item->model?>
		</p>
		<p class="shop-detail__item">
			<b>Производитель:</b>
			<?=$item->manufacturer?>
		</p>
		<p class="shop-detail__item">
			<b>Страна:</b>
			<?=$item->country?>
		</p>
		<?php if (!empty ($item->depth)): ?>
			<p class="shop-detail__item">
				<b>Габариты:</b>
				<?=(1*$item->depth)?> x <?=(1*$item->width)?> x <?=(1*$item->height)?>&nbsp;см
			</p>
		<?php endif; ?>

	</div>
		
	<div class="shop-detail__text">
		<?=$item->text?>
	</div>
	
</div>
