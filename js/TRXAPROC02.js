  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPROC02X-AKSES.php";
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
        ambilviewpo(document.getElementById('hiduserid').value);      
      }
      else
      {
        ambilviewpo('x');
      }
    }
  }
// end periksa akses  

// Tampilkan Tabel Purchasing Order
var drz;
function ambilviewpo(userid)
{
  drz = buatajaxviewpo();
  var url="TRXAPROC02V.php";
  drz.onreadystatechange=stateChangedviewpo;
  var params = "q="+userid;
  //alert(params);
  drz.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  //}
} 

  function buatajaxviewpo()
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

function stateChangedviewpo()
{
  var datapost;
  if (drz.readyState==4 && drz.status==200)
  {
  datapost=drz.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tblviewpo").innerHTML = datapost;
    document.getElementById("tblviewpo").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewpo").innerHTML = "";
    document.getElementById("tblviewpo").style.visibility = "hidden";
    }
  }
}

// Cancel PO 
var formku;
function cancelpo(nomorpo)
  {
    formku = buatajaxpo();
    var url="TRXAPROC02D.php";
    formku.onreadystatechange=stateChangedpo;
    var params = "q="+nomorpo;
    formku.open("POST",url,true);
    formku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    formku.setRequestHeader("Content-length", params.length);
    formku.setRequestHeader("Connection", "close");
    formku.send(params);
  }

function buatajaxpo()
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

function stateChangedpo()
  {
  var data;
  if (formku.readyState==4 && formku.status==200)
  {
  xdata=formku.responseText;
  data = xdata.trim();
    if(data.length>3)
    {   

        //alert(data);
        //var res = data.split("|");
        ambilviewpo(data);
      }
      else
      {
        //alert('no data');
        ambilviewpo(document.getElementById('hiduserid').value);
      }
    }
  }
