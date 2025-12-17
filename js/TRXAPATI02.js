  // periksa akses
  var aksesku;
  function periksaakses(fieldid)
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
        //ambilscreen('');
        document.getElementById('txtsearch').focus();
        document.getElementById('tglregidate').setAttribute('disabled','true');
        document.getElementById('optregifrom').setAttribute('disabled','true');
        document.getElementById('optregipaym').setAttribute('disabled','true');
        document.getElementById('txtregidoct').setAttribute('disabled','true');
        document.getElementById('optcharge').setAttribute('disabled','true');
        document.getElementById('optnocharge').setAttribute('disabled','true');
        ambilscreen('');      
      }
      else
      {
        document.getElementById('txtsearch').setAttribute('disabled','true');
        document.getElementById('tglregidate').setAttribute('disabled','true');
        document.getElementById('optregifrom').setAttribute('disabled','true');
        document.getElementById('optregipaym').setAttribute('disabled','true');
        document.getElementById('txtregidoct').setAttribute('disabled','true');
        document.getElementById('optcharge').setAttribute('disabled','true');
        document.getElementById('optnocharge').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  

var patiku;
function ambilpaticode(paticode)
{
  if(paticode.length > 16)
  {
  //document.getElementById("tblpati").style.visibility = "hidden";
  }
  else
  {
  patiku = buatajaxpaticode();
  var url="TRXAPATI02C-PATI.php";
  patiku.onreadystatechange=stateChangedpaticode;
  var params = "q="+paticode;
  patiku.open("POST",url,true);
  patiku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  patiku.setRequestHeader("Content-length", params.length);
  patiku.setRequestHeader("Connection", "close");
  patiku.send(params);
  }
} 

function buatajaxpaticode()
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

function stateChangedpaticode()
{
  var data;
  if (patiku.readyState==4 && patiku.status==200)
  {
  data=patiku.responseText;
  //alert(data);
    if(data.length>3)
    {   
    document.getElementById("tblpati").innerHTML = data;
    document.getElementById("tblpati").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblpati").innerHTML = "";
    document.getElementById("tblpati").style.visibility = "";
    }
  }
}

function isipaticode(outmastcode,outmainname,outmaingend,outmainbirt,outmainblod,outmainaddr,outmainphne)

{
  try 
  {
  document.getElementById("hidpaticode").value = outmastcode;

  document.getElementById('tglregidate').removeAttribute('disabled');
  document.getElementById('optregifrom').removeAttribute('disabled');
  document.getElementById('optregipaym').removeAttribute('disabled');
  document.getElementById('txtregidoct').removeAttribute('disabled');
  document.getElementById('optcharge').removeAttribute('disabled');
  document.getElementById('optnocharge').removeAttribute('disabled');

  document.getElementById("txtmainname").value = outmainname;
  document.getElementById("txtmastcode").value = outmastcode;
  document.getElementById("txtmainbirt").value = outmainbirt;

  if (outmaingend == 'M') 
  {
    document.getElementById("txtmaingend").value = 'Pria';  
  }
  else if (outmaingend == 'F')
  {
    document.getElementById("txtmaingend").value = 'Wanita';  
  }
  else
  {
    document.getElementById("txtmaingend").value = 'Tidak Tahu'; 
  }
  
  if (outmainblod == 'X') 
  {
    document.getElementById("txtmainblod").value = 'Tidak Tahu';  
  }
  else
  {
    document.getElementById("txtmainblod").value = 'outmainblod'; 
  }
  

  document.getElementById("txtmainaddr").value = outmainaddr;
  document.getElementById("txtmainphne").value = outmainphne;

  document.getElementById("tblpati").style.visibility = "";
  document.getElementById("tblpati").innerHTML = "";
  document.getElementById("txtsearch").value = '';
  document.getElementById("txtregidoct").focus();

  } 
  catch(err){ alert(err.message); }
}
  
// Layer Control End

// tabel Doc user

var dokterku;
function ambildoctuser(doctuser)
{
  if(doctuser.length > 5)
  {
  document.getElementById("tbluser").style.visibility = "hidden";
  }
  else
  {
  dokterku = buatajaxdoctuser();
  var url="TRXAPATI02C-USER.php";
  dokterku.onreadystatechange=stateChangeddoctuser;
  var params = "q="+doctuser;
  //alert(params);
  dokterku.open("POST",url,true);
  dokterku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  dokterku.setRequestHeader("Content-length", params.length);
  dokterku.setRequestHeader("Connection", "close");
  dokterku.send(params);
  }
} 
function buatajaxdoctuser()
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

function stateChangeddoctuser()
{
  var data;
  if (dokterku.readyState==4 && dokterku.status==200)
  {
  data=dokterku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbluser").innerHTML = data;
    document.getElementById("tbluser").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbluser").innerHTML = "";
    document.getElementById("tbluser").style.visibility = "hidden";
    }
  }
}

function isidoctuser(outdoctuser,outdoctname,outmediroom,outroomname)
{
  try 
  {
    document.getElementById("txtregidoct").value = outdoctname;
    document.getElementById("hidregidoct").value = outdoctuser;

    document.getElementById("txtregipoli").value = outroomname;
    document.getElementById("hidregipoli").value = outmediroom
    document.getElementById("optcharge").focus();
    document.getElementById("tbluser").style.visibility = "hidden";
    document.getElementById("tbluser").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
// Tabel end Doct
// Input Data Posisi dari form ke Tabel trxaregi
  var ajaxinput;
  function input(paticode,regidate,regifrom,regipaym,regidoct,regipoli,regifee)

  {
    ajaxinput = buatajaxinput();
    var url="TRXAPATI02E.php";
    //var url="TBLIUNIT01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+paticode+"|"+regidate+"|"+regifrom+"|"+regipaym+"|"+regidoct+"|"+regipoli+"|"+regifee;
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

        document.getElementById('txtsearch').focus();
        document.getElementById('tglregidate').setAttribute('disabled','true');
        document.getElementById('optregifrom').setAttribute('disabled','true');
        document.getElementById('optregipaym').setAttribute('disabled','true');
        document.getElementById('txtregidoct').setAttribute('disabled','true');
        document.getElementById('optcharge').setAttribute('disabled','true');
        document.getElementById('optnocharge').setAttribute('disabled','true');

        document.getElementById('txtmainname').value = '';
        document.getElementById('txtmastcode').value = '';
        document.getElementById('txtmainbirt').value = '';
        document.getElementById('txtmaingend').value = '';
        document.getElementById('txtmainblod').value = '';
        document.getElementById('txtmainphne').value = '';
        document.getElementById('txtmainaddr').value = '';

        document.getElementById('txtregidoct').value = '';
        document.getElementById('hidregidoct').value = '';

        document.getElementById('txtregipoli').value = '';
        document.getElementById('hidregipoli').value = '';

        document.getElementById('optcharge').checked = false;
        document.getElementById('optnocharge').checked = false;

        document.getElementById('hidregifee').value = '';

        ambilscreen('');      

        //}
    }
  }
  // Selesai Input Data Wall ke Tabel trxaregi

// Tampilkan Data Posisi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(outregicode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPATI02C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+outregicode;
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
       //     1         2        3         4          5         6        7          8       
       //|$paticode|$patiname|$patibirt|$patigend|$patiblod|$patiphne|$patiaddr|$regidate
       //    9         10        11        12        13        14        15
       //|$regifrom|$regipaym|$regidoct|$doctname|$regipoli|$poliname|$regifee| 
    var res = data.split("|");
        document.getElementById('hidpaticode').value = res[1];

        document.getElementById('tglregidate').removeAttribute('disabled');
        document.getElementById('tglregidate').value = res[8];        

        document.getElementById('txtmainname').value = res[2];

        document.getElementById('txtmastcode').value = res[1];

        document.getElementById('txtmainbirt').value = res[3];

        if (res[4] == 'M')
        {
          document.getElementById('txtmaingend').value = 'Pria';  
        }
        else if (res[4] == 'F')
        {
          document.getElementById('txtmaingend').value = 'Wanita';
        }
        else
        {
         document.getElementById('txtmaingend').value = 'No Gender'; 
        }

         if (res[5] == 'X') 
        {
          document.getElementById("txtmainblod").value = 'Tidak Tahu';  
        }
        else
        {
          document.getElementById("txtmainblod").value = res[5]; 
        }
 
        document.getElementById('txtmainphne').value = res[6];
        document.getElementById('txtmainaddr').value = res[7];
        
        document.getElementById('optregifrom').removeAttribute('disabled');
        document.getElementById('optregifrom').value = res[9];

        document.getElementById('optregipaym').removeAttribute('disabled');
        document.getElementById('optregipaym').value = res[10];

        document.getElementById('txtregidoct').removeAttribute('disabled');
        document.getElementById('txtregidoct').value = res[12];
        document.getElementById('hidregidoct').value = res[11];

        document.getElementById('txtregipoli').value = res[14];
        document.getElementById('hidregipoli').value = res[13];

        if (res[15] == 'Y') 
        {
          document.getElementById('optcharge').removeAttribute('disabled');
          document.getElementById('optnocharge').removeAttribute('disabled');
          document.getElementById('optcharge').checked = true;
          document.getElementById('optnocharge').checked = false;
        }
        else if (res[15] == 'N')
        {
          document.getElementById('optcharge').removeAttribute('disabled');
          document.getElementById('optnocharge').removeAttribute('disabled');
          document.getElementById('optcharge').checked = false;
          document.getElementById('optnocharge').checked = true;
        } 
        else
        {
          document.getElementById('optcharge').checked = false;
          document.getElementById('optnocharge').checked = false;
        } 

        document.getElementById('hidregifee').value = res[15];

      }//}
    }
  }
// Hapus 
  var ajaxhapus;
  function hapuscode(regicode)
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAPATI02D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+regicode;
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
// Selesai hapus Data Posisi

// Tampilkan data yang diinput dalam datable
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
  var url="TRXAPATI02V.php";
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

