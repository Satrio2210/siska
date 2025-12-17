  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPATI03X-AKSES.php";
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
        document.getElementById('txtpolicode').focus();
        document.getElementById('txtpoliname').setAttribute('disabled','true');
        ambilscreen('');      
      }
      else
      {
        document.getElementById('txtpolicode').setAttribute('disabled','true');
        document.getElementById('txtpoliname').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  

  // periksa Kode bank
    var ajaxku;
  function periksaid(kodeid)
  {
    ajaxku = buatajax();
    var url="TRXAPATI03X.php";
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
        document.getElementById('txtpoliname').setAttribute('disabled','true');
        swal({
            title: 'Code is Exist' ,
            text: 'Kode Poli sudah ada',
            icon: 'warning',
        });
      }
      else
      {
        document.getElementById("txtpoliname").removeAttribute('disabled');
        document.getElementById("txtpoliname").value = '';
        document.getElementById('txtpoliname').focus();
      }
    }
  }
// end periksa Kode


  // Input Data Bank dari form ke Tabel tblebank

  var ajaxinput;
  function input(policode,poliname)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAPATI03E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+policode+"|"+poliname;
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
        document.getElementById('txtpolicode').value = '';
        document.getElementById('txtpoliname').value = '';
        document.getElementById('txtpoliname').setAttribute('disabled','true');
        ambilscreen('');
        document.getElementById('txtpolicode').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel TBLEBANK

// Tampilkan Data Transportasi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(policode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPATI03C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+policode;
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
      document.getElementById("txtpolicode").value = res[1];
      document.getElementById("txtpoliname").removeAttribute('disabled');
      document.getElementById("txtpoliname").value = res[2];
      }      
        //}
    }
  }

// Hapus Transportasi di Tabel tblitrans
  var ajaxhapus;
  function hapuscode(policode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="INVETRANS06D.php";
    var url="TRXAPATI03D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+policode;
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
  var url="TRXAPATI03V.php";
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

