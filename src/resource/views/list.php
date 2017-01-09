<?php /* @var $list \sale\model\SaleItem[] */ ?>
<?php /* @var $size int */ ?>
<?php /* @var $q \sale\dao\QuerySaleItem */ ?>
<?php /* @var $tag \sale\model\SaleTag */ ?> 
<?php /* @var $tags \sale\model\SaleTag[] */ ?> 
 

<?php

self::renderPhp('header', [
    'active'    => 'home',
    'title'     => !is_null($tag) ? 
        $tag->getTitle() . ' | Список самых лучших предложений онлайн-магазинов рунета'
        :
        'Список самых лучших предложений онлайн-магазинов рунета',
]);
?>

 

 <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          
	<h1>Охота за самыми лучшими предложениями интернета
            <?php if(!is_null($tag)):?>
            <small>Тэг: <?php echo $tag->getTitle(); ?></small>
            <?php endif; ?>
        </h1>
          <p>Всего: <?php echo $size; ?></p>
          <div class="row">
		<?php $n = 0;?>
            <?php foreach ($list as  $item): ?>
                <div class="col-xs-6 col-lg-4 item list"> 
                    <p><a class="" href="/?a=site/detail&id=<?php echo $item->getId(); ?>" title="Детально: <?php echo $item->getTitle(); ?>"><?php echo $item->getTitle(); ?></a> <b> скидка <?php echo $item->getPriceDiff(); ?> %</b> <small><?php echo $dateFormat($item->getDateInsert(), 'd.m.Y'); ?></small></p> 

		    <p><small>Было <?php echo $priceFormat( $item->getPriceOld()); ?></small> 
                        стало <strong><?php echo $priceFormat($item->getPriceNew()); ?></strong></p>
                    <?php $url = !is_null($item->getImage()) ? $item->getImage() : '/img/emptyimage.jpg'; ?>
                    <p><img src="<?php echo $url;?>" alt="<?php echo $item->getTitle(); ?>"/></p>
                      
                    <noindex>
                    <p><a target="_blank" class="" href="<?php echo $item->getLink();?>">На сайт <?php echo $item->getHost();?>&raquo;</a></p>
                    </noindex>
                </div>
              
               <?php if(++ $n % 3 == 0):?>
               </div> <div class="row">
               <?php endif; ?>    
            <?php endforeach; ?>
          </div><!--/row-->
          
          <p>Всего: <?php echo $size; ?></p>
    <?php if ($q->limit < $size): ?>
    <ul class="pagination">
	   <?php $queryParam = $q->getParams(); ?>
            <?php for ($i = 0, $l = 1; $i < $size; $i+=$q->limit, $l++): ?>
            <li>
                <?php if ($q->offset == $i): ?>
                    <span>[<?php echo ($l); ?>]</span>
                <?php else: ?>
                    <a href="/?a=site/index&p=<?php echo $i; ?>&<?php echo  $queryParam;?>"><?php echo ($l); ?></a>
            <?php endif; ?>
            </li>
    <?php endfor; ?>
    </ul>
<?php endif; ?>

<div class="jumbotron">
            <h2>Добро пожаловать!</h2>
            <p>Миссия нашего проекта найти и не упустить самую боьшую скидку в интернет магазинах. 
Найти и вовремя воспользоватся супер выгодным предложением. У нас вы найдете реальные скидки до 50 % и выше. Единственное, сайт находятся в стадии разработки, поэтому возможны некоторые проблемы в его работу. Приносим свои извенения, если что не так.</p>
          </div>

          
        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
           <?php self::renderPhp('_filter', [
               'q'      => $q,
               'tags'   => $tags,
           ]); ?> 
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->

 



 

<?php self::renderPhp('footer'); ?>
