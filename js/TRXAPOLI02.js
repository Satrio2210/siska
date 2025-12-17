  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPOLI01X-AKSES.php";
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

        document.getElementById('txtmedicode').setAttribute('disabled','true');
        document.getElementById('txttretquty').setAttribute('disabled','true');
        var dokter = document.getElementById('hidtretdoct').value;
        ambilregicode('x',dokter);
      }
      else
      {
        document.getElementById('txtsearch').setAttribute('disabled','true');
        document.getElementById('txtmedicode').setAttribute('disabled','true');
        document.getElementById('txttretquty').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

// ambil data pendaftaran
var regiku;
function ambilregicode(kata,dokter)
{
  if(kata.length > 5)
  {
    document.getElementById("tblregi").innerHTML = "";
    document.getElementById("tblregi").style.visibility = "hidden";
  }
  else
  {
  regiku = buatajaxregi();
  //var url="TRXAPOLI01C-ANAMNESA.php";
  var url="TRXAPOLI02C-REGI.php";
  regiku.onreadystatechange=stateChangedregi;
  var params = "q="+kata+"|"+dokter;
  regiku.open("POST",url,true);
  regiku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  regiku.setRequestHeader("Content-length", params.length);
  regiku.setRequestHeader("Connection", "close");
  regiku.send(params);
  }
} 

function buatajaxregi()
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

function stateChangedregi()
{
  var data;
  if (regiku.readyState==4 && regiku.status==200)
  {
  data=regiku.responseText;

      if(data.length>3)
    {   
    document.getElementById("tblregi").innerHTML = data;
    document.getElementById("tblregi").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblregi").innerHTML = "";
    document.getElementById("tblregi").style.visibility = "hidden";
    }
  }
}

function isiregi(outtretcode,outpaticode,outmainname,outmaingend,outmainage,outregipaym,outpaymcode,outregipoli)

{
  try 
  {
  document.getElementById("txttretcode").value = outtretcode;
  
  document.getElementById("txtpaticode").value = outpaticode;
  document.getElementById("txtmainname").value = outmainname;
  document.getElementById("txtmaingend").value = outmaingend;
  document.getElementById("txtmainage").value = outmainage;


  document.getElementById("txtregipaym").value = outregipaym;
  document.getElementById("hidregipaym").value = outpaymcode;
  document.getElementById("hidmediroom").value = outregipoli;
   
  ambilscreen(outtretcode);
  ambiltindakan('x',outregipoli,outpaymcode);
  
  document.getElementById("txtmedicode").removeAttribute('disabled');
  document.getElementById("txttretquty").removeAttribute('disabled');

  document.getElementById("txtsearch").value = '';

  document.getElementById("txtmedicode").focus();
  document.getElementById("tblregi").style.visibility = "hidden";
  document.getElementById("tblregi").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

    // ambil List Tindakan 
    
var tindakanku;
function ambiltindakan(kata,regipoli,regipaym)
{
  if(kata.length > 15)
  {
    document.getElementById("tbltindakan").innerHTML = "";
    document.getElementById("tbltindakan").style.visibility = "hidden";
  }
  else
  {
  tindakanku = buatajaxtindakan();
  //var url="TRXAPOLI01C-ANAMNESA.php";
  var url="TRXAPOLI02C-TINDAKAN.php";
  tindakanku.onreadystatechange=stateChangedtindakan;
  var params = "q="+kata+"|"+regipoli+"|"+regipaym;
  tindakanku.open("POST",url,true);
  tindakanku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  tindakanku.setRequestHeader("Content-length", params.length);
  tindakanku.setRequestHeader("Connection", "close");
  tindakanku.send(params);
  }
} 

function buatajaxtindakan()
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

function stateChangedtindakan()
{
  var data;
  if (tindakanku.readyState==4 && tindakanku.status==200)
  {
    data=tindakanku.responseText;
    if(data.length>3)
      {   
        document.getElementById("tbltindakan").innerHTML = data;
        document.getElementById("tbltindakan").style.visibility = "";
      }
    else  
      {
      document.getElementById("tbltindakan").innerHTML = "";
      document.getElementById("tbltindakan").style.visibility = "hidden";
      }
  }
  //else
  //{
  //  data=tindakanku.status;
  //  alert(data);
  //}
}

function isitindakan(outmedicode,outmediname,outmedirate)

{
  try 
  {
  
  document.getElementById("txtmedicode").value = outmediname;

  document.getElementById("hidmedicode").value = outmedicode;
  
  document.getElementById("hidmedirate").value = outmedirate;
  

  document.getElementById("txttretquty").focus();
  document.getElementById("tbltindakan").style.visibility = "hidden";
  document.getElementById("tbltindakan").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}



  // Input Data Posisi dari form ke Tabel 
//   intretcode,intretdoct,inmedicode,inmedirate,intretquty,inmediroom
  var ajaxinput;
  function input(tretcode,tretdoct,medicode,medirate,tretquty,mediroom)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAPOLI02E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+tretcode+"|"+tretdoct+"|"+medicode+"|"+medirate+"|"+tretquty+"|"+mediroom;
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

        document.getElementById('txtmedicode').value = '';
        document.getElementById('hidmedicode').value = '';
        document.getElementById('hidmedirate').value = '';
        document.getElementById('txttretquty').value = '1';

        var tretcode = document.getElementById('txttretcode').value;

        var regipolicode = document.getElementById("hidmediroom").value;
        

        var regipaymcode = document.getElementById("hidregipaym").value;        

        ambilscreen(tretcode);
        ambiltindakan('x',regipolicode,regipaymcode);

        document.getElementById('txtmedicode').focus();

        //}
    }
    //else
    //{
    //  alert(ajaxinput.readyState);
    //}
  }
  // Selesai Input Data

// Tampilkan Data Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(tretcode,paticode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPOLI01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+regicode+"|"+paticode;
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
//      1        2          3       4        5         6        7        8         9         10       11
//|$regicode|$paticode|$mainname|$fullage|$gender|$regipaym|$examhght|$examwght|$examblod|$examanam|$examdiag|

      var res = data.split("|");
      document.getElementById("txtexamcode").value = res[1];

      document.getElementById("txtpaticode").value = res[2];

      document.getElementById("txtmainname").value = res[3];

      document.getElementById("txtmaingend").value = res[5];

      document.getElementById("txtmainage").value = res[4];

      document.getElementById("txtregipaym").value = res[6];

      document.getElementById("txtexamhght").removeAttribute('disabled');
      document.getElementById("txtexamhght").value = res[7];

      document.getElementById("txtexamwght").removeAttribute('disabled');
      document.getElementById("txtexamwght").value = res[8];

      document.getElementById("txtexamblod").removeAttribute('disabled');
      document.getElementById("txtexamblod").value = res[9];

      document.getElementById("txtexamanam").removeAttribute('disabled');
      document.getElementById("txtexamanam").value = res[10];

      document.getElementById("txtexamdiag").removeAttribute('disabled');
      document.getElementById("txtexamdiag").value = res[11];

      document.getElementById("txtexamhght").focus();

      }      
        //}
    }
  }



// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(tretcode)
{
  if(tretcode.length > 14)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXAPOLI02V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+tretcode;
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
  function hapuscode(tretcode,medicode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="TBLIUNIT01D.php";
    var url="TRXAPOLI02D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+tretcode+"|"+medicode;
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
        var intretcode = document.getElementById('txttretcode').value;
        ambilscreen(intretcode);
        document.getElementById('txtmedicode').focus();
    }
  }
// Selesai hapus Data 
