  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPOLI01X-AKSES.php";
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

        document.getElementById('txtexamhght').setAttribute('disabled','true');
        document.getElementById('txtexamwght').setAttribute('disabled','true');
        document.getElementById('txtexamblod').setAttribute('disabled','true');
        document.getElementById('txtexamtemp').setAttribute('disabled','true');

        document.getElementById('optmedialle-no').setAttribute('disabled','true');
        document.getElementById('optmedialle-yes').setAttribute('disabled','true');        

        document.getElementById('optfoodalle-no').setAttribute('disabled','true');
        document.getElementById('optfoodalle-yes').setAttribute('disabled','true');        

        document.getElementById('optchrodsse-no').setAttribute('disabled','true');
        document.getElementById('optchrodsse-yes').setAttribute('disabled','true');        

        document.getElementById('optothrdsse-no').setAttribute('disabled','true');
        document.getElementById('optothrdsse-yes').setAttribute('disabled','true');        

        document.getElementById('optpaticare-no').setAttribute('disabled','true');
        document.getElementById('optpaticare-yes').setAttribute('disabled','true');        

        document.getElementById('optpatisurge-no').setAttribute('disabled','true');
        document.getElementById('optpatisurge-yes').setAttribute('disabled','true');        

        document.getElementById('optpatismoke-no').setAttribute('disabled','true');
        document.getElementById('optpatismoke-yes').setAttribute('disabled','true');        


        document.getElementById('txtexamanam').setAttribute('disabled','true');
        document.getElementById('txtexambody').setAttribute('disabled','true');
        document.getElementById('txtlistdiag').setAttribute('disabled','true');
        document.getElementById('txtexamdiag').setAttribute('disabled','true');
        document.getElementById('txtexamprsc').setAttribute('disabled','true');

        ambilscreen(document.getElementById('hidexamdoct').value);
      }
      else
      {
        document.getElementById('txtexamcode').setAttribute('disabled','true');

        document.getElementById('txtexamhght').setAttribute('disabled','true');
        document.getElementById('txtexamwght').setAttribute('disabled','true');
        document.getElementById('txtexamblod').setAttribute('disabled','true');
        document.getElementById('txtexamtemp').setAttribute('disabled','true');

        document.getElementById('optmedialle-no').setAttribute('disabled','false');
        document.getElementById('optmedialle-yes').setAttribute('disabled','false');        

        document.getElementById('optfoodalle-no').setAttribute('disabled','true');
        document.getElementById('optfoodalle-yes').setAttribute('disabled','true');        

        document.getElementById('optchrodsse-no').setAttribute('disabled','true');
        document.getElementById('optchrodsse-yes').setAttribute('disabled','true');        

        document.getElementById('optothrdsse-no').setAttribute('disabled','true');
        document.getElementById('optothrdsse-yes').setAttribute('disabled','true');        

        document.getElementById('optpaticare-no').setAttribute('disabled','true');
        document.getElementById('optpaticare-yes').setAttribute('disabled','true');        

        document.getElementById('optpatisurge-no').setAttribute('disabled','true');
        document.getElementById('optpatisurge-yes').setAttribute('disabled','true');        

        document.getElementById('optpatismoke-no').setAttribute('disabled','true');
        document.getElementById('optpatismoke-yes').setAttribute('disabled','true');        

        document.getElementById('optmedialle-no').setAttribute('disabled','true');
        document.getElementById('optmedialle-yes').setAttribute('disabled','true');        

        document.getElementById('txtexamanam').setAttribute('disabled','true');
        document.getElementById('txtexambody').setAttribute('disabled','true');
        document.getElementById('txtlistdiag').setAttribute('disabled','true');
        document.getElementById('txtexamdiag').setAttribute('disabled','true');
        document.getElementById('txtexamprsc').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

// inexamcode,inexamdoct,inexamhght,inexamwght,inexamblod,inexamtemp,inmedialle,infoodalle,inchrodsse,inothrdsse,inpaticare,inpatisurge,inpatismoke,inexamanam,inexambody,inexamdiag,inexamprsc
  var ajaxinput;
  function input(examcode,examdoct,examhght,examwght,examblod,examtemp,medialle,foodalle,chrodsse,othrdsse,paticare,patisurge,patismoke,examanam,exambody,examdiag,examprsc)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAPOLI01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+examcode+"|"+examdoct+"|"+examhght+"|"+examwght+"|"+examblod+"|"+examtemp+"|"+medialle+"|"+foodalle+"|"+chrodsse+"|"+othrdsse+"|"+paticare+"|"+patisurge+"|"+patismoke+"|"+examanam+"|"+exambody+"|"+examdiag+"|"+examprsc;
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
  if (ajaxinput.readyState==4)
    {
        document.getElementById('txtregidate').value = '';
        document.getElementById('txtexamcode').value = '';

        var examdoct = document.getElementById('hidexamdoct').value;

        document.getElementById('txtpaticode').value = '';
        document.getElementById('txtmainname').value = '';
        document.getElementById('txtmaingend').value = '';
        document.getElementById('txtmainage').value = '';
        document.getElementById('txtbirtdate').value = '';
        document.getElementById('txtmainaddr').value = '';
        document.getElementById('txtregipaym').value = '';

        document.getElementById('txtexamhght').value = '';
        document.getElementById('txtexamhght').setAttribute('disabled','true');

        document.getElementById('txtexamwght').value = '';
        document.getElementById('txtexamwght').setAttribute('disabled','true');

        document.getElementById('txtexamblod').value = '';
        document.getElementById('txtexamblod').setAttribute('disabled','true');

        document.getElementById('txtexamtemp').value = '';
        document.getElementById('txtexamtemp').setAttribute('disabled','true');

        document.getElementById('optmedialle-no').checked = true;
        document.getElementById('optmedialle-yes').checked = false;
        document.getElementById('hidmedialle').value = '';        
        document.getElementById('optmedialle-no').setAttribute('disabled','false');
        document.getElementById('optmedialle-yes').setAttribute('disabled','true');

        document.getElementById('optfoodalle-no').checked = true;
        document.getElementById('optfoodalle-yes').checked = false;
        document.getElementById('hidfoodalle').value = 'N';        
        document.getElementById('optfoodalle-no').setAttribute('disabled','false');
        document.getElementById('optfoodalle-yes').setAttribute('disabled','true');        

        document.getElementById('optchrodsse-no').checked = true;
        document.getElementById('optchrodsse-yes').checked = false;
        document.getElementById('hidchrodsse').value = 'N';        
        document.getElementById('optchrodsse-no').setAttribute('disabled','true');
        document.getElementById('optchrodsse-yes').setAttribute('disabled','true');        

        document.getElementById('optothrdsse-no').checked = true;
        document.getElementById('optothrdsse-yes').checked = false;
        document.getElementById('hidothrdsse').value = 'N';        
        document.getElementById('optothrdsse-no').setAttribute('disabled','true');
        document.getElementById('optothrdsse-yes').setAttribute('disabled','true');        

        document.getElementById('optpaticare-no').checked = true;
        document.getElementById('optpaticare-yes').checked = false;
        document.getElementById('hidpaticare').value = 'N';        
        document.getElementById('optpaticare-no').setAttribute('disabled','true');
        document.getElementById('optpaticare-yes').setAttribute('disabled','true');        

        document.getElementById('optpatisurge-no').checked = true;
        document.getElementById('optpatisurge-yes').checked = false;
        document.getElementById('hidpatisurge').value = 'N';        
        document.getElementById('optpatisurge-no').setAttribute('disabled','true');
        document.getElementById('optpatisurge-yes').setAttribute('disabled','true');        

        document.getElementById('optpatismoke-no').checked = true;
        document.getElementById('optpatismoke-yes').checked = false;
        document.getElementById('hidpatismoke').value = 'N';        
        document.getElementById('optpatismoke-no').setAttribute('disabled','true');
        document.getElementById('optpatismoke-yes').setAttribute('disabled','true');        

        document.getElementById('txtexamanam').value = '';
        document.getElementById('txtexamanam').setAttribute('disabled','true');

        document.getElementById('txtexambody').value = '';
        document.getElementById('txtexambody').setAttribute('disabled','true');

        document.getElementById('txtexamdiag').value = '';
        document.getElementById('txtexamdiag').setAttribute('disabled','true');

        document.getElementById('txtexamprsc').value = '';
        document.getElementById('txtexamprsc').setAttribute('disabled','true');

        ambilscreen(examdoct);
        ambilscreendiagnosa('');
        document.getElementById('txtexamcode').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblitype

// Tampilkan Data Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(regicode,paticode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPOLI01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+regicode+"|"+paticode;
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

      var res = data.split("|"); 
      document.getElementById("txtregidate").value = res[1];

      document.getElementById("txtexamcode").value = res[2];

      document.getElementById("txtpaticode").value = res[3];

      ambilrekammedis(res[3]);

      ambilscreendiagnosa(res[2]);

      document.getElementById("txtmainname").value = res[4];

      document.getElementById("txtmaingend").value = res[8];

      document.getElementById("txtmainage").value = res[5];

      document.getElementById("txtbirtdate").value = res[6];

      document.getElementById("txtmainaddr").value = res[7];


      document.getElementById("txtregipaym").value = res[9];

      document.getElementById("txtexamhght").removeAttribute('disabled');
      document.getElementById("txtexamhght").value = res[10];

      document.getElementById("txtexamwght").removeAttribute('disabled');
      document.getElementById("txtexamwght").value = res[11];

      document.getElementById("txtexamblod").removeAttribute('disabled');
      document.getElementById("txtexamblod").value = res[12];

      document.getElementById("txtexamtemp").removeAttribute('disabled');
      document.getElementById("txtexamtemp").value = res[13];

      document.getElementById('optmedialle-no').removeAttribute('disabled');
      document.getElementById('optmedialle-yes').removeAttribute('disabled');
      document.getElementById('hidmedialle').value = res[14]        

      if (res[14] == 'Y') 
      {
        document.getElementById('optmedialle-no').checked=false;
        document.getElementById('optmedialle-yes').checked=true;       
      }
      else if (res[14] == 'N')
      {
        document.getElementById('optmedialle-no').checked=true;
        document.getElementById('optmedialle-yes').checked=false;               
      }
      else
      {
        document.getElementById('optmedialle-no').checked=false;
        document.getElementById('optmedialle-yes').checked=false;       
      }

      document.getElementById('optfoodalle-no').removeAttribute('disabled');
      document.getElementById('optfoodalle-yes').removeAttribute('disabled');        
      document.getElementById('hidfoodalle').value = res[15]

      if (res[15] == 'Y') 
      {
        document.getElementById('optfoodalle-no').checked=false;
        document.getElementById('optfoodalle-yes').checked=true;       
      }
      else if (res[15] == 'N')
      {
        document.getElementById('optfoodalle-no').checked=true;
        document.getElementById('optfoodalle-yes').checked=false;       
      }
      else
      {
        document.getElementById('optfoodalle-no').checked=false;
        document.getElementById('optfoodalle-yes').checked=false;               
      }

      document.getElementById('optchrodsse-no').removeAttribute('disabled');
      document.getElementById('optchrodsse-yes').removeAttribute('disabled');
      document.getElementById('hidchrodsse').value = res[16]        

      if (res[16] == 'Y') 
      {
        document.getElementById('optchrodsse-no').checked=false;
        document.getElementById('optchrodsse-yes').checked=true;       
      }
      else if (res[16] == 'N')
      {
        document.getElementById('optchrodsse-no').checked=true;
        document.getElementById('optchrodsse-yes').checked=false;       
      }
      else
      {
        document.getElementById('optchrodsse-no').checked=false;
        document.getElementById('optchrodsse-yes').checked=false;               
      }

      document.getElementById('optothrdsse-no').removeAttribute('disabled');
      document.getElementById('optothrdsse-yes').removeAttribute('disabled');
      document.getElementById('hidothrdsse').value = res[17]        

      if (res[17] == 'Y') 
      {
        document.getElementById('optothrdsse-no').checked=false;
        document.getElementById('optothrdsse-yes').checked=true;       
      }
      else if (res[17] == 'N')
      {
        document.getElementById('optothrdsse-no').checked=true;
        document.getElementById('optothrdsse-yes').checked=false;       
      }
      else
      {
        document.getElementById('optothrdsse-no').checked=false;
        document.getElementById('optothrdsse-yes').checked=false;               
      }


      document.getElementById('optpaticare-no').removeAttribute('disabled');
      document.getElementById('optpaticare-yes').removeAttribute('disabled');
      document.getElementById('hidpaticare').value = res[18]        

      if (res[18] == 'Y') 
      {
        document.getElementById('optpaticare-no').checked=false;
        document.getElementById('optpaticare-yes').checked=true;       
      }
      else if (res[18] == 'N')
      {
        document.getElementById('optpaticare-no').checked=true;
        document.getElementById('optpaticare-yes').checked=false;       
      }
      else
      {
        document.getElementById('optpaticare-no').checked=false;
        document.getElementById('optpaticare-yes').checked=false;               
      }

      document.getElementById('optpatisurge-no').removeAttribute('disabled');
      document.getElementById('optpatisurge-yes').removeAttribute('disabled');
      document.getElementById('hidpatisurge').value = res[19]        

      if (res[19] == 'Y') 
      {
        document.getElementById('optpatisurge-no').checked=false;
        document.getElementById('optpatisurge-yes').checked=true;       
      }
      else if (res[19] == 'N')
      {
        document.getElementById('optpatisurge-no').checked=true;
        document.getElementById('optpatisurge-yes').checked=false;       
      }
      else
      {
        document.getElementById('optpatisurge-no').checked=false;
        document.getElementById('optpatisurge-yes').checked=false;               
      }  

      document.getElementById('optpatismoke-no').removeAttribute('disabled');
      document.getElementById('optpatismoke-yes').removeAttribute('disabled');
      document.getElementById('hidpatismoke').value = res[20]        

      if (res[20] == 'Y') 
      {
        document.getElementById('optpatismoke-no').checked=false;
        document.getElementById('optpatismoke-yes').checked=true;       
      }
      else if (res[20] == 'N')
      {
        document.getElementById('optpatismoke-no').checked=true;
        document.getElementById('optpatismoke-yes').checked=false;       
      }
      else
      {
        document.getElementById('optpatismoke-no').checked=false;
        document.getElementById('optpatismoke-yes').checked=false;       

      }


      document.getElementById("txtexamanam").removeAttribute('disabled');
      document.getElementById("txtexamanam").value = res[21];

      document.getElementById("txtexambody").removeAttribute('disabled');
      document.getElementById("txtexambody").value = res[22];

      document.getElementById("txtlistdiag").removeAttribute('disabled');

      document.getElementById("txtexamdiag").removeAttribute('disabled');
      document.getElementById("txtexamdiag").value = res[23];

      document.getElementById("txtexamprsc").removeAttribute('disabled');
      document.getElementById("txtexamprsc").value = res[24];

      document.getElementById("txtexamhght").focus();

      }      
        //}
    }
  }



// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(dokter)
{
  if(dokter.length > 5)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXAPOLI01V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+dokter;
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

    // ambil Teks Anamnesa tabel trxaexam

var anamnesaku;
function ambilanamnesa(kata)
{
  if(kata.length > 5)
  {
    document.getElementById("tblanamnesa").innerHTML = "";
    document.getElementById("tblanamnesa").style.visibility = "hidden";
  }
  else
  {
  anamnesaku = buatajaxanamnesa();
  //var url="WAREMAST05C-WARE.php";
  var url="TRXAPOLI01C-ANAMNESA.php";
  anamnesaku.onreadystatechange=stateChangedexamanam;
  var params = "q="+kata;
  anamnesaku.open("POST",url,true);
  anamnesaku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  anamnesaku.setRequestHeader("Content-length", params.length);
  anamnesaku.setRequestHeader("Connection", "close");
  anamnesaku.send(params);
  }
} 

function buatajaxanamnesa()
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

function stateChangedexamanam()
{
  var data;
  if (anamnesaku.readyState==4 && anamnesaku.status==200)
  {
  data=anamnesaku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblanamnesa").innerHTML = data;
    document.getElementById("tblanamnesa").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblanamnesa").innerHTML = "";
    document.getElementById("tblanamnesa").style.visibility = "hidden";
    }
  }
}

function isiexamanam(outexamanam)
{
  try 
  {
  document.getElementById("txtexamanam").value = outexamanam;
  document.getElementById("txtexambody").focus();
  document.getElementById("tblanamnesa").style.visibility = "hidden";
  document.getElementById("tblanamnesa").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// tabel Rekam Medis Pasien
var rekamku;

function ambilrekammedis(rekammedis)
{
  if(rekammedis.length > 10)
  {
  document.getElementById("tblrekammedis").style.visibility = "hidden";
  }
  else
  {
  rekamku = buatajaxrekammedis();
  var url="TRXAPOLI01C-REKAMMEDIS.php";
  rekamku.onreadystatechange=stateChangedrekammedis;
  var params = "q="+rekammedis;
  rekamku.open("POST",url,true);
  rekamku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  rekamku.setRequestHeader("Content-length", params.length);
  rekamku.setRequestHeader("Connection", "close");
  rekamku.send(params);
  }
} 

function buatajaxrekammedis()
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

function stateChangedrekammedis()
{
  var data;
  if (rekamku.readyState==4 && rekamku.status==200)
  {
  data=rekamku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblrekammedis").innerHTML = data;
    document.getElementById("tblrekammedis").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblrekammedis").innerHTML = "";
    document.getElementById("tblrekammedis").style.visibility = "hidden";
    }
  }
}

// ambil list diagnosa

var diagku;
function ambildiagnosa(regicode,diagcode)
{
  if(diagcode.length > 20)
  {
  document.getElementById("tbllistdiag").style.visibility = "hidden";
  }
  else
  {
  diagku = buatajaxdiagnosa();
  var url="TRXAPOLI01C-DIAGNOSA.php";
  diagku.onreadystatechange=stateChangeddiagnosa;
  var params = "q="+regicode+"|"+diagcode;
  diagku.open("POST",url,true);
  diagku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  diagku.setRequestHeader("Content-length", params.length);
  diagku.setRequestHeader("Connection", "close");
  diagku.send(params);
  }
} 

function buatajaxdiagnosa()
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

function stateChangeddiagnosa()
{
  var data;
  if (diagku.readyState==4 && diagku.status==200)
  {
  data=diagku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbllistdiag").innerHTML = data;
    document.getElementById("tbllistdiag").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbllistdiag").innerHTML = "";
    document.getElementById("tbllistdiag").style.visibility = "hidden";
    }
  }
}

function isidiagnosa(outregicode,outdiagcode,outdiagname)
{
  try 
  {

  inputdiagnosa(outregicode,outdiagcode,outdiagname);

 // document.getElementById("txtlistdiag").value = outdiagname;
  //document.getElementById("hidprocdivi").value = tbldivicode;
  document.getElementById("txtlistdiag").focus();
  document.getElementById("tbllistdiag").style.visibility = "hidden";
  document.getElementById("tbllistdiag").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
// Layer Control End


// input daftar diagnosa
  var ajaxinputdiagnosa;
  function inputdiagnosa(regicode,diagcode,diagname)
  {
    ajaxinputdiagnosa = buatajaxinputdiagnosa();
    var url="TRXAPOLI01E-DIAGNOSA.php";
    ajaxinputdiagnosa.onreadystatechange=stateChangedInputdiagnosa;
    var params = "q="+regicode+"|"+diagcode+"|"+diagname;
    //alert(params);
    ajaxinputdiagnosa.open("POST",url,true);
    ajaxinputdiagnosa.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ajaxinputdiagnosa.setRequestHeader("Content-length", params.length);
    //ajaxinputdiagnosa.setRequestHeader("Connection", "close");
    ajaxinputdiagnosa.send(params);
  }

  function buatajaxinputdiagnosa()
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

  function stateChangedInputdiagnosa()
  {
  if (ajaxinputdiagnosa.readyState==4)
    {
        document.getElementById('txtlistdiag').value = '';
        let regidiagcode = document.getElementById('txtexamcode').value;

        //alert(regidiagcode);

        ambilscreendiagnosa(regidiagcode);

        //}
    }
  }
  // Selesai Input Data Diagnosa

  // Tampilkan data yang diinput dalam datable
var asr;
function ambilscreendiagnosa(regicode)
{

  if(regicode.length > 14)
  {
  document.getElementById("tbldiagnosa").style.visibility = "hidden";
  }
  else
  {
  asr = buatajaxscreendiagnosa();
  var url="TRXAPOLI01V-DIAGNOSA.php";
  asr.onreadystatechange=stateChangedscreendiagnosa;
  var params = "q="+regicode;
  asr.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  asr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  asr.setRequestHeader("Content-length", params.length);
  asr.setRequestHeader("Connection", "close");
  asr.send(params);
  }
} 

  function buatajaxscreendiagnosa()
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

function stateChangedscreendiagnosa()
{
  var datapost;
  if (asr.readyState==4 && asr.status==200)
  {
  datapost=asr.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tbldiagnosa").innerHTML = datapost;
    document.getElementById("tbldiagnosa").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbldiagnosa").innerHTML = "";
    document.getElementById("tbldiagnosa").style.visibility = "hidden";
    }
  }
}


// Hapus 
  var ajaxhapus;
  function hapuscode(examcode,diagcode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="TBLIUNIT01D.php";
    var url="TRXAPOLI01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+examcode+"|"+diagcode;
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
        var inexamcode = document.getElementById('txtexamcode').value;
        ambilscreendiagnosa(inexamcode);
        document.getElementById('txtlistdiag').focus();
    }
  }
// Selesai hapus Data 

