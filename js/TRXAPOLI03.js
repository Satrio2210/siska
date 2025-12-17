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

        document.getElementById('txtstockcode').setAttribute('disabled','true');
        document.getElementById('txtstockquty').setAttribute('disabled','true');
        var dokter = document.getElementById('hidcsbldoct').value;
        ambilregicode('x',dokter);

      }
      else
      {
        document.getElementById('txtsearch').setAttribute('disabled','true');
        document.getElementById('txtstockcode').setAttribute('disabled','true');
        document.getElementById('txtstockquty').setAttribute('disabled','true');


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
  var url="TRXAPOLI03C-REGI.php";
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

function isiregi(outcsblcode,outpaticode,outmainname,outmaingend,outmainage,outregipaym,outpaymcode,outregipoli)

{
  try 
  {
  document.getElementById("txtcsblcode").value = outcsblcode;
  
  document.getElementById("txtpaticode").value = outpaticode;
  document.getElementById("txtmainname").value = outmainname;
  document.getElementById("txtmaingend").value = outmaingend;
  document.getElementById("txtmainage").value = outmainage;


  document.getElementById("txtregipaym").value = outregipaym;
  document.getElementById("hidregipaym").value = outpaymcode;
  document.getElementById("hidmediroom").value = outregipoli;
   
  ambilscreen(outcsblcode);
  
  document.getElementById("txtstockcode").removeAttribute('disabled');
  document.getElementById("txtstockquty").removeAttribute('disabled');

  document.getElementById("txtsearch").value = '';

  document.getElementById("txtstockcode").focus();
  document.getElementById("tblregi").style.visibility = "hidden";
  document.getElementById("tblregi").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

    // ambil List Tindakan 
    
var bhpku;
function ambilbhp(kata,regipoli)
{
  if(kata.length > 7)
  {
    document.getElementById("tblbhp").innerHTML = "";
    document.getElementById("tblbhp").style.visibility = "hidden";
  }
  else
  {
  bhpku = buatajaxbhp();
  //var url="TRXAPOLI01C-ANAMNESA.php";
  var url="TRXAPOLI03C-BHP.php";
  bhpku.onreadystatechange=stateChangedbhp;
  var params = "q="+kata+"|"+regipoli;
  bhpku.open("POST",url,true);
  bhpku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  bhpku.setRequestHeader("Content-length", params.length);
  bhpku.setRequestHeader("Connection", "close");
  bhpku.send(params);
  }
} 

function buatajaxbhp()
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

function stateChangedbhp()
{
  var data;
  if (bhpku.readyState==4 && bhpku.status==200)
  {
  data=bhpku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblbhp").innerHTML = data;
    document.getElementById("tblbhp").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblbhp").innerHTML = "";
    document.getElementById("tblbhp").style.visibility = "hidden";
    }
  }
}

function isibhp(outstockcode,outstockname,outstockpric, outstockamnt)

{
  try 
  {
  
  document.getElementById("txtstockcode").value = outstockname;

  document.getElementById("hidstockcode").value = outstockcode;
  
  document.getElementById("hidstockpric").value = outstockpric;

  document.getElementById("hidstockamnt").value = outstockamnt;

  document.getElementById("txtstockquty").focus();
  document.getElementById("tblbhp").style.visibility = "hidden";
  document.getElementById("tblbhp").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}



  // Input Data Posisi dari form ke Tabel 
 //  incsblcode,incsbldoct,instockcode,instockpric,instockquty,inmediroom
  var ajaxinput;
  function input(csblcode,csbldoct,stockcode,stockpric,stockquty,mediroom)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAPOLI03E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+csblcode+"|"+csbldoct+"|"+stockcode+"|"+stockpric+"|"+stockquty+"|"+mediroom;
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

        document.getElementById('txtstockcode').value = '';
        document.getElementById('hidstockcode').value = '';
        document.getElementById('hidstockpric').value = '';
        document.getElementById('hidstockamnt').value = '';
        document.getElementById('txtstockquty').value = '1';

        var csblcode = document.getElementById('txtcsblcode').value;
        ambilscreen(csblcode);

        document.getElementById('txtstockcode').focus();

        //}
    }
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
function ambilscreen(csblcode)
{
  if(csblcode.length > 14)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXAPOLI03V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+csblcode;
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
  function hapuscode(csblcode,stockcode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="TBLIUNIT01D.php";
    var url="TRXAPOLI03D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+csblcode+"|"+stockcode;
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
        var incsblcode = document.getElementById('txtcsblcode').value;
        ambilscreen(incsblcode);
        document.getElementById('txtstockcode').focus();
    }
  }
// Selesai hapus Data 
