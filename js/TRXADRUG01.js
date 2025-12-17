  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXADRUG01X-AKSES.php";
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
        document.getElementById('txtstockquty').setAttribute('disabled','true');

        document.getElementById('optnonracikan').setAttribute('disabled','true');
        document.getElementById('optracikan').setAttribute('disabled','true');

        document.getElementById('txtstockbtch').setAttribute('disabled','true');

        ambilscreen('');
      }
      else
      {
        document.getElementById('txtprsccode').setAttribute('disabled','true');
        document.getElementById('txtpaticode').setAttribute('disabled','true');
        document.getElementById('txtmainname').setAttribute('disabled','true');
        document.getElementById('txtmaingend').setAttribute('disabled','true');
        document.getElementById('txtstockcode').setAttribute('disabled','true');
        document.getElementById('txtstockquty').setAttribute('disabled','true');
        document.getElementById('optnonracikan').setAttribute('disabled','true');
        document.getElementById('optracikan').setAttribute('disabled','true');
        document.getElementById('txtstockbtch').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

  // Input Data Posisi dari form ke Tabel 

  var ajaxinput;
  function input(prsccode,stockcode,prscconc,stockbtch)
  {
    ajaxinput = buatajaxinput();
    var url="TRXADRUG01U.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+prsccode+"|"+stockcode+"|"+prscconc+"|"+stockbtch;
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


        document.getElementById('txtprsccode').value = '';
        document.getElementById('txtpaticode').value = '';

        document.getElementById('txtmainname').value = '';

        document.getElementById('txtmaingend').value = '';

        document.getElementById('txtstockcode').value = '';
        document.getElementById('hidstockcode').value = '';

        document.getElementById('txtstockquty').value = '';
        document.getElementById('txtstockquty').setAttribute('disabled','true');

        document.getElementById('optnonracikan').checked = false;
        document.getElementById('optracikan').checked = false;
        document.getElementById('optnonracikan').setAttribute('disabled','true');
        document.getElementById('optracikan').setAttribute('disabled','true');

        document.getElementById('txtstockbtch').value = '';
        document.getElementById('txtstockbtch').setAttribute('disabled','true');
        let xcari = document.getElementById('txtsearch').value;

        ambilscreen(xcari);
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblitype

// Tampilkan Data Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(prsccode,stockcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXADRUG01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+prsccode+"|"+stockcode;
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
 //    1         2        3         4          5         6          7          8         9     
//|$prsccode|$paticode|$mainname|$maingend|$stockcode|$stockname|$stockbtch|$prscconc|$stockquty|
      var res = data.split("|");
      document.getElementById("txtprsccode").value = res[1];

      document.getElementById("txtpaticode").value = res[2];

      document.getElementById("txtmainname").value = res[3];

      document.getElementById("txtmaingend").value = res[4];

      document.getElementById("txtstockcode").value = res[6];
      document.getElementById("hidstockcode").value = res[5];

      document.getElementById("txtstockquty").removeAttribute('disabled');
      document.getElementById("txtstockquty").value = res[9];

      if (res[8] == 'Y')
      {
      document.getElementById("optnonracikan").removeAttribute('disabled');
      document.getElementById("optracikan").removeAttribute('disabled');

      document.getElementById("optnonracikan").checked = false;
      document.getElementById("optracikan").checked = true;

      document.getElementById("hidprscconc").value = res[8];        
      }
      else if (res[8] == 'N')
      {
      document.getElementById("optnonracikan").removeAttribute('disabled');
      document.getElementById("optracikan").removeAttribute('disabled');

      document.getElementById("optnonracikan").checked = true;
      document.getElementById("optracikan").checked = false;

      document.getElementById("hidprscconc").value = res[8];        
      }
      else
      {
      document.getElementById("optnonracikan").removeAttribute('disabled');
      document.getElementById("optracikan").removeAttribute('disabled');

      document.getElementById("optnonracikan").checked = false;
      document.getElementById("optracikan").checked = false;

      document.getElementById("hidprscconc").value = '';        
      }        

      document.getElementById("txtstockbtch").removeAttribute('disabled');
      document.getElementById("txtstockbtch").value = res[7];

      }      
        //}
    }
  }



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
  var url="TRXADRUG01V.php";
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


    // ambil Teks Batch Code, 

var batchku;
function ambilbatch(kata,stockcode)
{
  if(kata.length > 5)
  {
    document.getElementById("tblbatch").innerHTML = "";
    document.getElementById("tblbatch").style.visibility = "hidden";
  }
  else
  {
  batchku = buatajaxbatch();
  //var url="TRXAPOLI01C-ANAMNESA.php";
  var url="TRXADRUG01C-BATCH.php";

  batchku.onreadystatechange=stateChangedbatch;
  var params = "q="+kata+"|"+stockcode;
  batchku.open("POST",url,true);
  batchku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  batchku.setRequestHeader("Content-length", params.length);
  batchku.setRequestHeader("Connection", "close");
  batchku.send(params);
  }
} 

function buatajaxbatch()
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

function stateChangedbatch()
{
  var data;
  if (batchku.readyState==4 && batchku.status==200)
  {
  data=batchku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblbatch").innerHTML = data;
    document.getElementById("tblbatch").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblbatch").innerHTML = "";
    document.getElementById("tblbatch").style.visibility = "hidden";
    }
  }
}

function isibatch(outbatch)
{
  try 
  {
  document.getElementById("txtstockbtch").value = outbatch;
  document.getElementById("txtstockbtch").focus();
  document.getElementById("tblbatch").style.visibility = "hidden";
  document.getElementById("tblbatch").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


// Hapus 
  var ajaxhapus;
  function hapuscode(prsccode,stockcode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="TRXAPOLI04D.php";
    var url="TRXADRUG01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+prsccode+"|"+stockcode;
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
        //document.getElementById('txtstockcode').focus();
    }
  }
// Selesai hapus Data 
