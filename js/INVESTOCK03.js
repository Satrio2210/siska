  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="INVESTOCK03X-AKSES.php";
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
        document.getElementById('txtopnacode').focus();

      }
      else
      {
        document.getElementById('txtopnacode').setAttribute('disabled','true');
        document.getElementById('tglopnadate').setAttribute('disabled','true');

        document.getElementById('txtwarename').setAttribute('disabled','true');
        document.getElementById('txtopnadlay').setAttribute('disabled','true');

        //document.getElementById('optinvetype').setAttribute('disabled','true');
        document.getElementById('tglfinsdate').setAttribute('disabled','true');

        document.getElementById('txtopnanote').setAttribute('disabled','true');
        document.getElementById('txtemplname').setAttribute('disabled','true');

        document.getElementById('txtstockname').setAttribute('disabled','true');
        document.getElementById('txtstockopna').setAttribute('disabled','true');

      }
    }
  }
// end periksa akses  

    // ambil data dari  tabel trxaopna

var opnaku;
function ambilopnacode(opnacode)
{
  if(opnacode.length > 10)
  {
  document.getElementById("tblopna").style.visibility = "hidden";
  }
  else
  {
  opnaku = buatajaxopnacode();
  var url="INVESTOCK03C.php";
  opnaku.onreadystatechange=stateChangedopnacode;
  var params = "q="+opnacode;
  opnaku.open("POST",url,true);
  opnaku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  opnaku.setRequestHeader("Content-length", params.length);
  opnaku.setRequestHeader("Connection", "close");
  opnaku.send(params);
  }
} 

function buatajaxopnacode()
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

function stateChangedopnacode()
{
  var data;
  if (opnaku.readyState==4 && opnaku.status==200)
  {
  data=opnaku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblopna").innerHTML = data;
    document.getElementById("tblopna").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblopna").innerHTML = "";
    document.getElementById("tblopna").style.visibility = "hidden";
    }
  }
}

function isiopnacode(outopnacode,outopnadate,outwarename,outwarecode,outopnadlay,outfinsdate,outopnanote,outemplname,outemplcode)
{
  try 
  {
  document.getElementById("txtopnacode").value = outopnacode;
  document.getElementById("tglopnadate").value = outopnadate;
  document.getElementById("txtwarename").value = outwarename;
  document.getElementById("hidwarecode").value = outwarecode;
  document.getElementById("txtopnadlay").value = outopnadlay;
  document.getElementById("tglfinsdate").value = outfinsdate;
  document.getElementById("txtopnanote").value = outopnanote;
  document.getElementById("txtemplname").value = outemplname;
  document.getElementById("hidemplcode").value = outemplcode;

  ambilscreen(outopnacode,outwarecode);

  document.getElementById("txtopnadlay").focus();
  document.getElementById("tblopna").style.visibility = "hidden";
  document.getElementById("tblopna").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(opnacode,warecode)
{
  if(warecode.length > 4)
  {
  document.getElementById("tbltrxascreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="INVESTOCK03V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+opnacode+"|"+warecode;
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
    document.getElementById("tbltrxascreen").innerHTML = datapost;
    document.getElementById("tbltrxascreen").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbltrxascreen").innerHTML = "";
    document.getElementById("tbltrxascreen").style.visibility = "hidden";
    }
  }
}


// Change Stock Item 
var stockku;
function ubahstock(opnacode,warecode,stockcode,timecode,qtyopname)
  {
    stockku = buatajaxubah();
    var url="INVESTOCK03U.php";
    stockku.onreadystatechange=stateChangedubah;
    var params = "q="+opnacode+"|"+warecode+"|"+stockcode+"|"+timecode+"|"+qtyopname;
    //alert(params);
    stockku.open("POST",url,true);
    stockku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    stockku.setRequestHeader("Content-length", params.length);
    stockku.setRequestHeader("Connection", "close");
    stockku.send(params);
  }

function buatajaxubah()
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

function stateChangedubah()
  {
  var data;
  if (stockku.readyState==4)
    {
        ambilscreen(document.getElementById("txtopnacode").value,document.getElementById("hidwarecode").value);
    }
  }


// Closing Opname
  var ajaxcloseopname;
  function closeopname(opnacode)
  {
    ajaxcloseopname = buatajaxcloseopname();
    //var url="INVETRANS01U.php";
    var url="INVESTOCK03U-OPNA.php";
    ajaxcloseopname.onreadystatechange=stateChangedcloseopname;
    var params = "q="+opnacode;
    //alert(params);
    ajaxcloseopname.open("POST",url,true);
    ajaxcloseopname.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ajaxcloseopname.setRequestHeader("Content-length", params.length);
    //ajaxcloseopname.setRequestHeader("Connection", "close");
    ajaxcloseopname.send(params);
  }

  function buatajaxcloseopname()
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

  function stateChangedcloseopname()
  {
  var data;
  if (ajaxcloseopname.readyState==4)
    {
        var todaynow = new Date()
        var today = convertDate(todaynow);

        document.getElementById('txtopnacode').value = '';
        document.getElementById('tglopnadate').value = today;
        document.getElementById('txtwarename').value = '';
        document.getElementById('hidwarecode').value = '';
        document.getElementById('txtopnadlay').value = '';
        document.getElementById('tglfinsdate').value = today;
        document.getElementById('txtopnanote').value = '';
        document.getElementById('txtemplname').value = '';
        document.getElementById('hidemplcode').value = '';
        //document.getElementById('hidtimecode').value = '';

    document.getElementById("tbltrxascreen").style.visibility = "hidden";

        document.getElementById('txtopnacode').focus();

        //}
    }
  }
  // Selesai Input Data  ke Tabel trxaopna
