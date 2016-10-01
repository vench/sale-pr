<?php /* @var $list \sale\model\SaleItem[] */ ?>
<?php /* @var $size int */ ?>
<?php /* @var $limit int */ ?>
<?php /* @var $page int */?>

<?php
self::renderPhp('header', [
    'active' => 'home',
]);
?>

 

 <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Меню</button>
          </p>

	<h1>Самые лучшие предложения интернета!</h1>
          
          <div class="row">
		<?php $n = 0;?>
            <?php foreach ($list as  $item): ?>
                <div class="col-xs-6 col-lg-4 item list"> 
                    <p><?php echo $item->getTitle(); ?> <b><?php echo $item->getPriceDiff(); ?> %</b></p> 

		    <p>Было <?php echo $priceFormat( $item->getPriceOld()); ?> 
стало <?php echo $priceFormat($item->getPriceNew()); ?></p>
                    <p><img src="/img/emptyimage.jpg" alt="<?php echo $item->getTitle(); ?>"/></p>
                     <p><a class="" href="/?a=site/detail&id=<?php echo $item->getId(); ?>" title="<?php echo $item->getTitle(); ?>">Просмотреть детально&raquo;</a></p>
		    <p><a class="" href="<?php echo $item->getLink();?>">На сайт <?php echo $item->getHost();?>&raquo;</a></p>
                </div>
              
               <?php if(++ $n % 3 == 0):?>
               </div> <div class="row">
               <?php endif; ?>    
            <?php endforeach; ?>
          </div><!--/row-->
          
          <p>Всего: <?php echo $size; ?></p>
    <?php if ($limit < $size): ?>
    <ul class="pagination">
            <?php for ($i = 0, $l = 1; $i < $size; $i+=$limit, $l++): ?>
            <li>
                <?php if ($page == $i): ?>
                    <span>[<?php echo ($l); ?>]</span>
                <?php else: ?>
                    <a href="/?a=site/index&p=<?php echo $i; ?>"><?php echo ($l); ?></a>
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
            <h3>Фильтры</h3>
          <div class="list-group">
             
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->

 



 

<?php self::renderPhp('footer'); ?>
