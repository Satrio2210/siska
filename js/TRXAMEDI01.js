  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAMEDI01X-AKSES.php";
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
        periksamedical('1');

        document.getElementById('txtmediname').focus();
        document.getElementById('txtmedirate').setAttribute('disabled','true');
        document.getElementById('txtmediroom').setAttribute('disabled','true');
        document.getElementById('optmeditype').setAttribute('disabled','true');
        document.getElementById('optmedipaym').setAttribute('disabled','true');
        document.getElementById('txtmedinote').setAttribute('disabled','true');
        document.getElementById('optactive').setAttribute('disabled','true');
        document.getElementById('optnonactive').setAttribute('disabled','true');

        ambilscreen('');
      }
      else
      {
        document.getElementById('txtmediname').setAttribute('disabled','true');
        document.getElementById('txtmedirate').setAttribute('disabled','true');
        document.getElementById('txtmediroom').setAttribute('disabled','true');
        document.getElementById('optmeditype').setAttribute('disabled','true');
        document.getElementById('optmedipaym').setAttribute('disabled','true');
        document.getElementById('txtmedinote').setAttribute('disabled','true');
        document.getElementById('optactive').setAttribute('disabled','true');
        document.getElementById('optnonactive').setAttribute('disabled','true');
        document.getElementById('txtsearch').setAttribute('disabled','true');

      }
    }
  }
// end periksa akses  


  // periksa Kode Suplier 
    var mediku;
  function periksamedical(status)
  {
    mediku = buatajaxmedical();
    var url="TRXAMEDI01X.php";
    mediku.onreadystatechange=stateChangedmedical;
    var params = "q="+status;
    //alert(params);
    mediku.open("POST",url,true);
    mediku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    mediku.setRequestHeader("Content-length", params.length);
    mediku.setRequestHeader("Connection", "close");
    mediku.send(params);

  }

  function buatajaxmedical()
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

  function stateChangedmedical()
  {
  var data;
  if (mediku.readyState==4)
    {

    xdata=mediku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtmedicode').value=data;
      }
      else
      {
        document.getElementById('txtmedicode').value='';
      }
    }
  }
// end periksa Kode Tindakan 

// tabel Poli

var poliku;
function ambilpolicode(policode)
{
  if(policode.length > 5)
  {
  document.getElementById("tblpoli").style.visibility = "hidden";
  }
  else
  {
  poliku = buatajaxpolicode();
  var url="TRXAMEDI01C-POLI.php";
  poliku.onreadystatechange=stateChangedpolicode;
  var params = "q="+policode;
  poliku.open("POST",url,true);
  poliku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  poliku.setRequestHeader("Content-length", params.length);
  poliku.setRequestHeader("Connection", "close");
  poliku.send(params);
  }
} 
function buatajaxpolicode()
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

function stateChangedpolicode()
{
  var data;
  if (poliku.readyState==4 && poliku.status==200)
  {
  data=poliku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblpoli").innerHTML = data;
    document.getElementById("tblpoli").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblpoli").innerHTML = "";
    document.getElementById("tblpoli").style.visibility = "hidden";
    }
  }
}

function isipolicode(outpolicode,outpoliname)
{
  try 
  {
  document.getElementById("txtmediroom").value = outpoliname;
  document.getElementById("hidmediroom").value = outpolicode;
  document.getElementById("txtmediroom").focus();
  document.getElementById("tblpoli").style.visibility = "hidden";
  document.getElementById("tblpoli").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}



  // Input Data Posisi dari form ke Tabel tblfmedi

  var ajaxinput;
  function input(medicode,mediname,medirate,mediroom,meditype,medipaym,medinote,mediacti)
  {
    ajaxinput = buatajaxinput();
    //var url="TBLIUNIT01E.php";
    var url="TRXAMEDI01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+medicode+"|"+mediname+"|"+medirate+"|"+mediroom+"|"+meditype+"|"+medipaym+"|"+medinote+"|"+mediacti;
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
      document.getElementById("txtmediname").value = '';
      document.getElementById("txtmedirate").value = '0';

      document.getElementById("txtmediroom").value = '';
      document.getElementById("hidmediroom").value = '';

      document.getElementById("txtmedinote").value = '';

      document.getElementById("optactive").checked = false;
      document.getElementById("optnonactive").checked = false;

      document.getElementById("hidmediacti").value = '';

      periksaakses('PASS_MEDI_ENTR');
    }
  }
  // Selesai Input Data Wall ke Tabel tblitype

// Tampilkan Data Tindakan  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(medicode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAMEDI01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+medicode;
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
      var res = data.split("|");
      document.getElementById("txtmedicode").value = res[1];

      document.getElementById("txtmediname").value = res[2];

      var nominalrate = convertToRupiah(Math.round(res[3]));
      document.getElementById("txtmedirate").removeAttribute('disabled');
      document.getElementById("txtmedirate").value = nominalrate;

      document.getElementById("txtmediroom").removeAttribute('disabled');
      document.getElementById("txtmediroom").value = res[5];
      document.getElementById("hidmediroom").value = res[4];

      document.getElementById('optmeditype').removeAttribute('disabled');
      document.getElementById('optmeditype').value = res[6];

      document.getElementById('optmedipaym').removeAttribute('disabled');
      document.getElementById('optmedipaym').value = res[7];

      document.getElementById('txtmedinote').removeAttribute('disabled');
      document.getElementById("txtmedinote").value = res[8];   

      document.getElementById("optactive").removeAttribute('disabled');
      document.getElementById("optnonactive").removeAttribute('disabled');


      if (res[9] == 'A') 
        {
        document.getElementById("optactive").checked = true;
        document.getElementById("optnonactive").checked = false;
        document.getElementById("hidmediacti").value = res[9];
        }

      else if (res[9] == 'N') 
        {
        document.getElementById("optactive").checked = false;
        document.getElementById("optnonactive").checked = true;
        document.getElementById("hidmediacti").value = res[9];
        }

      else
      {
        document.getElementById("optactive").checked = false;
        document.getElementById("optnonactive").checked = false;
      }
      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(medicode)
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAMEDI01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+medicode;
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
        ambilscreen('');
    }
  }
// Selesai hapus Data Tindakan


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
  //var url="TBLIUNIT01V.php";
  var url="TRXAMEDI01V.php";
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

