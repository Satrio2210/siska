  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAJRNL02X-AKSES.php";
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
            document.getElementById('tgljrnldate').setAttribute('disabled','true');
            document.getElementById('txtcoaccode').setAttribute('disabled','true');
            document.getElementById('txtjrnldebt').setAttribute('disabled','true');
            document.getElementById('txtjrnlcrdt').setAttribute('disabled','true');
            document.getElementById('txtdiviname').setAttribute('disabled','true');
            document.getElementById('txtjrnlnote').setAttribute('disabled','true');
            document.getElementById('txtjrnlcode').focus();
      }
      else
      {
          document.getElementById('txtjrnlcode').setAttribute('disabled','true');
          document.getElementById('tgljrnldate').setAttribute('disabled','true');
          document.getElementById('txtcoaccode').setAttribute('disabled','true');      
          document.getElementById('txtcoacname').setAttribute('disabled','true');
          document.getElementById('txtjrnldebt').setAttribute('disabled','true');
          document.getElementById('txtjrnlcrdt').setAttribute('disabled','true');
          document.getElementById('txtdiviname').setAttribute('disabled','true');
          document.getElementById('txtjrnlnote').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


	// Ambil Kode Jurnal Transaksi tabel trxajrnl
var jrnlku;
function ambiljrnlcode(jrnlcode)
{
  if(jrnlcode.length > 7)
  {
  document.getElementById("tbljrnl").style.visibility = "hidden";
  }
  else
  {
  jrnlku = buatajaxjrnlcode();
  var url="TRXAJRNL02C.php";
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
  document.getElementById("txtjrnldebt").removeAttribute('disabled','true');
  document.getElementById("txtjrnlcrdt").removeAttribute('disabled','true');
  document.getElementById("txtdiviname").removeAttribute('disabled','true');
  document.getElementById("txtjrnlnote").removeAttribute('disabled','true');
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
  var url="TRXAJRNL01C-COAC.php";
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
  var url="TRXAJRNL01C-DIVI.php";
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

// Update Data Jurnal Transaksi ke Tabel Jurnal
  var ajaxupdate;
  function Update(jrnlcode,jrnldate,oldcoaccode,coaccode,coacname,jrnldebt,jrnlcrdt,divicode,diviname,jrnlnote,entrtime)
  {
    ajaxupdate = buatajaxupdate();
    var url="TRXAJRNL02U.php";
    ajaxupdate.onreadystatechange=stateChangedUpdate;
    var params = "q="+jrnlcode+"|"+jrnldate+"|"+oldcoaccode+"|"+coaccode+"|"+coacname+"|"+jrnldebt+"|"+jrnlcrdt+"|"+divicode+"|"+diviname+"|"+jrnlnote+"|"+entrtime;
    //alert(params);
    ajaxupdate.open("POST",url,true);
    ajaxupdate.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxupdate.setRequestHeader("Content-length", params.length);
    ajaxupdate.setRequestHeader("Connection", "close");
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

  function stateChangedUpdate()
  {
  var data;
  if (ajaxupdate.readyState==4)
    {
      var todaynow = new Date()
      var today = convertDate(todaynow);
      document.getElementById('txtjrnlcode').value = '';
			document.getElementById('hidentrtime').value = '';
			document.getElementById('tgljrnldate').value = today;
			document.getElementById('txtcoaccode').value = '';
      document.getElementById('hidcoaccode').value = '';
			document.getElementById('txtcoacname').value = '';
			document.getElementById('txtjrnldebt').value = '';
			document.getElementById('txtjrnlcrdt').value = '';
			document.getElementById('hiddivicode').value = '';
			document.getElementById('txtdiviname').value = '';
			document.getElementById('txtjrnlnote').value = '';
      document.getElementById('txtjrnlcode').focus();
      var kodejurnal = document.getElementById('hidjrnlcode').value;
      ambiltrxascreen(kodejurnal);
        //}
    }
  }
// Selesai Update Data Jurnal Transaksi ke Tabel Jurnal

// Insert Data Jurnal Transaksi ke Tabel Jurnal
  var ajaxInsert;
  function Insert(jrnlcode,jrnldate,coaccode,coacname,jrnldebt,jrnlcrdt,divicode,diviname,jrnlnote)
  {
    ajaxInsert = buatajaxInsert();
    var url="TRXAJRNL02E.php";
    ajaxInsert.onreadystatechange=stateChangedInsert;
    var params = "q="+jrnlcode+"|"+jrnldate+"|"+coaccode+"|"+coacname+"|"+jrnldebt+"|"+jrnlcrdt+"|"+divicode+"|"+diviname+"|"+jrnlnote;
    //alert(params);
    ajaxInsert.open("POST",url,true);
    ajaxInsert.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxInsert.setRequestHeader("Content-length", params.length);
    ajaxInsert.setRequestHeader("Connection", "close");
    ajaxInsert.send(params);
  }

  function buatajaxInsert()
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

  function stateChangedInsert()
  {
  var data;
  if (ajaxInsert.readyState==4)
    {
      var todaynow = new Date()
      var today = convertDate(todaynow);
      document.getElementById('txtjrnlcode').value = '';
      document.getElementById('hidentrtime').value = '';
      document.getElementById('tgljrnldate').value = today;
      document.getElementById('txtcoaccode').value = '';
      document.getElementById('hidcoaccode').value = '';
      document.getElementById('txtcoacname').value = '';
      document.getElementById('txtjrnldebt').value = '';
      document.getElementById('txtjrnlcrdt').value = '';
      document.getElementById('hiddivicode').value = '';
      document.getElementById('txtdiviname').value = '';
      document.getElementById('txtjrnlnote').value = '';
      document.getElementById('txtjrnlcode').focus();
      var kodejurnal = document.getElementById('hidjrnlcode').value;
      ambiltrxascreen(kodejurnal);
        //}
    }
  }
// Selesai Insert Data Jurnal Transaksi ke Tabel Jurnal


// tampilkan data transaksi yang telah dipilih , baik setelah Update maupun setelah ditambahkan

var drz;
function ambiltrxascreen(kodejurnal)
{
  try {	
  drz = buatajaxtrxascreen();
  var url="TRXAJRNL02V.php";
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
// Tampilkan item transaksi yang telah di pilih pada form untuk di ubah 
var ajaxview
function viewcode(outjrnlcode,outcoaccode,outentrtime)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAJRNL02C-JRNL.php";
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
    	document.getElementById("tgljrnldate").disabled = false;
        document.getElementById("tgljrnldate").value = res[2];
        document.getElementById("txtcoaccode").disabled = false;
        document.getElementById('txtcoaccode').value = res[3];
        document.getElementById('hidcoaccode').value = res[3];
        document.getElementById('txtcoacname').value = res[4];
        document.getElementById('txtjrnldebt').disabled = false;
        var nominaldebt = convertToRupiah(Math.round(res[5]));
        document.getElementById('txtjrnldebt').value = nominaldebt;
        document.getElementById('txtjrnlcrdt').disabled = false;
        var nominalcrdt = convertToRupiah(Math.round(res[6]));
        document.getElementById('txtjrnlcrdt').value = nominalcrdt;
        document.getElementById('hiddivicode').value = res[7];
        document.getElementById('txtdiviname').value = res[8];
        document.getElementById('txtjrnlnote').disabled = false;
        document.getElementById('txtjrnlnote').value = res[9];
        document.getElementById('txtcoaccode').focus();
        //var kodejurnal = document.getElementById('txtjrnlcode').value;
        //ambiltrxascreen(kodejurnal);

    	}
    	
        //}
    }
  }


// Delete Data Jurnal Transaksi ke Tabel Jurnal
  var ajaxdelete;
  function Delete(jrnlcode,coaccode,entrtime)
  {
    ajaxdelete = buatajaxdelete();
    var url="TRXAJRNL02D.php";
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
            var todaynow = new Date()
      var today = convertDate(todaynow);
        document.getElementById('txtjrnlcode').value = '';
        document.getElementById('hidentrtime').value = '';
        document.getElementById('tgljrnldate').value = today;
        document.getElementById('txtcoaccode').value = '';
        document.getElementById('txtcoacname').value = '';
        document.getElementById('txtjrnldebt').value = '';
        document.getElementById('txtjrnlcrdt').value = '';
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
