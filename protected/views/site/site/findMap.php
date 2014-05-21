<link rel='stylesheet' href='./newsite/find.css' />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/site/js/search.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/range.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/find.js"></script>
<script src="//api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>

<script>
	$(document).ready(function() {
		$('.go-find-actions a').click(function() {
			var startPrice = $('input[name=startPrice]').val();
			var endPrice = $('input[name=endPrice]').val();
			var cat = $('input[name=category]').val();
			var q = $('input[name=q]').val();
			var address = $('input[name=metro]').val();
			location = '/index.php?r=site/find&q='+q+'&address='+address+'&category='+cat+'&startPrice='+startPrice+'&endPrice='+endPrice;
		});
	});

    function moveMap(pos, needCenter){
        var c=myMap.getCenter();
        pos = pos || {l: c[0], d:c[1]};
        var max = 0.001;
        var zoom = 18;
        while (zoom != myMap.getZoom()) {
            zoom--;
            max *= 2;
        }
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('site/getBallons', array('count' => 1000))?>",
            data: {
                maps: true,
                lat: pos.l,
                long: pos.d,
                range: max,
                q: $('input[name=q]').val(),
                metro: $('input[name=metro]').val(),
                startPrice: $('input[name=startPrice]').val(),
                endPrice: $('input[name=endPrice]').val(),
                category: $('#category').val()
            },
			dataType: "json",
            success: function(data){
                var iter = myMap.geoObjects.getIterator();
                while(true) {
                    var a = iter.getNext();
                    if (a == null) break;
                    myMap.geoObjects.remove(a);
                }
                var end = "салонов";
                if (data.data.length === 0) {
                    $('.found').text("Ничего не найдено");
                    if (needCenter) {
                        window.myMap.setCenter([pos.l, pos.d]);
                        window.myMap.container.fitToViewport();
                    }
                } else {
                    if ((data.data.length %100) >= 10 && (data.data.length%100) <= 20)
                    {} else {
                        var rounded = data.data.length%10;
                        switch (rounded) {
                            case 1:
                                end = "салон"
                                break;
                            case 2:
                            case 3:
                            case 4:
                                end = "салона"
                                break;
                        }
                    }
                    $('.found').html("Мы нашли для Вас <span>"+data.data.length+'</span> '+end);
				}
				for(var i in data.data) {
					var d = data.data[i];
					var ball = new ymaps.Placemark([d.l, d.d], {
						balloonContentBody:
                            d.img+'<a href="<?= Yii::app()->createUrl('site/salon')?>&id='+d.id+'"><b>'+d.name+'</b></a><br>'
								+ "<b>" + d.city + ", "+d.address+"</b><br>"
                                +'<span>'+d.phone+"</span><br>"
								+'<span style="color:#979797;font-size: 0.8em">'+d.work_time+'</span>',
						draggable: true,
						hintContent: d.name
					}, {
						iconImageHref: '/site/img/finder/flag.png',
						iconImageSize:[24,24],
                        iconImageOffset: [-10, -30]
					});
					window.myMap.geoObjects.add(ball);
					//setBallon(d.coords, d);
				}
				if (needCenter){
					window.myMap.setCenter([data.data[0].l, data.data[0].d]);
					window.myMap.container.fitToViewport();
				}
            }
        });
        //todo: ajax to get ballons of salons
    }

   /* function sethere(pos){
        var here = new ymaps.Placemark([pos.l, pos.d], {
            balloonContentBody:
                'Вы находитесь здесь',
            draggable: true,
            hintContent: 'Вы находитесь здесь'
        }, {
            iconImageHref: '/site/img/start-here.png',
            iconImageSize:[24,24],
            iconImageOffset: [-30, -30]
        });
        window.myMap.geoObjects.add(here);
    }*/

	function initMap(isResearch) {
    <?
    $city = '';
    if (isset($_SESSION['city']))
        $city = $_SESSION['city'];
    if (is_array($city))
        $city = $city['city'];
    ?>
        var city = "<?= !empty($city) ? $city : "Москва" ?>";
        var search = $('input[name=metro]').val();//'<?= empty($metro) ? $center : $metro ?>';
        if (city === ymaps.geolocation.city && search.length == 0) {
            if (navigator.geolocation) {
                // Запрашиваем текущие координаты устройства.
//                navigator.geolocation.getCurrentPosition(
//                    ymaps.util.bind(function(er) {
//                        if (isResearch)
//                            moveMap({l: er.coords.latitude, d: er.coords.longitude}, true);
//                        /*sethere({l: er.coords.latitude, d: er.coords.longitude});*/
//                    }),
//                    ymaps.util.bind(function(f) {}),
//                    this.geoLocationOptions
//                );
                moveMap(false, true);
            }
        } else {
            ymaps.geocode(city+','+search)
                .then(function(r){
                    var coord = r.geoObjects.get(0).geometry.getCoordinates();
                    moveMap({l:coord[0], d: coord[1]}, true);
                });
        }
    }

    $(document).ready(function(){
        ymaps.ready(function() {
            ymaps.geocode("Москва", { results: 1 }).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                window.myMap = new ymaps.Map("salonMap", {
                    center: firstGeoObject.geometry.getCoordinates(),
                    zoom: 16,
                    behaviors:['default', 'scrollZoom']
                });
                window.myMap.controls.add(
                    new ymaps.control.ZoomControl()
                );
                window.myMap.events.add('boundschange', function(event) {
                    //if (event.get('newZoom') != event.get('oldZoom')) {
                    //}
                    //if (event.get('newCenter') != event.get('oldCenter')) {
                    moveMap({l:event.get('newCenter')[0], d: event.get('newCenter')[1]});
                    //}
                });
                $('input[name=metro]').keydown(function() {initMap(true)});
                $('input[name=q]').keydown(function() {initMap(true)});
                $('input[name=metro]').focusout(function() {initMap(true)});
                $('input[name=q]').focusout(function() {initMap(true)});

                $('.find-btn').click(function() {initMap(true)});
                $('input[name=startPrice]').on('change',function(){moveMap();});
                $('input[name=endPrice]').on('change',function(){moveMap();});
                $('#category').on('change',function(){moveMap();});
                initMap(false);
            });
        });
    });
</script>
<style type="text/css">
    #salonMap {
        width: 100%;
        height: 600px;
        border: 1px solid #bfbfbf;
    }
</style>
<!-- BOF Content -->
<div class="container" style="margin-top: 28px">
  <div class="row">

    <div class="span5">

      <?php
        $category_html = '';
		foreach (ServiceCategory::getCategoryList(0) as $k => $cat) {
		  $cat_part_html = '';
          $b = false;
          $cat_part_html .= "<div class='white' data='$k' d='$k'><h4 class='text-center'>$cat</h4></div>";
		  foreach (ServiceCategory::getCategoryList($k) as $k1 => $sub) {
		    $active = "";
			if (is_array($categories) && in_array($k1, $categories)) {
			  $active = " checked";
              $b = true;
            }
            $cat_part_html .= "
              <div class='grey' data='$k1' d='$k'><div class='service $active'>$sub</div></div>
            ";
          }
          if ($b) $category_html .= $cat_part_html;
		}
        if ($category_html) {
          echo '<div class="well service-checker">'.$category_html.'</div>';
        }
	  ?>


      <div class="well">
        <div class="grey" ><div class="cprice"> 500-999 рублей</div></div>
        <div class="grey" ><div class="cprice"> 1000-1499 рублей</div></div>
        <div class="grey" ><div class="cprice"> 1500-1999 рублей</div></div>
        <div class="grey" ><div class="cprice"> 2000-2999 рублей</div></div>
        <div class="grey" ><div class="cprice"> Свыше 3000 рублей</div></div>
      </div>

    </div>

    <div class="span11"><div style="padding-left: 0">

<? include dirname(__FILE__).'/includes/search_form.php' ?>

      <div id='salonMap'></div>

      <!-- BOF Salons -->
      <div class='salons-holder'>
    	<div class='found'></div>
      </div>
      <!-- EOF Salons -->


    </div></div>

  </div>
</div>
<!-- EOF Content -->







<form action="index.php" class='top-control'>
<input type="hidden" name="r" value="newsite/findMap" id='goTo'>
<input type="hidden" id='startPrice' name="startPrice" value="<?= $startPrice?>">
<input type="hidden" id='endPrice' name="endPrice" value="<?= $endPrice?>">
<input type="hidden" name="category" value="[]" id='category'>
	<div class='container'>
	<div class='col-md-3 left-menu'>
		<div class='light-blue'>
			Цены и скидки
		</div>
		<div class='white price'>
			<div class='prices'>
				<span class='from'><?= $startPrice ?></span> р. - <span class='to'><?= $endPrice ?></span> р.
			</div>
			<div class='slider-range'>
			</div>
			<div class='minmax'>
				<span class='min'>0р</span>
				<span class='max'><?= Service::getMaxCost() ?>р</span>
			</div>
			<script>
				window.maxPrice = <?= Service::getMaxCost() ?>;
			</script>
		</div>
		<div class='light-blue select-cats'>
			Выбор услуги
		</div>
		<?php
		$bb = false;
		foreach (ServiceCategory::getCategoryList(0) as $k => $cat) {
			?>
		<div class='white' data='<?= $k?>' d='<?= $k ?>'>
			<div class='serv-header'>
				<?= $cat ?>
			</div>
		</div>
		<?php
			$b = false;
			foreach (ServiceCategory::getCategoryList($k) as $k1 => $sub) {
				$active = "";
				if (in_array($k1, $categories))
				{
					$active = " checked";
					$b = true;
					$bb = true;
				}
				?>
		<div class='grey' data='<?=$k1?>' d='<?= $k ?>'>
			<div class='service <?= $active?>'>
				<?= $sub ?>
			</div>
		</div>
		<?php
			}
		?>
		<?php
			if (!$b) {?>
			<script>
				$('[d=<?= $k?>]').remove();
			</script>
			<?php
			}
		}
		if (!$bb) {?>
			<script>
				$('.select-cats').remove();
			</script>
		<?php
		}
		?>
	</div>
<div class='col-md-9'>
		<div class='salons-holder col-md-12'>
			<div class='row header'>
				<div class='col-md-3 '>
					<h4>Результаты поиска</h4>
				</div>
				<div class='col-md-2 go-find-actions'>
					<a href='#' class='glyphicon glyphicon-gift'><span> Показать Салоны</span></a>
				</div>
                <div class='col-md-7'>
                    <div class='full-info all present col-md-7'>
                        <div class='btn btn-cat' data="present">
                            <i class='present-ico'></i>
                            Посещай салоны и получай бонусы
                        </div>
                    </div>
                    <div class='full-info all bonus-button col-md-5'>
                        <div class='btn btn-black' data="bonus-button">
                            <i class='phone-ico'></i>
                            Бонусы на мобильный
                        </div>
                    </div>
                </div>
			</div>
			<div class='finder row'>
				<?$this->widget('zii.widgets.jui.CJuiAutoComplete',
                        array(
                            'name'=>'q',
                            'source' =>Yii::app()->createUrl('serviceCategory/complete'),
                            'options'=>array(
                                'minLength'=>'3',
                                'showAnim'=>'fold',
                            ),
                            'htmlOptions' => array(
                                'maxlength'=>150,
								'class'=>'col-md-5',
                                'placeholder'=>'Услуга или название салона'
                            ),
                            'value'=> $q
                        )
                    );?>
					<?$this->widget('zii.widgets.jui.CJuiAutoComplete',
                    array(
                        'name'=>'metro',
                        'source' =>Yii::app()->createUrl('metro/complete'),
                        'options'=>array(
                            'minLength'=>'3',
                            'showAnim'=>'fold',
                        ),
                        'htmlOptions' => array(
                            'maxlength'=>150,
                            'placeholder'=>'Улица или метро',
                            'class'=>'address col-md-5'
                        ),
                        'value'=> $metro
                    )
                );?>
				<div class='col-md-1' style="margin-left: 1em">
					<div class='btn btn-cat find-btn'>
						Найти
					</div>
				</div>
			</div>
			<div class='row result-header'>
				<div class='found'></div>
			</div>
<!--			<div id='salonMap' class="row">
			</div>-->
		</div>
	</div>
</div>
</form>
</div>
<a href="#top" class="ancLinks"><div id="scrollUp">Наверх</div></a>
