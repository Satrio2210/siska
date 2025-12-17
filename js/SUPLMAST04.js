  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="SUPLMAST01X-AKSES.php";
    aksesku.onreadystatechange=stateChangedAkses;
    var params = "q="+fieldid;
    //alert('Parameter adalah '+fieldid);
    aksesku.open("POST",url,true);
    aksesku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    aksesku.setRequestHeader("Content-length", params.length);
    aksesku.setRequestHeader("Connection", "close");
    aksesku.send(params);

  }

  function buatajaxakses()
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

  function stateChangedAkses()
  {
  var data;
  if (aksesku.readyState==4)
    {

    xdata=aksesku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
          document.getElementById('txtmastcode').focus(); ambilviewid('');

      }
      else
      {
          document.getElementById('txtmastcode').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


var asr;
function ambilviewid(kata)
{
  if(kata.length > 13)
  {
  document.getElementById("tblviewid").style.visibility = "hidden";
  }
  else
  {
  asr = buatajaxviewid();
  var url="SUPLMAST04V.php";
  asr.onreadystatechange=stateChangedviewid;
  var params = "q="+kata;
  asr.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  asr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  asr.setRequestHeader("Content-length", params.length);
  asr.setRequestHeader("Connection", "close");
  asr.send(params);
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
  if (asr.readyState==4 && asr.status==200)
  {
  datapost=asr.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tblviewid").innerHTML = datapost;
    document.getElementById("tblviewid").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewid").innerHTML = "";
    document.getElementById("tblviewid").style.visibility = "hidden";
    }
  }
}
