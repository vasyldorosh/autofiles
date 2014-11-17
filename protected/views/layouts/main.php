<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	 <meta name="keywords" content="<?php echo CHtml::encode($this->meta_keywords); ?>" />
	 <meta name="description" content="<?php echo CHtml::encode($this->meta_description); ?>" />	
	
	<meta name="viewport" content="initial-scale=1"/>
	<link rel="stylesheet" media="screen" href="/css/screen.css" >
	<!--[if IE]><script src="/js/html5shiv.js"></script><![endif]-->
	
	<script src="/js/lib/jquery.js"></script>	
</head>
<body class="l">
<!-- BEGIN HEADER -->
<header>
	<a href="/" class="logo" title="Cars technical information"><span>Auto</span>Files.com</a>
	<!--<div class="search">
		<input type="text" placeholder="Search">
		<button type="submit" class="btn btn_search"></button>
	</div>-->
	<!--
	<a href="#" class="sign-in">Sign in</a>
	<a href="#" class="join">Join</a>
	-->
</header>

<nav>
	<ul class="menu-list">
		<li class="is-active"><a href="/">Home</a></li>
		<!--
		<li><a href="#">All cars</a></li>
		<li><a href="#">Cars specs</a></li>
		<li><a href="#">Store</a></li>
		<li><a href="#">Tires</a></li>
		<li><a href="#">Media</a></li>
		-->

	</ul>
</nav>

<ul class="breadcrumb">
	<?php foreach ($this->breadcrumbs as $url=>$title):?>
		<li>
			<?php if ($url != '#'):?>
				<a href="<?=$url?>"><?=$title?></a><span>→</span>
			<?php else:?>
				<a href="#"><?=$title?></a>
			<?php endif;?>
		</li>
	<?php endforeach;?>
</ul>

<?php echo $content;?>

<!-- BEGIN FOOTER -->
<footer>
	<section class="footer__info">
		<a href="#">RSS</a>
		<a href="#">About us</a>
		<a href="#">Support</a>
	</section>
	<section class="footer__copyright">
		&copy <?=date('Y')?> AutoFiles. All Rights Reserved.

		<?php if ($_SERVER['SERVER_NAME'] == 'autofiles.com'):?>		
			<script type="text/javascript"><!--
			document.write("<img src='//counter.yadro.ru/hit?t26.10;r"+
			escape(document.referrer)+((typeof(screen)=="undefined")?"":
			";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
			screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
			";"+Math.random()+
			"' alt='' title='LiveInternet: показано число посетителей за"+
			" сегодня' "+
			"border='0' width='1' height='1'>")
			//--></script>
		<?php endif;?>		
		
	</section>
</footer>

</body>
</html>

<?php if ($_SERVER['SERVER_NAME'] == 'autofiles.com'):?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2389032-30', 'autofiles.com');
  ga('send', 'pageview');

</script>
<?php endif;?>

<?php if (YII_DEBUG):?>
<div style="position:fixed;right:0;top:0;color:green;margin-right:5px;z-index:10000;">
  <?php $stat = Yii::app()->db->getStats();?>
  <?=$stat[0]?> / <?=round($stat[1],5)?>
</div> 
<?php endif;?>

</body>
</html>
