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

      document.getElementById('optmasttype').setAttribute('disabled','true');

      document.getElementById('optmastpaym').setAttribute('disabled','true');

      document.getElementById('txtmastuser').setAttribute('disabled','true');


      document.getElementById('txtmedicode').setAttribute('disabled','true');

      document.getElementById("optprosentase").setAttribute('disabled','true');
      document.getElementById("optfixrate").setAttribute('disabled','true');

      document.getElementById("txtpartuser").setAttribute('disabled','true');

      document.getElementById("txtparthome").setAttribute('disabled','true');

      document.getElementById("txtmaxiamnt").setAttribute('disabled','true');

      document.getElementById("txtminiamnt").setAttribute('disabled','true');

        ambilscreen('');
      }
      else
      {
      document.getElementById("txtfeecode").setAttribute('disabled','true');

      document.getElementById("txtmastroom").setAttribute('disabled','true');

      document.getElementById('optmasttype').setAttribute('disabled','true');

      document.getElementById('optmastpaym').setAttribute('disabled','true');

      document.getElementById('txtmastuser').setAttribute('disabled','true');


      document.getElementById('txtmedicode').setAttribute('disabled','true');

      document.getElementById("optprosentase").setAttribute('disabled','true');
      document.getElementById("optfixrate").setAttribute('disabled','true');

      document.getElementById("txtpartuser").setAttribute('disabled','true');

      document.getElementById("txtparthome").setAttribute('disabled','true');

      document.getElementById("txtmaxiamnt").setAttribute('disabled','true');

      document.getElementById("txtminiamnt").setAttribute('disabled','true');
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
    var url="TRXAMEDI02X.php";
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
        document.getElementById('txtfeecode').value=data;
      }
      else
      {
        document.getElementById('txtfeecode').value='';
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
  var url="TRXAMEDI02C-POLI.php";
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

  document.getElementById('optmasttype').removeAttribute('disabled');
  document.getElementById('optmastpaym').removeAttribute('disabled');
  document.getElementById('txtmastuser').removeAttribute('disabled');
  document.getElementById('txtmedicode').removeAttribute('disabled');
  document.getElementById('optprosentase').removeAttribute('disabled');
  document.getElementById('optfixrate').removeAttribute('disabled');
  document.getElementById('txtpartuser').removeAttribute('disabled');
  document.getElementById('txtparthome').removeAttribute('disabled');
  document.getElementById('txtmaxiamnt').removeAttribute('disabled');
  document.getElementById('txtminiamnt').removeAttribute('disabled');

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
  var url="TRXAMEDI02C-USER.php";
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


// tabel Medical Action

var mediku;
function ambilmedicode(mediroom,meditype,medipaym,kata)
{
  if(kata.length > 5)
  {
  document.getElementById("tblmedi").style.visibility = "hidden";
  }
  else
  {
  mediku = buatajaxmedicode();
  var url="TRXAMEDI02C-MEDI.php";
  mediku.onreadystatechange=stateChangedmedicode;
  var params = "q="+mediroom+"|"+meditype+"|"+medipaym+"|"+kata;
  //alert(params);
  mediku.open("POST",url,true);
  mediku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  mediku.setRequestHeader("Content-length", params.length);
  mediku.setRequestHeader("Connection", "close");
  mediku.send(params);
  }
} 
function buatajaxmedicode()
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

function stateChangedmedicode()
{
  var data;
  if (mediku.readyState==4 && mediku.status==200)
  {
  data=mediku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblmedi").innerHTML = data;
    document.getElementById("tblmedi").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblmedi").innerHTML = "";
    document.getElementById("tblmedi").style.visibility = "hidden";
    }
  }
}

function isimedicode(outmedicode,outmediname)
{
  try 
  {
  document.getElementById("txtmedicode").value = outmediname;
  document.getElementById("hidmedicode").value = outmedicode;
  document.getElementById("optprosentase").checked = false;
  document.getElementById("optfixrate").checked = false;
  document.getElementById("txtparthome").value = '';

  document.getElementById("txtmedicode").focus();
  document.getElementById("tblmedi").style.visibility = "hidden";
  document.getElementById("tblmedi").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


  // Input Data Posisi dari form ke Tabel feemast
// infeecode,inmastroom,inmasttype,inmastpaym,inmastuser,inmedicode,inmastrate,inpartuser,inparthome,inmaxiamnt,inminiamnt
  var ajaxinput;
  function input(feecode,mastroom,masttype,mastpaym,mastuser,medicode,mastrate,partuser,parthome,maxiamnt,miniamnt)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAMEDI02E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+feecode+"|"+mastroom+"|"+masttype+"|"+mastpaym+"|"+mastuser+"|"+medicode+"|"+mastrate+"|"+partuser+"|"+parthome+"|"+maxiamnt+"|"+miniamnt;
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

      document.getElementById("txtmedicode").value = '';
      document.getElementById("hidmedicode").value = '';

      document.getElementById("optprosentase").checked = false;
      document.getElementById("optfixrate").checked = false;

      document.getElementById("txtpartuser").value = '0';
      document.getElementById("txtparthome").value = '0';
      document.getElementById("txtmaxiamnt").value = '0';
      document.getElementById("txtminiamnt").value = '0';      

      periksaakses('PASS_MEDI_UPDT');
    }
  }
  // Selesai Input Data Wall ke Tabel feemast

// Tampilkan Data Tindakan  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(feecode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAMEDI02C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+feecode;
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
      document.getElementById("txtfeecode").value = res[1];

      document.getElementById("txtmastroom").value = res[2];
      document.getElementById("hidmastroom").value = res[3];

      document.getElementById('optmasttype').removeAttribute('disabled');
      document.getElementById('optmasttype').value = res[4];

      document.getElementById('optmastpaym').removeAttribute('disabled');
      document.getElementById('optmastpaym').value = res[5];

      document.getElementById('txtmastuser').removeAttribute('disabled');

      document.getElementById("txtmastuser").value = res[6];
      document.getElementById("hidmastuser").value = res[7];

      document.getElementById('txtmedicode').removeAttribute('disabled');
      document.getElementById("txtmedicode").value = res[8];
      document.getElementById("hidmedicode").value = res[9];

      document.getElementById("optprosentase").removeAttribute('disabled');
      document.getElementById("optfixrate").removeAttribute('disabled');

      if (res[10] == 'P') 
        {
        document.getElementById("optprosentase").checked = true;
        document.getElementById("optfixrate").checked = false;
        document.getElementById("hidmastrate").value = res[10];
        }

      else if (res[10] == 'F') 
        {
        document.getElementById("optprosentase").checked = false;
        document.getElementById("optfixrate").checked = true;
        document.getElementById("hidmastrate").value = res[10];
        }

      else
      {
        document.getElementById("optprosentase").checked = false;
        document.getElementById("optfixrate").checked = false;
        document.getElementById("hidmastrate").value = '';
      }

      var nominaluser = convertToRupiah(Math.round(res[11]));
      document.getElementById("txtpartuser").removeAttribute('disabled');
      document.getElementById("txtpartuser").value = nominaluser;

      var nominalhome = convertToRupiah(Math.round(res[12]));
      document.getElementById("txtparthome").removeAttribute('disabled');
      document.getElementById("txtparthome").value = nominalhome;

      var nominalmaxi = convertToRupiah(Math.round(res[13]));
      document.getElementById("txtmaxiamnt").removeAttribute('disabled');
      document.getElementById("txtmaxiamnt").value = nominalmaxi;

      var nominalmini = convertToRupiah(Math.round(res[14]));
      document.getElementById("txtminiamnt").removeAttribute('disabled');
      document.getElementById("txtminiamnt").value = nominalmini;

      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(feecode)
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAMEDI02D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+feecode;
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
  var url="TRXAMEDI02V.php";
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

  // periksa Tarif Fee 
    var tarifku;
  function ambiltarif(medicode)
  {
    tarifku = buatajaxtarif();
    var url="TRXAMEDI02C-TARIF.php";
    tarifku.onreadystatechange=stateChangedtarif;
    var params = "q="+medicode;
    //alert(params);
    tarifku.open("POST",url,true);
    tarifku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    tarifku.setRequestHeader("Content-length", params.length);
    tarifku.setRequestHeader("Connection", "close");
    tarifku.send(params);

  }

  function buatajaxtarif()
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

  function stateChangedtarif()
  {
  var data;
  if (tarifku.readyState==4)
    {
    xdata=tarifku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtparthome').value=data;
      }
      else
      {
        document.getElementById('txtparthome').value='0';
      }
    }
  }
// end periksa Tarif Fee

  // periksa Pengurangan Fee Klinik 
    var nilaiku;
  function ambilnilai(medicode,feeuser,rate)
  {
    nilaiku = buatajaxnilai();
    var url="TRXAMEDI02C-KALKULASI.php";
    nilaiku.onreadystatechange=stateChangednilai;
    var params = "q="+medicode+"|"+feeuser+"|"+rate;
    //alert(params);
    nilaiku.open("POST",url,true);
    nilaiku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    nilaiku.setRequestHeader("Content-length", params.length);
    nilaiku.setRequestHeader("Connection", "close");
    nilaiku.send(params);

  }

  function buatajaxnilai()
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

  function stateChangednilai()
  {
  var data;
  if (nilaiku.readyState==4)
    {
    xdata=nilaiku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtparthome').value=data;
      }
      else
      {
        document.getElementById('txtparthome').value='0';
      }
    }
  }
// end periksa Kalkulasi Fee Klinik
