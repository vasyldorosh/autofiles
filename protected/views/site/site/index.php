<?php
/* @var $this SiteController */

$theme = '/themes/newdes';

$this->pageTitle=Yii::app()->name;
?>
<link rel='stylesheet' href='./newsite/main.css' />
<link rel='stylesheet' href='./newsite/home-actions.css' />
<script src="/js/home-actions.js"></script>
<script src="/js/main.js"></script>
<script src="/site/js/main.js"></script>
<script src="//api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script>
  $(document).ready(function() {
    $('.block_btn').click(function() {$('#main_search_form').submit()});
  });
</script>

<!-- BOF SearchForm -->
<div id="search_wrapper">
  <div class="container" style="padding-top: 12px">
    <div class="row">
    <div class="span16">
      <div class="well ban_search">
      <a href="<?=Yii::app()->createUrl('page/view',array('id'=>6))?>"  style="height: 336px; width: 635px; position: absolute; top:0; right: 0; z-index: 10"><img src="<?=$theme?>/images/spacer.gif" style="height: 336px; width: 635px;"/></a>
        <a href="<?=Yii::app()->createUrl('page/view',array('id'=>6))?>" class="btn btn-danger input-large" style="position: absolute; bottom: 20px; right: 67px">Получить бонусы</a>
        <div id="search_block">
        <form role="form" class='girl'  action='index.php' id="main_search_form">
                <input type="hidden" name="r" value="site/find" id='goTo'>
      			<input type="hidden" id='long' name="long">
				<input type="hidden" id='lat' name="lat">
				<input type="hidden" name='category' value="[]" id='search-categories'>
                <input type="hidden" name="mapview" value="0" id='mapview'>
          <p class="lead" style="font-size: 20px">Мы дарим бонусы за красоту!</p>
          <div class="clearfix"><div class="well search_field">
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
                                'placeholder'=>'Услуга или название салона',
								'class' => 'col-md-10 col-xs-8 w280'
                            )
                        )
                    );?>
            <div class="block_btn"><img src="<?=$theme?>/images/btn_search.png" /></div>
          </div></div>
          <div class="clearfix"><div class="well search_field">
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
                                'class'=>'address col-md-10 col-xs-8 w280'
                            )
                        )
                    );?>
            <div class="block_btn"><img src="<?=$theme?>/images/btn_address.png" /></div>
          </div></div>
          <div class="text-right" style="width: 337px">
            <a class="find-on-map" href="#" style="font-size: 120%">На карте</a>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-success btn135" type="submit">Найти</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
<!-- EOF SearchForm -->

<br />
<!-- BOF Actions -->
<div class="container">

<?
  $offers_html = '';
  $offers = Offer::model()->findAll(array('condition' => 'is_home>0', 'order' => 'sort_order'));
  $offers_count = count($offers);
  $i = 0;
  $col_count = 3; //количество столбцов
  foreach ($offers as $offer) {
    $i++;
    $odd = $i%$col_count;
    $offers_html .= '
            <td class="' . ($odd==1 ? 'tbl_col_left' : 'tbl_col_right') . '">
              <div class="well inner_block action_block">
                <a href="' . Yii::app()->createUrl('site/action', array('id'=>$offer->id)) . '" class="action_link">
                  <p><span class="highlight">' . $offer->what . '</span><br />
                  В ' . ($offer->salon->type ? $offer->salon->type->title_genitive_case : '') . ' ' . $offer->salon->name . ' ' . $offer->present . '</p>
                  <img src="' . $offer->getThumb() .'" />
                </a>
                <table width="100%" style="margin-top: 15px"><tr>
                  <td class="tprice">' . $offer->cost . ' р.</td><td class="tdiscount">-' . $offer->discount . '%</td><td class="tgift"><div class="gift pull-right"><b>+' . ($offer->cost * 0.1) . '</b></div></td>
                </tr></table>
                <div style="margin-top: 12px;">
                  <div class="metro">' . ( $offer->salon->metros ? '<i class="metro-icon" style="background-color: ' . $offer->salon->metros[0]->color . ';"></i><span>' . $offer->salon->metros[0]->name : '') . '</span></div>&nbsp;<button class="btn btn-success pull-right">Подробнее</button>
                </div>
              </div>
            </td>
    ';

    if ($odd==1 && $i<$offers_count) $offers_html = '<tr>' . $offers_html;
    elseif ($odd && $i==$offers_count) $offers_html = '<tr>' . $offers_html . str_repeat('<td></td>', $col_count-$odd) . '</tr>';
    elseif (!$odd) $offers_html = $offers_html . '</tr>';
  }

?>

  <div class="row">
    <div class="span16">
      <div class="well" style="padding: 10px">
        <p class="text-center" style="font-size: 21px; font-weight: bold">Акции</p>
        <table width="100%" class="actions_table">
          <?=$offers_html?>
        </table>

        <div class="text-center" style="margin-top: 6px"><a href="<?=Yii::app()->createUrl('site/findAction',array('q'=>'', 'address'=>'', 'category'=>'[]', 'startPrice'=>0, 'endPrice'=>12000))?>" class="btn btn-info">Все акции</a></div>

      </div>
    </div>
  </div>
</div>
      <!-- EOF Actions -->

<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('#metro').autocomplete({'minLength':'3','showAnim':'fold','source':'/metro/complete'}).data("autocomplete")._renderItem = function( ul, item) {
    var mc = '';
    if (item.metroColor!==undefined) mc = '&nbsp;<i class="metro-icon" style="background-color: ' + item.metroColor + ';"></i>'
	return $( "<li>" + mc + "</li>" )
		.data( "item.autocomplete", item )
		.append( $( "<a style=\"display: inline-block\"></a>" ).html( item.label ) )
		.appendTo( ul );
};
});
/*]]>*/
</script>
