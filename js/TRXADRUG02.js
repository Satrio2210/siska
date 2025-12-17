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
        periksafaktur('I')
        periksabayar(document.getElementById('txtdrugcode').value);
        ambilscreen(document.getElementById('txtdrugcode').value);

      }
      else
      {

        document.getElementById('txtdrugcode').setAttribute('disabled','true');
        document.getElementById('optpaymmode').setAttribute('disabled','true');

        document.getElementById('txtpaymamnt').setAttribute('disabled','true');
        document.getElementById('txtpaymdisc').setAttribute('disabled','true');

        document.getElementById('txtstockcode').setAttribute('disabled','true');
        document.getElementById('txtstockbtch').setAttribute('disabled','true');
        document.getElementById('txtstockquty').setAttribute('disabled','true');

        document.getElementById('optnonracikan').setAttribute('disabled','true'); 
        document.getElementById('optracikan').setAttribute('disabled','true');


        document.getElementById('txtdrugsigna').setAttribute('disabled','true');
        document.getElementById('txtdrugusage').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

  // periksa Kode Faktur 
    var fakturku;
  function periksafaktur(status)
  {
    fakturku = buatajaxfaktur();
    //var url="INVEMAST01X.php";
    var url="TRXADRUG02X.php";
    fakturku.onreadystatechange=stateChangedfaktur;
    var params = "q="+status;
    //alert(params);
    fakturku.open("POST",url,true);
    fakturku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    fakturku.setRequestHeader("Content-length", params.length);
    fakturku.setRequestHeader("Connection", "close");
    fakturku.send(params);

  }

  function buatajaxfaktur()
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

  function stateChangedfaktur()
  {
  var data;
  if (fakturku.readyState==4)
    {

    xdata=fakturku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtdrugcode').value=data;
        periksabayar(data);
        ambilscreen(data);
      }
      else
      {
        document.getElementById('txtdrugcode').value='';
      }
    }
  }
// end periksa Kode faktur  

  // periksa Nominal Yang Harus di bayar
    var bayarku;
  function periksabayar(faktur)
  {
    bayarku = buatajaxbayar();
    var url="TRXADRUG02X-BAYAR.php";
    bayarku.onreadystatechange=stateChangedbayar;
    var params = "q="+faktur;
    //alert(params);
    bayarku.open("POST",url,true);
    bayarku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    bayarku.setRequestHeader("Content-length", params.length);
    bayarku.setRequestHeader("Connection", "close");
    bayarku.send(params);

  }

  function buatajaxbayar()
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

  function stateChangedbayar()
  {
  var data;
  if (bayarku.readyState==4)
    {

    xdata=bayarku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtpaymamnt').value=data;
      }
      else
      {
        document.getElementById('txtpaymamnt').value='0';
      }
    }
  }
// end periksa Kode bayar  


    // ambil List Obat
    
function ambilobat(kata)
{
  if (kata.length > 10)
  {
    document.getElementById("tblobat").innerHTML = "";
    document.getElementById("tblobat").style.visibility = "hidden";
  }
  else
  {
  obatku = buatajaxobat();
  //var url="TRXAPOLI04C-obat.php";
  var url="TRXADRUG02C-OBAT.php"
  obatku.onreadystatechange=stateChangedobat;
  var params = "q="+kata;
  obatku.open("POST",url,true);
  obatku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  obatku.setRequestHeader("Content-length", params.length);
  obatku.setRequestHeader("Connection", "close");
  obatku.send(params);
  }
} 

function buatajaxobat()
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

function stateChangedobat()
{
  var data;
  if (obatku.readyState==4 && obatku.status==200)
  {
  data=obatku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblobat").innerHTML = data;
    document.getElementById("tblobat").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblobat").innerHTML = "";
    document.getElementById("tblobat").style.visibility = "hidden";
    }
  }
}

//function isiobat(outstockcode,outstockname,outstockpric, outstockquty)
function isiobat(outstockcode,outstockname)

{
  try 
  {
  
  document.getElementById("txtstockcode").value = outstockname;

  document.getElementById("hidstockcode").value = outstockcode;
  
  //document.getElementById("hidstockpric").value = outstockpric;

  //document.getElementById("hidstockquty").value = outstockquty;

  document.getElementById("txtstockbtch").focus();
  document.getElementById("tblobat").style.visibility = "hidden";
  document.getElementById("tblobat").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// end Isi List Obat

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
  var url="TRXADRUG02C-BATCH.php";

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

function isibatch(outbatch,outpric,outquty)
{
  try 
  {
  document.getElementById("hidstockpric").value = outpric;

  document.getElementById("hidstockquty").value = outquty;

  document.getElementById("txtstockbtch").value = outbatch;
  document.getElementById("txtstockbtch").focus();
  document.getElementById("tblbatch").style.visibility = "hidden";
  document.getElementById("tblbatch").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
// END batch Code



// isi data signa
var signaku;
function ambilsignacode(kata)
{
  if(kata.length > 5)
  {
    document.getElementById("tblsigna").innerHTML = "";
    document.getElementById("tblsigna").style.visibility = "hidden";
  }
  else
  {
  signaku = buatajaxsigna();
  var url="TRXADRUG02C-SIGNA.php";
  signaku.onreadystatechange=stateChangedsigna;
  var params = "q="+kata;
  signaku.open("POST",url,true);
  signaku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  signaku.setRequestHeader("Content-length", params.length);
  signaku.setRequestHeader("Connection", "close");
  signaku.send(params);
  }
} 

function buatajaxsigna()
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

function stateChangedsigna()
{
  var data;
  if (signaku.readyState==4 && signaku.status==200)
  {
  data=signaku.responseText;

      if(data.length>3)
    {   
    document.getElementById("tblsigna").innerHTML = data;
    document.getElementById("tblsigna").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblsigna").innerHTML = "";
    document.getElementById("tblsigna").style.visibility = "hidden";
    }
  }
}

function isisigna(outsgnacode,outsgnaname)

{
  try 
  {
  document.getElementById("txtdrugsigna").value = outsgnaname;
  
  document.getElementById("hiddrugsigna").value = outsgnacode;
   
 
  document.getElementById("txtdrugusage").focus();
  document.getElementById("tblsigna").style.visibility = "hidden";
  document.getElementById("tblsigna").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


  // Input Data Posisi dari form ke Tabel 
 // indrugcode,inpaymmode,inpaymamnt,inpaymdisc,instockcode,instockpric,instockbtch,instockquty,indrugconc, indrugsgna, indrugusag
  var ajaxinput;
  function input(drugcode,paymmode,paymamnt,paymdisc,stockcode,stockpric,stockbtch,stockquty,drugconc,drugsgna,drugusag)
  {
    ajaxinput = buatajaxinput();
    var url="TRXADRUG02E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+drugcode+"|"+paymmode+"|"+paymamnt+"|"+paymdisc+"|"+stockcode+"|"+stockpric+"|"+stockbtch+"|"+stockquty+"|"+drugconc+"|"+drugsgna+"|"+drugusag;
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

        document.getElementById('txtpaymamnt').value = '';
        document.getElementById('txtpaymdisc').value = '0';
        document.getElementById('txtstockcode').value = '';
        document.getElementById('hidstockcode').value = '';
        document.getElementById('hidstockpric').value = '';
        document.getElementById('hidstockquty').value = '';

        document.getElementById('txtstockbtch').value = '';
        document.getElementById('txtstockquty').value = '1';

        document.getElementById('optnonracikan').checked = false;
        document.getElementById('optracikan').checked = false;

        document.getElementById('hiddrugconc').value = '';

        document.getElementById('txtdrugsigna').value = '';
        document.getElementById('hiddrugsigna').value = '';

        document.getElementById('txtdrugusage').value = '';


        var drugcode = document.getElementById('txtdrugcode').value;
        periksabayar(drugcode);
        ambilscreen(drugcode);

        document.getElementById('txtstockcode').focus();

        //}
    }
  }
  // Selesai Input Data




// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(drugcode)
{
  if(drugcode.length > 14)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXADRUG02V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+drugcode;
  //alert(params);
  
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


// Hapus 
  var ajaxhapus;
  function hapuscode(drugcode,stockcode)
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXADRUG02D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+drugcode+"|"+stockcode;
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
        var indrugcode = document.getElementById('txtdrugcode').value;
        periksabayar(indrugcode);
        ambilscreen(indrugcode);
        document.getElementById('txtstockcode').focus();
    }
  }
// Selesai hapus Data 
