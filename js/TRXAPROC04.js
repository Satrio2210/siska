  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPROC03X-AKSES.php";
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
        document.getElementById('tglarrvrequ').setAttribute('disabled','true');
        document.getElementById('txtwarename').setAttribute('disabled','true');
        document.getElementById('txtproccode').setAttribute('disabled','true');
        document.getElementById('txtsuplname').setAttribute('disabled','true');
        document.getElementById('tglprocdued').setAttribute('disabled','true');
        document.getElementById('txtprocterm').setAttribute('disabled','true');
        document.getElementById('txtdownpaid').setAttribute('disabled','true');
        document.getElementById('txtremapaid').setAttribute('disabled','true');      
      }
      else
      {
        document.getElementById('txtsearch').setAttribute('disabled','true');
        document.getElementById('tglarrvrequ').setAttribute('disabled','true');
        document.getElementById('txtwarename').setAttribute('disabled','true');
        document.getElementById('txtproccode').setAttribute('disabled','true');
        document.getElementById('txtsuplname').setAttribute('disabled','true');
        document.getElementById('tglprocdued').setAttribute('disabled','true');
        document.getElementById('txtprocterm').setAttribute('disabled','true');
        document.getElementById('txtdownpaid').setAttribute('disabled','true');
        document.getElementById('txtremapaid').setAttribute('disabled','true');      


      }
    }
  }
// end periksa akses  


	// Ambil data Purchase Order
var poku;
function ambilpocode(pocode)
{
  if(pocode.length > 7)
  {
  document.getElementById("tblpo").style.visibility = "hidden";
  }
  else
  {
  poku = buatajaxpocode();
  var url="TRXAPROC04C.php";
  poku.onreadystatechange=stateChangedpocode;
  var params = "q="+pocode;
  poku.open("POST",url,true);
  poku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  poku.setRequestHeader("Content-length", params.length);
  poku.setRequestHeader("Connection", "close");
  poku.send(params);
  }
} 
function buatajaxpocode()
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

function stateChangedpocode()
{
  var data;
  if (poku.readyState==4 && poku.status==200)
  {
  data=poku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblpo").innerHTML = data;
    document.getElementById("tblpo").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblpo").innerHTML = "";
    document.getElementById("tblpo").style.visibility = "hidden";
    }
  }
}
function isipocode(outproccode,outprocdued,outsuplname,outsuplcode,outdownpaid,outremapaid,outprocterm,outarrvrequ,outwarecode,outwarename
)
{
	try 
	{
  document.getElementById('tglarrvrequ').removeAttribute('disabled','true');
  document.getElementById('tglarrvrequ').value = outarrvrequ; 

  document.getElementById('txtwarename').removeAttribute('disabled','true');
  document.getElementById('txtwarename').value = outwarename;
  document.getElementById('hidwarecode').value = outwarecode;

  document.getElementById('txtproccode').removeAttribute('disabled','true');
  document.getElementById('txtproccode').value = outproccode;

  document.getElementById('txtsuplname').removeAttribute('disabled','true');
  document.getElementById('txtsuplname').value = outsuplname;
  document.getElementById('hidsuplcode').value = outsuplcode;

  document.getElementById('tglprocdued').removeAttribute('disabled','true');
  document.getElementById('tglprocdued').value = outprocdued;

  document.getElementById('txtprocterm').removeAttribute('disabled','true');
  document.getElementById('txtprocterm').value = outprocterm;

  document.getElementById('txtdownpaid').removeAttribute('disabled','true');
  document.getElementById('txtdownpaid').value = outdownpaid;

  document.getElementById('txtremapaid').removeAttribute('disabled','true');
  document.getElementById('txtremapaid').value = outremapaid;

  ambiltrxascreen(outproccode);
  document.getElementById("txtsearch").value = '';
  document.getElementById("txtsearch").focus();
  document.getElementById("tblpo").style.visibility = "hidden";
  document.getElementById("tblpo").innerHTML = "";

	} catch(err){ alert(err.message); }


}




// tampilkan data transaksi yang telah dipilih , baik setelah Update maupun setelah ditambahkan

var drz;
function ambiltrxascreen(pocode)
{
  try {	
  drz = buatajaxtrxascreen();
  var url="TRXAPROC04V.php";
  drz.onreadystatechange=stateChangedtrxascreen;
  var params = "q="+pocode;
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


// Rollback Goods Receiving to Receiving Form
  var ajaxdelete;
  function cancelpo(pocode)
  {
    ajaxdelete = buatajaxdelete();
    var url="TRXAPROC04D.php";
    ajaxdelete.onreadystatechange=stateChangedDelete;
    var params = "q="+pocode;
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
      document.getElementById('tglarrvrequ').setAttribute('disabled','true');
      document.getElementById('txtwarename').setAttribute('disabled','true');
      document.getElementById('txtwarename').value = '';
      document.getElementById('txtproccode').setAttribute('disabled','true');
      document.getElementById('txtproccode').value = '';
      document.getElementById('txtsuplname').setAttribute('disabled','true');
      document.getElementById('txtsuplname').value = '';
      document.getElementById('tglprocdued').setAttribute('disabled','true');
      document.getElementById('txtprocterm').setAttribute('disabled','true');
      document.getElementById('txtprocterm').value = '';
      document.getElementById('txtdownpaid').setAttribute('disabled','true');
      document.getElementById('txtdownpaid').value = '';
      document.getElementById('txtremapaid').setAttribute('disabled','true');
      document.getElementById('txtremapaid').value = '';
      ambiltrxascreen('');
    }
  }
// Selesai Hapus Data Jurnal Transaksi ke Tabel Jurnal
