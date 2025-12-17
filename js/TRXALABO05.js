  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="ACCESS.php";
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

        document.getElementById('txtmastcode').setAttribute('disabled','true');
        document.getElementById('txtlaborslt').setAttribute('disabled','true');

        document.getElementById('txtlabovalu').setAttribute('disabled','true');
        document.getElementById('txtlabonote').setAttribute('disabled','true');

        ambilscreen('',document.getElementById('hidlabodoct').value);

      }
      else
      {
        document.getElementById('txtmastcode').setAttribute('disabled','true');
        document.getElementById('txtlaborslt').setAttribute('disabled','true');

        document.getElementById('txtlabovalu').setAttribute('disabled','true');
        document.getElementById('txtlabonote').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

// ambil data rujukan pemeriksaan Laborat

var rujukanku;
function ambilrujukan(kata,gender,tindakan)
{
  if(kata.length > 5)
  {
    document.getElementById("tbllabomast").innerHTML = "";
    document.getElementById("tbllabomast").style.visibility = "hidden";
  }
  else
  {
  rujukanku = buatajaxrujukan();

  var url="TRXALABO05C-LABOMAST.php";
  rujukanku.onreadystatechange=stateChangedrujukan;
  var params = "q="+kata+"|"+gender+"|"+tindakan;
  //alert(params);
  rujukanku.open("POST",url,true);
  rujukanku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  rujukanku.setRequestHeader("Content-length", params.length);
  rujukanku.setRequestHeader("Connection", "close");
  rujukanku.send(params);
  }
} 

function buatajaxrujukan()
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

function stateChangedrujukan()
{
  var data;
  if (rujukanku.readyState==4 && rujukanku.status==200)
  {
  data=rujukanku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbllabomast").innerHTML = data;
    document.getElementById("tbllabomast").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbllabomast").innerHTML = "";
    document.getElementById("tbllabomast").style.visibility = "hidden";
    }
  }
}

function isirujukan(outmastcode,outsizename,outunitname,outvalumin,outvalumax,outvalustrg)
{
  try 
  {

  document.getElementById("hidmastcode").value = outmastcode;
  document.getElementById("txtmastcode").value = outsizename;
  
  if (outvalumin == '<')
  {
  var valuminmax = outvalumin+" "+outvalumax;  
  }
  else if (outvalumin == '>')
  {
  var valuminmax = outvalumin+" "+outvalumax;  
  }
  else if ((outvalumin == '') && (outvalumax == ''))
  {
  var valuminmax = outvalustrg;  
  } 
  else 
  {
  var valuminmax = outvalumin+" - "+outvalumax;  
  }
  

  document.getElementById("txtlabovalu").value = valuminmax;

  document.getElementById("txtlabounit").value = outunitname;

  document.getElementById("txtlaborslt").focus();
  
  document.getElementById("tbllabomast").style.visibility = "hidden";
  document.getElementById("tbllabomast").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// selesai ambil data rujukan

// input hasil pemeriksaan
// inlaboregi,inlabodoct,inmastcode,inlaborslt,inlabonote
  var ajaxinput;
  function input(laboregi,labodoct,mastcode,laborslt,labonote)
  {
    ajaxinput = buatajaxinput();
    var url="TRXALABO05E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+laboregi+"|"+labodoct+"|"+mastcode+"|"+laborslt+"|"+labonote;
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
        //document.getElementById('txtlaboregi').value = '';
        //document.getElementById('txtpaticode').value = '';

        var labodoct = document.getElementById('hidlabodoct').value;
        var laboregi = document.getElementById('txtlaboregi').value;
        //document.getElementById('txtmainname').value = '';
        //document.getElementById('txtmaingend').value = '';
        //document.getElementById('hidmaingend').value = '';

        //document.getElementById('txtmainage').value = '';
        //document.getElementById('txtbirtdate').value = '';

        //document.getElementById('txtmainaddr').value = '';
        //document.getElementById('txtregipaym').value = '';

        document.getElementById('txtmastcode').value = '';
        //document.getElementById('txtmastcode').setAttribute('disabled','true');
        document.getElementById('hidmastcode').value = '';

        document.getElementById('txtlaborslt').value = '';
        //document.getElementById('txtlaborslt').setAttribute('disabled','true');

        document.getElementById('txtlabovalu').value = '';
        //document.getElementById('txtlabovalu').setAttribute('disabled','true');

        document.getElementById('txtlabounit').value = '';

        document.getElementById('txtlabonote').value = '';
		//document.getElementById('txtlabonote').setAttribute('disabled','true');

		document.getElementById('txtmastcode').focus();

        ambilscreen('',labodoct);
        ambilhasil(laboregi);
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel trxalabo

// Tampilkan Data Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(regicode,paticode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXALABO05C.php";
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
        //alert(data);
//      1         2       3         4         5       6         7        8         9         10       
//|$regicode|$paticode|$mainname|$maingend|$gender|$maintitl|$fullage|$mainbirt|$mainaddr|$regipaym|
      var res = data.split("|"); 
      document.getElementById("txtlaboregi").value = res[1];

      ambilhasil(res[1]);

      document.getElementById("txtpaticode").value = res[2];

      document.getElementById("txtmainname").value = res[3];

      document.getElementById("txtmaingend").value = res[5];
      document.getElementById("hidmaingend").value = res[4];

      if (res[6] == 'Tn.')
      {
      document.getElementById("hidmaintitl").value = 'M';  
      }
      else if (res[6] == 'Ny.')
      {
      document.getElementById("hidmaintitl").value = 'F';  
      } 
      else if (res[6] == 'Nn.')
      {
      document.getElementById("hidmaintitl").value = 'F';  
      } 
      else if (res[6] == 'An.')
      {
      document.getElementById("hidmaintitl").value = 'C';  
      } 
            

      document.getElementById("txtmainage").value = res[7];

      document.getElementById("txtbirtdate").value = res[8];

      document.getElementById("txtmainaddr").value = res[9];

      document.getElementById("txtregipaym").value = res[10];

      document.getElementById("txtmastcode").removeAttribute('disabled');
      //document.getElementById("txtmastcode").value = res[11];

      document.getElementById("txtlaborslt").removeAttribute('disabled');
      //document.getElementById("txtlaborslt").value = res[12];

      document.getElementById("txtlabovalu").removeAttribute('disabled');
      //document.getElementById("txtlabovalu").value = res[13];

      //document.getElementById("txtlabounit").value = res[14];

      document.getElementById("txtlabonote").removeAttribute('disabled');
      //document.getElementById("txtlabonote").value = res[15];

      document.getElementById("txtmastcode").focus();

      }      
        //}
    }
  }




// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(kata,nakes)
{
  if(nakes.length > 5)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXALABO05V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+kata+"|"+nakes;
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


// tabel Hasil Pemeriksaan Laboratorium
var resultku;

function ambilhasil(regicode)
{
  if(regicode.length > 14)
  {
  document.getElementById("tblviewresult").style.visibility = "hidden";
  }
  else
  {
  resultku = buatajaxhasil();
  var url="TRXALABO05C-LABORESULT.php";
  resultku.onreadystatechange=stateChangedhasil;
  var params = "q="+regicode;
  resultku.open("POST",url,true);
  resultku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  resultku.setRequestHeader("Content-length", params.length);
  resultku.setRequestHeader("Connection", "close");
  resultku.send(params);
  }
} 

function buatajaxhasil()
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

function stateChangedhasil()
{
  var data;
  if (resultku.readyState==4 && resultku.status==200)
  {
  data=resultku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblviewresult").innerHTML = data;
    document.getElementById("tblviewresult").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewresult").innerHTML = "";
    document.getElementById("tblviewresult").style.visibility = "hidden";
    }
  }
}

// ambil list hasil labs

// Hapus 
  var ajaxhapus;
  function hapuscode(regicode,mastcode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="TBLIUNIT01D.php";
    var url="TRXALABO05D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+regicode+"|"+mastcode;
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
        var inregicode = document.getElementById('txtlaboregi').value;
        //alert(inregicode);
        ambilhasil(inregicode);
        //document.getElementById('txtlistdiag').focus();
    }
  }
// Selesai hapus Data 
