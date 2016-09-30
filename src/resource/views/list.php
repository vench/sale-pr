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
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="jumbotron">
            <h1>Hello, world!</h1>
            <p>This is an example to show the potential of an offcanvas layout pattern in Bootstrap. Try some responsive-range viewport sizes to see it in action.</p>
          </div>
          <div class="row">
            <?php foreach ($list as $n => $item): ?>
                <div class="col-xs-6 col-lg-4"> 
                    <h4><?php echo $item->getTitle(); ?></h4> 
                    <p><img src="/img/emptyimage.jpg" alt="<?php echo $item->getTitle(); ?>"/></p>
                     <p><a class="" href="#">Просмотреть детально&raquo;</a></p>
                </div>
              
               <?php if($n > 0 && $n % 3 == 0):?>
               </div> <div class="row">
               <?php endif; ?>    
            <?php endforeach; ?>
          </div><!--/row-->
          
          <p>Total: <?php echo $size; ?></p>
    <?php if ($limit < $size): ?>
    <ul>
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
          
        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
            <h3>Фильтры</h3>
          <div class="list-group">
             
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->

 



 

<?php self::renderPhp('footer'); ?>