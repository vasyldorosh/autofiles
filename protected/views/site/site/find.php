<script>
	window.maxPrice = <?= Service::getMaxCost() ?>;
    CURRENT_MODE = 0;
</script>
<!--<link rel='stylesheet' href='./newsite/find.css' /> -->

<!--<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
<script src="/site/js/search.js"></script>
<script src="/js/range.js"></script>
<script src="/js/find.js"></script>

<style>
    .page-hide {
        display: none;
    }

    .page-show {
        display: block;
    }
</style>
<script>
	SOffset = 0;
    function moveMap(pos, needCenter){
        var c=myMap.getCenter();
        pos = pos || {l: c[0], d:c[1]};
        var max = 0.001;
        var zoom = 18;
        while (zoom != myMap.getZoom()) {
            zoom--;
            max *= 2;
        }
		var wasOf = SOffset;

        $.ajax({
            url: "<?php echo Yii::app()->createUrl('site/getBallons', array('offset'=>''))?>"+SOffset,
            data: {
                maps: false,
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
                $(".page").removeClass("page-show").addClass("page-hide");
				if (!wasOf) {
					$('.salons-holder .found-salon').remove();
					var iter = myMap.geoObjects.getIterator();
					while(true) {
						var a = iter.getNext();
						if (a == null) break;
						myMap.geoObjects.remove(a);
					}
				}
                //data = JSON.parse(data);
                var end = "салонов";
                if (data.total === 0) {
                    $('.found').html("<p class=\"lead notfound\" >Ничего не найдено</p>");
                } else {
                  $('p.notfound').remove();
                    if ((data.total %100) >= 10 && (data.total%100) <= 20)
                    {} else {
                        var rounded = data.total%10;
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
                    /*$('.found').html("Мы нашли для Вас <span>"+data.total+'</span> '+end);   */
                }
                for(var i in data.data) {
                    var d = data.data[i];     //alert (''+d.img+'<a href="<?= Yii::app()->createUrl('site/salon')?>&id='+d.id+'" class="map_balloon"><div class="balloon_name">'+d.name+'</div><div class="balloon_img><img src="'+d.img+'" /></div><div class="balloon_address">'+d.address+'<div><div class="ballon_worktime">'+d.work_time+'</div> </div>');
                    var ball = new ymaps.Placemark([d.l, d.d], {
                        balloonContentBody:
                           '<a href="<?= Yii::app()->createUrl('site/salon')?>?id='+d.id+'" class="map_balloon"><div class="balloon_name">'+d.name+'</div><div class="balloon_img"><img src="'+d.img+'" /></div><div class="balloon_address">'+d.address+'<div><div class="ballon_worktime">'+d.work_time+'</div> </div>',
/*                            '<a href="<?= Yii::app()->createUrl('site/salon')?>&id='+d.id+'"><b>'+d.name+'</b><br>'
                                 +d.address+"<br>"
                                +d.phone+"<br>"
                                +d.work_time+'</a>',*/
                        draggable: true,
                        hintContent: d.name
                    }, {
                        iconImageHref: '/site/img/finder/flag2.png',
                        iconImageOffset: [-10, -30]
                    });
                    window.myMap.geoObjects.add(ball);
					addSalon($('.salons-holder'), d);
                    //setBallon(d.coords, d);
                }
				SOffset = $('.found-salon').length;
				if (SOffset >= data.total) {
					$('.load-salons').hide();
				} else $('.load-salons').show();
                $('.open .b').click(function() {
                    var p = $(this).parent().parent();
                    if (p.hasClass('active'))
                        p.removeClass('active');
                    else
                        p.addClass('active');
                });
                if (needCenter && data.data.length > 0) {
                    window.myMap.setCenter([data.data[0].l, data.data[0].d]);
                    window.myMap.container.fitToViewport();
                }
            }
        });
        //todo: ajax to get ballons of salons
//        if (needCenter) {
//            window.myMap.setCenter([pos.l, pos.d]);
//            window.myMap.container.fitToViewport();
//        }
    }

    /*function sethere(pos){
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
        var search = $('input[name=metro]').val();
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
        <?
    $city = '';
    if (isset($_SESSION['city']))
        $city = $_SESSION['city'];
    if (is_array($city))
        $city = $city['city'];
    ?>
        var city = "<?= !empty($city) ? $city : "Москва" ?>";
        ymaps.ready(function() {
            ymaps.geocode(city, { results: 1 }).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                window.myMap = new ymaps.Map("salonMap", {
                    center: firstGeoObject.geometry.getCoordinates(),
                    zoom: 16,
                    behaviors:['default', 'scrollZoom']
                });
                window.myMap.controls.add(
                    'smallZoomControl', { top: 5, left: 5 }
                );
                window.myMap.events.add('boundschange', function(event) {
                    //if (event.get('newZoom') != event.get('oldZoom')) {
                    //}
                    //if (event.get('newCenter') != event.get('oldCenter')) {
                    moveMap({l:event.get('newCenter')[0], d: event.get('newCenter')[1]});
                    //}
                });
                $('input[name=metro]').keydown(function() {
                    SOffset = 0;
                    initMap(true)
                });
                $('input[name=q]').keydown(function() {
                    SOffset = 0;
                    initMap(true)
                });
                $('.find-btn').click(function() {
                    initMap(true)
                });
                $('input[name=metro]').focusout(function() {initMap(true)});
                $('input[name=q]').focusout(function() {initMap(true)});
                $('input[name=startPrice]').on('change',function(){SOffset = 0;moveMap();});
                $('input[name=endPrice]').on('change',function(){SOffset = 0;moveMap();});
                $('#category').on('change',function(){SOffset = 0;moveMap();});
				$('.load-salons').click(function() {
					moveMap();
				});
                moveMap();
                <? if (isset($_REQUEST['mapview']) && $_REQUEST['mapview']) : ?> showMap (true); <? endif ?>
            });
        });
    });
/*	$(document).ready(function() {

		$('a.go-card').click(function() {
			var startPrice = $('input[name=startPrice]').val();
			var endPrice = $('input[name=endPrice]').val();
			var cat = $('input[name=category]').val();
			var q = $('input[name=q]').val();
			var address = $('input[name=metro]').val();
			location = '<?php echo Yii::app()->createUrl("site/findMap")?>?q='+q+'&address='+address+'&category='+cat+'&startPrice='+startPrice+'&endPrice='+endPrice;
		});


	});*/

    function showMap (big) {
      if (big && $("#smallmap-holder>#salonMap").length>0) {
        $('#bigmap-holder').append( $('#smallmap-holder>#salonMap') );
        $('#smallmap-holder').hide();
        $('#salonMap').height('450px');
        $('#bigmap-holder').show();
        window.myMap.container.fitToViewport();
      }
      if (!big && $("#bigmap-holder>#salonMap").length>0) {
        $('#smallmap-holder').append( $('#bigmap-holder>#salonMap') );
        $('#bigmap-holder').hide();
        $('#salonMap').height('270px');
        $('#smallmap-holder').show();
        window.myMap.container.fitToViewport();
      }
    }

</script>
<!-- BOF Content -->
<div class="container" style="margin-top: 28px">
  <div class="row">

    <div class="span5">
      <div class="well map" id="smallmap-holder">
        <div class="text-center"><button class="btn btn-success btn135" onclick="showMap(true)">На карте</button></div>
        <div id='salonMap' style="height: 270px; width:100%; margin-top: 15px;"></div>
      </div>


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


<? include dirname(__FILE__).'/includes/price_range.php' ?>

    </div>

    <div class="span11"><div style="padding-left: 0">

<? include dirname(__FILE__).'/includes/search_form.php' ?>

      <div id="bigmap-holder" class="well" style="display: none;">
        <a href="javascript:void(0)" onclick="showMap(false)">Свернуть карту</a>
      </div>

      <!-- BOF Salons -->
      <div class='salons-holder'>
    	<div class='found'></div>
      </div>
      <!-- EOF Salons -->


    </div></div>

  </div>
</div>
<!-- EOF Content -->
