<?php 

/* @var $item \sale\model\SaleItem */  
/* @var $tags \sale\model\SaleTags[] */  


$image = $item->getImage() ? $item->getImage() : '/img/emptyimage.jpg';

self::renderPhp('header', [
    'active' => 'item',
    'title'     => $item->getTitle() ,
]);



?>

<div class="jumbotron">
<h1><?php echo $item->getTitle();?></h1>

<p>Скидка <b><?php echo $item->getPriceDiff(); ?> %</b> дата обнаружения <?php echo $dateFormat($item->getDateInsert()); ?></p> 

		    <p>Было <?php echo $priceFormat( $item->getPriceOld()); ?> 
стало <?php echo $priceFormat($item->getPriceNew()); ?></p>
                    <p><img src="<?php echo $image; ?>" alt="<?php echo $item->getTitle(); ?>"/></p>
                 
                    <noindex>
		    <p><a class="" target="_blank" href="<?php echo $item->getLink();?>">На сайт <?php echo $item->getHost();?>&raquo;</a></p>
                    </noindex>
                    
                    
                    <?php if(!empty($tags)):?>
                        <?php foreach ($tags as $tag): ?>
                    <a href="/?f[tag]=<?php echo $tag->getId(); ?>" class="label label-default"><?php echo $tag->getTitle(); ?></a>
                        
                        <?php endforeach; ?>
                    <?php endif; ?>
</div>
 

<?php self::renderPhp('footer'); ?>
