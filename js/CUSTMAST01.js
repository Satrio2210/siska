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

            document.getElementById('txtmainname').focus();

            document.getElementById('optbpjs').setAttribute('disabled','true');
            document.getElementById('optasuransi').setAttribute('disabled','true');
            document.getElementById('optperusahaan').setAttribute('disabled','true');

            document.getElementById('txtmainaddr').setAttribute('disabled','true');
            document.getElementById('txtmaincity').setAttribute('disabled','true');
            document.getElementById('txtmainctry').setAttribute('disabled','true');
            document.getElementById('txtmainphne').setAttribute('disabled','true');

            document.getElementById('txtcrdtlimt').setAttribute('disabled','true');
            document.getElementById('txtshipname').setAttribute('disabled','true');
            document.getElementById('txtshipaddr').setAttribute('disabled','true');

            ambilscreen('');
          }
          else
          {
            document.getElementById('txtmainname').setAttribute('disabled','true');

            document.getElementById('optbpjs').setAttribute('disabled','true');
            document.getElementById('optasuransi').setAttribute('disabled','true');
            document.getElementById('optperusahaan').setAttribute('disabled','true');

            document.getElementById('txtmainaddr').setAttribute('disabled','true');
            document.getElementById('txtmaincity').setAttribute('disabled','true');
            document.getElementById('txtmainctry').setAttribute('disabled','true');
            document.getElementById('txtmainphne').setAttribute('disabled','true');

            document.getElementById('txtcrdtlimt').setAttribute('disabled','true');
            document.getElementById('txtshipname').setAttribute('disabled','true');
            document.getElementById('txtshipaddr').setAttribute('disabled','true');

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
      var url="CUSTMAST01X.php";
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
        document.getElementById('txtmastcode').value=data;
      }
      else
      {
        document.getElementById('txtmastcode').value='';
      }
    }
  }
// end periksa Kode Urut

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
  var url="CUSTMAST01V.php";
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

  function input(mastcode,mainname,maintype,mainaddr,maincity,mainctry,mainphne,crdtlimt,shipname,shipaddr)
  {
    ajaxinput = buatajaxinput();
    
    var url="CUSTMAST01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+mastcode+"|"+mainname+"|"+maintype+"|"+mainaddr+"|"+maincity+"|"+mainctry+"|"+mainphne+"|"+crdtlimt+"|"+shipname+"|"+shipaddr;
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

        document.getElementById('txtmainname').focus();
        document.getElementById('txtmainname').value = '';

        document.getElementById('optbpjs').checked = false;
        document.getElementById('optbpjs').setAttribute('disabled','true');

        document.getElementById('optasuransi').checked = false;
        document.getElementById('optasuransi').setAttribute('disabled','true');

        document.getElementById('optperusahaan').checked = false;
        document.getElementById('optperusahaan').setAttribute('disabled','true');

        document.getElementById('hidmaintype').value = '';

        document.getElementById('txtmainaddr').setAttribute('disabled','true');
        document.getElementById('txtmainaddr').value = '';

        document.getElementById('txtmaincity').setAttribute('disabled','true');
        document.getElementById('txtmaincity').value = '';

        document.getElementById('txtmainctry').setAttribute('disabled','true');
        document.getElementById('txtmainctry').value = '';

        document.getElementById('txtmainphne').setAttribute('disabled','true');
        document.getElementById('txtmainphne').value = '';

        document.getElementById('txtcrdtlimt').setAttribute('disabled','true');
        document.getElementById('txtcrdtlimt').value = '';

        document.getElementById('txtshipname').setAttribute('disabled','true');
        document.getElementById('txtshipname').value = '';

        document.getElementById('txtshipaddr').setAttribute('disabled','true');
        document.getElementById('txtshipaddr').value = '';

        ambilscreen('');
    }
  }
  // Selesai Input Data Wall ke Tabel 

// Tampilkan Data pada form 
var ajaxview
function viewcode(mastcode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="CUSTMAST01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+mastcode;
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
 //    1         2          3        4        5            6         7         8       9         10              
// |$mastcode|$mainname|$maintype|$mainaddr|$maincity|$mainctry|$mainphne|$crdtlimt|$shipname|$shipaddr
      var res = data.split("|");
      document.getElementById("txtmastcode").value = res[1];

      document.getElementById("txtmainname").value = res[2];

      document.getElementById('optbpjs').removeAttribute('disabled');
      document.getElementById('optasuransi').removeAttribute('disabled');
      document.getElementById('optperusahaan').removeAttribute('disabled');


      if (res[3] == 'B') 
        {
          document.getElementById('optbpjs').checked = true;
          document.getElementById('optasuransi').checked = false;
          document.getElementById('optperusahaan').checked = false;
          document.getElementById('hidmaintype').value = 'B';

        }
      else if (res[3] == 'A')
        {
          document.getElementById('optbpjs').checked = false;
          document.getElementById('optasuransi').checked = true;
          document.getElementById('optperusahaan').checked = false;
          document.getElementById('hidmaintype').value = 'A';          

        }
      else if (res[3] == 'P')
        {
          document.getElementById('optbpjs').checked = false;
          document.getElementById('optasuransi').checked = false;
          document.getElementById('optperusahaan').checked = true;
          document.getElementById('hidmaintype').value = 'P';          

        }
        else
        {
          document.getElementById('optbpjs').checked = false;
          document.getElementById('optasuransi').checked = false;
          document.getElementById('optperusahaan').checked = false;
          document.getElementById('hidmaintype').value = '';          

        }

      document.getElementById('txtmainaddr').removeAttribute('disabled');
      document.getElementById('txtmainaddr').value = res[4];

      document.getElementById('txtmaincity').removeAttribute('disabled');
      document.getElementById('txtmaincity').value = res[5];

      document.getElementById('txtmainctry').removeAttribute('disabled');
      document.getElementById('txtmainctry').value = res[6];

      document.getElementById('txtmainphne').removeAttribute('disabled');
      document.getElementById('txtmainphne').value = res[7];

      var limitamnt = convertToRupiah(Math.round(res[8]));
      document.getElementById("txtcrdtlimt").removeAttribute('disabled');
      document.getElementById("txtcrdtlimt").value = limitamnt;

      document.getElementById('txtshipname').removeAttribute('disabled');
      document.getElementById('txtshipname').value = res[9];

      document.getElementById('txtshipaddr').removeAttribute('disabled');
      document.getElementById('txtshipaddr').value = res[10];


      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(mastcode)
  {
    ajaxhapus = buatajaxhapus();
    var url="CUSTMAST01D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+mastcode;
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
