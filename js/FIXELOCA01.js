  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="FIXELOCA01X-AKSES.php";
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
          document.getElementById('txtlocacode').focus();
          document.getElementById('txtlocaname').setAttribute('disabled','true');
          document.getElementById('txtlocaaddr').setAttribute('disabled','true');
          document.getElementById('txtemplname').setAttribute('disabled','true');
          document.getElementById('txtlocanote').setAttribute('disabled','true');
          ambilscreen('');
      }
      else
      {
          document.getElementById('txtlocacode').setAttribute('disabled','true');
          document.getElementById('txtlocaname').setAttribute('disabled','true');
          document.getElementById('txtlocaaddr').setAttribute('disabled','true');
          document.getElementById('txtemplname').setAttribute('disabled','true');
          document.getElementById('txtlocanote').setAttribute('disabled','true');
          document.getElementById('txtsearch').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


// periksa Kode Lokasi
    var ajaxku;
  function periksaid(kodeid)
  {
    ajaxku = buatajax();
    //var url="TBLIUNIT01X.php";
    var url="FIXELOCA01X.php";
    ajaxku.onreadystatechange=stateChanged;
    var params = "q="+kodeid;
    //alert('Parameter adalah '+kodeid);
    ajaxku.open("POST",url,true);
    ajaxku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ajaxku.setRequestHeader("Content-length", params.length);
    //ajaxku.setRequestHeader("Connection", "close");
    ajaxku.send(params);

  }

  function buatajax()
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

  function stateChanged()
  {
  var data;
  if (ajaxku.readyState==4)
    {

    xdata=ajaxku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtlocaname').setAttribute('disabled','true');
        document.getElementById('txtlocaaddr').setAttribute('disabled','true');
        document.getElementById('txtemplname').setAttribute('disabled','true');
        document.getElementById('txtlocanote').setAttribute('disabled','true');
        swal({
            title: 'Code is Exist' ,
            text: 'Kode Lokasi sudah ada',
            icon: 'warning',
        });
      }
      else
      {
        document.getElementById("txtlocaname").removeAttribute('disabled');
        document.getElementById("txtlocaname").value = '';
        document.getElementById("txtlocaaddr").removeAttribute('disabled');
        document.getElementById("txtlocaaddr").value = '';
        document.getElementById("txtemplname").removeAttribute('disabled');
        document.getElementById("txtemplname").value = '';
        document.getElementById("txtlocanote").removeAttribute('disabled');
        document.getElementById("txtlocanote").value = '';

        document.getElementById('txtlocaname').focus();
      }
    }
  }
// end periksa Kode

    // ambil Kode Type dari tabel empl
var typeku;
function ambilemplcode(emplcode)
{
  if(emplcode.length > 5)
  {
  document.getElementById("tblempl").style.visibility = "hidden";
  }
  else
  {
  typeku = buatajaxemplcode();
  //var url="INVEMAST01X.php";
  var url="FIXELOCA01C-EMPL.php";
  typeku.onreadystatechange=stateChangedemplcode;
  var params = "q="+emplcode;
  typeku.open("POST",url,true);
  typeku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  typeku.setRequestHeader("Content-length", params.length);
  typeku.setRequestHeader("Connection", "close");
  typeku.send(params);
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
  if (typeku.readyState==4 && typeku.status==200)
  {
  data=typeku.responseText;
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
  document.getElementById("txtlocanote").focus();
  document.getElementById("tblempl").style.visibility = "hidden";
  document.getElementById("tblempl").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
    // ambil Kode Type dari tabel tblempl


  // Input Data  dari form ke Tabel fixeloca
//input(inlocacode,inlocaname,inlocaaddr, inemplcode, inlocanote);
  var ajaxinput;
  function input(locacode,locaname,locaaddr,emplcode,locanote)
  {
    ajaxinput = buatajaxinput();
    //var url="TBLIUNIT01E.php";
    var url="FIXELOCA01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+locacode+"|"+locaname+"|"+locaaddr+"|"+emplcode+"|"+locanote;
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
        document.getElementById('txtlocacode').value = '';
        document.getElementById('txtlocaname').value = '';
        document.getElementById('txtlocaname').setAttribute('disabled','true');
        document.getElementById('txtlocaaddr').value = '';
        document.getElementById('txtlocaaddr').setAttribute('disabled','true');
        document.getElementById('txtlocaaddr').value = '';
        document.getElementById('txtlocaaddr').setAttribute('disabled','true');
        document.getElementById('txtemplname').value = '';
        document.getElementById('txtemplname').setAttribute('disabled','true');
        document.getElementById('hidemplcode').value = '';
        document.getElementById('txtlocanote').value = '';
        document.getElementById('txtlocanote').setAttribute('disabled','true');

        ambilscreen('');
        document.getElementById('txtlocacode').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblepost

// Tampilkan Data Transportasi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(locacode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="FIXELOCA01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+locacode;
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
      document.getElementById("txtlocacode").value = res[1];

      document.getElementById("txtlocaname").removeAttribute('disabled');
      document.getElementById("txtlocaname").value = res[2];

      document.getElementById("txtlocaaddr").removeAttribute('disabled');
      document.getElementById("txtlocaaddr").value = res[3];

      document.getElementById("txtemplname").removeAttribute('disabled');
      document.getElementById("txtemplname").value = res[5];
      document.getElementById("hidemplcode").value = res[4];

      document.getElementById("txtlocanote").removeAttribute('disabled');
      document.getElementById("txtlocanote").value = res[6];

      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(locacode)
  {
    ajaxhapus = buatajaxhapus();
    var url="FIXELOCA01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+locacode;
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
// Selesai hapus Data Distance


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
  var url="FIXELOCA01V.php";
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

