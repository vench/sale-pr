<?php /* @var $item \sale\model\SaleItem */ ?> 

<?php
self::renderPhp('header', [
    'active' => 'home',
    'title'     => $item->getTitle() . ' Список самых лучших предложений онлайн-магазинов рунета',
]);
?>

<div class="jumbotron">
<h1><?php echo $item->getTitle();?></h1>

<p>Скидка <b><?php echo $item->getPriceDiff(); ?> %</b> дата обнаружения <?php echo $dateFormat($item->getDateInsert()); ?></p> 

		    <p>Было <?php echo $priceFormat( $item->getPriceOld()); ?> 
стало <?php echo $priceFormat($item->getPriceNew()); ?></p>
                    <p><img src="/img/emptyimage.jpg" alt="<?php echo $item->getTitle(); ?>"/></p>
                 
		    <p><a class="" href="<?php echo $item->getLink();?>">На сайт <?php echo $item->getHost();?>&raquo;</a></p>
</div>
 

<?php self::renderPhp('footer'); ?>
