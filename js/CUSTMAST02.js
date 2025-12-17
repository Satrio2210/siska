// periksa akses menu

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
            periksakode('1');

            document.getElementById('txtinvecode').focus();

            document.getElementById('txtcustcode').setAttribute('disabled','true');

            ambilscreen('');
          }
          else
          {
            document.getElementById('txtinvecode').setAttribute('disabled','true');

            document.getElementById('txtcustcode').setAttribute('disabled','true');

          }
        }
    } 

    catch(err)
    {
      alert(err.message);     
    }


  }
// end periksa akses  
  // periksa Kode Anggota

   var kodeku;
   
  function periksakode(urut)
  {
    try 
    {
      kodeku = buatajaxkode();
      var url="CUSTMAST02X.php";
      kodeku.onreadystatechange=stateChangedkode;
      var params = "q="+urut;
      //alert(params);
      kodeku.open("POST",url,true);
      kodeku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      kodeku.setRequestHeader("Content-length", params.length);
      kodeku.setRequestHeader("Connection", "close");
      kodeku.send(params);
    }

    catch(err)
    {
     alert(err.message); 
    }

  }

  function buatajaxkode()
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

  function stateChangedkode()
  {
  var data;
  if (kodeku.readyState==4)
    {

    xdata=kodeku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtlistcode').value=data;
      }
      else
      {
        document.getElementById('txtlistcode').value='';
      }
    }
  }
// end periksa Kode Urut

// ambil list Item Master

var itemku;
function ambilinvecode(invecode)
{
  if(invecode.length > 10)
  {
  document.getElementById("tblinve").style.visibility = "hidden";
  }
  else
  {
  itemku = buatajaxinvecode();
  var url="CUSTMAST02C-INVE.php";
  itemku.onreadystatechange=stateChangedinvecode;
  var params = "q="+invecode;
  //alert(params);
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

function isiinvecode(outinvecode,outinvename)
{
  try 
  {
    document.getElementById("txtinvecode").value = outinvename;
  document.getElementById("hidinvecode").value = outinvecode;


      document.getElementById('txtcustcode').removeAttribute('disabled');

  document.getElementById("txtcustcode").focus();
  document.getElementById("tblinve").style.visibility = "hidden";
  document.getElementById("tblinve").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
// akses item inventori selesai

// ambil nama customer

var custku;
function ambilcustcode(custcode)
{
  if(custcode.length > 5)
  {
  document.getElementById("tblcust").style.visibility = "hidden";
  }
  else
  {
  custku = buatajaxcustcode();
  var url="CUSTMAST02C-TYPE.php";
  custku.onreadystatechange=stateChangedcustcode;
  var params = "q="+custcode;
  custku.open("POST",url,true);
  custku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  custku.setRequestHeader("Content-length", params.length);
  custku.setRequestHeader("Connection", "close");
  custku.send(params);
  }
} 

function buatajaxcustcode()
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

function stateChangedcustcode()
{
  var data;
  if (custku.readyState==4 && custku.status==200)
  {
  data=custku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblcust").innerHTML = data;
    document.getElementById("tblcust").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblcust").innerHTML = "";
    document.getElementById("tblcust").style.visibility = "hidden";
    }
  }
}

function isicustcode(outcustcode,outcustname,outcusttype)
{
  try 
  {
  document.getElementById("txtcustcode").value = outcustname;
  document.getElementById("hidcustcode").value = outcustcode;
  document.getElementById("hidcusttype").value = outcusttype;

  if (outcusttype == 'B') { document.getElementById("txtcusttype").value = 'BPJS';}
  else if (outcusttype == 'A') { document.getElementById("txtcusttype").value = 'Asuransi';}
  else if (outcusttype == 'P') { document.getElementById("txtcusttype").value = 'Perusahaan';}

  document.getElementById("txtcusttype").focus();
  document.getElementById("tblcust").style.visibility = "hidden";
  document.getElementById("tblcust").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
// Selesai ambil custcode


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
  var url="CUSTMAST02V.php";
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


// Input
  var ajaxinput;

  function input(listcode,invecode,custcode,custtype)
  {
    ajaxinput = buatajaxinput();
    
    var url="CUSTMAST02E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+listcode+"|"+invecode+"|"+custcode+"|"+custtype;
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
        periksakode('1');

        document.getElementById('txtinvecode').focus();
        document.getElementById('txtinvecode').value = '';
        document.getElementById('hidinvecode').value = '';

        document.getElementById('txtcustcode').setAttribute('disabled','true');
        document.getElementById('txtcustcode').value = '';

        document.getElementById('hidcustcode').value = '';

        document.getElementById('txtcusttype').value = '';
        document.getElementById('hidcusttype').value = '';

        ambilscreen('');
    }
  }
  // Selesai Input Data Wall ke Tabel 

// Tampilkan Data pada form 
var ajaxview
function viewcode(listcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="CUSTMAST02C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+listcode;
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
 //    1         2          3        4        5            6               
// |$listcode|$invecode|$invename|$custcode|$custname|$custtype
      var res = data.split("|");

      document.getElementById("txtlistcode").value = res[1];

      document.getElementById("txtinvecode").value = res[3];

      document.getElementById("hidinvecode").value = res[2];

      document.getElementById("txtcustcode").value = res[5];
      document.getElementById('txtcustcode').removeAttribute('disabled');

      document.getElementById("hidcustcode").value = res[4];

      document.getElementById("hidcusttype").value = res[6];


      if (res[6] == 'B') 
        {
          document.getElementById("txtcusttype").value = 'BPJS';

        }
      else if (res[6] == 'A')
        {
          document.getElementById("txtcusttype").value = 'Asuransi';
        }
      else if (res[6] == 'P')
        {
          document.getElementById("txtcusttype").value = 'Perusahaan';

        }
        else
        {
          document.getElementById("txtcusttype").value = ' ';

        }

      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(listcode)
  {
    ajaxhapus = buatajaxhapus();
    var url="CUSTMAST02D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+listcode;
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
