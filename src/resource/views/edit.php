<?php /* @var $page app\model\Page */ ?>
<?php /* @var $form app\Form */ ?>

<?php
self::renderPhp('header', [
    'active' => 'edit',
    'title' => 'Edit page ' . $page->getTitle(),
]);
?>


<a href="/?a=page/view&id=<?php echo $page->getPageId(); ?>">View</a>

<?php
self::renderPhp('_form', [
    'form' => $form,
]);
?>


<?php self::renderPhp('footer'); ?>