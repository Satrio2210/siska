  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="INVETRANS03X-AKSES.php";
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
        document.getElementById('txtrequcode').focus();
        document.getElementById('tglestmdate').setAttribute('disabled','true');
        
        document.getElementById('tgltrandate').setAttribute('disabled','true');
        document.getElementById('tglrcvedate').setAttribute('disabled','true');

        document.getElementById('txtstockname').setAttribute('disabled','true');
        document.getElementById('txtstockquty').setAttribute('disabled','true');

        document.getElementById('txtcartcode').setAttribute('disabled','true');
        document.getElementById('txtdimmcode').setAttribute('disabled','true');

      }
      else
      {
        document.getElementById('txtexeccode').setAttribute('disabled','true');
        document.getElementById('tglexecdate').setAttribute('disabled','true');

        document.getElementById('txtrequcode').setAttribute('disabled','true');
        document.getElementById('tglestmdate').setAttribute('disabled','true');

        document.getElementById('tgltrandate').setAttribute('disabled','true');
        document.getElementById('tglrcvedate').setAttribute('disabled','true');

        document.getElementById('txtwarefrom').setAttribute('disabled','true');
        document.getElementById('txtlocaname').setAttribute('disabled','true');

        document.getElementById('txtwaredest').setAttribute('disabled','true');
        document.getElementById('txtlocanamedest').setAttribute('disabled','true');

        document.getElementById('txtstockname').setAttribute('disabled','true');
        document.getElementById('txtstockquty').setAttribute('disabled','true');

        document.getElementById('txtcartcode').setAttribute('disabled','true');
        document.getElementById('txtdimmcode').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  

    // Membuat code Execute Transfer dengan nomor urut 
var ajaxsequ
function ambilexeccode(execcode)
{
  try 
  {
    ajaxsequ = buatajaxsequ();
    var url="INVETRANS03X.php";
    ajaxsequ.onreadystatechange=stateChangedcode;
    var params = "q="+execcode;
    //alert(params);
    ajaxsequ.open("POST",url,true);
    ajaxsequ.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxsequ.setRequestHeader("Content-length", params.length);
    ajaxsequ.setRequestHeader("Connection", "close");
    ajaxsequ.send(params);

  } 
  catch(err){ alert(err.message); }
}

  function buatajaxsequ()
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

  function stateChangedcode()
  {
  var data;
  if (ajaxsequ.readyState==4)
    {
    xdata=ajaxsequ.responseText;
    data=xdata.trim();
    if(data.length>1)
      {
        document.getElementById('txtexeccode').value = data;

      }
      else
      {
        document.getElementById('txtexeccode').value='';
      }
    }
  }

// Code urut Wallpaper selesai

    // ambil data dari form Request dari tabel trxarequ 

var requku;
function ambilrequcode(requcode)
{
  if(requcode.length > 5)
  {
  document.getElementById("tblrequ").style.visibility = "hidden";
  }
  else
  {
  requku = buatajaxrequcode();
  var url="INVETRANS03C.php";
  requku.onreadystatechange=stateChangedrequcode;
  var params = "q="+requcode;
  requku.open("POST",url,true);
  requku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  requku.setRequestHeader("Content-length", params.length);
  requku.setRequestHeader("Connection", "close");
  requku.send(params);
  }
} 

function buatajaxrequcode()
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

function stateChangedrequcode()
{
  var data;
  if (requku.readyState==4 && requku.status==200)
  {
  data=requku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblrequ").innerHTML = data;
    document.getElementById("tblrequ").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblrequ").innerHTML = "";
    document.getElementById("tblrequ").style.visibility = "hidden";
    }
  }
}

function isirequcode(outrequcode, outtrandate, outrcvedate, outhousnamefrom, outwarefrom, outlocanamefrom, outhousnamedest,outwaredest,outlocanamedest)
{
  try 
  {
  document.getElementById("txtrequcode").value = outrequcode;
  document.getElementById('tglestmdate').removeAttribute('disabled');

  document.getElementById('tgltrandate').removeAttribute('disabled');
  document.getElementById("tgltrandate").value = outtrandate;
  document.getElementById('tglrcvedate').removeAttribute('disabled');
  document.getElementById("tglrcvedate").value = outrcvedate;

  document.getElementById("txtwarefrom").value = outhousnamefrom;
  document.getElementById("hidwarefrom").value = outwarefrom;
  document.getElementById("txtlocaname").value = outlocanamefrom;

  document.getElementById("txtwaredest").value = outhousnamedest;
  document.getElementById("hidwaredest").value = outwaredest;
  document.getElementById("txtlocanamedest").value = outlocanamedest;

  document.getElementById('txtstockname').removeAttribute('disabled');
  document.getElementById('txtstockquty').removeAttribute('disabled');
  document.getElementById('txtcartcode').removeAttribute('disabled');
  document.getElementById('txtdimmcode').removeAttribute('disabled');

  ambilscreen(document.getElementById('txtexeccode').value);

  document.getElementById("tblrequ").style.visibility = "hidden";
  document.getElementById("tblrequ").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// KodeRequ selesai



  // ambil Kode Item Inventory dari tabel investock

var itemku;
function ambilitemcode(itemcode,warecode)
{
  if(itemcode.length > 5)
  {
  document.getElementById("tblitem").style.visibility = "hidden";
  }
  else
  {
  itemku = buatajaxitemcode();
  //var url="TRXAPROC01C-INVE.php";
  var url="INVETRANS03C-ITEM.php";
  itemku.onreadystatechange=stateChangeditemcode;
  var params = "q="+itemcode+"|"+warecode;
  //alert(params);
  itemku.open("POST",url,true);
  itemku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  itemku.setRequestHeader("Content-length", params.length);
  itemku.setRequestHeader("Connection", "close");
  itemku.send(params);
  }
} 
function buatajaxitemcode()
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

function stateChangeditemcode()
{
  var data;
  if (itemku.readyState==4 && itemku.status==200)
  {
  data=itemku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblitem").innerHTML = data;
    document.getElementById("tblitem").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblitem").innerHTML = "";
    document.getElementById("tblitem").style.visibility = "hidden";
    }
  }
}

function isiitemcode(outstockcode, outstockname, outstockquty, outpartunit, outstocksrnm, outstockbtch)
{
  try 
  {
  document.getElementById("txtstockname").value = outstockname;
  document.getElementById("hidstockcode").value = outstockcode;
  document.getElementById("txtstockquty").value = outstockquty;
  document.getElementById("hidpartunit").value = outpartunit;
  document.getElementById("hidstocksrnm").value = outstocksrnm;
  document.getElementById("hidstockbtch").value = outstockbtch;
  document.getElementById("txtstockquty").focus();
  document.getElementById("tblitem").style.visibility = "hidden";
  document.getElementById("tblitem").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// Input data ke tabel trxaexec
  var ajaxinput;
  function input(execcode,execdate,requcode,estmdate,trandate,rcvedate,warefrom,waredest,stockcode,stockname,stockquty,partunit,stocksrnm,stockbtch,cartcode,dimmcode)
  {
    ajaxinput = buatajaxinput();
    var url="INVETRANS03E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+execcode+"|"+execdate+"|"+requcode+"|"+estmdate+"|"+trandate+"|"+rcvedate+"|"+warefrom+"|"+waredest+"|"+stockcode+"|"+stockname+"|"+stockquty+"|"+partunit+"|"+stocksrnm+"|"+stockbtch+"|"+cartcode+"|"+dimmcode;
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
        document.getElementById('txtstockname').value = '';
        document.getElementById('txtstockquty').value = '';
        document.getElementById('txtcartcode').value = '';
        document.getElementById('txtdimmcode').value = '';
        document.getElementById('txtstockname').focus();
        ambilscreen(document.getElementById('txtexeccode').value);

        //}
    }
  }
  // Selesai Input Data  ke Tabel trxarequ
// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(execcode)
{
  if(execcode.length > 13)
  {
  document.getElementById("tbltrxascreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="INVETRANS03V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+execcode;
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
    document.getElementById("tbltrxascreen").innerHTML = datapost;
    document.getElementById("tbltrxascreen").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbltrxascreen").innerHTML = "";
    document.getElementById("tbltrxascreen").style.visibility = "hidden";
    }
  }
}

// Hapus Item  ke Tabel itemexec

  var ajaxhapus;
  function hapuscode(execcode,stockcode,timecode)
  {
    ajaxhapus = buatajaxhapus();
    var url="INVETRANS03D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+execcode+"|"+stockcode+"|"+timecode;
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
        var execcode = document.getElementById('txtexeccode').value;
        ambilscreen(execcode);
    }
  }
// Selesai hapus Data itemexec
