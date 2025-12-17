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
        document.getElementById('txttypecode').focus();
        document.getElementById('txttypename').setAttribute('disabled','true');
        document.getElementById('optgeneral').setAttribute('disabled','true');
        document.getElementById('optraw').setAttribute('disabled','true');
        document.getElementById('optfinish').setAttribute('disabled','true');
        document.getElementById('txttypenote').setAttribute('disabled','true');
        ambilscreen('');
      }
      else
      {
        document.getElementById('txttypecode').setAttribute('disabled','true');
        document.getElementById('txttypename').setAttribute('disabled','true');
        document.getElementById('optgeneral').setAttribute('disabled','true');
        document.getElementById('optraw').setAttribute('disabled','true');
        document.getElementById('optfinish').setAttribute('disabled','true');
        document.getElementById('txttypenote').setAttribute('disabled','true');
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
    //var url="TBLIUNIT01X.php";
    var url="TBLITYPE01X.php";
    ajaxku.onreadystatechange=stateChanged;
    var params = "q="+kodeid;
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
        document.getElementById('txttypename').setAttribute('disabled','true');
        document.getElementById('optgeneral').setAttribute('disabled','true');
        document.getElementById('optraw').setAttribute('disabled','true');
        document.getElementById('optfinish').setAttribute('disabled','true');
        document.getElementById('txttypenote').setAttribute('disabled','true');
        swal({
            title: 'Code is Exist' ,
            text: 'Kode Type sudah ada',
            icon: 'warning',
        });
      }
      else
      {
        document.getElementById("txttypename").removeAttribute('disabled');
        document.getElementById("txttypename").value = '';

        document.getElementById("optgeneral").removeAttribute('disabled');
        document.getElementById("optgeneral").checked = false;

        document.getElementById("optraw").removeAttribute('disabled');
        document.getElementById("optraw").checked = false;

        document.getElementById("optfinish").removeAttribute('disabled');
        document.getElementById("optfinish").checked = false;

        document.getElementById("txttypenote").removeAttribute('disabled');
        document.getElementById("txttypenote").value = '';

        document.getElementById('txttypename').focus();
      }
    }
  }
// end periksa Kode


  // Input Data Posisi dari form ke Tabel tblitype

  var ajaxinput;
  function input(typecode,typename,typecate,typenote)
  {
    ajaxinput = buatajaxinput();
    //var url="TBLIUNIT01E.php";
    var url="TBLITYPE01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+typecode+"|"+typename+"|"+typecate+"|"+typenote;
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
        document.getElementById('txttypecode').value = '';

        document.getElementById('txttypename').value = '';
        document.getElementById('txttypename').setAttribute('disabled','true');

        document.getElementById('optgeneral').checked = false;
        document.getElementById('optgeneral').setAttribute('disabled','true');

        document.getElementById('optraw').checked = false;
        document.getElementById('optraw').setAttribute('disabled','true');

        document.getElementById('optfinish').checked = false;
        document.getElementById('optfinish').setAttribute('disabled','true');

        document.getElementById('hidtypecate').value = '';

        document.getElementById('txttypenote').value = '';
        document.getElementById('txttypenote').setAttribute('disabled','true');
        ambilscreen('');
        document.getElementById('txttypecode').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblitype

// Tampilkan Data Transportasi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(typecode)
{
  try 
  {
    ajaxview = buatajaxview();
    //var url="TBLIUNIT01C.php";
    var url="TBLITYPE01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+typecode;
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
      document.getElementById("txttypecode").value = res[1];

      document.getElementById("txttypename").removeAttribute('disabled');
      document.getElementById("txttypename").value = res[2];

      document.getElementById("optgeneral").removeAttribute('disabled');
      document.getElementById("optraw").removeAttribute('disabled');
      document.getElementById("optfinish").removeAttribute('disabled');

      if (res[3] == 'GE') 
        {
        document.getElementById("optgeneral").checked = true;
        document.getElementById("optraw").checked = false;
        document.getElementById("optfinish").checked = false; 
        }

      else if (res[3] == 'RM') 
        {
        document.getElementById("optgeneral").checked = false;
        document.getElementById("optraw").checked = true;
        document.getElementById("optfinish").checked = false; 
        }

      else if (res[3] == 'FG') 
        {
        document.getElementById("optgeneral").checked = false;
        document.getElementById("optraw").checked = false;
        document.getElementById("optfinish").checked = true; 
        }
      else
      {
        document.getElementById("optgeneral").checked = false;
        document.getElementById("optraw").checked = false;
        document.getElementById("optfinish").checked = false;         
      }
      document.getElementById("hidtypecate").value = res[3];

      document.getElementById("txttypenote").removeAttribute('disabled');
      document.getElementById("txttypenote").value = res[4];
      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(typecode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="TBLIUNIT01D.php";
    var url="TBLITYPE01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+typecode;
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
  //var url="TBLIUNIT01V.php";
  var url="TBLITYPE01V.php";
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

