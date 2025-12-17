  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAMEDI02X-AKSES.php";
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

        document.getElementById('txtmastroom').focus();
        document.getElementById('optmastpaym').setAttribute('disabled','true');
        document.getElementById('txtmastuser').setAttribute('disabled','true');
        document.getElementById('txtmaxiamnt').setAttribute('disabled','true');
        document.getElementById('txtnomiamnt').setAttribute('disabled','true');

        ambilscreen('');
      }
      else
      {
        document.getElementById('txtmastroom').setAttribute('disabled','true');
        document.getElementById('optmastpaym').setAttribute('disabled','true');
        document.getElementById('txtmastuser').setAttribute('disabled','true');
        document.getElementById('txtmaxiamnt').setAttribute('disabled','true');
        document.getElementById('txtnomiamnt').setAttribute('disabled','true');
        document.getElementById('txtsearch').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


  // periksa Kode Fee 
    var mediku;
  function periksamedical(status)
  {
    mediku = buatajaxmedical();
    var url="TRXAMEDI04X.php";
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
        document.getElementById('txtvstcode').value=data;
      }
      else
      {
        document.getElementById('txtvstcode').value='';
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
  var url="TRXAMEDI04C-POLI.php";
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
  document.getElementById("txtmastroom").value = outpoliname;
  document.getElementById("hidmastroom").value = outpolicode;

  document.getElementById('optmastpaym').removeAttribute('disabled');
  document.getElementById('txtmastuser').removeAttribute('disabled');

  document.getElementById('txtmaxiamnt').removeAttribute('disabled');
  document.getElementById('txtnomiamnt').removeAttribute('disabled');

  document.getElementById("txtmastroom").focus();
  document.getElementById("tblpoli").style.visibility = "hidden";
  document.getElementById("tblpoli").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}



// tabel User Iden

var userku;
function ambiluseriden(useriden)
{
  if(useriden.length > 5)
  {
  document.getElementById("tbluser").style.visibility = "hidden";
  }
  else
  {
  userku = buatajaxuseriden();
  var url="TRXAMEDI04C-USER.php";
  userku.onreadystatechange=stateChangeduseriden;
  var params = "q="+useriden;
  userku.open("POST",url,true);
  userku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  userku.setRequestHeader("Content-length", params.length);
  userku.setRequestHeader("Connection", "close");
  userku.send(params);
  }
} 
function buatajaxuseriden()
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

function stateChangeduseriden()
{
  var data;
  if (userku.readyState==4 && userku.status==200)
  {
  data=userku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbluser").innerHTML = data;
    document.getElementById("tbluser").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbluser").innerHTML = "";
    document.getElementById("tbluser").style.visibility = "hidden";
    }
  }
}

function isiuseriden(outuseriden,outusername)
{
  try 
  {
  document.getElementById("txtmastuser").value = outusername;
  document.getElementById("hidmastuser").value = outuseriden;

  document.getElementById("txtmastuser").focus();
  document.getElementById("tbluser").style.visibility = "hidden";
  document.getElementById("tbluser").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

  // Input Data Posisi dari form ke Tabel attmast
  
//input(invstcode,inmastroom,inmastpaym,inmastuser,inmaxiamnt,innomiamnt);
  var ajaxinput;
  function input(vstcode,mastroom,mastpaym,mastuser,maxiamnt,nomiamnt)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAMEDI04E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+vstcode+"|"+mastroom+"|"+mastpaym+"|"+mastuser+"|"+maxiamnt+"|"+nomiamnt;
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
      document.getElementById("txtmastroom").value = '';


      document.getElementById("txtmastuser").value = '';
      document.getElementById("hidmastuser").value = '';
      document.getElementById("txtmaxiamnt").value = '';
      document.getElementById("txtnomiamnt").value = '';

      periksaakses('PASS_MEDI_UPDT');
    }
  }
  // Selesai Input Data Wall ke Tabel feemast

// Tampilkan Data Tindakan  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(vstcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAMEDI04C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+vstcode;
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
      document.getElementById("txtvstcode").value = res[1];

      document.getElementById("txtmastroom").value = res[2];
      document.getElementById("hidmastroom").value = res[3];

      document.getElementById('optmastpaym').removeAttribute('disabled');
      document.getElementById('optmastpaym').value = res[4];

      document.getElementById('txtmastuser').removeAttribute('disabled');
      document.getElementById("txtmastuser").value = res[5];
      document.getElementById("hidmastuser").value = res[6];

      document.getElementById("txtmaxiamnt").removeAttribute('disabled');
      document.getElementById("txtmaxiamnt").value = res[7];

      var nominalamount = convertToRupiah(Math.round(res[8]));
      document.getElementById("txtnomiamnt").removeAttribute('disabled');
      document.getElementById("txtnomiamnt").value = nominalamount;

      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(vstcode)
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAMEDI04D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+attcode;
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
function ambilscreen(kode)
{
  if(kode.length > 8)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXAMEDI04V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+kode;
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

