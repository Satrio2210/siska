  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="WAREMAST01X-AKSES.php";
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
          document.getElementById('txthouscode').focus();
          document.getElementById('txthousname').setAttribute('disabled','true');
          document.getElementById('txtlocaname').setAttribute('disabled','true');
          document.getElementById('txtmediroom').setAttribute('disabled','true');
          document.getElementById('optnormal').setAttribute('disabled','true');
          document.getElementById('optreject').setAttribute('disabled','true');
          document.getElementById('txtemplname').setAttribute('disabled','true');
          document.getElementById('txthousnote').setAttribute('disabled','true');
          ambilscreen('');
      }
      else
      {
          document.getElementById('txthouscode').setAttribute('disabled','true');
          document.getElementById('txthousname').setAttribute('disabled','true');
          document.getElementById('txtlocaname').setAttribute('disabled','true');
          document.getElementById('txtmediroom').setAttribute('disabled','true');
          document.getElementById('optnormal').setAttribute('disabled','true');
          document.getElementById('optreject').setAttribute('disabled','true');
          document.getElementById('txtemplname').setAttribute('disabled','true');
          document.getElementById('txthousnote').setAttribute('disabled','true');
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
    var url="WAREMAST01X.php";
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
        document.getElementById('txthousname').setAttribute('disabled','true');
        document.getElementById('txtlocaname').setAttribute('disabled','true');
        document.getElementById('txtmediroom').setAttribute('disabled','true');
        document.getElementById('optnormal').setAttribute('disabled','true');
        document.getElementById('optreject').setAttribute('disabled','true');
        document.getElementById('txtemplname').setAttribute('disabled','true');
        document.getElementById('txthousnote').setAttribute('disabled','true');
        swal({
            title: 'Code is Exist' ,
            text: 'Kode WareHouse sudah ada',
            icon: 'warning',
        });
      }
      else
      {
        document.getElementById("txthousname").removeAttribute('disabled');
        document.getElementById("txthousname").value = '';

        document.getElementById("txtlocaname").removeAttribute('disabled');
        document.getElementById("txtlocaname").value = '';

        document.getElementById("txtmediroom").removeAttribute('disabled');
        document.getElementById("txtmediroom").value = '';

        document.getElementById("optnormal").removeAttribute('disabled');
        document.getElementById("optnormal").checked = false;

        document.getElementById("optreject").removeAttribute('disabled');
        document.getElementById("optreject").checked = false;

        document.getElementById("txtemplname").removeAttribute('disabled');
        document.getElementById("txtemplname").value = '';

        document.getElementById("txthousnote").removeAttribute('disabled');
        document.getElementById("txthousnote").value = '';

        document.getElementById('txthousname').focus();
      }
    }
  }
// end periksa Kode

    // ambil Kode Sales dari tabel tblloca

var locaku;
function ambillocacode(locacode)
{
  if(locacode.length > 5)
  {
  document.getElementById("tblloca").style.visibility = "hidden";
  }
  else
  {
  locaku = buatajaxlocacode();
  var url="WAREMAST01C-LOCA.php";
  locaku.onreadystatechange=stateChangedlocacode;
  var params = "q="+locacode;
  locaku.open("POST",url,true);
  locaku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  locaku.setRequestHeader("Content-length", params.length);
  locaku.setRequestHeader("Connection", "close");
  locaku.send(params);
  }
} 

function buatajaxlocacode()
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

function stateChangedlocacode()
{
  var data;
  if (locaku.readyState==4 && locaku.status==200)
  {
  data=locaku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblloca").innerHTML = data;
    document.getElementById("tblloca").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblloca").innerHTML = "";
    document.getElementById("tblloca").style.visibility = "hidden";
    }
  }
}

function isilocacode(outlocacode,outlocaname)
{
  try 
  {
  document.getElementById("txtlocaname").value = outlocaname;
  document.getElementById("hidlocacode").value = outlocacode;
  document.getElementById("txtmediroom").focus();
  document.getElementById("tblloca").style.visibility = "hidden";
  document.getElementById("tblloca").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

var poliku;
function ambilpolicode(policode)
{
  if(policode.length > 5)
  {
  document.getElementById("tblloca").style.visibility = "hidden";
  }
  else
  {
  poliku = buatajaxpolicode();
  var url="WAREMAST01C-POLI.php";
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
    document.getElementById("tblloca").innerHTML = data;
    document.getElementById("tblloca").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblloca").innerHTML = "";
    document.getElementById("tblloca").style.visibility = "hidden";
    }
  }
}

function isipolicode(outpolicode,outpoliname)
{
  try 
  {
  document.getElementById("txtmediroom").value = outpoliname;
  document.getElementById("hidmediroom").value = outpolicode;
  document.getElementById("txtemplname").focus();
  document.getElementById("tblloca").style.visibility = "hidden";
  document.getElementById("tblloca").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


    // ambil Kode Empl tabel empl
var emplku;
function ambilemplcode(emplcode)
{
  if(emplcode.length > 5)
  {
  document.getElementById("tblempl").style.visibility = "hidden";
  }
  else
  {
  emplku = buatajaxemplcode();
  var url="WAREMAST01C-EMPL.php";
  emplku.onreadystatechange=stateChangedemplcode;
  var params = "q="+emplcode;
  emplku.open("POST",url,true);
  emplku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  emplku.setRequestHeader("Content-length", params.length);
  emplku.setRequestHeader("Connection", "close");
  emplku.send(params);
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
  if (emplku.readyState==4 && emplku.status==200)
  {
  data=emplku.responseText;
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
  document.getElementById("txthousnote").focus();
  document.getElementById("tblempl").style.visibility = "hidden";
  document.getElementById("tblempl").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
    // ambil Kode EMPL dari tabel tblempl


  // Input Data  dari form ke Tabel waremast
  var ajaxinput;
  function input(houscode,housname,housloca,mediroom,houstype,emplcode,housnote)
  {
    ajaxinput = buatajaxinput();
    var url="WAREMAST01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+houscode+"|"+housname+"|"+housloca+"|"+mediroom+"|"+houstype+"|"+emplcode+"|"+housnote;
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
        document.getElementById('txthouscode').value = '';

        document.getElementById('txthousname').value = '';
        document.getElementById('txthousname').setAttribute('disabled','true');

        document.getElementById('txtlocaname').value = '';
        document.getElementById('hidlocacode').value = '';
        document.getElementById('txtlocaname').setAttribute('disabled','true');

        document.getElementById('txtmediroom').value = '';
        document.getElementById('hidmediroom').value = '';
        document.getElementById('txtmediroom').setAttribute('disabled','true');

        document.getElementById('hidhoustype').value = '';
        document.getElementById('optnormal').checked = false;
        document.getElementById('optnormal').setAttribute('disabled','true');
        document.getElementById('optreject').checked = false;
        document.getElementById('optreject').setAttribute('disabled','true');

        document.getElementById('txtemplname').value = '';
        document.getElementById('hidemplcode').value = '';
        document.getElementById('txtemplname').setAttribute('disabled','true');
        
        document.getElementById('txthousnote').value = '';
        document.getElementById('txthousnote').setAttribute('disabled','true');

        ambilscreen('');
        document.getElementById('txthouscode').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblepost

// Tampilkan Data Transportasi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(houscode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="WAREMAST01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+houscode;
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
      document.getElementById("txthouscode").value = res[1];

      document.getElementById("txthousname").removeAttribute('disabled');
      document.getElementById("txthousname").value = res[2];

      document.getElementById("txtlocaname").removeAttribute('disabled');
      document.getElementById("txtlocaname").value = res[3];
      document.getElementById("hidlocacode").value = res[4];

      document.getElementById("txtmediroom").removeAttribute('disabled');
      document.getElementById("txtmediroom").value = res[5];
      document.getElementById("hidmediroom").value = res[6];

      if (res[7] == 'N') 
        {
          document.getElementById("optnormal").removeAttribute('disabled');
          document.getElementById("optreject").removeAttribute('disabled');
          document.getElementById('optnormal').checked = true;
          document.getElementById('optreject').checked = false;
          document.getElementById("hidhoustype").value = res[7];
        }
      else if(res[7] == 'R')
        {
          document.getElementById("optnormal").removeAttribute('disabled');
          document.getElementById("optreject").removeAttribute('disabled');
          document.getElementById('optnormal').checked = false;
          document.getElementById('optreject').checked = true;
          document.getElementById("hidhoustype").value = res[7];
        }
      else
        {
          document.getElementById('optnormal').checked = false;
          document.getElementById('optreject').checked = false;
          document.getElementById("hidhoustype").value = '';
        }      

      document.getElementById("txtemplname").removeAttribute('disabled');
      document.getElementById("txtemplname").value = res[8];
      document.getElementById("hidemplcode").value = res[9];

      document.getElementById("txthousnote").removeAttribute('disabled');
      document.getElementById("txthousnote").value = res[10];

      document.getElementById("txtsearch").value = '';

      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(houscode)
  {
    ajaxhapus = buatajaxhapus();
    var url="WAREMAST01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+houscode;
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
  var url="WAREMAST01V.php";
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

