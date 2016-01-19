<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	 <meta name="keywords" content="<?php echo CHtml::encode($this->meta_keywords); ?>" />
	 <meta name="description" content="<?php echo CHtml::encode($this->meta_description); ?>" />	
	
	<meta name="viewport" content="initial-scale=1"/>
	<link rel="stylesheet" media="screen" href="/css/screen.css" >
        <link rel="stylesheet" href="/css/responsive.css" />
	<!--[if IE]><script src="/js/html5shiv.js"></script><![endif]-->

</head>
<body class="l">
<!-- BEGIN HEADER -->
<header>
	<a href="/" class="logo" title="Cars technical information"><span>Autotk</span>.com</a>
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
	<?php $uri = Yii::app()->request->requestUri;?>
		<li <?=($uri=='/')?'class="is-active"':''?>><a href="/">All cars</a></li>
		<li <?=($uri=='/0-60-times.html')?'class="is-active"':''?>><a href="/0-60-times.html">0-60 times</a></li>
		<li <?=($uri=='/wheels.html')?'class="is-active"':''?>><a href="/wheels.html">Wheels</a></li>
		<li <?=($uri=='/tires.html')?'class="is-active"':''?>><a href="/tires.html">Tires</a></li>
		<li <?=($uri=='/horsepower.html')?'class="is-active"':''?>><a href="/horsepower.html">HP</a></li>
		<li <?=($uri=='/dimensions.html')?'class="is-active"':''?>><a href="/dimensions.html">Dimensions</a></li>
		<li <?=($uri=='/tuning.html')?'class="is-active"':''?>><a href="/tuning.html">Car Tuning</a></li>
	</ul>
</nav>

<ul class="breadcrumb">
	<?php foreach ($this->breadcrumbs as $url=>$item):?>
		<li>
			<?php 
			$anchor = '';
			$title = '';
			if (is_array($item)) {
				$anchor = $item['anchor'];
				if (isset($item['title']))
					$title = $item['title'];
			} else {
				$anchor = $item;
			}?>
		
			<?php if ($url != '#'):?>
				<a href="<?=$url?>" <?=!empty($title)?"title='{$title}'":""?> ><?=$anchor?></a><span>→</span>
			<?php else:?>
				<a href="#"><?=$anchor?></a>
			<?php endif;?>
		</li>
	<?php endforeach;?>
</ul>

<?php echo $content;?>

<!-- BEGIN FOOTER -->
<footer>
	<section class="footer__info">
		<a rel="nofollow" href="/about.html">About us</a>
	</section>
	<section class="footer__copyright">
		&copy <?=date('Y')?> Autotk.com. All Rights Reserved.

		
	</section>
</footer>

</body>
</html>

<?php if ($_SERVER['SERVER_NAME'] == 'autotk.com'):?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2389032-35', 'auto');
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
