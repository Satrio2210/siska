  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAVEND01X-AKSES.php";
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
        periksapayment('1');
        document.getElementById('tglvenddate').focus();
        ambilscreen('');
      }
      else
      {
        document.getElementById('txtvendcode').setAttribute('disabled','true');
        document.getElementById('tglvenddate').setAttribute('disabled','true');
        document.getElementById('txtsuplname').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  

  // periksa Kode Pembayaran
    var paymentku;
  function periksapayment(status)
  {
    paymentku = buatajaxpayment();
    var url="TRXAVEND01X.php";
    paymentku.onreadystatechange=stateChangedpayment;
    var params = "q="+status;
    //alert(params);
    paymentku.open("POST",url,true);
    paymentku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    paymentku.setRequestHeader("Content-length", params.length);
    paymentku.setRequestHeader("Connection", "close");
    paymentku.send(params);

  }

  function buatajaxpayment()
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

  function stateChangedpayment()
  {
  var data;
  if (paymentku.readyState==4)
    {

    xdata=paymentku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtvendcode').value=data;
      }
      else
      {
        document.getElementById('txtvendcode').value='';
      }
    }
  }
// end periksa Kode Pembayaran


// Tampilkan data Suplier yang kirim invoice ke kita
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
  var url="TRXAVEND01V.php";
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

// Tampilkan Data Suplier yang telah di pilih pada tabel untuk di input pada form 
var ajaxview
function viewcode(proccode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAVEND01C.php";
    ajaxview.onreadystatechange=stateChangedview;
    var params = "q="+proccode;
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
      document.getElementById("hidproccode").value = res[1];
      document.getElementById("hidprocdivi").value = res[2];

      document.getElementById("txtsuplname").value = res[4];

      document.getElementById("hidsuplcode").value = res[3];

      document.getElementById("hidprocvatx").value = res[5];

      document.getElementById("hiddownpaid").value = res[6];
      document.getElementById("hidremapaid").value = res[7];
      document.getElementById("hidinvccode").value = res[8];
      document.getElementById("hiddueddate").value = res[9];

      document.getElementById("tglvenddate").focus();

      }      
        //}
    }
  }

// input form pembayaran

  var ajaxinput;
  function input(vendcode,venddate,proccode,procdivi,suplcode,procvatx,downpaid,remapaid,invccode,dueddate)
  {
    ajaxinput = buatajaxinput();
    //invendcode,invenddate,inproccode,inprocdivi,insuplcode,inprocvatx, indownpaid, inremapaid, ininvccode, indueddate
    var url="TRXAVEND01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+vendcode+"|"+venddate+"|"+proccode+"|"+procdivi+"|"+suplcode+"|"+procvatx+"|"+downpaid+"|"+remapaid+"|"+invccode+"|"+dueddate;
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

        periksapayment('1');
        document.getElementById('txtsuplname').value = '';
        document.getElementById('tglvenddate').focus();
        ambilscreen('');
        //}
    }
  }
  // Selesai Input Data ke tabel trxavend
