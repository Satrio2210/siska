  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPROC07X-AKSES.php";
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
        document.getElementById('tglretudate').focus();
        document.getElementById('txtsuplname').setAttribute('disabled','true');
        document.getElementById('txtsupladdr').setAttribute('disabled','true');
        document.getElementById('txtretucode').setAttribute('disabled','true');
        document.getElementById('tglretudate').setAttribute('disabled','true');
        document.getElementById('txtdiviname').setAttribute('disabled','true');
        document.getElementById('txtretunote').setAttribute('disabled','true');
        ambilscreen('');
      }
      else
      {
        document.getElementById('tglretudate').setAttribute('disabled','true');
        document.getElementById('txtsuplname').setAttribute('disabled','true');
        document.getElementById('txtsupladdr').setAttribute('disabled','true');
        document.getElementById('txtretucode').setAttribute('disabled','true');
        document.getElementById('tglretudate').setAttribute('disabled','true');
        document.getElementById('txtdiviname').setAttribute('disabled','true');
        document.getElementById('txtretunote').setAttribute('disabled','true');
        

      }
    }
  }
// end periksa akses  


  var ajaxinput;
  function input(retucode,retudate,proccode,retudivi,suplcode,retunote)
  {
    ajaxinput = buatajaxinput();
    //var url="TRXAPROC03E.php";
    var url="TRXAPROC07E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+retucode+"|"+retudate+"|"+proccode+"|"+retudivi+"|"+suplcode+"|"+retunote;
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
  var todaynow = new Date()
  var data;
  if (ajaxinput.readyState==4)
    {

        document.getElementById('txtsuplname').value = '';
        document.getElementById('txtsuplname').setAttribute('disabled','true');

        document.getElementById('hidsuplcode').value = '';

        document.getElementById('txtsupladdr').value = '';
        document.getElementById('txtsupladdr').setAttribute('disabled','true');

        document.getElementById('txtretucode').value = '';
        document.getElementById('txtretucode').setAttribute('disabled','true');

        document.getElementById('hidproccode').value = '';

        var today = convertDate(todaynow);
        document.getElementById('tglretudate').value = today;
        document.getElementById('tglretudate').setAttribute('disabled','true');

        document.getElementById('txtdiviname').value = '';
        document.getElementById('txtdiviname').setAttribute('disabled','true');
        
        document.getElementById('hidretudivi').value = '';

        document.getElementById('txtretunote').value = '';
        document.getElementById('txtretunote').setAttribute('disabled','true');

        ambilscreen('');
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblitype

// Tampilkan Data Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(stockcode,proccode,retustat)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPROC07C.php";
    ajaxview.onreadystatechange=stateChangedview;
    var params = "q="+stockcode+"|"+proccode+"|"+retustat;
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

  function stateChangedview()
  {
  var data;
  if (ajaxview.readyState==4)
    {
      data=ajaxview.responseText;
      if(data.length>1)
      {
      var res = data.split("|");
      document.getElementById("txtsuplname").removeAttribute('disabled');
      document.getElementById("txtsuplname").value = res[6];

      document.getElementById("hidsuplcode").value = res[5];

      document.getElementById("txtsupladdr").removeAttribute('disabled');
      document.getElementById("txtsupladdr").value = res[7];

      document.getElementById("txtretucode").removeAttribute('disabled');
      document.getElementById("txtretucode").value = res[1];

      document.getElementById("hidproccode").value = res[3];
    
      document.getElementById("tglretudate").removeAttribute('disabled');

      document.getElementById("txtdiviname").removeAttribute('disabled');
      document.getElementById("txtdiviname").value = res[8];
      document.getElementById("hidretudivi").value = res[4];
      document.getElementById("hidretustat").value = res[9];

      document.getElementById("txtretunote").removeAttribute('disabled');
      document.getElementById("txtretunote").focus();

      }      
        //}
    }
  }



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
  //var url="TRXAPROC03V.php";
  var url="TRXAPROC07V.php";
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

