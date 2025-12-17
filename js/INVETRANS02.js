  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="INVETRANS02X-AKSES.php";
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
        ambilviewrequ('Y');

      }
      else
      {
        ambilviewrequ('N');

      }
    }
  }
// end periksa akses  


// Tampilkan Tabel Request 
var drz;
function ambilviewrequ(requstat)
{
  drz = buatajaxviewrequ();
  var url="INVETRANS02V.php";
  drz.onreadystatechange=stateChangedviewrequ;
  var params = "q="+requstat;
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
    document.getElementById("tblviewrequ").innerHTML = datapost;
    document.getElementById("tblviewrequ").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewrequ").innerHTML = "";
    document.getElementById("tblviewrequ").style.visibility = "hidden";
    }
  }
}

// Approve Request 
var approveku;
function approverequest(requcode)
  {
    approveku = buatajaxapprove();
    var url="INVETRANS02U-APP.php";
    approveku.onreadystatechange=stateChangedapprove;
    var params = "q="+requcode;
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
        ambilviewrequ('Y');
    }
  }

// UnApprove Request 
var unapproveku;
function unapproverequest(requcode)
  {
    unapproveku = buatajaxunapprove();
    var url="INVETRANS02U-UNAPP.php";
    unapproveku.onreadystatechange=stateChangedunapprove;
    var params = "q="+requcode;
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
        ambilviewrequ('Y');
    }
  }

// Reject Request 
var rejectku;
function rejectrequest(requcode)
  {
    rejectku = buatajaxreject();
    var url="INVETRANS02U-REJ.php";
    rejectku.onreadystatechange=stateChangedreject;
    var params = "q="+requcode;
    rejectku.open("POST",url,true);
    rejectku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    rejectku.setRequestHeader("Content-length", params.length);
    rejectku.setRequestHeader("Connection", "close");
    rejectku.send(params);
  }

function buatajaxreject()
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

function stateChangedreject()
  {
  var data;
  if (rejectku.readyState==4)
    {
        ambilviewrequ('Y');
    }
  }

// UnReject Request 
var unrejectku;
function unrejectrequest(requcode)
  {
    unrejectku = buatajaxunreject();
    var url="INVETRANS02U-UNREJ.php";
    unrejectku.onreadystatechange=stateChangedunreject;
    var params = "q="+requcode;
    unrejectku.open("POST",url,true);
    unrejectku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    unrejectku.setRequestHeader("Content-length", params.length);
    unrejectku.setRequestHeader("Connection", "close");
    unrejectku.send(params);
  }

function buatajaxunreject()
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

function stateChangedunreject()
  {
  var data;
  if (unrejectku.readyState==4)
    {
        ambilviewrequ('Y');
    }
  }
