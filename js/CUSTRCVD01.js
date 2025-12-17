  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="ACCESS.php";
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

        document.getElementById('optpaymmode').setAttribute('disabled','true');
        ambilscreen('');
      }
      else
      {
        document.getElementById('optpaymmode').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(kata)
{
  if(kata.length > 14)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="CUSTRCVD01V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+kata;
  drz.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  }
} 

  function buatajaxscreen()
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

function stateChangedscreen()
{
  var datapost;
  if (drz.readyState==4 && drz.status==200)
  {
  datapost=drz.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tblscreen").innerHTML = datapost;
    document.getElementById("tblscreen").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblscreen").innerHTML = "";
    document.getElementById("tblscreen").style.visibility = "hidden";
    }
  }
}

// ambil sceen selesai

// Tampilkan Data Kwitansi   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(salecode,regicode,paticode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="CUSTRCVD01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+salecode+"|"+regicode+"|"+paticode;
    //alert(params);
    ajaxview.open("POST",url,true);
    ajaxview.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxview.setRequestHeader("Content-length", params.length);
    ajaxview.setRequestHeader("Connection", "close");
    ajaxview.send(params);

  } 
  catch(err){ alert(err.message); }
}

  function buatajaxview()
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

  function stateChangedView()
  {
  var data;
  if (ajaxview.readyState==4)
    {
      data=ajaxview.responseText;
      if(data.length>1)
      {
//      1        2          3       4        5         6        7    
//|$regicode|$paticode|$mainname|$gender|$fullage|$regipaym|$salecode

      var res = data.split("|");
      document.getElementById("txtregicode").value = res[1];

      document.getElementById("txtpaticode").value = res[2];

      document.getElementById("txtmainname").value = res[3];

      document.getElementById("txtmaingend").value = res[4];

      document.getElementById("txtmainage").value = res[5];

      document.getElementById("txtregipaym").value = res[6];

      document.getElementById("hidsalecode").value = res[7];

     ambiltrxascreen(res[7],res[1]);
      document.getElementById("optpaymmode").removeAttribute('disabled');

      document.getElementById("optpaymmode").focus();

      }      
        //}
    }
  }

  // Input Data Posisi dari form ke Tabel 
  var ajaxinput;
  function input(regicode,salecode,paymmode)
  {
    ajaxinput = buatajaxinput();
    var url="CUSTRCVD01U.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+regicode+"|"+salecode+"|"+paymmode;
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
  if (ajaxinput.readyState==4)
    {

        document.getElementById('txtregicode').value = '';
        document.getElementById('txtpaticode').value = '';
        document.getElementById('txtmainname').value = '';
        document.getElementById('txtmaingend').value = '';
        document.getElementById('txtmainage').value = '';
        document.getElementById('txtregipaym').value = '';

        document.getElementById('hidsalecode').value = '';

        document.getElementById('optpaymmode').setAttribute('disabled','true');
        ambilscreen('');
        document.getElementById("tblsale").innerHTML = "";
         document.getElementById("tblsale").style.visibility = "hidden";     


    }
  }
  // Selesai Input Data

// tampilkan rincian data transaksi kwitansi
var drz;
function ambiltrxascreen(salecode,regicode)
{
  try { 
  drz = buatajaxtrxascreen();
  var url="CUSTRCVD01V-KWITANSI.php";
  drz.onreadystatechange=stateChangedtrxascreen;
  var params = "q="+salecode+"|"+regicode;
  drz.open("POST",url,true);
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  }  catch(err) {alert (err.message);}
  //}
} 

function buatajaxtrxascreen()
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

function stateChangedtrxascreen() 
{   var datapost;   
  if (drz.readyState==4)   
    { 
      datapost=drz.responseText;
      if(datapost.length>3)
        { 
          document.getElementById("tblsale").innerHTML = datapost;
            document.getElementById("tblsale").style.visibility = "";     
        }     
      else 
        {  
          document.getElementById("tblsale").innerHTML = "";
          document.getElementById("tblsale").style.visibility = "hidden";     
        }

    } 
}
