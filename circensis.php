<?php

include_once('simplehtmldom/simple_html_dom.php');

	function parsequery($q){
	/*	
	 * ROBA MALVAGIA RICORSIVA PER PARSARE DOPPIE QUERY
	 */
		$resp=NULL;
		
		if(!((strpos($q,'film con '))===FALSE)){
			//echo "trovata X amigo";
			preg_match_all('/film con (.+?) e (.+)/',$q,$a);
			$sx=$a[1][0];
			$dx=$a[2][0];
			$sx=parsequery($sx);
			$dx=parsequery($dx);
			$resp=incrocio($sx,$dx);
			return $resp;
		}
		if(preg_match_all("/attori nel film (.+)/i",$q,$x)){
			$resp=attoriperfilm($x[1][0]);
			return $resp;
		}
	
		if(!((strpos($q,'('))===FALSE)){
			preg_match_all('/\((.+?)\)/',$q,$m);
			$subq=$m[1][0];
			$resp=parsequery($subq);
			$q=str_replace('('.$subq.')',$resp,$q);
			$resp=parsequery($q);
			//return $resp;
		}
		
		if(preg_match_all('/(.+?) nel film (.+)/',$q,$c)){
			$resp=perstoact($c[1][0],$c[2][0]);
			//return $resp;
		}
		
		if(preg_match_all('/trama del film (.+)/i',$q,$c1)){
			$resp=tramafilm($c1[1][0]);
			return $resp;
		}
		
		if(preg_match_all('/Film di (.+)/i',$q,$d)){
			$resp=filmografia($d[1][0]);
			//return $resp;
		}
		
		if($resp==NULL) $resp=$q;
		return $resp;
	}
	
	function attoriperfilm($f){
		$f=str_replace(' ','_',$f);
		$query='http://localhost/cinemoo/actorperfilm.php?f='.$f;
		$html=file_get_contents($query);
		return $html;
	}
	
	function tramafilm($f){
		$f=str_replace(' ','_',$f);
		$query='http://localhost/cinemoo/tramafilm.php?f='.$f;
		$html=file_get_contents($query);
		return $html;
	}
	
	function incrocio($sx,$dx){
		$sx=str_replace(' ','_',$sx);
		$dx=str_replace(' ','_',$dx);
		$query='http://localhost/cinemoo/crossfilms.php?a='.$sx.'&b='.$dx;
		//echo $query."<br />";
		$html=file_get_contents($query);
		//echo $html."<br />";
		return $html;
	}
	
	function filmografia($a){
		$a=str_replace(' ','_',$a);
		$query='http://localhost/cinemoo/crossfilms.php?a='.$a.'&b='.$a;
		//echo $query."<br />";
		$html=file_get_contents($query);
		//echo $html."<br />";
		return $html;
	}
	
	function perstoact($a,$f){
		$a=str_replace(' ','_',$a);
		$f=str_replace(' ','_',$f);
		$query='http://localhost/cinemoo/charactorfilm.php?a='.$a.'&f='.$f;
		//echo $query."<br />";
		$html=file_get_contents($query);
		//echo $html."<br />";
		return $html;
	}
	


	//$q=$_POST['q'];
	$q=$_GET['q'];
	
	//$q="trama del film Matrix";
	if(isset($_GET['q'])){
		if($q[0]==' '){
			$q=trim($q);
		}
		$resp=parsequery($q);
	}
		if ($resp!=$q){
			echo $resp;
		}else{
			echo "Query non riconosciuta dal sistema";
		}
?>

