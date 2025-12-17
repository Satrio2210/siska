  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXALABO01X-AKSES.php";
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
        periksalaborat('1');

        document.getElementById('txtsubscode').focus();
        document.getElementById('txtsizename').setAttribute('disabled','true');
        document.getElementById('txtsizename2').setAttribute('disabled','true');
        document.getElementById('txtunitname').setAttribute('disabled','true');

        document.getElementById('optrange').setAttribute('disabled','true');
        document.getElementById('optstring').setAttribute('disabled','true');

        document.getElementById('txtvalumin').setAttribute('disabled','true');
        document.getElementById('txtvalumax').setAttribute('disabled','true');
        document.getElementById('txtstring').setAttribute('disabled','true');

        document.getElementById('optpatigend').setAttribute('disabled','true');

        ambilscreen('');
      }
      else
      {
        document.getElementById('txtsubscode').focus();
        document.getElementById('txtsizename').setAttribute('disabled','true');
        document.getElementById('txtsizename2').setAttribute('disabled','true');
        document.getElementById('txtunitname').setAttribute('disabled','true');

        document.getElementById('optrange').setAttribute('disabled','true');
        document.getElementById('optstring').setAttribute('disabled','true');

        document.getElementById('txtvalumin').setAttribute('disabled','true');
        document.getElementById('txtvalumax').setAttribute('disabled','true');
        document.getElementById('txtstring').setAttribute('disabled','true');

        document.getElementById('optpatigend').setAttribute('disabled','true');
        document.getElementById('txtsearch').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


  // periksa Kode Pemeriksaan Laborat
   var laboratku;
   
  function periksalaborat(status)
  {
    laboratku = buatajaxmedical();
    var url="LABOMAST01X.php";
    laboratku.onreadystatechange=stateChangedmedical;
    var params = "q="+status;
    //alert(params);
    laboratku.open("POST",url,true);
    laboratku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    laboratku.setRequestHeader("Content-length", params.length);
    laboratku.setRequestHeader("Connection", "close");
    laboratku.send(params);

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
  if (laboratku.readyState==4)
    {

    xdata=laboratku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtmastcode').value=data;
      }
      else
      {
        document.getElementById('txtmastcode').value='';
      }
    }
  }
// end periksa Kode Pemeriksaan Laborat

// tabel Group Pemeriksaan

var subsku;
function ambilsubscode(subscode)
{
  if(subscode.length > 5)
  {
  document.getElementById("tblcategory").style.visibility = "hidden";
  }
  else
  {
  subsku = buatajaxsubscode();
  var url="LABOMAST01C-SUBS.php";
  subsku.onreadystatechange=stateChangedsubscode;
  var params = "q="+subscode;
  subsku.open("POST",url,true);
  subsku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  subsku.setRequestHeader("Content-length", params.length);
  subsku.setRequestHeader("Connection", "close");
  subsku.send(params);
  }
} 
function buatajaxsubscode()
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

function stateChangedsubscode()
{
  var data;
  if (subsku.readyState==4 && subsku.status==200)
  {
  data=subsku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblcategory").innerHTML = data;
    document.getElementById("tblcategory").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblcategory").innerHTML = "";
    document.getElementById("tblcategory").style.visibility = "hidden";
    }
  }
}

function isisubscode(outsubscode,outsubsname)
{
  try 
  {
  document.getElementById("txtsubscode").value = outsubsname;
  document.getElementById("hidsubscode").value = outsubscode;

  document.getElementById('txtsizename').removeAttribute('disabled');
   document.getElementById('txtsizename2').removeAttribute('disabled');
  document.getElementById('txtunitname').removeAttribute('disabled');

  document.getElementById('optrange').removeAttribute('disabled');
  document.getElementById('optrange').checked = true;
  document.getElementById('hidnilainormal').value = 'N';

  document.getElementById('optstring').removeAttribute('disabled');

  document.getElementById('txtvalumin').removeAttribute('disabled');
  document.getElementById('txtvalumax').removeAttribute('disabled');

  document.getElementById('optpatigend').removeAttribute('disabled');

  document.getElementById("txtsizename").focus();
  document.getElementById("tblcategory").style.visibility = "hidden";
  document.getElementById("tblcategory").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// data tindakan

var tindakanku;
function ambilsizecode(sizecode)
{
  if(sizecode.length > 5)
  {
  document.getElementById("tbltindakan").style.visibility = "hidden";
  }
  else
  {
  tindakanku = buatajaxsizecode();
  var url="LABOMAST01C-SIZE.php";
  tindakanku.onreadystatechange=stateChangedsizecode;
  var params = "q="+sizecode;
  tindakanku.open("POST",url,true);
  tindakanku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  tindakanku.setRequestHeader("Content-length", params.length);
  tindakanku.setRequestHeader("Connection", "close");
  tindakanku.send(params);
  }
} 
function buatajaxsizecode()
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

function stateChangedsizecode()
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
}

function isisizecode(outsizecode,outsizename)
{
  try 
  {
  document.getElementById("txtsizename").value = outsizename;
  document.getElementById("hidsizecode").value = outsizecode;

  document.getElementById("txtsizename").focus();
  document.getElementById("tbltindakan").style.visibility = "hidden";
  document.getElementById("tbltindakan").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// data tindakan

// tabel User Iden

var unitku;
function ambilsatuan(unitcode)
{
  if(unitcode.length > 5)
  {
  document.getElementById("tblsatuan").style.visibility = "hidden";
  }
  else
  {
  unitku = buatajaxsatuan();
  var url="LABOMAST01C-UNIT.php";
  unitku.onreadystatechange=stateChangedsatuan;
  var params = "q="+unitcode;
  unitku.open("POST",url,true);
  unitku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  unitku.setRequestHeader("Content-length", params.length);
  unitku.setRequestHeader("Connection", "close");
  unitku.send(params);
  }
} 
function buatajaxsatuan()
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

function stateChangedsatuan()
{
  var data;
  if (unitku.readyState==4 && unitku.status==200)
  {
  data=unitku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblsatuan").innerHTML = data;
    document.getElementById("tblsatuan").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblsatuan").innerHTML = "";
    document.getElementById("tblsatuan").style.visibility = "hidden";
    }
  }
}

function isiunitcode(outunitcode,outunitname)
{
  try 
  {
  document.getElementById("txtunitname").value = outunitname;
  document.getElementById("hidunitname").value = outunitcode;

  document.getElementById("txtvalumin").focus();
  document.getElementById("tblsatuan").style.visibility = "hidden";
  document.getElementById("tblsatuan").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

  // Input Data Posisi dari form ke Tabel attmast
  
//inmastcode,insubscode,insizecode,insizename,inunitname,invalumin,invalumax,inpatigend
  var ajaxinput;
  function input(mastcode,subscode,sizecode,sizename,unitname,valumin,valumax,valustring,patigend)
  {
    ajaxinput = buatajaxinput();
    var url="LABOMAST01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+mastcode+"|"+subscode+"|"+sizecode+"|"+sizename+"|"+unitname+"|"+valumin+"|"+valumax+"|"+valustring+"|"+patigend;
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
      document.getElementById("txtsubscode").value = '';
      document.getElementById("hidsubscode").value = '';

      document.getElementById("txtsizename").value = '';
      document.getElementById("txtsizename2").value = '';

      document.getElementById("txtunitname").value = '';
      document.getElementById("hidunitname").value = '';

      document.getElementById('optrange').checked = false;
      document.getElementById('optstring').checked = false;

      document.getElementById("txtvalumin").value = '';
      document.getElementById("txtvalumax").value = '';

      document.getElementById("txtstring").value = '';


      periksaakses('PASS_LABO_ENTR');
    }
  }
  // Selesai Input Data Wall ke Tabel feemast

// Tampilkan Data Tindakan  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(mastcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="LABOMAST01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+mastcode;
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
 //    1         2          3        4        5            6         7         8       9         10      11        12
// |$mastcode|$subscode|$subsname|$sizecode|$mediname|$sizename|$unitcode|$unitname|$valumin|$valumax|$valustrg|$patigend
      var res = data.split("|");
      document.getElementById("txtmastcode").value = res[1];

      document.getElementById("txtsubscode").value = res[3];
      document.getElementById("hidsubscode").value = res[2];

      document.getElementById('txtsizename').removeAttribute('disabled');
      document.getElementById('txtsizename').value = res[5];

      document.getElementById('txtsizename2').removeAttribute('disabled');
      document.getElementById('txtsizename2').value = res[6];

      document.getElementById("hidsizecode").value = res[4];

      document.getElementById('txtunitname').removeAttribute('disabled');
      document.getElementById("txtunitname").value = res[8];
      document.getElementById("hidunitname").value = res[7];

      document.getElementById("optrange").removeAttribute('disabled');
      document.getElementById("optstring").removeAttribute('disabled');

      if ( res[9] == '')
      {
      document.getElementById("optrange").checked = false;
      document.getElementById('txtvalumin').setAttribute('disabled','true');  
      document.getElementById("txtvalumin").value = res[9];  
      }
      else
      {
      document.getElementById("optrange").checked = true;
      document.getElementById("hidnilainormal").value = 'N';
      document.getElementById("txtvalumin").removeAttribute('disabled');
      document.getElementById("txtvalumin").value = res[9];        
      }

      if (res[10] == '')
      {
      document.getElementById('txtvalumax').setAttribute('disabled','true');
      document.getElementById("txtvalumax").value = res[10];  
      }
      else
      {
      document.getElementById("txtvalumax").removeAttribute('disabled');
      document.getElementById("txtvalumax").value = res[10];        
      }

      if (res[11] == '')
      {
      document.getElementById("optstring").checked = false;
      document.getElementById('txtstring').setAttribute('disabled','true');  
      document.getElementById("txtstring").value = res[11];  
      }
      else
      {
      document.getElementById("optstring").checked = true;
      document.getElementById("hidnilainormal").value = 'S';
      document.getElementById("txtstring").removeAttribute('disabled');
      document.getElementById("txtstring").value = res[11];        
      }


      document.getElementById("optpatigend").removeAttribute('disabled');
      document.getElementById("optpatigend").value = res[12];

      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(mastcode)
  {
    ajaxhapus = buatajaxhapus();
    var url="LABOMAST01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+mastcode;
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
  if(kode.length > 10)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="LABOMAST01V.php";
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




// tabel Pemeriksaan Manual

var stringku;
function ambilstringcode(stringcode)
{
  if(stringcode.length > 10)
  {
  document.getElementById("tblstring").style.visibility = "hidden";
  }
  else
  {
  stringku = buatajaxstringcode();
  var url="LABOMAST01C-STRING.php";
  stringku.onreadystatechange=stateChangedstringcode;
  var params = "q="+stringcode;
  stringku.open("POST",url,true);
  stringku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  stringku.setRequestHeader("Content-length", params.length);
  stringku.setRequestHeader("Connection", "close");
  stringku.send(params);
  }
} 
function buatajaxstringcode()
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

function stateChangedstringcode()
{
  var data;
  if (stringku.readyState==4 && stringku.status==200)
  {
  data=stringku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblstring").innerHTML = data;
    document.getElementById("tblstring").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblstring").innerHTML = "";
    document.getElementById("tblstring").style.visibility = "hidden";
    }
  }
}

function isistringcode(outstringcode,outstingname)
{
  try 
  {
  document.getElementById("txtstring").value = outstingname;
  //document.getElementById("hidstringcode").value = outstringcode;

  document.getElementById("txtstring").focus();
  document.getElementById("tblstring").style.visibility = "hidden";
  document.getElementById("tblstring").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
