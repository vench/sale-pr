<?php
/* @var $item \sale\model\SaleItem */
/* @var $tags \sale\model\SaleTags[] */
/* @var  $description string */
/* @var $relatedItems \sale\model\SaleItem[]  */ 



\app\util\View::addStaticContent('script-head', '<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="//yastatic.net/share2/share.js"></script> ');

$image = $item->getImage() ? $item->getImage() : 'http://bcost.ru/img/emptyimage.jpg';
$titlePrice = $item->getTitle() . ' за ' . $priceFormat($item->getPriceNew());
self::renderPhp('header', [
    'active' => 'item',
    'title' => $titlePrice,
    'obImage' => $image,
    'obUrl' => 'http://bcost.ru/?a=site/detail&id=' . $item->getId(),
    'obTitle' => $titlePrice,
]);
?>

<div class="jumbotron">
    <h1><?php echo $item->getTitle(); ?></h1>

    <p>Скидка <b><?php echo $item->getPriceDiff(); ?> %</b> дата обнаружения <?php echo $dateFormat($item->getDateInsert()); ?>, успейте купить!</p> 

    <p>Было <span class="price-old"><?php echo $priceFormat($item->getPriceOld()); ?> </span>
        стало <span class="price-new"><?php echo $priceFormat($item->getPriceNew()); ?></span>
    </p>
    <noindex>
        <p><img src="<?php echo $image; ?>" alt="<?php echo $item->getTitle(); ?>"/></p>
    </noindex>
    <noindex>
        <p><a class="" target="_blank" href="<?php echo $item->getLink(); ?>">На сайт <?php echo $item->getHost(); ?>&raquo;</a></p>
    </noindex>

    <div>
        Поделиться
        <div class="ya-share2" data-services="collections,vkontakte,facebook,gplus,twitter,viber,skype" data-counter=""></div>
    </div>

    <?php if (!empty($description)): ?>
        <div class="text-left clearfix"><br/><?php echo $description; ?></div>
    <?php endif; ?>

    <?php if (!empty($tags)): ?>
        <div>
            <?php foreach ($tags as $tag): ?>
                <a href="/?f[tag]=<?php echo $tag->getId(); ?>" class="label label-default"><?php echo $tag->getTitle(); ?></a>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

        
        
    
        
</div>

  <?php if(!empty($relatedItems)):?>
<div class="sidebar-module-inset">
        <h3>Похожие товары</h3>
        <div class="row " >
        <?php foreach ($relatedItems as $relatedItem): ?>
         <div  class="col-xs-6 col-lg-3 item">
             <p><a class="" href="/?a=site/detail&id=<?php echo $relatedItem->getId(); ?>" title="Детально: <?php echo $relatedItem->getTitle(); ?>">
                 <?php echo $relatedItem->getTitle(); ?></a> <b> скидка <?php echo $relatedItem->getPriceDiff(); ?> %</b> <small><?php echo $dateFormat($relatedItem->getDateInsert(), 'd.m.Y'); ?></small></p> 

		    <p><small>Было  <span class="price-old"><?php echo $priceFormat( $relatedItem->getPriceOld()); ?></span>
                        </small> 
                        стало <span class="price-new"><?php echo $priceFormat($relatedItem->getPriceNew()); ?> </span> 
                    </p>
                    <?php $url = !is_null($relatedItem->getImage()) ? $relatedItem->getImage() : '/img/emptyimage.jpg'; ?>
                    <p>
                        <a class="" href="/?a=site/detail&id=<?php echo $relatedItem->getId(); ?>" title="Детально: <?php echo $relatedItem->getTitle(); ?>">
                             <noindex>
                            <img src="<?php echo $url;?>" alt="<?php echo $relatedItem->getTitle(); ?>"/>
                             </noindex>
                        </a>
                        </p>
                      
                    <noindex>
                    <p><a target="_blank" class="" href="<?php echo $item->getLink();?>">На сайт <?php echo $item->getHost();?>&raquo;</a></p>
                    </noindex>
         </div>
        
        <?php endforeach; ?>
           </div>
    </div>    
     <?php endif; ?> 


<?php self::renderPhp('footer'); ?>
