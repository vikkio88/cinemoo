<?php

include_once('simplehtmldom/simple_html_dom.php');


function ls($pattern="*", $folder="", $recursivly=false) {
		//this is a private function that copy the UNIX 'ls' functionality
		//***thanks a lot to me cause the old ls function does not works on php5 with safemode on
	$list=array();
	
		if ($handle = opendir($folder)) {
	
			while (false !== ($file = readdir($handle))) {
	
				if ($file != "." && $file != "..") {
					array_push($list,$file);
				}
	
			}
		
			closedir($handle);
		}
	//readdr return list of file completly random order, maybe ordered by weight
	//with this simple function Dblister object order things ASC
	array_multisort($list,SORT_ASC,SORT_NUMERIC);
	
	return $list;
}
?> 
<html>
<head>
	<title>CineMoo</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/scripts.js" type="text/javascript"></script>
	<script src="js/textinputs_jquery.js" type="text/javascript"></script>
	<link href="template/template.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="centermain">
		<?php 
			$listaloghi=ls("*.png","img/speciali/");
			shuffle($listaloghi);
			echo "<img id='mainlogo' src='img/speciali/".($listaloghi[0])."' />";
		?>
	
	<div id="search">
		
		<form style="margin:auto" action="javascript:searchResult($('#searchbar').val())">
			<input id="searchbar" class="searchbox" type="textbox" size="80" autocomplete="off"/>
		</form>
		
		<div id="actor"><img class="button" src="img/logo/actor.png" onclick="insertform('actor')" /></div> <div id="movie"><img class="button" src="img/logo/movie.png" onclick="insertform('movie')"/></div>
	</div>
	<div id="resp">
	</div>
	<div id="cloud">
		<h3>Ricerche Frequenti</h3>
		<span class="filler">Film di Samuel L Jackson</span>
		<span class="filler">attori nel film Pulp Fiction</span> <span class="filler">film di Keanu Reeves</span> <span class="filler">film di (Neo nel film Matrix)</span> <span class="filler">attori nel film Matrix</span>
		<span class="filler">attori nel film Men in Black</span> <span class="filler">attori nel film Contact</span> <span class="filler">film con Ben Stiller e Jack Black</span>
	</div>
</div>
<script type="text/javascript">
	$("#searchbar").focus();
	$("#searchbar").keydown(function(e){
								if(e.keyCode==39){
									if(($("#searchbar").val().indexOf('{')) != -1 ){ 
										selGraffe();
									}
								}
							});
	$(".filler").click(
		function(){
			$("#searchbar").val($(this).html());$("#searchbar").focus();
		}
	);
	
	$("#resp a").click(
		function(){
			alert("cliccato");
		}
	);
</script>
</body>

</html>
