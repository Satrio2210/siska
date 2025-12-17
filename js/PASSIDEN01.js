  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="PASSIDEN01X-AKSES.php";
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
        document.getElementById('txtuseriden').focus(); 
        document.getElementById('txtusername').setAttribute('disabled','true');
        document.getElementById('optdoctor').setAttribute('disabled','true');
        document.getElementById('optnondoctor').setAttribute('disabled','true');
        document.getElementById('txtuserpswd').setAttribute('disabled','true');
        document.getElementById('txtuserpswd2').setAttribute('disabled','true');      
      }
      else
      {
        document.getElementById('txtuseriden').setAttribute('disabled','true');
        document.getElementById('txtusername').setAttribute('disabled','true');
        document.getElementById('optdoctor').setAttribute('disabled','true');
        document.getElementById('optnondoctor').setAttribute('disabled','true');
        document.getElementById('txtuserpswd').setAttribute('disabled','true');
        document.getElementById('txtuserpswd2').setAttribute('disabled','true');      


      }
    }
  }
// end periksa akses  


    var ajaxku;
  function periksaid(kodeid)
  {
    ajaxku = buatajax();
    var url="PASSIDEN01X.php";
    ajaxku.onreadystatechange=stateChanged
    var params = "q="+kodeid;
    // alert('Parameter adalah' + kodeid);
    ajaxku.open("POST",url,true)
    ajaxku.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    ajaxku.setRequestHeader("Content-length", params.length);
    ajaxku.setRequestHeader("Connection", "close");
    ajaxku.send(params);
  }

  function buatajax()
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

  function stateChanged()
  {
  var data;
  if (ajaxku.readyState==4)
    {
    data=ajaxku.responseText;
    if(data.length>3)
      { 
        document.getElementById("labelmessage").style.visibility = "";
        document.getElementById('txtusername').setAttribute('disabled','true');
        document.getElementById('optdoctor').setAttribute('disabled','true');
        document.getElementById('optnondoctor').setAttribute('disabled','true');
        document.getElementById('txtuserpswd').setAttribute('disabled','true');
        document.getElementById('txtuserpswd2').setAttribute('disabled','true');

      }
      else
      {
        document.getElementById("txtusername").removeAttribute('disabled');
        document.getElementById("txtusername").value = '';

        document.getElementById('optdoctor').removeAttribute('disabled');
        document.getElementById('optnondoctor').removeAttribute('disabled');

        document.getElementById("txtuserpswd").removeAttribute('disabled');
        document.getElementById("txtuserpswd").value = '';
        document.getElementById("txtuserpswd2").removeAttribute('disabled');
        document.getElementById("txtuserpswd2").value = '';

        document.getElementById("labelmessage").style.visibility =  "hidden";
      }
    }
  }


    // ambil Kode Type dari tabel empl
var userku;
function ambilemplcode(emplcode)
{
  if(emplcode.length > 5)
  {
  document.getElementById("tblempl").style.visibility = "hidden";
  }
  else
  {
  userku = buatajaxemplcode();
  //var url="INVEMAST01X.php";
  var url="PASSIDEN01C-EMPL.php";
  userku.onreadystatechange=stateChangedemplcode;
  var params = "q="+emplcode;
  userku.open("POST",url,true);
  userku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  userku.setRequestHeader("Content-length", params.length);
  userku.setRequestHeader("Connection", "close");
  userku.send(params);
  }
} 

function buatajaxemplcode()
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

function stateChangedemplcode()
{
  var data;
  if (userku.readyState==4 && userku.status==200)
  {
  data=userku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblempl").innerHTML = data;
    document.getElementById("tblempl").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblempl").innerHTML = "";
    document.getElementById("tblempl").style.visibility = "hidden";
    }
  }
}

function isiemplcode(outemplcode,outemplname)
{
  try 
  {
  document.getElementById("txtusername").value = outemplname;
  document.getElementById("hidemplcode").value = outemplcode;
  document.getElementById("txtuserpswd").focus();
  document.getElementById("tblempl").style.visibility = "hidden";
  document.getElementById("tblempl").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
    // ambil Kode Type dari tabel tblempl
