  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAVEND03X-AKSES.php";
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
        ambilinvccode('x');
        document.getElementById('txtvendcode').setAttribute('disabled','true');
        document.getElementById('tglvenddate').setAttribute('disabled','true');
        document.getElementById('txtsuplname').setAttribute('disabled','true');
        document.getElementById('txtcoaccode').setAttribute('disabled','true');
        document.getElementById('txtcoacname').setAttribute('disabled','true');
        document.getElementById('txtcheqcode').setAttribute('disabled','true');
        document.getElementById('tglcheqdate').setAttribute('disabled','true');
        document.getElementById('txtcheqbank').setAttribute('disabled','true');
        document.getElementById('txtinvccode').setAttribute('disabled','true');
        document.getElementById('tgldueddate').setAttribute('disabled','true');
        document.getElementById('txtsummamnt').setAttribute('disabled','true');
        document.getElementById('txtpaymamnt').setAttribute('disabled','true');                
        
      }
      else
      {
        document.getElementById('txtsearch').setAttribute('disabled','true');
        document.getElementById('txtvendcode').setAttribute('disabled','true');
        document.getElementById('tglvenddate').setAttribute('disabled','true');
        document.getElementById('txtsuplname').setAttribute('disabled','true');
        document.getElementById('txtcoaccode').setAttribute('disabled','true');
        document.getElementById('txtcoacname').setAttribute('disabled','true');
        document.getElementById('txtcheqcode').setAttribute('disabled','true');
        document.getElementById('tglcheqdate').setAttribute('disabled','true');
        document.getElementById('txtcheqbank').setAttribute('disabled','true');
        document.getElementById('txtinvccode').setAttribute('disabled','true');
        document.getElementById('tgldueddate').setAttribute('disabled','true');
        document.getElementById('txtsummamnt').setAttribute('disabled','true');
        document.getElementById('txtpaymamnt').setAttribute('disabled','true');                
      }
    }
  }
// end periksa akses  

      // ambil Kode Invoice dari tabel trxavend
var invoiceku;
function ambilinvccode(invccode)
{
  if(invccode.length > 5)
  {
  document.getElementById("tblinvc").style.visibility = "hidden";
  }
  else
  {
  invoiceku = buatajaxinvoicecode();
  var url="TRXAVEND03C-INVOICE.php";
  invoiceku.onreadystatechange=stateChangedinvoicecode;
  var params = "q="+invccode;
  //alert(params);
  invoiceku.open("POST",url,true);
  invoiceku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  invoiceku.setRequestHeader("Content-length", params.length);
  invoiceku.setRequestHeader("Connection", "close");
  invoiceku.send(params);
  }
} 

function buatajaxinvoicecode()
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

function stateChangedinvoicecode()
{
  var data;
  if (invoiceku.readyState==4 && invoiceku.status==200)
  {
  data=invoiceku.responseText;
    if(data.length>1)
    {   
    document.getElementById("tblinvc").innerHTML = data;
    document.getElementById("tblinvc").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblinvc").innerHTML = "";
    document.getElementById("tblinvc").style.visibility = "hidden";
    }
  }
}

function isiinvccode(outvendcode,outvenddate,outsuplcode,outsuplname,outinvccode,outdueddate,amount)
{
  try 
  {
  document.getElementById("txtsearch").value = '';

  document.getElementById("txtvendcode").removeAttribute('disabled');
  document.getElementById("txtvendcode").value = outvendcode;

  document.getElementById("tglvenddate").removeAttribute('disabled');
  document.getElementById("tglvenddate").value = outvenddate;

  document.getElementById("txtsuplname").removeAttribute('disabled');
  document.getElementById("txtsuplname").value = outsuplname;
  document.getElementById("hidsuplcode").value = outsuplcode;

  document.getElementById("txtcoaccode").removeAttribute('disabled');
  document.getElementById("txtcoacname").removeAttribute('disabled');
  document.getElementById("txtcheqcode").removeAttribute('disabled');
  document.getElementById("tglcheqdate").removeAttribute('disabled');
  document.getElementById("txtcheqbank").removeAttribute('disabled');

  document.getElementById("txtinvccode").removeAttribute('disabled');
  document.getElementById("txtinvccode").value = outinvccode;

  document.getElementById("tgldueddate").removeAttribute('disabled');
  document.getElementById("tgldueddate").value = outdueddate;

  document.getElementById("txtsummamnt").removeAttribute('disabled');
  document.getElementById("txtsummamnt").value = amount;

  document.getElementById("txtpaymamnt").removeAttribute('disabled');
  
  document.getElementById("txtcoaccode").focus();
  document.getElementById("tblinvc").style.visibility = "hidden";
  document.getElementById("tblinvc").innerHTML = "";

  ambilscreen(document.getElementById("txtvendcode").value);
  } 
  catch(err){ alert(err.message); }
}
// end code invoice


    // ambil Akun Code dari tabel coacmast
var coacku;
function ambilcoaccode(coaccode)
{
  if(coaccode.length > 13)
  {
  document.getElementById("tblcoac").style.visibility = "hidden";
  }
  else
  {
  coacku = buatajaxcoaccode();
  var url="TRXAVEND03C-COAC.php";
  coacku.onreadystatechange=stateChangedcoaccode;
  var params = "q="+coaccode;
  coacku.open("POST",url,true);
  coacku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  coacku.setRequestHeader("Content-length", params.length);
  coacku.setRequestHeader("Connection", "close");
  coacku.send(params);
  }
} 
function buatajaxcoaccode()
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

function stateChangedcoaccode()
{
  var data;
  if (coacku.readyState==4 && coacku.status==200)
  {
  data=coacku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblcoac").innerHTML = data;
    document.getElementById("tblcoac").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblcoac").innerHTML = "";
    document.getElementById("tblcoac").style.visibility = "hidden";
    }
  }
}

function isicoaccode(tblcoaccode,tblcoacname)
{
    try 
    {
    document.getElementById("txtcoaccode").value = tblcoaccode;
    document.getElementById("txtcoacname").value = tblcoacname;
    document.getElementById("txtcheqcode").focus(); 
    document.getElementById("tblcoac").style.visibility = "hidden";
    document.getElementById("tblcoac").innerHTML = "";

    } catch(err){ alert(err.message); }

}
// end 

      // ambil Kode Bank dari tabel tblbank
var bankku;
function ambilbankcode(bankcode)
{
  if(bankcode.length > 5)
  {
  document.getElementById("tblbank").style.visibility = "hidden";
  }
  else
  {
  bankku = buatajaxbankcode();
  var url="TRXAVEND03C-BANK.php";
  bankku.onreadystatechange=stateChangedbankcode;
  var params = "q="+bankcode;
  //alert(params);
  bankku.open("POST",url,true);
  bankku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  bankku.setRequestHeader("Content-length", params.length);
  bankku.setRequestHeader("Connection", "close");
  bankku.send(params);
  }
} 

function buatajaxbankcode()
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

function stateChangedbankcode()
{
  var data;
  if (bankku.readyState==4 && bankku.status==200)
  {
  data=bankku.responseText;
    if(data.length>1)
    {   
    document.getElementById("tblbank").innerHTML = data;
    document.getElementById("tblbank").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblbank").innerHTML = "";
    document.getElementById("tblbank").style.visibility = "hidden";
    }
  }
}

function isibankcode(outbankcode,outbankname)
{
  try 
  {
  document.getElementById("txtcheqbank").value = outbankname;
  document.getElementById("hidcheqbank").value = outbankcode;
  document.getElementById("txtpaymamnt").focus();
  document.getElementById("tblbank").style.visibility = "hidden";
  document.getElementById("tblbank").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
// end code bank 


// input form pembayaran

  var ajaxinput;
  function input(vendcode,invccode,dueddate,coaccode,coacname,cheqcode,cheqdate,cheqbank,summamnt,paymamnt)
  {
    ajaxinput = buatajaxinput();
    //invendcode,invenddate,insuplcode
    var url="TRXAVEND03E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+vendcode+"|"+invccode+"|"+dueddate+"|"+coaccode+"|"+coacname+"|"+cheqcode+"|"+cheqdate+"|"+cheqbank+"|"+summamnt+"|"+paymamnt;
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

        document.getElementById('txtsearch').focus();

        ambilinvccode('x');

        ambilscreen(document.getElementById('txtvendcode').value);
        document.getElementById('txtvendcode').value = '';
        document.getElementById('txtvendcode').setAttribute('disabled','true');

        document.getElementById('tglvenddate').setAttribute('disabled','true');

        document.getElementById('txtsuplname').value = '';
        document.getElementById('txtsuplname').setAttribute('disabled','true');

        document.getElementById('txtcoaccode').value = '';
        document.getElementById('txtcoaccode').setAttribute('disabled','true');

        document.getElementById('txtcoacname').value = '';
        document.getElementById('txtcoacname').setAttribute('disabled','true');

        document.getElementById('txtcheqcode').value = '';
        document.getElementById('txtcheqcode').setAttribute('disabled','true');

        document.getElementById('tglcheqdate').setAttribute('disabled','true');

        document.getElementById('txtcheqbank').value = '';
        document.getElementById('txtcheqbank').setAttribute('disabled','true');

        document.getElementById('txtinvccode').value = '';
        document.getElementById('txtinvccode').setAttribute('disabled','true');

        document.getElementById('tgldueddate').setAttribute('disabled','true');

        document.getElementById('txtsummamnt').value = 0;
        document.getElementById('txtsummamnt').setAttribute('disabled','true');

        document.getElementById('txtpaymamnt').value = 0;
        document.getElementById('txtpaymamnt').setAttribute('disabled','true');                

        //}
    }
  }
  // Selesai Input Data ke tabel trxavend


// Tampilkan data pembayaran invoice berdasarkan invoice number 
var drz;
function ambilscreen(vendcode)
{
  if(vendcode.length > 0)
  {
    drz = buatajaxscreen();
    var url="TRXAVEND03V.php";
    drz.onreadystatechange=stateChangedscreen;
    var params = "q="+vendcode;
    drz.open("POST",url,true);
    //beberapa http header harus kita set kalau menggunakan POST
    drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    drz.setRequestHeader("Content-length", params.length);
    drz.setRequestHeader("Connection", "close");
    drz.send(params);

  }
  else
  {
    document.getElementById("tblscreen").style.visibility = "hidden";
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

// Tampilkan Data Pembayaran Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(vendcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAVEND03C.php";
    ajaxview.onreadystatechange=stateChangedview;
    var params = "q="+vendcode;
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

      document.getElementById("txtvendcode").value = res[1];
 
      document.getElementById("tglvenddate").removeAttribute('disabled');
      document.getElementById("tglvenddate").value = res[2];

      document.getElementById("txtsuplname").removeAttribute('disabled');
      document.getElementById("txtsuplname").value = res[4];
      document.getElementById("hidsuplcode").value = res[3];
    
      document.getElementById("txtcoaccode").removeAttribute('disabled');
      document.getElementById("txtcoacname").removeAttribute('disabled');
      document.getElementById("txtcheqcode").removeAttribute('disabled');
      document.getElementById("tglcheqdate").removeAttribute('disabled');
      document.getElementById("txtcheqbank").removeAttribute('disabled');

      document.getElementById('txtinvccode').removeAttribute('disabled');
      document.getElementById('tgldueddate').removeAttribute('disabled');
      document.getElementById('txtsummamnt').removeAttribute('disabled');
      document.getElementById('txtpaymamnt').removeAttribute('disabled');                

      document.getElementById("txtcoaccode").focus();

      }      
        //}
    }
  }
