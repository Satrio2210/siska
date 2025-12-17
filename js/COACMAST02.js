  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="COACMAST02X-AKSES.php";
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
  var url="COACMAST02C.php";
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
    var url="COACMAST02X.php";
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
    if(data.length>5)
      {
        //alert(xdata);
        // Data yang mau di ubah di temukan
        var res = data.split("|");
        document.getElementById('txtmastname').value = res[0];

        if (res[1] == 'Y') {
        document.getElementById("optmastcosg").checked = true;    
        document.getElementById("hidmastcosg").value = res[1];  
        }
        else if (res[1] == 'N')
        {
        document.getElementById("optmastcosg").checked = false;
        document.getElementById("hidmastcosg").value = res[1]; 
        }
        else
        {
        document.getElementById("optmastcosg").checked = false;
        document.getElementById("hidmastcosg").value = '';
        }

        if (res[2] == 'P') 
        {
        document.getElementById("optparent").checked = true;
        document.getElementById("optchild").checked = false;
        document.getElementById("hidmaststat").value = res[2];    
        }
        else if (res[2] == 'C')
        {
        document.getElementById("optparent").checked = false;
        document.getElementById("optchild").checked = true;   
        document.getElementById("hidmaststat").value = res[2];
        }
        else
        {
        document.getElementById("optparent").checked = false;
        document.getElementById("optchild").checked = false;   
        document.getElementById("hidmaststat").value = ''; 
        }

        if (res[3] == 'DB') 
        {
        document.getElementById("optdebit").checked = true;
        document.getElementById("optcredit").checked = false;
        document.getElementById("hidnormblnc").value = res[3];   
        }
        else if (res[3] == 'CR')
        {
        document.getElementById("optdebit").checked = false;
        document.getElementById("optcredit").checked = true;
        document.getElementById("hidnormblnc").value = res[3];    
        }
        else
        {
        document.getElementById("optdebit").checked = false;
        document.getElementById("optcredit").checked = false; 
        document.getElementById("hidnormblnc").value = '';  
        }

        if (res[4] == 'BS') 
        {
        document.getElementById("optbs").checked = true;
        document.getElementById("optpl").checked = false;
        document.getElementById("hidfnrpstat").value = res[4];   
        }
        else if (res[4] == 'PL')
        {
        document.getElementById("optbs").checked = false;
        document.getElementById("optpl").checked = true; 
        document.getElementById("hidfnrpstat").value = res[4];   
        }
        else
        {
        document.getElementById("optbs").checked = false;
        document.getElementById("optpl").checked = false;
        document.getElementById("hidfnrpstat").value = '';   
        }
        document.getElementById("txtmastnote").value = res[5]; 

        document.getElementById('labelmessage').style.visibility = 'hidden';
        document.getElementById('txtmastcode').focus();                 
      }
      else
      {
        //alert(xdata);
        // Data yang mau di ubah tidak ada
        document.getElementById('labelmessage').style.visibility = '';
        document.getElementById('txtmastname').value = '';

        document.getElementById("optmastcosg").checked = false;    
        document.getElementById("hidmastcosg").value = '';  

        document.getElementById("optparent").checked = false;
        document.getElementById("optchild").checked = false;
        document.getElementById("hidmaststat").value = '';    

        document.getElementById("optdebit").checked = false;
        document.getElementById("optcredit").checked = false;
        document.getElementById("hidnormblnc").value = '';   

        document.getElementById("optbs").checked = false;
        document.getElementById("optpl").checked = false;
        document.getElementById("hidfnrpstat").value = '';   

        document.getElementById("txtmastnote").value = ''; 

        document.getElementById('txtmastcode').focus();
      }
    }
  }

