

var drz;
function ambilviewid(kata)
{
  if(kata.length > 13)
  {
  document.getElementById("tblviewdata").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxviewid();
  var url="VIEWINVE.php";
  drz.onreadystatechange=stateChangedviewid;
  var params = "q="+kata;
  drz.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  }
} 

  function buatajaxviewid()
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

function stateChangedviewid()
{
  var datapost;
  if (drz.readyState==4 && drz.status==200)
  {
  datapost=drz.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tblviewdata").innerHTML = datapost;
    document.getElementById("tblviewdata").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewdata").innerHTML = "";
    document.getElementById("tblviewdata").style.visibility = "hidden";
    }
  }
}


