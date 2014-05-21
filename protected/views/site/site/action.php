<?php

?>
<!--<link rel='stylesheet' href='./site/css/lightbox.css' />-->
<script src="/site/js/info.js"></script>
<script src="/site/js/jquery.cycle.js"></script>
<link href="/newsite/salon.css" rel="stylesheet" media="screen">
<link href="/newsite/find.css" rel="stylesheet" media="screen">
<link href="/newsite/main.css" rel="stylesheet" media="screen">
<link href="/newsite/view.css" rel="stylesheet" media="screen">
<link href="/newsite/info.css" rel="stylesheet" media="screen">
<link href="/newsite/action-base.css" rel="stylesheet" media="screen">
<link href="/newsite/home-actions.css" rel="stylesheet" media="screen">
<style type="text/css">
    #salonMap {
        width: 103.5%;
        height:25em;
        font-size:12px;
        padding:0;
    }
</style>
<script src="/js/home-actions.js"></script>
<script src="/js/main.js"></script>
<script src="//api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script>
    <?
            $city = '';
            if (isset($_SESSION['city']))
                $city = $_SESSION['city'];
                if (is_array($city))
                    $city = $city['city'];
        ?>
    var city = "<?= !empty($city) ? $city : "Москва" ?>";
    var search = '<?= $model->address ?>';
	window.ignoreList = [<?= $model->id ?>];
	$(document).ready(function() {
		var retUrl = '<?= Yii::app()->user->returnUrl ?>';
		<?php Yii::app()->user->setReturnUrl(Yii::app()->createUrl('site/action', array('id' => $model->id)));?>
		if (retUrl.indexOf('/find') >= 0)
			$('.return-to-search').click(function() {
				window.location = retUrl;
			});
		else {
			$('.return-to-search').hide();
		}
	});
</script>
<script type="text/javascript" src="/site/js/maps.js"></script>
<script type="text/javascript">
    var info = {
        l: <?= $model->l ?>,
        d: <?= $model->d ?>,
        name: "<?= nl2br(htmlspecialchars(trim($model->name))) ?>",
        work_time: "<?= nl2br(htmlspecialchars(trim($model->work_time))) ?>",
        phone: "<?= nl2br(htmlspecialchars(trim($model->phone))) ?>",
        city:"<?= nl2br(htmlspecialchars(trim($model->city->name))) ?>",
        address: "<?= nl2br(htmlspecialchars(trim($model->address))) ?>"
    };
    function update() {
        setBallon(info.l+","+info.d);
    }
    function getBalloon(){
        return new ymaps.Placemark([info.l, info.d], {
            balloonContentBody:
                '<b>'+info.name+'</b>',
            draggable: true,
            hintContent: info.name
        }, {
            iconImageHref: '/site/img/finder/flag2.png',
            iconImageOffset: [-10, -30]
        });
    }
</script>

<div class="modal hide fade" id="howtouse">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Чтобы воспользоваться этой акцией:</h3>
  </div>
  <div class="modal-body">
    <p>1. Введите Email и номер телефона<br />
<form class="form-inline">
  <input type="text" class="input-large" placeholder="Email">&nbsp;
  <input type="text" class="input-large" placeholder="Номер телефона">&nbsp;
  <button type="submit" class="btn btn-info">ОК</button>
</form>
    </p>
    <p>2. Запишитесь на удобное время по тел:<br />
    <?if ($model->phone) : ?><span><?=$model->phone ?></span><br /><? endif ?>
    </p>
  </div>
</div>


<!-- BOF Content -->
<div class="container" style="margin-top: 28px">
  <div class="row">

    <div class="span5">
      <div class="well map">
         <div id='salonMap' style="height: 270px;"></div>
      </div>

      <a href="<?= Yii::app()->createUrl('site/salon', array('id'=>$model->id))?>" style="display: block">
      <div class="well salon-lblock">
        <p style="font-weight: bold; text-align: center; font-size: 120%" ><?= $model->name ?></p>
        <img src="<? echo $model->getThumb(); ?>" />
        <?
          //if ($model->gallery) echo "<img src='/images/{$model->id}/gallery/{$model->gallery[0]->id}.jpg' alt='{$model->gallery[0]->name}'/>";
		?>
      </div>
      </a>


    </div>

    <div class="span11"><div style="padding-left: 0">
      <div class="well salon-info">
        <table width="100%"><tbody><tr>
        <td valign="top" class="image_cell">
          <?  //echo ($offer->img == null || $offer->img == 'null' || strlen($offer->img) == 0)?"":"<img src = '{$offer->img}'><br />" ?>
          <img src="<?= $offer->getThumb() ?>" /><br />
        </td>
        <td style="padding-left:20px; vertical-align: top">
          <p class="lead text-left page_header"><?= $offer->what ?></p>
          <p>В <a href='<?= Yii::app()->createUrl('site/salon', array('id'=>$model->id))?>'><?= $model->type->title_genitive_case ?> <?= $model->name ?></a> <?= $offer->present ?></p>
          <div class="salon-address">
            <div class="metro">
              <? foreach ($model->metros as $smet) : ?>
                <i class="metro-icon" style="background: url(/site/images/metro-icon.fw.png) 50% 100% no-repeat, <?=$smet->color?>;"></i><span><?=$smet->name?></span><br />
              <? endforeach ?>
            </div>
            <?=$model->address?>
          </div>



          <div>
            <?if ($model->work_time) : ?>Мы работаем <?= $model->work_time?><br /><? endif ?>
            <?if ($offer->start_date) : ?><br />Период проведения акции <?= date('d.m.Y',strtotime($offer->start_date)) ?> - <?= date('d.m.Y',strtotime($offer->end_date)) ?><? endif ?>

          </div>

        </td>
        </tr>
        <tr>
          <td style="padding-top:20px">
          <table width="100%">
            <tr>
              <td class="tprice"><?= $offer->cost ?> р.</td><td class="tdiscount">-<?=$offer->discount?>%</td><td class="tgift"><div class="gift pull-right"><b>+<?= $offer->cost * 0.1 ?></b></div></td>
            </tr>
          </table>
          </td>
          <td style="padding-left: 20px; padding-top:20px"><button class="btn btn-success" data-toggle="modal" data-target="#howtouse">&nbsp;&nbsp;&nbsp;Как воспользоваться акцией&nbsp;&nbsp;&nbsp;</button></td>
        </tr>

        </tbody></table>
        <br />
        <p style="font-size: 13px"><?= $offer->description ?></p>

        <div class="actions-block" style="display: none">
        <p class="headline">&nbsp;</p>
        <div class="salonview-spoiler actions-spoiler">
          <div class="spoil_header up">Акции</div>
          <div class="spoiler">
            <table width="100%" class="salonview-action-table  table-striped">
            </table>
          </div>
        </div>
        </div>


      </div>
    </div></div>

  </div>
</div>
<!-- EOF Content -->


