<?php
	include_once('simplehtmldom/simple_html_dom.php');
	
	$f=str_replace('_','',$_GET['f']);
	/*$f="Matrix";*/
	
	function cleantext($t){
		//$t=str_replace(' ','',$t);
		$t=str_replace('.','',$t);
		return $t;
	}


	$suca=file_get_html('wiki/films/'.$f.".htm");
	$suca=$suca->innertext;
	preg_match_all('/<span id="Trama">Trama<\/span><\/h2>(.+?)Chiudi questa sezione<\/a><\/div>/',$suca,$m);
	

	$suca=str_get_html($m[1][0]);
	/*$suca=preg_replace('/<.+?>/','',$suca);*/
	echo "<ul></ul>".$suca;

?>
