<?php

class Myclass{

public $file_content;
	
public function __construct(){
		$file_content='';
	}
	
public function get_content($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		$file_content = curl_exec($ch);
		curl_close($ch);
		
		return $file_content ;
	}

}

$objMyclass = new Myclass();

$str =   ($objMyclass->get_content("http://testing.moacreative.com/job_interview/php/index.html"));

$str = preg_replace('/^\s+|\n|\r|\s+$/m', '', $str);

preg_match( "/\<div class=\"movie-list\"\>(.*?)\<\/div\>\<\/body\>/",$str, $byname );

preg_match_all( "/\<div.*?>(.*?)\<\/div\>/", $byname[0], $moviedata );

$a_moviedata = $moviedata[0];
$count=1;

$data = Array();


foreach($a_moviedata as $am){

preg_match( "/\<a class=\"title\"(.*?)\>(.*?)\<a\>\<div class=\"synopsis\"\>/",$am, $title );

$title = preg_replace( "/<.*?>/", "", $title[0] );

preg_match( "/\<div class=\"synopsis\"\>(.*?)\<\/div\>/",$am, $synopsis );
$synopsis = preg_replace( "/<.*?>/", "", $synopsis[0] );

preg_match( "/\<img src=\"(.*?)\" \/\>/",$am, $img );
$img =str_replace( "<img src=\"", "", $img[0] );
$img =str_replace( "\" />", "", $img );


$data [] = Array(
	'ItemId' => $count,
	
	'Title' => $title,
	'Items' => Array(Array(
			'ItemId' => $count.'1', 	'Title'=>"<p><img class = 'mythumbnail' src='".$img."' /></p><p>".$synopsis."</p>")),

	'Selected' => false,
	'HasSubItem' => "true"
		
);
$count++;

}
$json_data = json_encode($data);

$myfile = fopen("C:\\xampp\htdocs\moa\movie.json", "w") or die("Unable to open file!");
fwrite($myfile, $json_data);
fclose($myfile);


?>
<p><a href="index.html">Index</a></p>