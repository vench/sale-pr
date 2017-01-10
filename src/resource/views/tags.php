<?php /* @var $tags \sale\model\SaleTag[] */ ?> 

<?php

self::renderPhp('header', [
    'active'    => 'tags',
    'title'     => 'Все тэги',
]);



?>


<h1>Все тэги  </h1>



<div>
<?php $first = null; ?>
<?php foreach ($tags as $tag): ?>
    
    
    <?php $f = $firstChar($tag->getTitle()); ?>
    <?php if(is_null($first) || $first != $f): ?>
    </div><div>
        <h3><?php echo $f; ?></h3>
        <?php $first = $f; ?>
    <?php endif; ?>
    
    <a href="/?f[tag]=<?php echo $tag->getId(); ?>"><?php echo $tag->getTitle(); ?></a>
    
<?php endforeach; ?>
</div>
<?php self::renderPhp('footer'); ?>