<?php /* @var $tags \sale\model\SaleTag[] */ ?> 

<?php

self::renderPhp('header', [
    'active'    => 'tags',
    'title'     => 'Все тэги | Список самых лучших предложений онлайн-магазинов рунета',
]);
?>

<?php foreach ($tags as $tag): ?>
    <a href="/?f[tag]=<?php echo $tag->getId(); ?>"><?php echo $tag->getTitle(); ?></a>
    
<?php endforeach; ?>

<?php self::renderPhp('footer'); ?>