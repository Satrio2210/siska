  // periksa akses

    var aksesku;
  function periksaakses(fieldid)
  {
    try 
    {
      aksesku = buatajaxakses();
      var url="ACCESS.php";
      aksesku.onreadystatechange=stateChangedAkses;
      var params = "q="+fieldid;
      //alert('Parameter adalah '+fieldid);
      aksesku.open("POST",url,true);
      aksesku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      aksesku.setRequestHeader("Content-length", params.length);
      aksesku.setRequestHeader("Connection", "close");
      aksesku.send(params);
    }

    catch(err)
    {
      alert(err.message);     
    }

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

    try
    {
      var data;
      if (aksesku.readyState==4)
        {

        xdata=aksesku.responseText;
        data=xdata.trim();
        
        if(data.length>1)
          {
            periksapaymen('1');

            document.getElementById('txtcoaccode').focus();
            document.getElementById('tglpaymdate').setAttribute('disabled','true');
            document.getElementById('txtcheqcode').setAttribute('disabled','true');
            document.getElementById('txtdivicode').setAttribute('disabled','true');

            document.getElementById('txtpayecode').setAttribute('disabled','true');
            document.getElementById('txtpaymamnt').setAttribute('disabled','true');
            document.getElementById('txtpaymnote').setAttribute('disabled','true');

            ambilscreen('');
          }
          else
          {
            document.getElementById('txtpaymcode').setAttribute('disabled','true');
            document.getElementById('tglpaymdate').setAttribute('disabled','true');
            document.getElementById('txtcoaccode').setAttribute('disabled','true');
            document.getElementById('txtcheqcode').setAttribute('disabled','true');
            document.getElementById('txtdivicode').setAttribute('disabled','true');

            document.getElementById('txtpayecode').setAttribute('disabled','true');
            document.getElementById('txtpaymamnt').setAttribute('disabled','true');
            document.getElementById('txtpaymnote').setAttribute('disabled','true');

          }
        }
    } 

    catch(err)
    {
      alert(err.message);     
    }


  }
// end periksa akses  

  // periksa Kode Pembayaran

   var bayarku;
   
  function periksapaymen(status)
  {
    try 
    {
      bayarku = buatajaxpaymen();
      var url="TRXAPAYM01X.php";
      bayarku.onreadystatechange=stateChangedpaymen;
      var params = "q="+status;
      //alert(params);
      bayarku.open("POST",url,true);
      bayarku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      bayarku.setRequestHeader("Content-length", params.length);
      bayarku.setRequestHeader("Connection", "close");
      bayarku.send(params);
    }

    catch(err)
    {
     alert(err.message); 
    }

  }

  function buatajaxpaymen()
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

  function stateChangedpaymen()
  {
  var data;
  if (bayarku.readyState==4)
    {

    xdata=bayarku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtpaymcode').value=data;
      }
      else
      {
        document.getElementById('txtpaymcode').value='';
      }
    }
  }
// end periksa Kode Pemeriksaan Pembayaran

// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(kode)
{
  if(kode.length > 10)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXAPAYM01V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+kode;
  //alert(params);
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

// ambil screen selesai

// ambil akun kas
var coacku;
function ambilcoaccode(coaccode)
{
  if(coaccode.length > 10)
  {
  document.getElementById("tblcoac").style.visibility = "hidden";
  }
  else
  {
  coacku = buatajaxcoaccode();
  var url="TRXAPAYM01C-COAC.php";
  coacku.onreadystatechange=stateChangedcoaccode;
  var params = "q="+coaccode;
  //alert(params);
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

function isicoaccode(outcoaccode,outcoacname)
{
  try 
  {
    document.getElementById("txtcoaccode").value = outcoacname;
  document.getElementById("hidcoaccode").value = outcoaccode;

      document.getElementById('tglpaymdate').removeAttribute('disabled');

      document.getElementById('txtcheqcode').removeAttribute('disabled');

      document.getElementById('txtdivicode').removeAttribute('disabled');

      document.getElementById('txtpayecode').removeAttribute('disabled');

      document.getElementById('txtpaymamnt').removeAttribute('disabled');

      document.getElementById('txtpaymnote').removeAttribute('disabled');

  document.getElementById("txtcheqcode").focus();
  document.getElementById("tblcoac").style.visibility = "hidden";
  document.getElementById("tblcoac").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
// akses akun selesai


// ambil nama divisi

var diviku;
function ambildivicode(divicode)
{
  if(divicode.length > 5)
  {
  document.getElementById("tbldivi").style.visibility = "hidden";
  }
  else
  {
  diviku = buatajaxdivicode();
  var url="TRXAPAYM01C-DIVI.php";
  diviku.onreadystatechange=stateChangeddivicode;
  var params = "q="+divicode;
  diviku.open("POST",url,true);
  diviku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  diviku.setRequestHeader("Content-length", params.length);
  diviku.setRequestHeader("Connection", "close");
  diviku.send(params);
  }
} 
function buatajaxdivicode()
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

function stateChangeddivicode()
{
  var data;
  if (diviku.readyState==4 && diviku.status==200)
  {
  data=diviku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbldivi").innerHTML = data;
    document.getElementById("tbldivi").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbldivi").innerHTML = "";
    document.getElementById("tbldivi").style.visibility = "hidden";
    }
  }
}

function isidivicode(tbldivicode,tbldiviname)
{
  try 
  {
  document.getElementById("txtdivicode").value = tbldiviname;
  document.getElementById("hiddivicode").value = tbldivicode;
  document.getElementById("txtpayecode").focus();
  document.getElementById("tbldivi").style.visibility = "hidden";
  document.getElementById("tbldivi").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
// Selesai ambil divi

// ambil akun biaya
var payeku;
function ambilpayecode(payecode)
{
  if(payecode.length > 10)
  {
  document.getElementById("tblcoac").style.visibility = "hidden";
  }
  else
  {
  payeku = buatajaxpayecode();
  var url="TRXAPAYM01C-PAYE.php";
  payeku.onreadystatechange=stateChangedpayecode;
  var params = "q="+payecode;
  //alert(params);
  payeku.open("POST",url,true);
  payeku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  payeku.setRequestHeader("Content-length", params.length);
  payeku.setRequestHeader("Connection", "close");
  payeku.send(params);
  }
} 

function buatajaxpayecode()
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

function stateChangedpayecode()
{
  var data;
  if (payeku.readyState==4 && payeku.status==200)
  {
  data=payeku.responseText;
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

function isipayecode(outpayecode,outpayename)
{
  try 
  {
  document.getElementById("txtpayecode").value = outpayename;
  document.getElementById("hidpayecode").value = outpayecode;
  document.getElementById("txtpaymamnt").focus();
  document.getElementById("tblcoac").style.visibility = "hidden";
  document.getElementById("tblcoac").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
// ambil akun biaya selesai


// Input
  var ajaxinput;
  function input(paymcode,paymdate,coaccode,cheqcode,divicode,payecode,paymamnt,paymnote)
  {
    ajaxinput = buatajaxinput();
    
    var url="TRXAPAYM01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+paymcode+"|"+paymdate+"|"+coaccode+"|"+cheqcode+"|"+divicode+"|"+payecode+"|"+paymamnt+"|"+paymnote;
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
        periksapaymen('1');

        document.getElementById('txtcoaccode').focus();
        document.getElementById('txtcoaccode').value = '';
        document.getElementById('tglpaymdate').setAttribute('disabled','true');

        document.getElementById('txtcheqcode').setAttribute('disabled','true');
        document.getElementById('txtcheqcode').value = '';

        document.getElementById('txtdivicode').setAttribute('disabled','true');
        document.getElementById('txtdivicode').value = '';

        document.getElementById('txtpayecode').setAttribute('disabled','true');
        document.getElementById('txtpayecode').value = '';

        document.getElementById('txtpaymamnt').setAttribute('disabled','true');
        document.getElementById('txtpaymamnt').value = '';

        document.getElementById('txtpaymnote').setAttribute('disabled','true');
        document.getElementById('txtpaymnote').value = '';

        ambilscreen('');
    }
  }
  // Selesai Input Data Wall ke Tabel 

// Tampilkan Data pada form 
var ajaxview
function viewcode(paymcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPAYM01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+paymcode;
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
        //alert(data);
 //    1         2          3        4        5            6         7         8       9         10      11        
// |$paymcode|$paymdate|$coaccode|$coacname|$cheqcode|$divicode|$diviname|$payecode|$payename|$paymamnt|$paymnote
      var res = data.split("|");
      document.getElementById("txtpaymcode").value = res[1];

      document.getElementById('tglpaymdate').removeAttribute('disabled');
      document.getElementById("tglpaymdate").value = res[2];

      document.getElementById("txtcoaccode").value = res[4];
      document.getElementById("hidcoaccode").value = res[3];

      document.getElementById('txtcheqcode').removeAttribute('disabled');
      document.getElementById('txtcheqcode').value = res[5];

      document.getElementById('txtdivicode').removeAttribute('disabled');
      document.getElementById('txtdivicode').value = res[7];
      document.getElementById("hiddivicode").value = res[6];

      document.getElementById('txtpayecode').removeAttribute('disabled');
      document.getElementById('txtpayecode').value = res[9];
      document.getElementById("hidpayecode").value = res[8];

      var paymamnt = convertToRupiah(Math.round(res[10]));
      document.getElementById("txtpaymamnt").removeAttribute('disabled');
      document.getElementById("txtpaymamnt").value = paymamnt;

      document.getElementById('txtpaymnote').removeAttribute('disabled');
      document.getElementById('txtpaymnote').value = res[11];

      document.getElementById("hidpaymstat").value = res[12];

      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(paymcode)
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAPAYM01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+paymcode;
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
// Selesai hapus Data Tindakan

// Posting Data pada form 
var ajaxposting
function postcode(paymcode)
{
  try 
  {
    ajaxposting = buatajaxposting();
    var url="TRXAPAYM01E-POSTING.php";
    ajaxposting.onreadystatechange=stateChangedposting;
    var params = "q="+paymcode;
    //alert(params);
    ajaxposting.open("POST",url,true);
    ajaxposting.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxposting.setRequestHeader("Content-length", params.length);
    ajaxposting.setRequestHeader("Connection", "close");
    ajaxposting.send(params);

  } 
  catch(err){ alert(err.message); }
}

  function buatajaxposting()
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

  function stateChangedposting()
  {
  var data;
  if (ajaxposting.readyState==4)
    {
      data=ajaxposting.responseText;
      if(data.length>1)
      {

     
      swal({
          title: 'Berhasil' ,
          text: 'Posting Berhasil',
          icon: 'success',
          });
      
      ambilscreen('');

     
      }      
        //}
    }
  }
