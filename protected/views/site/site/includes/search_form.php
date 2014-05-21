<!-- BOF SearchForm -->
<script language="JavaScript" type="text/javascript">
  function setMode (mode) {
    if (!mode && $('#btn_actions').hasClass('btn-success btn-success-inv')) {
      showModeBtn(mode);
      var startPrice = $('input[name=startPrice]').val();
	  var endPrice = $('input[name=endPrice]').val();
	  var cat = $('input[name=category]').val();
	  var q = $('input[name=q]').val();
	  var address = $('input[name=metro]').val();
	  location = '<?php echo Yii::app()->createUrl("site/find")?>?q='+q+'&address='+address+'&category='+cat+'&startPrice='+startPrice+'&endPrice='+endPrice;
    }
    if (mode && $('#btn_saloon').hasClass('btn-success btn-success-inv')) {
      showModeBtn(mode);
      var startPrice = $('input[name=startPrice]').val();
	  var endPrice = $('input[name=endPrice]').val();
	  var cat = $('input[name=category]').val();
	  var q = $('input[name=q]').val();
	  var address = $('input[name=metro]').val();
	  location = '<?php echo Yii::app()->createUrl("site/findAction")?>?q='+q+'&address='+address+'&category='+cat+'&startPrice='+startPrice+'&endPrice='+endPrice;
    }
  }

  function showModeBtn (mode) {
    if (mode) {
      $('#btn_saloon').removeClass('btn-success btn-success-inv');
      $('#btn_actions').addClass('btn-success btn-success-inv');
    } else {
      $('#btn_actions').removeClass('btn-success btn-success-inv');
      $('#btn_saloon').addClass('btn-success btn-success-inv');
    }
  }

  $(document).ready(function() {
    showModeBtn (CURRENT_MODE);
  });
</script>

      <div class="well">

        <form class="form-inline" action="index.php" >
<input type="hidden" name="r" value="site/find" id='goTo'>
<input type="hidden" id='startPrice' name="startPrice" value="<?= $startPrice?>">
<input type="hidden" id='endPrice' name="endPrice" value="<?= $endPrice?>">
<input type="hidden" name="category" value="[]" id='category'>
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
								'class'=>'col-md-5 w196',
                                'placeholder'=>'Услуга или название салона'
                            ),
                            'value'=> $q
                        )
          );?>&nbsp;&nbsp;
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
                            'class'=>'address col-md-5 w196'
                        ),
                        'value'=> $metro
                    )
          );?>&nbsp;&nbsp;
          <button type="submit" class="btn btn-success btn135 pull-right find-btn">Найти</button>
        </form>

        <div>
          <a href="<?=Yii::app()->createUrl('page/view',array('id'=>6))?>" class="btn btn-danger input-large" style="width:224px">Получить бонусы</a>
          <div class="btn-group pull-right">
            <button class="btn" style="width: 85px" id="btn_saloon" onclick="setMode(0)">Салоны</button>
            <button class="btn" style="width: 85px" id="btn_actions" onclick="setMode(1)">Акции</button>
          </div>
        </div>

      </div>
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
<!-- EOF SearchForm -->