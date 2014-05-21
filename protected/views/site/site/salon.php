<!--<link rel='stylesheet' href='./site/css/lightbox.css' />-->
<script src="/site/js/info.js"></script>
<script src="/site/js/jquery.cycle.js"></script>
<link href="/newsite/salon.css" rel="stylesheet" media="screen">
<link href="/newsite/find.css" rel="stylesheet" media="screen">
<link href="/newsite/main.css" rel="stylesheet" media="screen">
<link href="/newsite/view.css" rel="stylesheet" media="screen">
<link href="/newsite/info.css" rel="stylesheet" media="screen">
<link href="/newsite/home-actions.css" rel="stylesheet" media="screen">
<script src='/js/home-actions.js'></script>

<!-- Add fancyBox main JS and CSS files -->
<?php
$gallery = array();
foreach ($model->galleryPhotos as $photo) : 
      array_push($gallery, array('href' => $photo->getThumb(), 'title' => $photo->name));
endforeach;
?>
<script type="text/javascript" src="/js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="/themes/newdes/gallery.css" />
<script type="text/javascript">
    $(document).ready(function() {    
        $("#galleryZoom").click(function() {
            $.fancybox.open(<?php echo json_encode($gallery);; ?> 
                    /*,{
                    helpers : {
                            thumbs : {
                                    width: 75,
                                    height: 50
                            }
                    }
            }*/
                    );
        });

    });
</script>
<!-- end fancyBox -->
<style type="text/css">
    #salonMap {
        width: 103.5%;
        height:25em;
        font-size:12px;
        padding:0;
    }

.salon-info .gallery {
  position: relative
}

.salon-info .gallery .previewer {
  height: 202px
}

.salon-info .gallery .button-left {
  margin-top: 76px
}

.salon-info .gallery .button-right {
  margin-top: -126px
}

</style>
<script src="//api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		$.ajax({
            url: "<?= Yii::app()->createUrl('site/getActions')?>",
            data: {
                'pid' : <?= $model->id ?>,
				'count' : 10000
            },
            dataType: "json",
            success: function(data){
              var tpl = '';
			  for (var i in data.data) {
			    //addAction($('.actions-holder'), data.data[i], 6, 'cat');
                tpl = tpl + '<tr><td class="salonview-action"><a href="<? echo Yii::app()->createUrl('site/action').'?id='?>' + data.data[i].id + '">'+data.data[i].what+'</a></td><td class="salonview-action-price">'+data.data[i].cost+' р.</td><td class="salonview-action-discount">-'+data.data[i].rubles+' р.</td><td class="salonview-action-bonus">+'+data.data[i].cost*0.05+' бонусов</td></tr>';
			  }
              if (tpl) {
                $('.salonview-action-table').html(tpl);
                $('.actions-spoiler .spoiler').show();
                $('.actions-block').show();
              } else {
                $('.salonview-action-table').html('<tr><td>Акции отсутствуют</td></tr>');
                $('.actions-block').hide();
              }


			}
		});
	});
    <?
            $city = '';
            if (isset($_SESSION['city']))
                $city = $_SESSION['city'];
                if (is_array($city))
                    $city = $city['city'];
        ?>
    var city = "<?= !empty($city) ? $city : "Москва" ?>";
    var search = '<?= $model->address ?>';
    $(document).ready(function() {
		var retUrl = '<?= Yii::app()->user->returnUrl ?>';
		<?php Yii::app()->user->setReturnUrl(Yii::app()->createUrl('site/salon', array('id' => $model->id)));?>
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
        name: "<?= $model->name ?>",
        work_time: "<?= $model->work_time ?>",
        phone: "<?= $model->phone ?>",
        city:"<?= $model->city->name ?>",
        address: "<?= $model->address?>"
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

<script>
	$(document).ready(function() {
	  $('.spoil_ctrl, .spoil_header').click(function () {
	    if ($(this).hasClass('up')) {
	      $('.spoiler', $(this).parent()).slideUp();
          $(this).removeClass('up')
	    } else {
	      $('.spoiler', $(this).parent()).slideDown();
          $(this).addClass('up')
        }
	  });
	});
</script>


<!-- BOF Content -->
<div class="container" style="margin-top: 28px">
  <div class="row">

    <div class="span5">
      <div class="well map">
         <div id='salonMap' style="height: 270px;"></div>
      </div>
    </div>

    <div class="span11"><div style="padding-left: 0">
      <div class="well salon-info">     

      <table width="100%"><tbody><tr>
        <td valign="top" class="image_cell">

<div class='gallery'>
    <img id="galleryZoom" src="/themes/newdes/images/zoom_32.png">
    <div class='button-left'>
    </div>
    <div class='previewer' style="position: relative;">
    <? foreach ($model->galleryPhotos as $photo) : ?>
      <img src="<? echo $photo->getThumb() ?>" alt="<? echo $photo->name ?>" />
    <? endforeach ?>

    </div>
    <div class='button-right'>
    </div>
</div>

        </td>
        <td style="padding-left:20px; vertical-align: top">
          <p class="lead text-center page_header"><?= $model->name ?></p>
          <?
/*            $catlist = '';
            foreach ($model->category as $cat)
              if ($cat->pid==0) $catlist .= '<li><a href="'.Yii::app()->createUrl('site/find', array('category'=>'['.$cat->id.']')).'">' . $cat->name . '</a></li>';
            if ($catlist) echo '<ul class="categories">' . $catlist . '</ul>';*/
          ?>
          <div class="salon-address">
            <div class="metro">
              <? foreach ($model->metros as $smet) : ?>
                <i class="metro-icon" style="background: url(/site/images/metro-icon.fw.png) 50% 100% no-repeat, <?=$smet->color?>;"></i><span><?=$smet->name?></span><br />
              <? endforeach ?>
            </div>
            <?=$model->address?>
          </div>
          <div class="bonus_present">
            <?if ($model->work_time) : ?>Мы работаем <?= $model->work_time?><br /><? endif ?>
            <?if ($model->phone) : ?><span class="salonview_phone"><?=$model->phone ?></span><? endif ?>
          </div>

        </td>
        </tr></tbody></table>
        <br />
        <p style="font-size: 13px"><?= $model->description ?></p>

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


        <?php
        //Вывод услуг
		$groups = array();
		foreach ($model->services as $item) {
			$key = $item->category_id;
			if (!isset($groups[$key])) {
				$groups[$key] = array(
					'items' => array($item),
					'count' => 1,
				);
			} else {
				$groups[$key]['items'][] = $item;
				$groups[$key]['count'] += 1;
			}
		}
		foreach ($groups as $k => $v) {
		  echo '
          <p class="headline">&nbsp;</p>
          <div class="salonview-spoiler">
            <div class="spoil_header">' . ServiceCategory::getString($k) . '</div>

            <div class="spoiler">
              <table width="100%" class="salonview-service-table table-striped">';
//			echo "<div class='category open'><div class='name'><i class='open-icon'></i><span>".ServiceCategory::getString($k)."</span></div><div class='service-hldr'>";
			foreach ($v['items'] as $i) {
				$hours = floor($i->duration);
				$minutes = floor(60*($i->duration - $hours));
				$hoursStr = "";
				if ($hours != 0)
					$hoursStr .= $hours." час. ";
				if ($minutes != 0)
					$hoursStr .= $minutes." мин.";
				$oldPriceStr = "";
				if ($i->old_price > 0 && $i->old_price != $i->price)
					$oldPriceStr = "<span class='old'>{$i->old_price} р</span>";
				//$rk = $i->price * 0.05;
                $rk = $i->price * 0.1;
                echo '<tr><td class="salonview-service">'.$i->name.'</td><td class="salonview-service-price">'. ( $hoursStr ? '<span class="worktime"><i class="icon-time"></i> '.$hoursStr.'</span>' : '' ) . '&nbsp;&nbsp;&nbsp;'.$i->price.' р.'.($rk ? '&nbsp;&nbsp;&nbsp;+'.$rk.' бонусов' : '').'</td></tr>';
				//echo "<div class='service row'><div class='col-xs-7 col-md-7 name'><span>{$i->name}</span></div><div class='col-xs-2 col-md-2 length'>{$hoursStr}</div><div class='col-md-2 col-xs-2 cost'>{$oldPriceStr}<span>{$i->price} р</span></div><div class='col-xs-1 col-md-1 buy show-promo' title='Как получить бонусы?'>+{$rk}Р</div></div>";
			}
			echo '
              </table>
            </div>
          </div>';
		}

        //если услуг нет
        if (!$groups) {
          $current_cat = array();
          $cat_group = array();
          foreach ($model->category as $k=>$cat) $current_cat[$cat->id] = $cat->name;
          foreach (ServiceCategory::getCategoryList(0) as $kgr => $catgr)
            foreach (ServiceCategory::getCategoryList($kgr) as $k => $cat) {
              if (isset($current_cat[$k])) {
                $cat_group[$kgr]['name'] = $catgr;
                $cat_group[$kgr]['items'][$k] = array('id'=>$k, 'name'=>$cat);
              }
            }

          foreach ($cat_group as $catgr) {
		    echo '
            <p class="headline">&nbsp;</p>
            <div class="salonview-spoiler">
              <div class="spoil_header">' . $catgr['name'] . '</div>

              <div class="spoiler">
                <table width="100%" class="salonview-service-table table-striped">';
            foreach ($catgr['items'] as $cat) {
              echo '<tr><td class="salonview-service">'.$cat['name'].'</td><td class="salonview-service-price">&nbsp;</td></tr>';
            }
		    echo '
                </table>
              </div>
            </div>';
          }
        }


		?>


<!--        <p class="headline">&nbsp;</p>
        <div class="salonview-dopinfo">
          <img src="/images/dop_image.jpg"/>
          <p>Главный тренд 2014 года - ЕСТЕСТВЕННОСТЬ. Последние несколько лет в моде прочно сохранялось уверенное стремление к естественности. Многие
стали избегать яркого макияжа и экстравагантных причесок. На смену пришла...<a href="#">читать далее</a></p>
        </div>-->

      </div>
    </div></div>

  </div>
</div>
<!-- EOF Content -->






