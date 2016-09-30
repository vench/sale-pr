<?php /* @var $page app\model\Page */ ?>
<?php /* @var $form app\Form */ ?>
    
 <?php self::renderPhp('header', [
    'active' => 'edit',
    'title' => 'Add page',
]); ?>

<?php self::renderPhp('_form', [
    'form' => $form,
]); ?>


<?php self::renderPhp('footer'); ?>