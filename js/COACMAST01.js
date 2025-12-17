  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="COACMAST01X-AKSES.php";
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
        document.getElementById('txtmastprnt').focus();
        document.getElementById('txtmastcode').setAttribute('disabled','true');      
      }
      else
      {
        document.getElementById('txtmastprnt').setAttribute('disabled','true');
        document.getElementById('txtmastcode').setAttribute('disabled','true');
        document.getElementById('txtmastname').setAttribute('disabled','true');      
        document.getElementById('optmastcosg').setAttribute('disabled','true');
        document.getElementById('optparent').setAttribute('disabled','true');
        document.getElementById('optchild').setAttribute('disabled','true');
        document.getElementById('optdebit').setAttribute('disabled','true');
        document.getElementById('optcredit').setAttribute('disabled','true');
        document.getElementById('optbs').setAttribute('disabled','true');
        document.getElementById('optpl').setAttribute('disabled','true');
        document.getElementById('txtmastnote').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


// ambil Kelompok Akun Code dari tabel tblacoac
var coacku;
function ambilcoaccode(coaccode)
{
  if(coaccode.length > 4)
  {
  document.getElementById("tblcoac").style.visibility = "hidden";
  }
  else
  {
  coacku = buatajaxcoaccode();
  var url="COACMAST01C.php";
  coacku.onreadystatechange=stateChangedcoaccode;
  var params = "q="+coaccode;
  coacku.open("POST",url,true);
  coacku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  coacku.setRequestHeader("Content-length", params.length);
  coacku.setRequestHeader("Connection", "close");
  coacku.send(params);
  }
} 
function buatajaxcoaccode()
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

function stateChangedcoaccode()
{
  var data;
  if (coacku.readyState==4 && coacku.status==200)
  {
  data=coacku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblcoac").innerHTML = data;
    document.getElementById("tblcoac").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblcoac").innerHTML = "";
    document.getElementById("tblcoac").style.visibility = "hidden";
    }
  }
}

function isicoaccode(tblacoaccode,tblacoacname)
{
  document.getElementById("txtmastprnt").value = tblacoacname;
  document.getElementById("hidmastprnt").value = tblacoaccode;
  document.getElementById("txtprntcode").value = tblacoaccode;
  document.getElementById("txtmastcode").removeAttribute('disabled');
  document.getElementById("txtmastcode").focus();
  document.getElementById("tblcoac").style.visibility = "hidden";
  document.getElementById("tblcoac").innerHTML = "";

}

var ajaxmastcode
function periksamastcode(inmastprnt,inmastcode)
{
  try 
  {
    ajaxmastcode = buatajaxmastcode();
    var url="COACMAST01X.php";
    ajaxmastcode.onreadystatechange=stateChangedMastcode;
    var params = "q="+inmastprnt+"|"+inmastcode;
    //alert(params);
    ajaxmastcode.open("POST",url,true);
    ajaxmastcode.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxmastcode.setRequestHeader("Content-length", params.length);
    ajaxmastcode.setRequestHeader("Connection", "close");
    ajaxmastcode.send(params);

  } 
  catch(err){ alert(err.message); }
}

  function buatajaxmastcode()
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

  function stateChangedMastcode()
  {
  var data;
  if (ajaxmastcode.readyState==4)
    {
    xdata=ajaxmastcode.responseText;
    data=xdata.trim();
    if(data.length>1)
      {
        //alert(xdata);
        document.getElementById('labelmessage').style.visibility = '';
        document.getElementById('txtmastcode').focus();                 
      }
      else
      {
        //alert(xdata);
        document.getElementById('labelmessage').style.visibility = 'hidden';
        document.getElementById('txtmastname').focus();
      }
    }
  }

