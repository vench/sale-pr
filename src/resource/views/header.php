<?php $siteName = 'Самая  большая скидка';; ?>
<?php $active = isset($active) ? $active : ''; ?>
<?php $title = isset($title ) && !empty($title) ? $title : $siteName; ?>
<?php $keywords = isset($keywords) ? $keywords : $title; ?>
<?php $description = isset($description) ? $description : $title;  ?>
<?php $obTitle = isset($obTitle) ? $obTitle : $title;  ?>
<?php $obUrl = isset($obUrl) ? $obUrl : '';  ?>
<?php $obImage = isset($obImage) ? $obImage : '';  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="575bb02c5d394514" />
    <meta name="description" content="<?php echo $description;?>">
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta name="author" content="">
    <link rel="icon" href="/img/favicon.ico">
    
    
    <meta property="og:title" content="<?php echo $obTitle; ?>" />
    <meta property="og:type" content="website" />
    <?php if(!empty($obUrl)):?>
    <meta property="og:url" content="<?php echo $obUrl; ?>" />
    <?php endif; ?>
    <?php if(!empty($obImage)):?>
    <meta property="og:image" content="<?php echo $obImage; ?>" />
    <?php endif; ?>
    
   <?php /* ?> <?php */?>
    
    <title><?php echo $title;?> | Список самых лучших предложений онлайн-магазинов рунета</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/offcanvas.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>    
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    <?php echo \app\util\View::getStaticContent('script-head'); ?>
    
    
    
  </head>

  <body>
    <nav class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Переключить меню</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><?php echo $siteName;?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php if($active == '' || $active == 'home'):?>class="active"<?php endif; ?>><a href="/">Домашняя</a></li>
            <li <?php if($active == 'tags'):?>class="active"<?php endif; ?>><a href="/?a=site/tags">Все тэги</a></li> 
            <li <?php if($active == 'about'):?>class="active"<?php endif; ?>><a href="/?a=site/about">О проекте</a></li> 
          </ul>
          
          
          <form action="/" class="navbar-form navbar-right">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Поиск по названию" name="f[text]"/>
                </div>
                <button type="submit" class="btn btn-default">Найти</button>
              </form>
          
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="container">

     
<?php
self::renderPhp('_bread', [
    'active'    => $active,
    'title'     => $title,
]);
 
     

