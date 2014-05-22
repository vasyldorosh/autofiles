<?php
class CUrlHelper
{
	public static function getPage($url, $ref='', $post='', $cookiefile='cookie.txt')
	{
		if (is_array($post)) $post = http_build_query($post);    echo $post;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		// откуда пришли на эту страницу
		if (!$ref) $ref=$url;
		curl_setopt($ch, CURLOPT_REFERER, $ref);
		if ($post) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}

		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		//отсылаем серверу COOKIE полученные от него при авторизации
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.0; rv:26.0) Gecko/20100101 Firefox/26.0");
		// не проверять SSL сертификат
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// не проверять Host SSL сертификата
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// это необходимо, чтобы cURL не высылал заголовок на ожидание
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		curl_setopt($ch, CURLOPT_HEADER, 0);

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}		
}