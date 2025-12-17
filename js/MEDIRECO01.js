  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="MEDIRECO01X-AKSES.php";
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
        document.getElementById('txtmastcode').value = '';
        document.getElementById('txtmaingend').value = '';      
        document.getElementById('txtmainname').value = '';      
        document.getElementById('txtmainpidn').value = '';      
        document.getElementById('txtmainbirt').value = '';
        document.getElementById('txtmainphne').value = '';
        document.getElementById('txtmainage').value = '';
        document.getElementById('txtmainprof').value = '';
        document.getElementById('txtmainaddr').value = '';
        document.getElementById('txtmainalergi').value = '';

        ambilscreen('');
      }
      else
      {
        document.getElementById('txtmastcode').setAttribute('disabled','true');
        document.getElementById('txtmaingend').setAttribute('disabled','true');      
        document.getElementById('txtmainname').setAttribute('disabled','true');      
        document.getElementById('txtmainpidn').setAttribute('disabled','true');      
        document.getElementById('txtmainbirt').setAttribute('disabled','true');
        document.getElementById('txtmainphne').setAttribute('disabled','true');
        document.getElementById('txtmainage').setAttribute('disabled','true');
        document.getElementById('txtmainprof').setAttribute('disabled','true');
        document.getElementById('txtmainaddr').setAttribute('disabled','true');
        document.getElementById('txtmainalergi').setAttribute('disabled','true');

      }
    }
  }
// end periksa akses  

  // Input Data Pembayaran Pasien dari form ke Tabel 
//   inmastcode, inmainalergi

  var ajaxinput;
  function input(paticode,allenote)
  {
    ajaxinput = buatajaxinput();
    //var url="TRXASALE01E.php";
    var url="MEDIRECO01E.php";

    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+paticode+"|"+allenote;
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
        let paticode = document.getElementById('txtmastcode').value;

        ambilscreen('');
        ambilviewrm(paticode);
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblitype

// Tampilkan Data Register   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(paticode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="MEDIRECO01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+paticode;
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
        //    1         2          3        4        5        6         7         8        9
        //|$paticode|$mainpidn|$mainname|$gender|$datebirt|$mainage|$mainaddr|$mainprof|$mainphne|
      var res = data.split("|");

      document.getElementById('txtmastcode').value = res[1];
      document.getElementById('txtmaingend').value = res[4];      
      document.getElementById('txtmainname').value = res[3];      
      document.getElementById('txtmainpidn').value = res[2];      
      document.getElementById('txtmainbirt').value = res[5];
      document.getElementById('txtmainphne').value = res[9];
      document.getElementById('txtmainage').value = res[6];
      document.getElementById('txtmainprof').value = res[8];
      document.getElementById('txtmainaddr').value = res[7];
      document.getElementById('txtmainalergi').value = res[10];
      ambilscreen(res[1]);
      ambilviewrm(res[1]);

      }      
        //}
    }
  }



// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(kata)
{
  if(kata.length > 10)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  //var url="TRXAPOLI01V.php";
  var url="MEDIRECO01V.php";
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


var asr;
function ambilviewrm(paticode)
{
  asr = buatajaxviewrm();
  //var url="TRXASALE01V-INVC.php";
  var url="MEDIRECO01V-RM.php";
  asr.onreadystatechange=stateChangedviewrm;
  var params = "q="+paticode;
  asr.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  asr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  asr.setRequestHeader("Content-length", params.length);
  asr.setRequestHeader("Connection", "close");
  asr.send(params);
  //}
} 

  function buatajaxviewrm()
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

function stateChangedviewrm()
{
  var datapost;
  if (asr.readyState==4 && asr.status==200)
  {
  datapost=asr.responseText;
  //alert(datapost);
    if(datapost.length>0)
    {
    document.getElementById("tblviewrm").innerHTML = datapost;
    document.getElementById("tblviewrm").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewrm").innerHTML = "";
    document.getElementById("tblviewrm").style.visibility = "hidden";
    }
  }
}

