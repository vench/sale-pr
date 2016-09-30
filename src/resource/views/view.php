<?php /* @var $page app\model\Page */ ?>
 
    
 <?php self::renderPhp('header', [
    'active' => 'edit',
    'title' => 'View page ' . $page->getTitle(),
    'keywords' => $page->getKeywords(),
]); ?>

<a href="/?a=page/edit&id=<?php echo $page->getPageId(); ?>">Edit</a>

<p>Title: <?php echo $page->getTitle();?></p>
<p>Body: <?php echo $page->getBody();?></p>
<p>Keywords: <?php echo $page->getKeywords();?></p>
<p>Modified: <?php echo $page->getModified()->format('Y-m-d H:i:s');?></p>

<?php self::renderPhp('footer'); ?>