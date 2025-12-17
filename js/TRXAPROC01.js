  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPROC01X-AKSES.php";
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
        periksastatus('AP');
        ambiltrxascreen(document.getElementById('txtproccode').value);      
      }
      else
      {
        document.getElementById('txtproccode').setAttribute('disabled','true');

        document.getElementById('tglprocdate').setAttribute('disabled','true');
        document.getElementById('tglprocdued').setAttribute('disabled','true');

        document.getElementById('txtprocdivi').setAttribute('disabled','true');
        document.getElementById('txtsuplname').setAttribute('disabled','true');
        document.getElementById('txtsupladdr').setAttribute('disabled','true');

        document.getElementById('optshipping').setAttribute('disabled','true');
        document.getElementById('optdestination').setAttribute('disabled','true');

        document.getElementById('optnone').setAttribute('disabled','true');
        document.getElementById('optexclude').setAttribute('disabled','true');
        document.getElementById('optinclude').setAttribute('disabled','true');

        document.getElementById('optnolc').setAttribute('disabled','true');
        document.getElementById('optwithlc').setAttribute('disabled','true');

        document.getElementById('opttermpaid').setAttribute('disabled','true');

        document.getElementById('txtdownpaid').setAttribute('disabled','true');

        document.getElementById('txtprocterm').setAttribute('disabled','true');

        document.getElementById('txtpartname').setAttribute('disabled','true');
        document.getElementById('txtqutyordr').setAttribute('disabled','true');
        document.getElementById('txtpartpric').setAttribute('disabled','true');
        document.getElementById('txttotalpric').setAttribute('disabled','true');

        document.getElementById('txtchrgvalu').setAttribute('disabled','true');
        document.getElementById('optamount').setAttribute('disabled','true');
        document.getElementById('optpercentage').setAttribute('disabled','true');

        document.getElementById('tglarrvrequ').setAttribute('disabled','true');
        document.getElementById('txtwarename').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

  // periksa Kode Purchasing Order Transaksi 
    var orderku;
  function periksastatus(status)
  {
    orderku = buatajaxstatus();
    var url="TRXAPROC01X.php";
    orderku.onreadystatechange=stateChangedstatus;
    var params = "q="+status;
    //alert(params);
    orderku.open("POST",url,true);
    orderku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    orderku.setRequestHeader("Content-length", params.length);
    orderku.setRequestHeader("Connection", "close");
    orderku.send(params);

  }

  function buatajaxstatus()
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

  function stateChangedstatus()
  {
  var data;
  if (orderku.readyState==4)
    {

    xdata=orderku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtproccode').value=data;
        ambiltrxascreen(data);
      }
      else
      {
        document.getElementById('txtproccode').value='';
      }
    }
  }
// end periksa Kode status  

  // tampilkan data form yang masih dalam proses input tapi belum di close 

var formku;
function periksaorder(kodeorder)
  {
    formku = buatajaxorder();
    var url="TRXAPROC01C.php";
    formku.onreadystatechange=stateChangedorder;
    var params = "q="+kodeorder;
    formku.open("POST",url,true);
    formku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    formku.setRequestHeader("Content-length", params.length);
    formku.setRequestHeader("Connection", "close");
    formku.send(params);
  }

function buatajaxorder()
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

function stateChangedorder()
  {
  var data;
  if (formku.readyState==4 && formku.status==200)
  {
  xdata=formku.responseText;
  data = xdata.trim();
    if(data.length>3)
    {   

        var res = data.split("|");
        document.getElementById("tglprocdate").value = res[1];
        document.getElementById("tglprocdued").value = res[2];
        document.getElementById("txtprocdivi").value = res[3];
        document.getElementById("hidprocdivi").value = res[4];
        document.getElementById("txtsuplname").value = res[5];
        document.getElementById("hidsuplcode").value = res[6];
        document.getElementById("txtsupladdr").value = res[7];

        if(res[8] == 'S') 
            { 
                document.getElementById("optshipping").checked = true;
                document.getElementById("optdestination").checked = false; 
            }
        else if(res[8] == 'D') 
            { 
                document.getElementById("optshipping").checked = false;
                document.getElementById("optdestination").checked = true; 
            }
        else
            {
                document.getElementById("optshipping").checked = false;
                document.getElementById("optdestination").checked = false; 
            }
        document.getElementById("hidprocfrob").value = res[8];


        if(res[9] == 'N') 
            { 
                document.getElementById("optnone").checked = true;
                document.getElementById("optexclude").checked = false;
                document.getElementById("optinclude").checked = false; 
            }
        else if(res[9] == 'E') 
            { 
                document.getElementById("optnone").checked = false;
                document.getElementById("optexclude").checked = true;
                document.getElementById("optinclude").checked = false; 
            }
        else if(res[9] == 'I') 
            { 
                document.getElementById("optnone").checked = false;
                document.getElementById("optexclude").checked = false;
                document.getElementById("optinclude").checked = true; 
            }
        else
            {
                document.getElementById("optnone").checked = false;
                document.getElementById("optexclude").checked = false;
                document.getElementById("optinclude").checked = false; 
            }

        document.getElementById("hidprocvatx").value = res[9];

        if(res[10] == 'NLC') 
            { 
                document.getElementById("optnolc").checked = true;
                document.getElementById("optwithlc").checked = false; 
            }
        else if(res[10] == 'WLC') 
            { 
                document.getElementById("optnolc").checked = false;
                document.getElementById("optwithlc").checked = true; 
            }
        else
            {
                document.getElementById("optnolc").checked = false;
                document.getElementById("optwithlc").checked = false; 
            }        
        document.getElementById("hidproctype").value = res[10];
        //document.getElementById("txttermpaid").value = res[11];
        var inDownPaid = convertToRupiah(Math.round(res[12]));
        document.getElementById("txtdownpaid").value = inDownPaid;
        document.getElementById("txtprocterm").value = res[13];
      }
      else
      {
        //alert('no data');
        document.getElementById("txtprocdivi").value = '';
        document.getElementById("hidprocdivi").value = '';
        document.getElementById("txtsuplname").value = '';
        document.getElementById("hidsuplcode").value = '';
        document.getElementById("txtsupladdr").value = '';

        document.getElementById("optshipping").checked = false;
        document.getElementById("optdestination").checked = false; 
        document.getElementById("hidprocfrob").value = '';

        document.getElementById("optnone").checked = false;
        document.getElementById("optexclude").checked = false;
        document.getElementById("optinclude").checked = false; 

        document.getElementById("hidprocvatx").value = '';

        document.getElementById("optnolc").checked = false;
        document.getElementById("optwithlc").checked = false; 
        document.getElementById("hidproctype").value = '';
        document.getElementById("txttermpaid").value = '';
        document.getElementById("txtdownpaid").value = '';
        document.getElementById("txtprocterm").value = '';
      }
    }
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
  var url="TRXAPROC01C-DIVI.php";
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
  document.getElementById("txtprocdivi").value = tbldiviname;
  document.getElementById("hidprocdivi").value = tbldivicode;
  document.getElementById("txtsuplname").focus();
  document.getElementById("tbldivi").style.visibility = "hidden";
  document.getElementById("tbldivi").innerHTML = "";

	} 
  catch(err){ alert(err.message); }
}

  // ambil Kode Divisi dari tabel suplmast
var suplku;
function ambilsuplcode(suplcode)
{
  if(suplcode.length > 5)
  {
  document.getElementById("tblsupl").style.visibility = "hidden";
  }
  else
  {
  suplku = buatajaxsuplcode();
  var url="TRXAPROC01C-SUPL.php";
  suplku.onreadystatechange=stateChangedsuplcode;
  var params = "q="+suplcode;
  suplku.open("POST",url,true);
  suplku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  suplku.setRequestHeader("Content-length", params.length);
  suplku.setRequestHeader("Connection", "close");
  suplku.send(params);
  }
} 
function buatajaxsuplcode()
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

function stateChangedsuplcode()
{
  var data;
  if (suplku.readyState==4 && suplku.status==200)
  {
  data=suplku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblsupl").innerHTML = data;
    document.getElementById("tblsupl").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblsupl").innerHTML = "";
    document.getElementById("tblsupl").style.visibility = "hidden";
    }
  }
}

function isisuplcode(tblsuplcode,tblsuplname,tblsupladdr,tblsuplterm)
{
  try 
  {
  document.getElementById("hidsuplcode").value = tblsuplcode;
  document.getElementById("txtsuplname").value = tblsuplname;
  document.getElementById("txtsupladdr").value = tblsupladdr;
  document.getElementById("txtprocterm").value = tblsuplterm;
  document.getElementById("txtsupladdr").focus();
  document.getElementById("tblsupl").style.visibility = "hidden";
  document.getElementById("tblsupl").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


  // ambil Kode Item Inventory dari tabel invemast

var itemku;
function ambilinvecode(invecode)
{
  if(invecode.length > 5)
  {
  document.getElementById("tblinve").style.visibility = "hidden";
  }
  else
  {
  itemku = buatajaxinvecode();
  var url="TRXAPROC01C-INVE.php";
  itemku.onreadystatechange=stateChangedinvecode;
  var params = "q="+invecode;
  itemku.open("POST",url,true);
  itemku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  itemku.setRequestHeader("Content-length", params.length);
  itemku.setRequestHeader("Connection", "close");
  itemku.send(params);
  }
} 
function buatajaxinvecode()
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

function stateChangedinvecode()
{
  var data;
  if (itemku.readyState==4 && itemku.status==200)
  {
  data=itemku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblinve").innerHTML = data;
    document.getElementById("tblinve").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblinve").innerHTML = "";
    document.getElementById("tblinve").style.visibility = "hidden";
    }
  }
}

function isiinvecode(tblinvecode,tblunitcode, tblinvename, tblwarecode, tblwarename)
{
  try 
  {
  document.getElementById("txtpartname").value = tblinvename;
  document.getElementById("hidpartcode").value = tblinvecode;
  document.getElementById("hidpartunit").value = tblunitcode;
  document.getElementById("txtwarename").value = tblwarename;
  document.getElementById("hidwarecode").value = tblwarecode;
  document.getElementById("txtqutyordr").value = 0;
  document.getElementById("txtpartpric").value = 0;
  document.getElementById("txtchrgvalu").value = 0;
  document.getElementById("optamount").checked = true;
  document.getElementById("txtqutyordr").focus();
  document.getElementById("tblinve").style.visibility = "hidden";
  document.getElementById("tblinve").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// periksa limit hutang suplier
var limitku;
function periksalimit(kodevendor)
  {
    limitku = buatajaxlimit();
    var url="TRXAPROC01X-LIMIT.php";
    limitku.onreadystatechange=stateChangedlimit;
    var params = "q="+kodevendor;
    limitku.open("POST",url,true);
    limitku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    limitku.setRequestHeader("Content-length", params.length);
    limitku.setRequestHeader("Connection", "close");
    limitku.send(params);
  }

function buatajaxlimit()
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

function stateChangedlimit()
  {
  var data;
  if (limitku.readyState==4 && limitku.status==200)
  {
  xdata=limitku.responseText;
  data = xdata.trim();
    if(data.length>3)
    {   
        var res = data.split("|");

        var xnewqty = convertToAngka(document.getElementById('txtqutyordr').value);
        var newqty = parseInt(xnewqty);

        var xnewpric = convertToAngka(document.getElementById('txtpartpric').value);
        var newpric = parseInt(xnewpric);

        var newsummary = (newqty * newpric);

        var cursummary = parseInt(res[3]);

        var limitsummary = parseInt(res[2]);
        //alert('Limit :'+limitsummary+'Total Order :'+newsummary);

        var totalsummary = newsummary + cursummary;

        if(totalsummary > limitsummary)
        {
          alert('Limit Hutang Suplier melewati batas');
          document.getElementById('txtpartname').focus();
        }
        else
        {
          var inproccode = document.getElementById('txtproccode').value;
          var inprocdate = document.getElementById('tglprocdate').value;
          var inprocdued = document.getElementById('tglprocdued').value;
          var inprocdivi = document.getElementById('hidprocdivi').value;
          var insuplcode = document.getElementById('hidsuplcode').value;
          var inprocfrob = document.getElementById('hidprocfrob').value;
          var inprocvatx = document.getElementById('hidprocvatx').value;
          var inproctype = document.getElementById('hidproctype').value;
          var intermpaid = document.getElementById('opttermpaid').value;
          var indownpaid = document.getElementById('txtdownpaid').value;
          var inprocterm = document.getElementById('txtprocterm').value;
          var inpartcode = document.getElementById('hidpartcode').value;
          var inpartname = document.getElementById('txtpartname').value;
          var inqutyordr = document.getElementById('txtqutyordr').value;
          var inpartunit = document.getElementById('hidpartunit').value;
          var inpartpric = document.getElementById('txtpartpric').value;
          var inchrgvalu = document.getElementById('txtchrgvalu').value;
          var inchrgmthd = document.getElementById('hidchrgmthd').value;                                
          var inarrvrequ = document.getElementById('tglarrvrequ').value;
          var inwarecode = document.getElementById('hidwarecode').value;

          Input(inproccode, inprocdate, inprocdued, inprocdivi, insuplcode, inprocfrob, inprocvatx, inproctype, intermpaid, indownpaid, inprocterm, inpartcode, inpartname, inqutyordr, inpartunit, inpartpric, inchrgvalu, inchrgmthd, inarrvrequ, inwarecode);
        }
    }
    else
    {
        alert('Limit Hutang Suplier belum lengkap');
        document.getElementById('txtpartname').focus();
    }
  }
}

// Periksa limit hutang suplier selesai

// Input Data Purchase Order Transaksi ke Tabel Purchase Order dan Tabel Item Order

  var ajaxinput;
  function Input(proccode,procdate,procdued,procdivi,suplcode,procfrob,procvatx,proctype,termpaid,downpaid,procterm,partcode,partname,qutyordr,partunit,partpric,chrgvalu,chrgmthd,arrvrequ,warecode)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAPROC01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+proccode+"|"+procdate+"|"+procdued+"|"+procdivi+"|"+suplcode+"|"+procfrob+"|"+procvatx+"|"+proctype+"|"+termpaid+"|"+downpaid+"|"+procterm+"|"+partcode+"|"+partname+"|"+qutyordr+"|"+partunit+"|"+partpric+"|"+chrgvalu+"|"+chrgmthd+"|"+arrvrequ+"|"+warecode;   
    //alert(params);
    ajaxinput.open("POST",url,true);
    ajaxinput.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxinput.setRequestHeader("Content-length", params.length);
    ajaxinput.setRequestHeader("Connection", "close");
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
        document.getElementById("hidpartcode").value = '';
        document.getElementById('txtpartname').value = '';
        document.getElementById('txtqutyordr').value = '';
        document.getElementById('hidpartunit').value = '';
        document.getElementById('txtpartpric').value = '';
        document.getElementById('txtchrgvalu').value = '';
        document.getElementById('hidwarecode').value = '';
        document.getElementById('txtpartname').focus();
        var kodeorder = document.getElementById('txtproccode').value;
        ambiltrxascreen(kodeorder);
        //}
    }
  }
// Selesai Input Data Jurnal Transaksi ke Tabel Jurnal

// tampilkan data transaksi yang sedang di proses dan belum di posting

var drz;
function ambiltrxascreen(kodeorder)
{
  //if(kodejurnal.length > 7)
  //{
  //document.getElementById("tbltrxascreen").style.visibility = "hidden";
  //}
  //else
  //{
  try {	
  drz = buatajaxtrxascreen();
  var url="TRXAPROC01V.php";
  //var url=url+"?q="+kodejurnal;
  //var url=url+"&sid="+Math.random();
  drz.onreadystatechange=stateChangedtrxascreen;
  var params = "q="+kodeorder;
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
            // tampilkan input order yang masih gantung
            periksaorder(document.getElementById('txtproccode').value);     
        }     
      else 
        {  
          document.getElementById("tbltrxascreen").innerHTML = "";
          document.getElementById("tbltrxascreen").style.visibility = "hidden";     
        }

    } 
}
// hapus item transaksi pada jurnal yang masih proses input 
var ajaxhapus
function hapusitem(outproccode,outpartcode,outentrtime)
{
  try 
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAPROC01D.php";
    ajaxhapus.onreadystatechange=stateChangedHapus;
    var params = "q="+outproccode+"|"+outpartcode+"|"+outentrtime;
    //alert(params);
    ajaxhapus.open("POST",url,true);
    ajaxhapus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxhapus.setRequestHeader("Content-length", params.length);
    ajaxhapus.setRequestHeader("Connection", "close");
    ajaxhapus.send(params);

  } 
  catch(err){ alert(err.message); }
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

  function stateChangedHapus()
  {
  var data;
  if (ajaxhapus.readyState==4)
    {
        document.getElementById("hidpartcode").value = '';
        document.getElementById('txtpartname').value = '';
        document.getElementById('txtqutyordr').value = '';
        document.getElementById('hidpartunit').value = '';
        document.getElementById('txtpartpric').value = '';
        document.getElementById('txtchrgvalu').value = '';
        document.getElementById('hidchrgmthd').value = '';
        document.getElementById('hidwarecode').value = '';
        document.getElementById('txtpartname').focus();
        var kodeorder = document.getElementById('txtproccode').value;
        ambiltrxascreen(kodeorder);
        //}
    }
  }
