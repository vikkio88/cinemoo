<?php
	include_once('simplehtmldom/simple_html_dom.php');
	
	$f=str_replace('_','',$_GET['f']);
	
	function cleantext($t){
		//$t=str_replace(' ','',$t);
		$t=str_replace('.','',$t);
		return $t;
	}


	$suca=file_get_html('wiki/films/'.$f.".htm");
	$suca=$suca->innertext;
	preg_match_all('/<th.+Interpreti<\/a>(.+?)<\/ul>/',$suca,$m);
	
/*	echo "iniziale:<br />";
	//myprintr($m);
	//echo $m[1][0];
	echo "<hr /><br /><br />";
/*
$suca=cleantext($suca);

*/
	$suca=str_get_html($m[1][0]);
	$pers=array();
	$att=array();
	foreach($suca->find('li') as $li){
		$li=preg_replace('/<.+?>/','',$li->innertext);
		//$li=str_replace(':','$',$li);
	//	echo "li: ".$li."<br />";
	
		preg_match_all('/(.+?): .+/',$li,$b);
		//echo "secondomatch: ".$b[1][0]."<br />";
		//myprintr($b);
		$res=cleantext($b[1][0]);
		$att[]=$res;
	
		preg_match_all('/.+: (.+)/',$li,$a);
		//echo "primomatch: ".$a[1][0]."<br />";
		//myprintr($a);
		$pers[]=$a[1][0];
		

	}
	
	echo "<ul class='response'>";
	$i=0;
	foreach($att as $ac){
		echo "<li><strong class='filler' onclick='fillme($(this))'>$ac</strong> nel ruolo di <strong>".($pers[$i]).'</strong></li>';
		$i++;
	}
	echo "</ul>";
	

?>
