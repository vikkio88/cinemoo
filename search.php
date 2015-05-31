<?php
	include_once('simplehtmldom/simple_html_dom.php');
	$q=str_replace(" ","+",$_GET['q']);
	//echo "http://it.wikipedia.org/w/index.php?title=Speciale:Ricerca&search=".$q."&fulltext=Search<br />";
	ini_set('user_agent', 'Mozilla/5.0 (Windows NT 5.1; rv:11.0) Gecko Firefox/11.0');
	//$q="matrix";
	//$r=file_get_contents("http://it.wikipedia.org/w/index.php?title=Speciale:Ricerca&limit=100&offset=0&redirs=0&profile=default&search=".$q."&fulltext=Search");
	$r=file_get_contents("http://it.wikipedia.org/w/index.php?search=".$q);
	$html=str_get_html($r);
	echo $html->innertext;
	$means=NULL;
	foreach($html->find("div.searchdidyoumean a") as $mean){
		$means=preg_replace('/<.+?>/','',$mean->innertext);
	}
	
	
	foreach($html->find('div.searchresults') as $div){
		$res=$div->innertext;
	}
	$html=str_get_html($res);
	$res=array();
	foreach($html->find('li') as $li){
		$li=$li->innertext;
		//echo "li: $li";
		//if(preg_match_all("/un film/",$li)){
			$res[]=$li;
		//}
	}
	if((count($res))>=1){
		foreach($res as $r){
			if(preg_match_all('/<a.+href="(.+?)"/',$r,$match)){
				echo "it.wikipedia.org".$match[1][0]."<br />";
			}
		}
	}else{
		echo "ciao: $means";
	}
	
?>
