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
        document.getElementById('hidregicode').value = '';
        document.getElementById('hidpaticode').value = '';      
        document.getElementById('hidregidoct').value = '';      
        document.getElementById('hidregipoli').value = '';      
        document.getElementById('txtpaymtota').value = '';
        document.getElementById('txtpaymamnt').value = '';
        document.getElementById('txtpaymamnt').setAttribute('disabled','true');
        document.getElementById('txtpaymdisc').setAttribute('disabled','true');
        document.getElementById('optpaymmode').setAttribute('disabled','true');

        ambilscreen('');
      }
      else
      {
        document.getElementById('txtpaymamnt').setAttribute('disabled','true');
        document.getElementById('txtpaymdisc').setAttribute('disabled','true');
        document.getElementById('optpaymmode').setAttribute('disabled','true');

      }
    }
  }
// end periksa akses  

  // Input Data Pembayaran Pasien dari form ke Tabel 
//inregicode,inpaticode,inregidoct,inregipoli,inregipaym,inpaymtota,inpaymamnt,inpaymdisc,inpaymmode
  var ajaxinput;
  function input(regicode,paticode,regidoct,regipoli,regipaym,paymtota,paymamnt,paymdisc,paymmode)
  {
    ajaxinput = buatajaxinput();
    var url="TRXASALE01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+regicode+"|"+paticode+"|"+regidoct+"|"+regipoli+"|"+regipaym+"|"+paymtota+"|"+paymamnt+"|"+paymdisc+"|"+paymmode;
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

        let xregicode = document.getElementById('hidregicode').value;
        ambilviewinvc(xregicode);

        document.getElementById('hidregicode').value = '';

        document.getElementById('hidpaticode').value = '';
        document.getElementById('hidregidoct').value = '';

        document.getElementById('hidregipoli').value = '';

        document.getElementById('txtpaymtota').value = '';

        document.getElementById('txtpaymamnt').value = '';
        document.getElementById('txtpaymamnt').setAttribute('disabled','true');

        document.getElementById('txtpaymdisc').value = '0';
        document.getElementById('txtpaymdisc').setAttribute('disabled','true');

        document.getElementById('optpaymmode').setAttribute('disabled','true');
        let xcari = document.getElementById('txtsearch').value;

        ambilscreen(xcari);


        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblitype

// Tampilkan Data Register   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(regicode,paticode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXASALE01C.php";
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
        //      1       2         3         4         5          6        7
        //|$regicode|$paticode|$regidoct|$regipoli|$regipaym|$paymtota|$viewpaymtota|
      var res = data.split("|");
      document.getElementById("hidregicode").value = res[1];

      document.getElementById("hidpaticode").value = res[2];

      document.getElementById("hidregidoct").value = res[3];

      document.getElementById("hidregipoli").value = res[4];

      document.getElementById("hidregipaym").value = res[5];

      document.getElementById("hidpaymtota").value = res[6];

      if (res[6] > 0)
      {
        document.getElementById("txtpaymtota").value = res[7];
      }
      else
      {
        document.getElementById("txtpaymtota").value = 0;  
      }
      
      document.getElementById("txtpaymamnt").removeAttribute('disabled');
      document.getElementById("txtpaymdisc").removeAttribute('disabled');
      document.getElementById("optpaymmode").removeAttribute('disabled');
      ambilviewinvc(res[1]);
      document.getElementById("txtpaymamnt").focus();

      }      
        //}
    }
  }



// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(kata)
{
  if(kata.length > 8)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  //var url="TRXAPOLI01V.php";
  var url="TRXASALE01V.php";
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
function ambilviewinvc(regicode)
{
  asr = buatajaxviewinvc();
  var url="TRXASALE01V-INVC.php";
  asr.onreadystatechange=stateChangedviewinvc;
  var params = "q="+regicode;
  asr.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  asr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  asr.setRequestHeader("Content-length", params.length);
  asr.setRequestHeader("Connection", "close");
  asr.send(params);
  //}
} 

  function buatajaxviewinvc()
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

function stateChangedviewinvc()
{
  var datapost;
  if (asr.readyState==4 && asr.status==200)
  {
  datapost=asr.responseText;
  //alert(datapost);
    if(datapost.length>0)
    {
    document.getElementById("tblviewinvc").innerHTML = datapost;
    document.getElementById("tblviewinvc").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewinvc").innerHTML = "";
    document.getElementById("tblviewinvc").style.visibility = "hidden";
    }
  }
}

document.addEventListener('click', function (e) {
  const btn = e.target.closest('.button-panggil');
  if (!btn) return;

  const nomor = btn.getAttribute('data-noantri') || '';
  const nama = btn.getAttribute('data-nama') || '';
  const poli = btn.getAttribute('data-poli') || '';
  const channel = btn.getAttribute('data-channel') || 'POLI';

  const params = "channel=" + encodeURIComponent(channel)
    + "&nomor=" + encodeURIComponent(nomor)
    + "&nama=" + encodeURIComponent(nama)
    + "&poli=" + encodeURIComponent(poli);

  fetch('panggil_queue.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: params
  })
    .then(r => r.json())
    .then(res => {
      console.log('RESP panggil_queue POLI:', res);
      // kalau mau: if (!res.ok) alert(res.error);
    })
    .catch(err => {
      console.error('Error fetch panggil_queue POLI:', err);
    });
});
