  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="INVESTOCK02X-AKSES.php";
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
        ambilviewopna('Y');

      }
      else
      {
        ambilviewopna('N');

      }
    }
  }
// end periksa akses  


// Tampilkan Tabel Request 
var drz;
function ambilviewopna(opnastat)
{
  drz = buatajaxviewrequ();
  var url="INVESTOCK02V.php";
  drz.onreadystatechange=stateChangedviewrequ;
  var params = "q="+opnastat;
  //alert(params);
  drz.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  //}
} 

  function buatajaxviewrequ()
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

function stateChangedviewrequ()
{
  var datapost;
  if (drz.readyState==4 && drz.status==200)
  {
  datapost=drz.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tblviewopna").innerHTML = datapost;
    document.getElementById("tblviewopna").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewopna").innerHTML = "";
    document.getElementById("tblviewopna").style.visibility = "hidden";
    }
  }
}

// Approve Request 
var approveku;
function adjustment(opnacode)
  {
    approveku = buatajaxapprove();
    var url="INVESTOCK02U-APP.php";
    approveku.onreadystatechange=stateChangedapprove;
    var params = "q="+opnacode;
    approveku.open("POST",url,true);
    approveku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    approveku.setRequestHeader("Content-length", params.length);
    approveku.setRequestHeader("Connection", "close");
    approveku.send(params);
  }

function buatajaxapprove()
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

function stateChangedapprove()
  {
  var data;
  if (approveku.readyState==4)
    {
        ambilviewopna('Y');
    }
  }

// UnApprove Request 
var unapproveku;
function unadjustment(opnacode)
  {
    unapproveku = buatajaxunapprove();
    var url="INVESTOCK02U-UNAPP.php";
    unapproveku.onreadystatechange=stateChangedunapprove;
    var params = "q="+opnacode;
    unapproveku.open("POST",url,true);
    unapproveku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    unapproveku.setRequestHeader("Content-length", params.length);
    unapproveku.setRequestHeader("Connection", "close");
    unapproveku.send(params);
  }

function buatajaxunapprove()
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

function stateChangedunapprove()
  {
  var data;
  if (unapproveku.readyState==4)
    {
        ambilviewopna('Y');
    }
  }

