<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <link rel="shortcut icon" href="/site/img/favicon.ico" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <style type="text/css">
        body {
            background: #ffffff;
        }

        #page {
            padding: 10px;
            border: 0px solid #dddddd;
			min-height:800px;
        }
        .page-header h3,.page-header h2,.page-header h1 {
            font-size:17px;
            line-height: 20px;
            margin: 0;
        }
    </style>

</head>

<body>

<div class="container" id="page">
	<?php echo $content; ?>
	<div class="clear"></div>
</div>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2389032-30', 'autofiles.com');
  ga('send', 'pageview');

</script>

</body>
</html>
