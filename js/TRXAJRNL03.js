	// Ambil Kode Jurnal Transaksi tabel trxajrnl
var jrnlku;
function ambiljrnlcode(jrnlcode)
{
  if(jrnlcode.length > 4)
  {
  document.getElementById("tbljrnl").style.visibility = "hidden";
  }
  else
  {
  jrnlku = buatajaxjrnlcode();
  var url="TRXAJRNL03GETCODE.php";
  jrnlku.onreadystatechange=stateChangedjrnlcode;
  var params = "q="+jrnlcode;
  jrnlku.open("POST",url,true);
  jrnlku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  jrnlku.setRequestHeader("Content-length", params.length);
  jrnlku.setRequestHeader("Connection", "close");
  jrnlku.send(params);
  }
} 
function buatajaxjrnlcode()
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

function stateChangedjrnlcode()
{
  var data;
  if (jrnlku.readyState==4 && jrnlku.status==200)
  {
  data=jrnlku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbljrnl").innerHTML = data;
    document.getElementById("tbljrnl").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbljrnl").innerHTML = "";
    document.getElementById("tbljrnl").style.visibility = "hidden";
    }
  }
}

function isijrnlcode(tbljrnlcode)
{
	try 
	{
  ambiltrxascreen(tbljrnlcode);
  document.getElementById("txtjrnlcode").value = '';
  document.getElementById("txtjrnlcode").focus();
  document.getElementById("tbljrnl").style.visibility = "hidden";
  document.getElementById("tbljrnl").innerHTML = "";

	} catch(err){ alert(err.message); }
}

	// ambil Akun Code dari tabel coacmast
var coacku;
function ambilcoaccode(coaccode)
{
  if(coaccode.length > 4)
  {
  document.getElementById("tblcoac").style.visibility = "hidden";
  }
  else
  {
  coacku = buatajaxcoaccode();
  var url="TRXAJRNL03GETCOACCODE.php";
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

function isicoaccode(tblcoaccode,tblcoacname,tblcoaccrnc)
{
	try 
	{
  document.getElementById("txtcoaccode").value = tblcoaccode;
  document.getElementById("txtcoacname").value = tblcoacname;
  document.getElementById("txtjrnldebt").removeAttribute('disabled','true');
  document.getElementById("txtjrnlcrdt").removeAttribute('disabled','true');
  document.getElementById("txtdiviname").removeAttribute('disabled','true');
  document.getElementById("txtjrnlnote").removeAttribute('disabled','true');
  document.getElementById("txtjrnldebt").focus();
  document.getElementById("tblcoac").style.visibility = "hidden";
  document.getElementById("tblcoac").innerHTML = "";

	} catch(err){ alert(err.message); }


}
	// ambil Kode Divisi dari tabel tbledivi
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
  var url="TRXAJRNL03GETDIVICODE.php";
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

function isidivicode(tbldivicode,tbldiviname,tbldivicrnc)
{
	try 
	{
  document.getElementById("hiddivicode").value = tbldivicode;
  document.getElementById("txtdiviname").value = tbldiviname;
  document.getElementById("txtjrnlnote").focus();
  document.getElementById("tbldivi").style.visibility = "hidden";
  document.getElementById("tbldivi").innerHTML = "";

	} 
  catch(err){ alert(err.message); }
}

// Delete Data Jurnal Transaksi ke Tabel Jurnal
  var ajaxdelete;
  function Delete(jrnlcode,coaccode,entrtime)
  {
    ajaxdelete = buatajaxdelete();
    var url="TRXAJRNL03U.php";
    ajaxdelete.onreadystatechange=stateChangedDelete;
    var params = "q="+jrnlcode+"|"+coaccode+"|"+entrtime;
    //alert(params);
    ajaxdelete.open("POST",url,true);
    ajaxdelete.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxdelete.setRequestHeader("Content-length", params.length);
    ajaxdelete.setRequestHeader("Connection", "close");
    ajaxdelete.send(params);
  }

  function buatajaxdelete()
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

  function stateChangedDelete()
  {
  var data;
  if (ajaxdelete.readyState==4)
    {
        document.getElementById('txtjrnlcode').value = '';
				document.getElementById('hidentrtime').value = '';
				document.getElementById('tgljrnldate').value = '';
				document.getElementById('txtcoaccode').value = '';
				document.getElementById('txtcoacname').value = '';
				document.getElementById('txtjrnldebt').value = '';
				document.getElementById('txtjrnlcrdt').value = '';
				document.getElementById('txtjrnlcrnc').value = '';
				document.getElementById('hiddivicode').value = '';
				document.getElementById('txtdiviname').value = '';
				document.getElementById('txtjrnlnote').value = '';
        document.getElementById('txtjrnlcode').focus();
        var kodejurnal = document.getElementById('hidjrnlcode').value;
        ambiltrxascreen(kodejurnal);
        //}
    }
  }
// Selesai Hapus Data Jurnal Transaksi ke Tabel Jurnal

// tampilkan data transaksi yang sedang di proses dan belum di posting

var drz;
function ambiltrxascreen(kodejurnal)
{
  //if(kodejurnal.length > 7)
  //{
  //document.getElementById("tbltrxascreen").style.visibility = "hidden";
  //}
  //else
  //{
  try {	
  drz = buatajaxtrxascreen();
  var url="TRXAJRNL03XX.php";
  //var url=url+"?q="+kodejurnal;
  //var url=url+"&sid="+Math.random();
  drz.onreadystatechange=stateChangedtrxascreen;
  var params = "q="+kodejurnal;
  drz.open("POST",url,true);
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  }  catch(err) {alert (err.message);}
  //}
} 

function buatajaxtrxascreen()
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

function stateChangedtrxascreen() 
{   var datapost;   
  if (drz.readyState==4)   
    { 
      datapost=drz.responseText;
      if(datapost.length>3)
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
// Tampilkan item transaksi pada form untuk di ubah 
var ajaxview
function viewcode(outjrnlcode,outcoaccode,outentrtime)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAJRNL03G.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+outjrnlcode+"|"+outcoaccode+"|"+outentrtime;
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
    	if(data.length>3)
    	{
    	var res = data.split("|");
    	document.getElementById("txtjrnlcode").value = res[1];
    	document.getElementById("hidjrnlcode").value = res[1];
    	document.getElementById("hidentrtime").value = res[10];
      document.getElementById("tgljrnldate").value = res[2];
      document.getElementById('txtcoaccode').value = res[3];
      document.getElementById('txtcoacname').value = res[4];
      var nominaldebt = convertToRupiah(Math.round(res[5]));
      document.getElementById('txtjrnldebt').value = nominaldebt;
      var nominalcrdt = convertToRupiah(Math.round(res[6]));
      document.getElementById('txtjrnlcrdt').value = nominalcrdt;
      document.getElementById('hiddivicode').value = res[7];
      document.getElementById('txtdiviname').value = res[8];
      document.getElementById('txtjrnlnote').value = res[9];
      document.getElementById('txtjrnlcode').focus();
        //var kodejurnal = document.getElementById('txtjrnlcode').value;
        //ambiltrxascreen(kodejurnal);

    	}
    	
        //}
    }
  }
