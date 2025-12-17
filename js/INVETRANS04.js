  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="INVETRANS04X-AKSES.php";
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
        document.getElementById('txtsearch').focus();

        document.getElementById('txtexeccode').value = '';
        document.getElementById('txtrequcode').value = '';
        document.getElementById('txtwarefrom').value = '';
        document.getElementById('txtlocaname').value = '';
        document.getElementById('txtwaredest').value = '';
        document.getElementById('txtlocanamedest').value = '';

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


      }
      else
      {
        document.getElementById('txtsearch').setAttribute('disabled','true');

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

      }
    }
  }
// end periksa akses  

    // ambil data dari  tabel trxexec 

var execku;
function ambilexeccode(execcode)
{
  if(execcode.length > 5)
  {
  document.getElementById("tblexec").style.visibility = "hidden";
  }
  else
  {
  execku = buatajaxexeccode();
  var url="INVETRANS04C.php";
  execku.onreadystatechange=stateChangedexeccode;
  var params = "q="+execcode;
  execku.open("POST",url,true);
  execku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  execku.setRequestHeader("Content-length", params.length);
  execku.setRequestHeader("Connection", "close");
  execku.send(params);
  }
} 

function buatajaxexeccode()
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

function stateChangedexeccode()
{
  var data;
  if (execku.readyState==4 && execku.status==200)
  {
  data=execku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblexec").innerHTML = data;
    document.getElementById("tblexec").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblexec").innerHTML = "";
    document.getElementById("tblexec").style.visibility = "hidden";
    }
  }
}

function isiexeccode(outexeccode, outexecdate,outrequcode,outestmdate,
                      outtrandate,outrcvedate,
                      outwarefrom,outhousnamefrom,outlocanamefrom,
                      outwaredest,outhousnamedest,outlocanamedest)
{
  try 
  {

  document.getElementById('txtexeccode').removeAttribute('disabled');
  document.getElementById("txtexeccode").value = outexeccode;

  document.getElementById('tglexecdate').removeAttribute('disabled');
  document.getElementById("tglexecdate").value = outexecdate;

  document.getElementById('txtrequcode').removeAttribute('disabled');
  document.getElementById("txtrequcode").value = outrequcode;

  document.getElementById('tglestmdate').removeAttribute('disabled');
  document.getElementById("tglestmdate").value = outestmdate;

// 
  document.getElementById('tgltrandate').removeAttribute('disabled');
  document.getElementById("tgltrandate").value = outtrandate;

  document.getElementById('tglrcvedate').removeAttribute('disabled');
  document.getElementById("tglrcvedate").value = outrcvedate;

//
  document.getElementById('txtwarefrom').removeAttribute('disabled');
  document.getElementById("txtwarefrom").value = outhousnamefrom;
  document.getElementById("hidwarefrom").value = outwarefrom;

  document.getElementById('txtlocaname').removeAttribute('disabled');
  document.getElementById("txtlocaname").value = outlocanamefrom;

  document.getElementById('txtwaredest').removeAttribute('disabled');
  document.getElementById("txtwaredest").value = outhousnamedest;
  document.getElementById("hidwaredest").value = outwaredest;

  document.getElementById('txtlocanamedest').removeAttribute('disabled');
  document.getElementById("txtlocanamedest").value = outlocanamedest;

  ambilscreen(outexeccode);

  document.getElementById('txtsearch').value = '';

  document.getElementById("tblexec").style.visibility = "hidden";
  document.getElementById("tblexec").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// KodeRequ selesai

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
  var url="INVETRANS04V.php";
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
// Tampilkan data yang diinput dalam datable

// Update data Receipt ke tabel investock
  var ajaxupdate;
  function update(execcode)
  {
    ajaxupdate = buatajaxupdate();
    var url="INVETRANS04E.php";
    ajaxupdate.onreadystatechange=stateChangedupdate;
    var params = "q="+execcode;
    //alert(params);
    ajaxupdate.open("POST",url,true);
    ajaxupdate.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ajaxupdate.setRequestHeader("Content-length", params.length);
    //ajaxupdate.setRequestHeader("Connection", "close");
    ajaxupdate.send(params);
  }

  function buatajaxupdate()
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

  function stateChangedupdate()
  {
  var data;
  if (ajaxupdate.readyState==4)
    {
      periksaakses('PASS_TRANS_RECE');        //}
      document.getElementById("tbltrxascreen").innerHTML = "";
      document.getElementById("tbltrxascreen").style.visibility = "hidden";

    }
  }
  // Selesai update Data  Receipt
