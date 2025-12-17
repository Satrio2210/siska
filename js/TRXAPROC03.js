  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPROC03X-AKSES.php";
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
        document.getElementById('txtproccode').focus();
        document.getElementById('tglarrvrequ').setAttribute('disabled','true');
        document.getElementById('txtpartname').setAttribute('disabled','true');
        document.getElementById('txtqutyrcve').setAttribute('disabled','true');
        document.getElementById('txtprocbtch').setAttribute('disabled','true');
        document.getElementById('txtprocsrnm').setAttribute('disabled','true');
        document.getElementById('txtwarename').setAttribute('disabled','true');
        document.getElementById('tglexprdate').setAttribute('disabled','true');
        document.getElementById('txtemplname').setAttribute('disabled','true');
        ambilscreen('');
      }
      else
      {
        document.getElementById('txtproccode').setAttribute('disabled','true');
        document.getElementById('tglarrvrequ').setAttribute('disabled','true');
        document.getElementById('txtpartname').setAttribute('disabled','true');
        document.getElementById('txtqutyrcve').setAttribute('disabled','true');
        document.getElementById('txtprocbtch').setAttribute('disabled','true');
        document.getElementById('txtprocsrnm').setAttribute('disabled','true');
        document.getElementById('txtwarename').setAttribute('disabled','true');
        document.getElementById('tglexprdate').setAttribute('disabled','true');
        document.getElementById('txtemplname').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

  // Input Data Posisi dari form ke Tabel 

  var ajaxinput;
  function input(proccode,partcode,unitcode,qutyrcve,procbtch,procsrnm,arrvrequ,warecode,exprdate,emplcode)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAPROC03E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+proccode+"|"+partcode+"|"+unitcode+"|"+qutyrcve+"|"+procbtch+"|"+procsrnm+"|"+arrvrequ+"|"+warecode+"|"+exprdate+"|"+emplcode;
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
  var todaynow = new Date()
  var data;
  if (ajaxinput.readyState==4)
    {
        document.getElementById('txtproccode').value = '';
        var today = convertDate(todaynow);

        document.getElementById('tglarrvrequ').value = today;
        document.getElementById('tglarrvrequ').setAttribute('disabled','true');

        document.getElementById('hidpartcode').value = '';
        document.getElementById('hidunitcode').value = '';

        document.getElementById('txtpartname').value = '';
        document.getElementById('txtpartname').setAttribute('disabled','true');

        document.getElementById('txtqutyrcve').value = '';
        document.getElementById('txtqutyrcve').setAttribute('disabled','true');

        document.getElementById('txtprocbtch').value = '';
        document.getElementById('txtprocbtch').setAttribute('disabled','true');

        document.getElementById('txtprocsrnm').value = '';
        document.getElementById('txtprocsrnm').setAttribute('disabled','true');

        document.getElementById('txtwarename').value = '';
        document.getElementById('txtwarename').setAttribute('disabled','true');
        document.getElementById('hidwarecode').value = '';

        document.getElementById('tglexprdate').value = today;
        document.getElementById('tglexprdate').setAttribute('disabled','true');

        document.getElementById('txtemplname').value = '';
        document.getElementById('txtemplname').setAttribute('disabled','true');
        document.getElementById('hidemplcode').value = '';

        let xcari = document.getElementById('txtsearch').value;


        ambilscreen(xcari);
        document.getElementById('txtproccode').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblitype

// Tampilkan Data Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(proccode,partcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPROC03C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+proccode+"|"+partcode;
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
//    1          2        3         4          5         6        7          8         9         10       11        12        13        
//|$proccode|$partcode|$partunit|$partname|$withsrnm|$qutyrest|$batchcode|$procsrnm|$arrvrequ|$warecode|$warename|$emplcode|$emplname
      var res = data.split("|");
      document.getElementById("txtproccode").value = res[1];

      document.getElementById("tglarrvrequ").removeAttribute('disabled');
      document.getElementById("tglarrvrequ").value = res[9];

      document.getElementById("hidpartcode").value = res[2];
      document.getElementById("hidunitcode").value = res[3];

      document.getElementById("txtpartname").removeAttribute('disabled');
      document.getElementById("txtpartname").value = res[4];

      document.getElementById("txtqutyrcve").removeAttribute('disabled');
      document.getElementById("txtqutyrcve").value = res[6];
      document.getElementById("hidqutyrcve").value = res[6];      

      document.getElementById("txtprocbtch").removeAttribute('disabled');
      document.getElementById("txtprocbtch").value = res[7];

      if (res[5] == 'Y')
      {
      document.getElementById("txtprocsrnm").removeAttribute('disabled');
      document.getElementById("txtprocsrnm").value = res[8];        
      }
      else
      {
      //document.getElementById("txtprocsrnm").removeAttribute('disabled');
      document.getElementById('txtprocsrnm').setAttribute('disabled','true');
      document.getElementById("txtprocsrnm").value = 'NoSerial';                
      }

      document.getElementById("txtwarename").removeAttribute('disabled');
      document.getElementById("txtwarename").value = res[11];

      document.getElementById("hidwarecode").value = res[10];

      document.getElementById('tglexprdate').removeAttribute('disabled');

      document.getElementById("txtemplname").removeAttribute('disabled');
      document.getElementById("txtemplname").value = res[13];

      document.getElementById("txtqutyrcve").focus();

      }      
        //}
    }
  }

// Menutup List barang dalam proses delivery menjadi masuk ke dalam gudang 
  var ajaxhapus;
  function hapuscode(proccode,partcode)
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAPROC03D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+proccode+"|"+partcode;
    //alert(params);
    ajaxhapus.open("POST",url,true);
    ajaxhapus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxhapus.setRequestHeader("Content-length", params.length);
    ajaxhapus.setRequestHeader("Connection", "close");
    ajaxhapus.send(params);
  }

  function buatajaxhapus()
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

  function stateChangedhapus()
  {
  var data;
  if (ajaxhapus.readyState==4)
    {
        let xcari = document.getElementById('txtsearch').value;
        ambilscreen(xcari);
    }
  }
// Selesai proses tutup list item order


// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(kata)
{
  if(kata.length > 13)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXAPROC03V.php";
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

    // ambil Kode Ware House tabel waremast

var wareku;
function ambilwarecode(warecode)
{
  if(warecode.length > 9)
  {
  document.getElementById("tblware").style.visibility = "hidden";
  }
  else
  {
  wareku = buatajaxwarecode();
  //var url="WAREMAST05C-WARE.php";
  var url="TRXAPROC03C-WARE.php";
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
  document.getElementById("txtemplname").focus();
  document.getElementById("tblware").style.visibility = "hidden";
  document.getElementById("tblware").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


    // ambil Kode Empl tabel empl
var emplku;
function ambilemplcode(emplcode)
{
  if(emplcode.length > 9)
  {
  document.getElementById("tblempl").style.visibility = "hidden";
  }
  else
  {
  emplku = buatajaxemplcode();
  //var url="WAREMAST01C-EMPL.php";
  var url="TRXAPROC03C-EMPL.php";
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
  document.getElementById("tblempl").style.visibility = "hidden";
  document.getElementById("tblempl").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
    // ambil Kode EMPL dari tabel tblempl
