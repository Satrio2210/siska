  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="SUPLMAST01X-AKSES.php";
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
          periksasuplier('1');
          document.getElementById('txtmainname').focus();

      }
      else
      {
          document.getElementById('txtmastcode').setAttribute('disabled','true');
          document.getElementById('txtmainname').setAttribute('disabled','true');
          document.getElementById('txtmainaddr').setAttribute('disabled','true');
          document.getElementById('txtmaincity').setAttribute('disabled','true');
          document.getElementById('txtmainctry').setAttribute('disabled','true');
          document.getElementById('txtmainphne').setAttribute('disabled','true');
          document.getElementById('txtmainfaxi').setAttribute('disabled','true');
          document.getElementById('txtmainmail').setAttribute('disabled','true');
          document.getElementById('txtmainwebs').setAttribute('disabled','true');
          document.getElementById('txtmainpers').setAttribute('disabled','true');

          document.getElementById('txtmaintidn1').setAttribute('disabled','true');
          document.getElementById('txtmaintidn2').setAttribute('disabled','true');
          document.getElementById('txtmaintidn3').setAttribute('disabled','true');
          document.getElementById('txtmaintidn4').setAttribute('disabled','true');
          document.getElementById('txtmaintidn5').setAttribute('disabled','true');
          document.getElementById('txtmaintidn6').setAttribute('disabled','true');

          document.getElementById('txtmainterm').setAttribute('disabled','true');
          document.getElementById('txtestiarrv').setAttribute('disabled','true');
          document.getElementById('txtestideli').setAttribute('disabled','true');
          document.getElementById('txtpayalimt').setAttribute('disabled','true');
          document.getElementById('txtbankname').setAttribute('disabled','true');

          document.getElementById('optvailfrwd').setAttribute('disabled','true');
      }
    }
  }


  // periksa Kode Suplier 
    var suplku;
  function periksasuplier(status)
  {
    suplku = buatajaxsuplier();
    var url="SUPLMAST01X.php";
    suplku.onreadystatechange=stateChangedsuplier;
    var params = "q="+status;
    //alert(params);
    suplku.open("POST",url,true);
    suplku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    suplku.setRequestHeader("Content-length", params.length);
    suplku.setRequestHeader("Connection", "close");
    suplku.send(params);

  }

  function buatajaxsuplier()
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

  function stateChangedsuplier()
  {
  var data;
  if (suplku.readyState==4)
    {

    xdata=suplku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtmastcode').value=data;
      }
      else
      {
        document.getElementById('txtmastcode').value='';
      }
    }
  }
// end periksa Kode suplier  

	  // ambil Kode Bank dari tabel tblebank
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
  var url="SUPLMAST01C-BANK.php";
  bankku.onreadystatechange=stateChangedbankcode;
  var params = "q="+bankcode;
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
    if(data.length>3)
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
  document.getElementById("txtbankname").value = outbankname;
  document.getElementById("hidbankcode").value = outbankcode;
  document.getElementById("txtbankname").focus();
  document.getElementById("tblbank").style.visibility = "hidden";
  document.getElementById("tblbank").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
