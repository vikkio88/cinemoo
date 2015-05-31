
function insertform(type){
	url="forms/"+type+".html";
	$.get(url,function(data){$("#"+type).html(data).fadeIn("quick",function(){$("#searchbar").focus();});});
}


function searchResult(query){
		url="circensis.php";
		$("#resp").css("height","400px").html("Loading...");
		$.get(url+"?q="+query,
			function(data){
				$("#resp").fadeIn("slow",function(){$("#resp").html(data);parseresp();});
			}
		);
}

function parseresp(){
	resp=$("#resp").html();
	if((resp.indexOf("<ul>"))==-1){
		//alert("no ul!");
		$("#resp").wrapInner("<strong class='filler' onclick='fillme($(this))'></strong>");
	}else{
		return;
	}
}

function selGraffe(){
		sel=$("#searchbar").getSelection();
		sel=((sel.end)-(sel.start));
		
		if(sel==0){
			$("#searchbar").setSelection($("#searchbar").val().indexOf("{"), ($("#searchbar").val().indexOf("}")+1)).focus();
			$("#searchbar").replaceSelectedText('');
		}
	//$("#searchbar").setSelection($("#searchbar").val().indexOf("{"),$("#searchbar").val().indexOf("}"));
}

function fillme(element){
	sel=$("#searchbar").getSelection()
	sel=((sel.start)-(sel.end));
		if(sel!=0){
			$("#searchbar").replaceSelectedText(element.html()).setSelection($("#searchbar").val().indexOf("{"), ($("#searchbar").val().indexOf("}")+1)).focus();
		}else{
			$("#searchbar").val($("#searchbar").val()+element.html()).focus();
		}
}

function fillertobar(value){
	alert(value);
	$("#searchbar").val(value);$("#searchbar").focus();
}
