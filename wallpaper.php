<?php
header('Content-Type: application/json');
function mycurl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;

}
$maqlo = $_GET['q'];
$url = "https://wall.alphacoders.com/search.php?search=".$maqlo;
$data = mycurl($url);
require 'simple_html_dom.php';
$html = new simple_html_dom();
$html->load($data);
//echo $data;die;
$gambar = $html->find('div[class=thumb-container-big ]');
foreach ($gambar as $key => $value) {
	$image = $value->find('img',0)->{'data-src'};
	$title = $value->find('a',0)->title;
	$results['status'] = 'success';
	$results['creator'] = 'Ami';
	$results['results'][] = array (
		'image' => str_replace('350','1920',$image), //image          
		'title' => $title //title
	);
}
echo json_encode($results, JSON_PRETTY_PRINT);
//var_dump($gambar);
//print_r($mmek);
