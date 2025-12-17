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
        document.getElementById('txticdcode').focus();
        document.getElementById('txticdnote').setAttribute('disabled','true');
        document.getElementById('txticdcategory').setAttribute('disabled','true');
        document.getElementById('txticdsubcate').setAttribute('disabled','true');
        ambilscreen('');      
      }
      else
      {
        document.getElementById('txticdcode').setAttribute('disabled','true');
        document.getElementById('txticdnote').setAttribute('disabled','true');
        document.getElementById('txticdcategory').setAttribute('disabled','true');
        document.getElementById('txticdsubcate').setAttribute('disabled','true');
        document.getElementById('txtsearch').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  

  // periksa Kode signa
    var ajaxku;
  function periksaid(kodeid)
  {
    ajaxku = buatajax();
    //var url="TRXAPOLI05X.php";
    var url="DIAGMAST01X.php";
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
        document.getElementById('txticdnote').setAttribute('disabled','true');
        document.getElementById('txticdcategory').setAttribute('disabled','true');
        document.getElementById('txticdsubcate').setAttribute('disabled','true');

        swal({
            title: 'Code is Exist' ,
            text: 'Kode Diagnosa sudah ada',
            icon: 'warning',
        });
      }
      else
      {
        document.getElementById('txticdnote').removeAttribute('disabled');
        document.getElementById('txticdcategory').removeAttribute('disabled');
        document.getElementById('txticdsubcate').removeAttribute('disabled');

        document.getElementById("txticdnote").value = '';
        document.getElementById('txticdnote').focus();
      }
    }
  }
// end periksa Kode


  // Input Data Signa dari form ke Tabel tblpsgna
  var ajaxinput;
  function input(icdcategory,icdsubcate,icdcode,icdnote)
  {
    ajaxinput = buatajaxinput();
    var url="DIAGMAST01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+icdcategory+"|"+icdsubcate+"|"+icdcode+"|"+icdnote;
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
        document.getElementById('txticdcode').value = '';
        document.getElementById('txticdnote').value = '';
        document.getElementById('txticdcategory').value = '';
        document.getElementById('txticdsubcate').value = '';

        document.getElementById('txticdnote').setAttribute('disabled','true');
        document.getElementById('txticdcategory').setAttribute('disabled','true');
        document.getElementById('txticdsubcate').setAttribute('disabled','true');

        ambilscreen('');
        document.getElementById('txticdcode').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel TBLEBANK

// Tampilkan Data Transportasi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(icdcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="DIAGMAST01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+icdcode;
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
      document.getElementById("txticdcode").value = res[3];

      document.getElementById("txticdnote").removeAttribute('disabled');   
      document.getElementById("txticdnote").value = res[4];

      document.getElementById("txticdcategory").removeAttribute('disabled');   
      document.getElementById("txticdcategory").value = res[1];

      document.getElementById("txticdsubcate").removeAttribute('disabled');   
      document.getElementById("txticdsubcate").value = res[2];


      }      
        //}
    }
  }

// Hapus Transportasi di Tabel tblitrans
  var ajaxhapus;
  function hapuscode(icdcode)
  {
    ajaxhapus = buatajaxhapus();
    var url="DIAGMAST01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+icdcode;
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
  var url="DIAGMAST01V.php";
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

