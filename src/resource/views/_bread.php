<?php 
$active = isset($active) ? $active : 'home'; 
$title = isset($title) ? $title : $active; 
              
?>



<?php if($active != 'home') :?>
<ol class="breadcrumb">  
  <li><a href="/">Главная</a></li> 
  <li><?php 
  
  
          switch ($title) {
              case 'tags': echo 'Тэги'; break;
              case 'about': echo 'О проекте'; break;
              default : echo $title;                  break;
          }
  ?></li> 
</ol>

<?php endif; ?>