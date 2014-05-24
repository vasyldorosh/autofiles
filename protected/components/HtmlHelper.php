<?php
/**
 * Класс HtmlHelper
 * @author dorosh_2009@meta.ua
 * 
 * Помощник html
 */
class HtmlHelper
{
	
	public static function select($model, $parent, $child, $url)
	{
		$js = "$('#".get_class($model)."_".$parent."').change(function(e) {";
		$js.= 	"$('#".get_class($model)."_".$child."').empty();";
		$js.= 	"$('#".get_class($model)."_".$child."').append('<option value=\"\"></option>');";
		$js.= 	"$.post('".$url."', {'id': $(this).val()} , function(response) {";
		$js.= 		"$.each(response.items, function(value, lable){";
		$js.= 			"$('#".get_class($model)."_".$child."').append('<option value=\"'+value+'\">'+lable+'</option>');";
		$js.= 		"});";
		$js.= 	"}, 'json');";
		$js.= "});";
		
		return $js;	
	}
	
	public static function getYesNoFilter()
	{
		return array(
			1 => Yii::t('admin', 'Yes'),
			0 => Yii::t('admin', 'No'),
		);
	}
	
	public static function getYesNoValue($value)
	{
		$items = self::getYesNoFilter();
		if ($items[$value]) {
			return $items[$value];
		} else {
			return false;
		}
	}
}