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
          document.getElementById('txtmastcode').focus();

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


// Ambil Data Suplier Master
var suplmastku;
function ambilsuplmastcode(suplmastcode)
{
  if(suplmastcode.length > 4)
  {
  document.getElementById("tblsuplmast").style.visibility = "hidden";
  }
  else
  {
  suplmastku = buatajaxsuplmastcode();
  var url="SUPLMAST02C.php";
  suplmastku.onreadystatechange=stateChangedsuplmastcode;
  var params = "q="+suplmastcode;
  suplmastku.open("POST",url,true);
  suplmastku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  suplmastku.setRequestHeader("Content-length", params.length);
  suplmastku.setRequestHeader("Connection", "close");
  suplmastku.send(params);
  }
} 

function buatajaxsuplmastcode()
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


function stateChangedsuplmastcode()
{
  var data;
  if (suplmastku.readyState==4 && suplmastku.status==200)
  {
  data=suplmastku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblsuplmast").innerHTML = data;
    document.getElementById("tblsuplmast").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblsuplmast").innerHTML = "";
    document.getElementById("tblsuplmast").style.visibility = "hidden";
    }
  }
}

function isisuplmastcode(mastcode, mainname, mainaddr, maincity, mainctry, mainphne, mainfaxi, mainmail, mainwebs, mainpers, maintidn, mainterm, estiarrv, estideli, payalimt, bankname, bankcode, avaifrwd)
{
	document.getElementById("txtmastcode").value = mastcode;
	document.getElementById("txtmainname").value = mainname;
	document.getElementById("txtmainaddr").value = mainaddr;
	document.getElementById("txtmaincity").value = maincity;
	document.getElementById("txtmainctry").value = mainctry;
	document.getElementById("txtmainphne").value = mainphne;
	document.getElementById("txtmainfaxi").value = mainfaxi;
	document.getElementById("txtmainmail").value = mainmail;
	document.getElementById("txtmainwebs").value = mainwebs;
	document.getElementById("txtmainpers").value = mainpers;

	taxnumber = new String (maintidn);
    //01.844.059.4-038.000 	
	var maintidn1 = taxnumber.substring(0,2);
	document.getElementById("txtmaintidn1").value = maintidn1;

	var maintidn2 = taxnumber.substring(6,3);
	document.getElementById("txtmaintidn2").value = maintidn2;

	var maintidn3 = taxnumber.substring(10,7);
	document.getElementById("txtmaintidn3").value = maintidn3;

	var maintidn4 = taxnumber.substring(12,11);
	document.getElementById("txtmaintidn4").value = maintidn4;

	var maintidn5 = taxnumber.substring(16,13);
	document.getElementById("txtmaintidn5").value = maintidn5;

	var maintidn6 = taxnumber.substring(20,17);
	document.getElementById("txtmaintidn6").value = maintidn6;

	document.getElementById("txtmainterm").value = mainterm;
	document.getElementById("txtestiarrv").value = estiarrv;
	document.getElementById("txtestideli").value = estideli;

	var nominallimit = convertToRupiah(Math.round(payalimt));
	document.getElementById("txtpayalimt").value = nominallimit;

	document.getElementById("txtbankname").value = bankname;
	document.getElementById("hidbankcode").value = bankcode;

	if (avaifrwd == 'Y') 
    { 
    	document.getElementById("optavaifrwd").checked = true;
    	document.getElementById("hidavaifrwd").value = 'Y'; 
  	}
  	else
  	{
    	document.getElementById("optavaifrwd").checked = false;
    	document.getElementById("hidavaifrwd").value = 'N'; 
  	}
  document.getElementById("txtmastcode").focus();
  document.getElementById("tblsuplmast").style.visibility = "hidden";
  document.getElementById("tblsuplmast").innerHTML = "";

}

