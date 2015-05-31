<?php
	include_once('simplehtmldom/simple_html_dom.php');
	/*/
	$ac=$_POST['a'];
	$f=$_POST['f'];
	$ch=(int) $_POST['ch'];
	//*/
	$ac=str_replace('_',' ',$_GET['a']);
	$f=str_replace('_','',$_GET['f']);
	$ch=(int)$_GET['ch'];
	//*/

	function myprintr($a){
		echo "<pre>";
		print_r($a);
		echo "</pre>";
		
	}
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
	
	/*echo "match:<br /><pre>";
	print_r($pers);
	print_r($att);
	echo "</pre><hr /><br /><br />";*/
	/*$found=array_search($ac,$pers);*/
	$found=-1;
	
	
	if(!$ch){
		
		if($ac!="protagonista"){
			$i=0;
			foreach($pers as $per){
				if(preg_match('/'.$ac.'/i',$per)){
					$found=$i;
					break;
				}
				$i++;
			}
		}else{
			$found=0;
		}
	}else{
		$i=0;
		foreach($att as $per){
			if(preg_match('/'.$ac.'/',$per)){
				$found=$i;
				break;
			}
			$i++;
		}
	}
	
	if(!($found==(-1))){
		//echo "<strong>$ac</strong> nel film <strong>$f</strong> recitava nel ruolo di <strong>".$att[$found]."</strong><br />";
		if(!$ch)
			echo "<strong class='filler' onclick='fillme($(this))'>".$att[$found]."</strong>";
		else
			echo "<strong class='filler' onclick='fillme($(this))'>".$pers[$found]."</strong>";
	}else{
		//echo "<strong>$ac</strong> (probabilmente) non ha recitato nel film <strong>$f</strong><br />";
		echo "<h4>$ac non ha recitato nel film $f</h4>";
	}

?>
