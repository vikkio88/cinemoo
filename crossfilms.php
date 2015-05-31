<?php
	include_once('simplehtmldom/simple_html_dom.php');
	/*/
	
	$a='CarloVerdone';$b='MargheritaBuy';
	
	/*/
	
	$a=str_replace('_','',$_GET['a']);$b=str_replace('_','',$_GET['b']);
	
	//*/
	
	function getFilms($page){
		
		$cinema=FALSE;
		//echo $page;
		$html = file_get_html($page);
		$html=$html->innertext;
		$match=array();
		$match1=array();
		if(!(preg_match_all('/>Filmografia(.*?)<\/div>/m',$html,$match))){
			$cinema=TRUE;
			preg_match_all('/>Cinema(.*?)<\/ul>/m',$html,$match);
		}
		if ((preg_match_all('/>Attore(.*?)<\/ul>/m',($match[1][0]),$match1))or(preg_match_all('/>Attrice(.*?)<\/ul>/m',($match[1][0]),$match1))){
			//echo "attore est";
			$match=$match1;
			//echo $match1[1][0];
		}else{
//		echo "caso2";
			if(!$cinema)
				preg_match_all('/>Filmografia(.*?)<\/ul>/m',$html,$match);
		}
		
		$match=$match[1][0];
		$html=str_get_html($match);
//		echo $html->innertext;
		
		$films=array();
		foreach($html->find('li') as $li){
			$films[]=$li->innertext;
		}

		return $films;
	}
	
	function intersect($f1,$f2){
		$i=0;
		$is=array();
		foreach($f1 as $f1a){
			$f1a=cleantext($f1a);
			foreach($f2 as $f2a){
				$f2a=(cleantext($f2a));
				//echo "$f1a == $f2a ==> ".((int) preg_match('/'.$f1a.'/',$f2a))."<br />";
				//if(preg_match('/'.$f1a.'/',$f2a)){
				if($f1a==$f2a){
					$is[]=$i;
				}
			}
			$i++;
		}
		$ret=array();
		foreach($is as $i){
			$ret[]=$f1[$i];
		}
		return $ret;
	}
	
	function cleantext($str){
		/*$str=preg_replace('/<.+?>/','',$str);
		//$str=preg_replace('/<\/.+>/','',$str);*/
		preg_match_all('/title="(.*?)"/',$str,$m);
		$str=$m[1][0];
		$str=str_replace(':','',$str);
		$str=str_replace('II','2',$str);
		$str=str_replace('III','3',$str);
		$str=str_replace('IV','4',$str);
		$str=str_replace('V','5',$str);
		$str=str_replace('VI','6',$str);
		$str=str_replace('VII','7',$str);
		
		//$str=str_replace(',','',$str);
		$str=str_replace('.','',$str);
		$str=str_replace("\''",'',$str);
		//$str=str_replace('(','',$str);
		//$str=str_replace(')','',$str);
		$str=str_replace('!','',$str);
		$str=str_replace('?','',$str);
		$str=str_replace('-','',$str);
		$str=str_replace('&','',$str);
		$str=strtolower($str);
		/*preg_match_all('/title="(.*?)"/',$str,$m);
		$str=$m[1][0];*/
		$str=preg_replace('/\s/','',$str);
		return $str;
	}
	if($a!=$b){
		$filmatt1=getFilms("wiki/attori/".$a.'.htm');
		$filmatt2=getFilms("wiki/attori/".$b.'.htm');
		$inter=intersect($filmatt1,$filmatt2);
		if(count($inter)>0) echo "<h4>film in comune tra <i>$a</i> e <i>$b</i></h4>";
	}else{
		echo "<h4>filmografia di <i>$a</i></h4>";
		$inter=getFilms("wiki/attori/".$a.'.htm');
	}
	
	//echo "<h4>Film in comune tra <i>$a</i> e <i>$b</i></h2><pre>";
	if(count($inter)<=0){
		echo "<h4>Nessun film in comune tra $a e $b</h4>";
	}else{
		
		echo "<ul class='response'>";
		foreach($inter as $i){
			$i=str_replace('m.','',$i);
			echo "<li>$i</li>";
		}
		echo "</ul>";
	}
	//print_r($filmatt1);
	//echo "</pre>";
	
?>
