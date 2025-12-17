  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAVEND01X-AKSES.php";
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
        ambilviewvend('Y');

      }
      else
      {
        ambilviewvend('N');

      }
    }
  }
// end periksa akses  


// Tampilkan Tabel Request 
var drz;
function ambilviewvend(vendstat)
{
  drz = buatajaxviewvend();
  var url="TRXAVEND02V.php";
  drz.onreadystatechange=stateChangedviewvend;
  var params = "q="+vendstat;
  //alert(params);
  drz.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  //}
} 

  function buatajaxviewvend()
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

function stateChangedviewvend()
{
  var datapost;
  if (drz.readyState==4 && drz.status==200)
  {
  datapost=drz.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tblviewvend").innerHTML = datapost;
    document.getElementById("tblviewvend").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewvend").innerHTML = "";
    document.getElementById("tblviewvend").style.visibility = "hidden";
    }
  }
}

// Approve Request 
var approveku;
function approverequest(vendcode)
  {
    approveku = buatajaxapprove();
    var url="TRXAVEND02U-APP.php";
    approveku.onreadystatechange=stateChangedapprove;
    var params = "q="+vendcode;
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
        ambilviewvend('Y');
    }
  }

// UnApprove Request 
var unapproveku;
function unapproverequest(vendcode)
  {
    unapproveku = buatajaxunapprove();
    var url="TRXAVEND02U-UNAPP.php";
    unapproveku.onreadystatechange=stateChangedunapprove;
    var params = "q="+vendcode;
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
        ambilviewvend('Y');
    }
  }

// Reject Request 
var rejectku;
function rejectrequest(vendcode)
  {
    rejectku = buatajaxreject();
    var url="TRXAVEND02U-REJ.php";
    rejectku.onreadystatechange=stateChangedreject;
    var params = "q="+vendcode;
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
        ambilviewvend('Y');
    }
  }

// UnReject Request 
var unrejectku;
function unrejectrequest(vendcode)
  {
    unrejectku = buatajaxunreject();
    var url="TRXAVEND02U-UNREJ.php";
    unrejectku.onreadystatechange=stateChangedunreject;
    var params = "q="+vendcode;
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
        ambilviewvend('Y');
    }
  }
