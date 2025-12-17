var drz;
function ambilcompscreen(kata)
{
	if(kata.length == 20)
	{
	document.getElementById("tblcompscreen").style.visibility =	"hidden";
	}
	else
	{
	drz = buatajaxcompscreen();
	var url="compscreen.php";
	drz.onreadystatechange=stateChangedcompscreen;
	var params = "q="+kata;
	drz.open("POST",url,true);
	//beberapa http header harus kita set kalau menggunakan POST
	drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	drz.setRequestHeader("Content-length", params.length);
	drz.setRequestHeader("Connection", "close");
	drz.send(params);
	}
} 
function buatajaxcompscreen()
{
	if (window.XMLHttpRequest)
	{
	return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{
	return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

function stateChangedcompscreen()
{
	var datapost;
	if (drz.readyState==4 && drz.status==200)
	{
	datapost=drz.responseText;
		if(datapost.length>0)
		{
		document.getElementById("tblcompscreen").innerHTML = datapost;
		document.getElementById("tblcompscreen").style.visibility = "";
		}
		else	
		{
		document.getElementById("tblcompscreen").innerHTML = "";
		document.getElementById("tblcompscreen").style.visibility = "hidden";
		}
	}
}

function isicompscreen(kata)
{
	document.getElementById("txtbankname").value = kata;
	document.getElementById("tblcompscreen").style.visibility = "hidden";
	document.getElementById("tblcompscreen").innerHTML = "";
	document.getElementById("txtbankname").focus();
}
