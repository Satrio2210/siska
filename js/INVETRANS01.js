  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="INVETRANS01X-AKSES.php";
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
        document.getElementById('txtwarefrom').focus();
        document.getElementById('txtwarefrom').value = '';
        document.getElementById('hidwarefrom').value = '';
        document.getElementById('txtlocaname').value = '';

        document.getElementById('txtwaredest').value = '';
        document.getElementById('hidwaredest').value = '';
        document.getElementById('txtlocanamedest').value = '';

        ambilrequcode('X');
      }
      else
      {
        document.getElementById('txtrequcode').setAttribute('disabled','true');
        document.getElementById('tglrequdate').setAttribute('disabled','true');

        document.getElementById('tgltrandate').setAttribute('disabled','true');
        document.getElementById('tglrcvedate').setAttribute('disabled','true');

        document.getElementById('txtwarefrom').setAttribute('disabled','true');
        document.getElementById('txtlocaname').setAttribute('disabled','true');

        document.getElementById('txtwaredest').setAttribute('disabled','true');
        document.getElementById('txtlocanamedest').setAttribute('disabled','true');

      }
    }
  }
// end periksa akses  

    // Membuat code Request Transfer dengan nomor urut 
var ajaxsequ
function ambilrequcode(requcode)
{
  try 
  {
    ajaxsequ = buatajaxsequ();
    var url="INVETRANS01X.php";
    ajaxsequ.onreadystatechange=stateChangedcode;
    var params = "q="+requcode;
    //alert(params);
    ajaxsequ.open("POST",url,true);
    ajaxsequ.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxsequ.setRequestHeader("Content-length", params.length);
    ajaxsequ.setRequestHeader("Connection", "close");
    ajaxsequ.send(params);

  } 
  catch(err){ alert(err.message); }
}

  function buatajaxsequ()
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

  function stateChangedcode()
  {
  var data;
  if (ajaxsequ.readyState==4)
    {
    xdata=ajaxsequ.responseText;
    data=xdata.trim();
    if(data.length>1)
      {
        document.getElementById('txtrequcode').value = data;         
      }
      else
      {
        document.getElementById('txtrequcode').value='';
      }
    }
  }

// Code urut Wallpaper selesai


    // ambil Kode Ware House tabel waremast

var wareku;
function ambilwarecode(warecode)
{
  if(warecode.length > 5)
  {
  document.getElementById("tblware").style.visibility = "hidden";
  }
  else
  {
  wareku = buatajaxwarecode();
  var url="INVETRANS01C-WARE.php";
  wareku.onreadystatechange=stateChangedwarecode;
  var params = "q="+warecode;
  wareku.open("POST",url,true);
  wareku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  wareku.setRequestHeader("Content-length", params.length);
  wareku.setRequestHeader("Connection", "close");
  wareku.send(params);
  }
} 

function buatajaxwarecode()
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

function stateChangedwarecode()
{
  var data;
  if (wareku.readyState==4 && wareku.status==200)
  {
  data=wareku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblware").innerHTML = data;
    document.getElementById("tblware").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblware").innerHTML = "";
    document.getElementById("tblware").style.visibility = "hidden";
    }
  }
}

function isiwarecode(outwarecode,outwarename,outlocaname)
{
  try 
  {
  document.getElementById("txtwarefrom").value = outwarename;
  document.getElementById("hidwarefrom").value = outwarecode;
  document.getElementById("txtlocaname").value = outlocaname;
  document.getElementById("txtwaredest").focus();
  document.getElementById("tblware").style.visibility = "hidden";
  document.getElementById("tblware").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

    // ambil Kode Ware House tabel waremast tujuan

var wareend;
function ambilwarecodeend(warecodeend)
{
  if(warecodeend.length > 5)
  {
  document.getElementById("tblware").style.visibility = "hidden";
  }
  else
  {
  wareend = buatajaxwarecodeend();
  var url="INVETRANS01C-WARE-END.php";
  wareend.onreadystatechange=stateChangedwarecodeend;
  var params = "q="+warecodeend;
  //alert(params);

  wareend.open("POST",url,true);
  wareend.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  wareend.setRequestHeader("Content-length", params.length);
  wareend.setRequestHeader("Connection", "close");
  wareend.send(params);
  }
} 

function buatajaxwarecodeend()
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

function stateChangedwarecodeend()
{
  var data;
  if (wareend.readyState==4 && wareend.status==200)
  {
  data=wareend.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblware").innerHTML = data;
    document.getElementById("tblware").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblware").innerHTML = "";
    document.getElementById("tblware").style.visibility = "hidden";


    }
  }
}

function isiwarecodeend(outwarecodeend,outwarenameend,outlocanameend)
{
  try 
  {
  document.getElementById("txtwaredest").value = outwarenameend;
  document.getElementById("hidwaredest").value = outwarecodeend;
  document.getElementById("txtlocanamedest").value = outlocanameend;

  document.getElementById("txtwaredest").focus();
  document.getElementById("tblware").style.visibility = "hidden";
  document.getElementById("tblware").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


// Input data ke tabel trxarequ
  var ajaxinput;
  function input(requcode,requdate,trandate,rcvedate,warefrom,waredest)
  {
    ajaxinput = buatajaxinput();
    var url="INVETRANS01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+requcode+"|"+requdate+"|"+trandate+"|"+rcvedate+"|"+warefrom+"|"+waredest;
    //alert(params);
    ajaxinput.open("POST",url,true);
    ajaxinput.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ajaxinput.setRequestHeader("Content-length", params.length);
    //ajaxinput.setRequestHeader("Connection", "close");
    ajaxinput.send(params);
  }

  function buatajaxinput()
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

  function stateChangedInput()
  {
  var data;
  if (ajaxinput.readyState==4)
    {
        document.getElementById('txtwarefrom').focus();
        document.getElementById('txtwarefrom').value = '';
        document.getElementById('hidwarefrom').value = '';
        document.getElementById('txtlocaname').value = '';

        document.getElementById('txtwaredest').value = '';
        document.getElementById('hidwaredest').value = '';
        document.getElementById('txtlocanamedest').value = '';

        ambilrequcode('X');
        //}
    }
  }
  // Selesai Input Data  ke Tabel trxarequ
