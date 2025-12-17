  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="INVESTOCK01X-AKSES.php";
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
      	ambilopnacode('X');
        document.getElementById('txtwarename').focus();

      }
      else
      {
        document.getElementById('txtopnacode').setAttribute('disabled','true');
        document.getElementById('tglopnadate').setAttribute('disabled','true');

        document.getElementById('txtwarename').setAttribute('disabled','true');
        document.getElementById('txtopnadlay').setAttribute('disabled','true');

        document.getElementById('txtinvetype').setAttribute('disabled','true');
        document.getElementById('tglfinsdate').setAttribute('disabled','true');

        document.getElementById('txtopnanote').setAttribute('disabled','true');
        document.getElementById('txtemplname').setAttribute('disabled','true');

        document.getElementById('txtstockname').setAttribute('disabled','true');
        document.getElementById('txtstockopna').setAttribute('disabled','true');

      }
    }
  }
// end periksa akses  

    // Membuat code Transaksi Stock Opname dengan nomor urut 
var ajaxsequ
function ambilopnacode(opnacode)
{
  try 
  {
    ajaxsequ = buatajaxsequ();
    var url="INVESTOCK01X.php";
    ajaxsequ.onreadystatechange=stateChangedcode;
    var params = "q="+opnacode;
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
        document.getElementById('txtopnacode').value = data;         
      }
      else
      {
        document.getElementById('txtopnacode').value='';
      }
    }
  }

// Code urut Wallpaper selesai

    // ambil Kode Ware House tabel waremast

var wareku;
function ambilwarecode(warecode)
{
  if(warecode.length > 10)
  {
  document.getElementById("tblware").style.visibility = "hidden";
  }
  else
  {
  wareku = buatajaxwarecode();
  var url="INVESTOCK01C-WARE.php";
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

function isiwarecode(outwarecode,outwarename)
{
  try 
  {
  document.getElementById("txtwarename").value = outwarename;
  document.getElementById("hidwarecode").value = outwarecode;
  document.getElementById("txtopnadlay").focus();
  document.getElementById("tblware").style.visibility = "hidden";
  document.getElementById("tblware").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


    // ambil Kode Type Inventory tabel tblitype

var typeku;
function ambiltypecode(typecode)
{
  if(typecode.length > 3)
  {
  document.getElementById("tblware").style.visibility = "hidden";
  }
  else
  {
  typeku = buatajaxtypecode();
  var url="INVESTOCK01C-TYPE.php";
  typeku.onreadystatechange=stateChangedtypecode;
  var params = "q="+typecode;
  typeku.open("POST",url,true);
  typeku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  typeku.setRequestHeader("Content-length", params.length);
  typeku.setRequestHeader("Connection", "close");
  typeku.send(params);
  }
} 

function buatajaxtypecode()
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

function stateChangedtypecode()
{
  var data;
  if (typeku.readyState==4 && typeku.status==200)
  {
  data=typeku.responseText;
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

function isitypecode(outtypecode,outtypename)
{
  try 
  {
  document.getElementById("txtinvetype").value = outtypename;
  document.getElementById("hidinvetype").value = outtypecode;

  ambilscreen(document.getElementById('txtopnacode').value,document.getElementById('hidwarecode').value, outtypecode);

  document.getElementById("txtopnanote").focus();
  document.getElementById("tblware").style.visibility = "hidden";
  document.getElementById("tblware").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


    // ambil Kode Empl tabel empl
var emplku;
function ambilemplcode(emplcode)
{
  if(emplcode.length > 5)
  {
  document.getElementById("tblempl").style.visibility = "hidden";
  }
  else
  {
  emplku = buatajaxemplcode();

  var url="INVESTOCK01C-EMPL.php";
  emplku.onreadystatechange=stateChangedemplcode;
  var params = "q="+emplcode;
  emplku.open("POST",url,true);
  emplku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  emplku.setRequestHeader("Content-length", params.length);
  emplku.setRequestHeader("Connection", "close");
  emplku.send(params);
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
  if (emplku.readyState==4 && emplku.status==200)
  {
  data=emplku.responseText;
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
  document.getElementById("txtemplname").value = outemplname;
  document.getElementById("hidemplcode").value = outemplcode;
  document.getElementById("txtstockname").focus();
  document.getElementById("tblempl").style.visibility = "hidden";
  document.getElementById("tblempl").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
    // ambil Kode EMPL dari tabel tblempl


// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(opnacode,warecode,typecode)
{
  if(warecode.length > 4)
  {
  document.getElementById("tbltrxascreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="INVESTOCK01V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+opnacode+"|"+warecode+"|"+typecode;
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

// Tampilkan Item Stock  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(warecode,stockcode,timecode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="INVESTOCK01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+warecode+"|"+stockcode+"|"+timecode;
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
      //alert(data);
      if(data.length>1)
      {
      var res = data.split("|");
      document.getElementById("hidstockcode").value = res[1];
      document.getElementById("txtstockname").value = res[2];
      document.getElementById("txtstockopna").value = res[3];
      document.getElementById("hidtimecode").value = res[4];
      document.getElementById("txtstockopna").focus();
      }      
        //}
    }
  }


// Input data ke tabel itemopna
  var ajaxinput;
  function input(opnacode, warecode, stockcode, stockname, stockopna, timecode)
  {
    ajaxinput = buatajaxinput();
    //var url="INVETRANS03E.php";
    var url="INVESTOCK01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+opnacode+"|"+warecode+"|"+stockcode+"|"+stockname+"|"+stockopna+"|"+timecode;
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
        document.getElementById('txtstockname').value = '';
        document.getElementById('hidstockcode').value = '';
        document.getElementById('txtstockopna').value = '';
        document.getElementById('hidtimecode').value = '';
        document.getElementById('txtstockname').focus();
        ambilscreen(document.getElementById('txtopnacode').value,document.getElementById('hidwarecode').value, document.getElementById("hidinvetype").value);

        //}
    }
  }
  // Selesai Input Data  ke Tabel itemopna

// Input data ke tabel trxaopna / tabel stock opname
  var ajaxinputopname;
  function inputopname(opnacode, opnadate, warecode, opnadlay, finsdate, opnanote, emplcode)
  {
    ajaxinputopname = buatajaxinputopname();
    //var url="INVETRANS03E.php";
    var url="INVESTOCK01U.php";
    ajaxinputopname.onreadystatechange=stateChangedInputopname;
    var params = "q="+opnacode+"|"+opnadate+"|"+warecode+"|"+opnadlay+"|"+finsdate+"|"+opnanote+"|"+emplcode;
    //alert(params);
    ajaxinputopname.open("POST",url,true);
    ajaxinputopname.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ajaxinputopname.setRequestHeader("Content-length", params.length);
    //ajaxinputopname.setRequestHeader("Connection", "close");
    ajaxinputopname.send(params);
  }

  function buatajaxinputopname()
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

  function stateChangedInputopname()
  {
  var data;
  if (ajaxinputopname.readyState==4)
    {
        ambilopnacode('X');

        var todaynow = new Date()
        var today = convertDate(todaynow);

        document.getElementById('tglopnadate').value = today;
        document.getElementById('txtwarename').value = '';
        document.getElementById('hidwarecode').value = '';
        document.getElementById('txtopnadlay').value = '';
        document.getElementById('txtinvetype').value = '';
        document.getElementById('hidinvetype').value = '';
        document.getElementById('tglfinsdate').value = today;
        document.getElementById('txtopnanote').value = '';
        document.getElementById('txtemplname').value = '';
        document.getElementById('hidemplcode').value = '';
        document.getElementById('txtstockname').value = '';
        document.getElementById('txtstockopna').value = '';
        document.getElementById('hidtimecode').value = '';

		document.getElementById("tbltrxascreen").style.visibility = "hidden";

        document.getElementById('txtwarename').focus();


        //}
    }
  }
  // Selesai Input Data  ke Tabel trxaopna
