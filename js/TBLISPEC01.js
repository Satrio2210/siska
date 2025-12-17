  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TBLIUNIT01X-AKSES.php";
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
        document.getElementById('txtspeccode').focus();
        document.getElementById('txtspecname').setAttribute('disabled','true');
        document.getElementById('txtspecnote').setAttribute('disabled','true');
        ambilscreen('');
      }
      else
      {
        document.getElementById('txtspeccode').setAttribute('disabled','true');
        document.getElementById('txtspecname').setAttribute('disabled','true');
        document.getElementById('txtspecnote').setAttribute('disabled','true');
        document.getElementById('txtsearch').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


// periksa Kode Unit
    var ajaxku;
  function periksaid(kodeid)
  {
    ajaxku = buatajax();
    //var url="TBLIVARN01X.php";
    var url="TBLISPEC01X.php";
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
        document.getElementById('txtspecname').setAttribute('disabled','true');
        document.getElementById('txtspecnote').setAttribute('disabled','true');
        swal({
            title: 'Code is Exist' ,
            text: 'Kode Specs sudah ada',
            icon: 'warning',
        });
      }
      else
      {
        document.getElementById("txtspecname").removeAttribute('disabled');
        document.getElementById("txtspecname").value = '';
        document.getElementById("txtspecnote").removeAttribute('disabled');
        document.getElementById("txtspecnote").value = '';
        document.getElementById('txtspecname').focus();
      }
    }
  }
// end periksa Kode


  // Input Data Posisi dari form ke Tabel tblispec

  var ajaxinput;
  function input(speccode,specname,specnote)
  {
    ajaxinput = buatajaxinput();
    //var url="TBLIVARN01E.php";
    var url="TBLISPEC01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+speccode+"|"+specname+"|"+specnote;
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
        document.getElementById('txtspeccode').value = '';
        document.getElementById('txtspecname').value = '';
        document.getElementById('txtspecname').setAttribute('disabled','true');
        document.getElementById('txtspecnote').value = '';
        document.getElementById('txtspecnote').setAttribute('disabled','true');
        ambilscreen('');
        document.getElementById('txtspeccode').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblepost

// Tampilkan Data Transportasi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(speccode)
{
  try 
  {
    ajaxview = buatajaxview();
    //var url="TBLIVARN01C.php";
    var url="TBLISPEC01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+speccode;
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
  { if (window.XMLHttpRequest) { return new XMLHttpRequest(); } if (window.ActiveXObject) { return new ActiveXObject("Microsoft.XMLHTTP"); }
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
      document.getElementById("txtspeccode").value = res[1];
      document.getElementById("txtspecname").removeAttribute('disabled');
      document.getElementById("txtspecname").value = res[2];
      document.getElementById("txtspecnote").removeAttribute('disabled');
      document.getElementById("txtspecnote").value = res[3];
      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(unitcode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="TBLIVARN01D.php";
    var url="TBLISPEC01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+unitcode;
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
  //var url="TBLIVARN01V.php";
  var url="TBLISPEC01V.php";
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

