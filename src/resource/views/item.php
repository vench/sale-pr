<?php 

/* @var $item \sale\model\SaleItem */  
/* @var $tags \sale\model\SaleTags[] */  

 

\app\util\View::addStaticContent('script-head', 
        '<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="//yastatic.net/share2/share.js"></script> ');

$image = $item->getImage() ? $item->getImage() : 'http://bcost.ru/img/emptyimage.jpg';

self::renderPhp('header', [
    'active'    => 'item',
    'title'     => $item->getTitle() ,
    'obImage'   => $image, 
    'obUrl'     => 'http://bcost.ru/?a=site/detail&id=' . $item->getId(),
    'obTitle'   => $item->getTitle() . ' за ' . $item->getTitle()
]);



?>

<div class="jumbotron">
<h1><?php echo $item->getTitle();?></h1>

<p>Скидка <b><?php echo $item->getPriceDiff(); ?> %</b> дата обнаружения <?php echo $dateFormat($item->getDateInsert()); ?>, успейте купить!</p> 

		    <p>Было <?php echo $priceFormat( $item->getPriceOld()); ?> 
стало <?php echo $priceFormat($item->getPriceNew()); ?></p>
                    <p><img src="<?php echo $image; ?>" alt="<?php echo $item->getTitle(); ?>"/></p>
                 
                    <noindex>
		    <p><a class="" target="_blank" href="<?php echo $item->getLink();?>">На сайт <?php echo $item->getHost();?>&raquo;</a></p>
                    </noindex>
                    
                    <div>
                    Поделиться
                    <div class="ya-share2" data-services="collections,vkontakte,facebook,gplus,twitter,viber,skype" data-counter=""></div>
                    </div>
                    
                    <?php if(!empty($tags)):?>
                    <div>
                        <?php foreach ($tags as $tag): ?>
                    <a href="/?f[tag]=<?php echo $tag->getId(); ?>" class="label label-default"><?php echo $tag->getTitle(); ?></a>
                        
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
</div>
 

<?php self::renderPhp('footer'); ?>
