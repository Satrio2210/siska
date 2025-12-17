  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPATI01X-AKSES.php";
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
          //periksanomor('1');
          document.getElementById('txtmainpidn').focus();
          document.getElementById('opttn').setAttribute('disabled','true');
          document.getElementById('optny').setAttribute('disabled','true');
          document.getElementById('optnn').setAttribute('disabled','true');
          document.getElementById('optan').setAttribute('disabled','true');

          document.getElementById('txtmainname').setAttribute('disabled','true');

          document.getElementById('optmale').setAttribute('disabled','true');
          document.getElementById('optfemale').setAttribute('disabled','true');

          document.getElementById('tglmainbirt').setAttribute('disabled','true');

          document.getElementById('optblooda').setAttribute('disabled','true');
          document.getElementById('optbloodb').setAttribute('disabled','true');
          document.getElementById('optbloodab').setAttribute('disabled','true');
          document.getElementById('optbloodo').setAttribute('disabled','true');
          document.getElementById('optbloodx').setAttribute('disabled','true');

          document.getElementById('txtmainaddr').setAttribute('disabled','true');
          document.getElementById('txtmainward').setAttribute('disabled','true');
          document.getElementById('txtmaindist').setAttribute('disabled','true');
          document.getElementById('txtmaincity').setAttribute('disabled','true');
          document.getElementById('txtmainprov').setAttribute('disabled','true');
          document.getElementById('txtmainreli').setAttribute('disabled','true');

          document.getElementById('optwni').setAttribute('disabled','true');
          document.getElementById('optwna').setAttribute('disabled','true');

          document.getElementById('optmainstat').setAttribute('disabled','true');
          document.getElementById('txtmainprof').setAttribute('disabled','true');
          document.getElementById('optmaineduc').setAttribute('disabled','true');

          document.getElementById('txtmainphne').setAttribute('disabled','true');
          
          document.getElementById('txtmainmail').setAttribute('disabled','true');

          document.getElementById('txtmainprnt').setAttribute('disabled','true');

      }
      else
      {
          document.getElementById('txtmastcode').setAttribute('disabled','true');
          document.getElementById('txtmainpidn').setAttribute('disabled','true');
          document.getElementById('opttn').setAttribute('disabled','true');
          document.getElementById('optny').setAttribute('disabled','true');
          document.getElementById('optnn').setAttribute('disabled','true');
          document.getElementById('optan').setAttribute('disabled','true');

          document.getElementById('txtmainname').setAttribute('disabled','true');

          document.getElementById('optmale').setAttribute('disabled','true');
          document.getElementById('optfemale').setAttribute('disabled','true');

          document.getElementById('tglmainbirt').setAttribute('disabled','true');

          document.getElementById('optblooda').setAttribute('disabled','true');
          document.getElementById('optbloodb').setAttribute('disabled','true');
          document.getElementById('optbloodab').setAttribute('disabled','true');
          document.getElementById('optbloodo').setAttribute('disabled','true');
          document.getElementById('optbloodx').setAttribute('disabled','true');

          document.getElementById('txtmainaddr').setAttribute('disabled','true');
          document.getElementById('txtmainward').setAttribute('disabled','true');
          document.getElementById('txtmaindist').setAttribute('disabled','true');
          document.getElementById('txtmaincity').setAttribute('disabled','true');
          document.getElementById('txtmainprov').setAttribute('disabled','true');
          document.getElementById('txtmainreli').setAttribute('disabled','true');

          document.getElementById('optwni').setAttribute('disabled','true');
          document.getElementById('optwna').setAttribute('disabled','true');

          document.getElementById('optmainstat').setAttribute('disabled','true');
          document.getElementById('txtmainprof').setAttribute('disabled','true');
          document.getElementById('optmaineduc').setAttribute('disabled','true');

          document.getElementById('txtmainphne').setAttribute('disabled','true');
          
          document.getElementById('txtmainmail').setAttribute('disabled','true');

          document.getElementById('txtmainprnt').setAttribute('disabled','true');

      }
    }
  }

  // periksa Kode Urut Medical Record Pasien 
    var emerku;
  function periksanomor(sequ)
  {
    emerku = buatajaxnomor();
    var url="TRXAPATI01X.php";
    emerku.onreadystatechange=stateChangednomor;
    var params = "q="+sequ;
    //alert(params);
    emerku.open("POST",url,true);
    emerku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    emerku.setRequestHeader("Content-length", params.length);
    emerku.setRequestHeader("Connection", "close");
    emerku.send(params);

  }

  function buatajaxnomor()
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

  function stateChangednomor()
  {
  var data;
  if (emerku.readyState==4)
    {

    xdata=emerku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {

        var onecode = document.getElementById('txtmastcode').value;
        var twocode = onecode+data;
        document.getElementById('txtmastcode').value = twocode;
        //ambiltrxascreen(data);
      }
      else
      {
        document.getElementById('txtmastcode').value=data;
      }
    }
  }
// end periksa Kode Nomor 

  // periksa tanggal lahir Pasien baru 
    var tanggalku;
  function periksatanggal(tanggal)
  {
    tanggalku = buatajaxtanggal();
    var url="TRXAPATI01X-DATE.php";
    tanggalku.onreadystatechange=stateChangedtanggal;
    var params = "q="+tanggal;
    //alert(params);
    tanggalku.open("POST",url,true);
    tanggalku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    tanggalku.setRequestHeader("Content-length", params.length);
    tanggalku.setRequestHeader("Connection", "close");
    tanggalku.send(params);

  }

  function buatajaxtanggal()
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

  function stateChangedtanggal()
  {
  var data;
  if (tanggalku.readyState==4)
    {

    xdata=tanggalku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {

        swal({
          title: 'Ada Kesamaan Tanggal Lahir' ,
          text: 'Periksa lagi apakah data pasien ini sudah pernah dimasukkan, silah periksa lagi',
          icon: 'warning',
        });

        document.getElementById('tglmainbirt').focus();
        //ambiltrxascreen(data);
      }
      else
      {
        document.getElementById('tglmainbirt').focus();
      }
    }
  }
// end periksa Tanggal Lahir 


// Pencarian Rekam Medis
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
  var url="TRXAPATI01C-PATI.php";
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

function isipaticode(outmastcode,outmainpidn,outmaintitl,outmainname,outmaingend,outmainbirt,outmainblod,outmainaddr,outmainward,outmaindist,outmaincity,outmainprov,outmainreli,outmainctzn,outmainstat,outmainprof,outmaineduc,outmainphne,outmainmail,outmainprnt)

{
  try 
  {
  document.getElementById("txtmastcode").value = outmastcode;

  document.getElementById('txtmainpidn').value = outmainpidn;

  document.getElementById('opttn').removeAttribute('disabled');
  document.getElementById('optny').removeAttribute('disabled');
  document.getElementById('optnn').removeAttribute('disabled');
  document.getElementById('optan').removeAttribute('disabled');

  if (outmaintitl == 'Tn.')
  {

  document.getElementById('opttn').checked = true;
  document.getElementById('optny').checked = false;
  document.getElementById('optnn').checked = false;
  document.getElementById('optan').checked = false;
  document.getElementById('hidmaintitl').value = 'Tn.';

  }
  else if (outmaintitl == 'Ny.')
  {

  document.getElementById('opttn').checked = false;
  document.getElementById('optny').checked = true;
  document.getElementById('optnn').checked = false;
  document.getElementById('optan').checked = false;
  document.getElementById('hidmaintitl').value = 'Ny.';

  }
  else if (outmaintitl == 'Nn.')
  {

  document.getElementById('opttn').checked = false;
  document.getElementById('optny').checked = false;
  document.getElementById('optnn').checked = true;
  document.getElementById('optan').checked = false;
  document.getElementById('hidmaintitl').value = 'Nn.';

  }
  else if (outmaintitl == 'An.')
  {

  document.getElementById('opttn').checked = false;
  document.getElementById('optny').checked = false;
  document.getElementById('optnn').checked = false;
  document.getElementById('optan').checked = true;
  document.getElementById('hidmaintitl').value = 'An.';

  }
  else
  {

  document.getElementById('opttn').checked = false;
  document.getElementById('optny').checked = false;
  document.getElementById('optnn').checked = false;
  document.getElementById('optan').checked = false;
  document.getElementById('hidmaintitl').value = '';

  }
  document.getElementById('txtmainname').removeAttribute('disabled');
  document.getElementById('txtmainname').value = outmainname;

  document.getElementById('optmale').removeAttribute('disabled');
  document.getElementById('optfemale').removeAttribute('disabled');

  if (outmaingend == 'M')
  {

  document.getElementById('optmale').checked = true;
  document.getElementById('optfemale').checked = false;
  document.getElementById('hidmaingend').value = 'M';

  }
  else if (outmaingend == 'F')
  {

  document.getElementById('optmale').checked = false;
  document.getElementById('optfemale').checked = true;
  document.getElementById('hidmaingend').value = 'F';

  }

  else

  {

  document.getElementById('optmale').checked = false;
  document.getElementById('optfemale').checked = false;
  document.getElementById('hidmaingend').value = '';

  }

  document.getElementById('tglmainbirt').removeAttribute('disabled');
  document.getElementById('tglmainbirt').value = outmainbirt;

  document.getElementById('optblooda').removeAttribute('disabled');
  document.getElementById('optbloodb').removeAttribute('disabled');
  document.getElementById('optbloodab').removeAttribute('disabled');
  document.getElementById('optbloodo').removeAttribute('disabled');
  document.getElementById('optbloodx').removeAttribute('disabled');

  if (outmainblod == 'A')
  {

  document.getElementById('optblooda').checked = true;
  document.getElementById('optbloodb').checked = false;
  document.getElementById('optbloodab').checked = false;
  document.getElementById('optbloodo').checked = false;
  document.getElementById('optbloodx').checked = false;
  document.getElementById('hidmainblod').value = 'A';

  }
  else if (outmainblod == 'B')
  {

  document.getElementById('optblooda').checked = false;
  document.getElementById('optbloodb').checked = true;
  document.getElementById('optbloodab').checked = false;
  document.getElementById('optbloodo').checked = false;
  document.getElementById('optbloodx').checked = false;
  document.getElementById('hidmainblod').value = 'B';

  }
  else if (outmainblod == 'AB')
  {

  document.getElementById('optblooda').checked = false;
  document.getElementById('optbloodb').checked = false;
  document.getElementById('optbloodab').checked = true;
  document.getElementById('optbloodo').checked = false;
  document.getElementById('optbloodx').checked = false;
  document.getElementById('hidmainblod').value = 'AB';

  }
  else if (outmainblod == 'O')
  {

  document.getElementById('optblooda').checked = false;
  document.getElementById('optbloodb').checked = false;
  document.getElementById('optbloodab').checked = false;
  document.getElementById('optbloodo').checked = true;
  document.getElementById('optbloodx').checked = false;
  document.getElementById('hidmainblod').value = 'O';

  }
  else if (outmainblod == 'X')
  {

  document.getElementById('optblooda').checked = false;
  document.getElementById('optbloodb').checked = false;
  document.getElementById('optbloodab').checked = false;
  document.getElementById('optbloodo').checked = false;
  document.getElementById('optbloodx').checked = true;
  document.getElementById('hidmainblod').value = 'X';

  }

  document.getElementById('txtmainaddr').removeAttribute('disabled');
  document.getElementById('txtmainaddr').value = outmainaddr;

  document.getElementById('txtmainward').removeAttribute('disabled');
  document.getElementById('txtmainward').value = outmainward;

  document.getElementById('txtmaindist').removeAttribute('disabled');
  document.getElementById('txtmaindist').value = outmaindist;  

  document.getElementById('txtmaincity').removeAttribute('disabled');
  document.getElementById('txtmaincity').value = outmaincity;

  document.getElementById('txtmainprov').removeAttribute('disabled');
  document.getElementById('txtmainprov').value = outmainprov;

  document.getElementById('txtmainreli').removeAttribute('disabled');
  document.getElementById('txtmainreli').value = outmainreli;

  document.getElementById('optwni').removeAttribute('disabled');
  document.getElementById('optwna').removeAttribute('disabled');

  if (outmainctzn == 'WNI')
  {

  document.getElementById('optwni').checked = true;
  document.getElementById('optwna').checked = false;
  document.getElementById('hidmainctzn').value = 'WNI';

  }
  else if (outmainctzn == 'WNA')
  {
  document.getElementById('optwni').checked = true;
  document.getElementById('optwna').checked = false;
  document.getElementById('hidmainctzn').value = 'WNA';

  }

  document.getElementById('optmainstat').removeAttribute('disabled');
  document.getElementById('optmainstat').value = outmainstat;  
  
  document.getElementById('txtmainprof').removeAttribute('disabled');
  document.getElementById('txtmainprof').value = outmainprof;

  document.getElementById('optmaineduc').removeAttribute('disabled');
  document.getElementById('optmaineduc').value = outmaineduc;

  document.getElementById('txtmainphne').removeAttribute('disabled');
  document.getElementById('txtmainphne').value = outmainphne;

  document.getElementById('txtmainmail').removeAttribute('disabled');
  document.getElementById('txtmainmail').value = outmainmail;  

  document.getElementById('txtmainprnt').removeAttribute('disabled');
  document.getElementById('txtmainprnt').value = outmainprnt

  document.getElementById("tblpati").style.visibility = "";
  document.getElementById("tblpati").innerHTML = "";
  document.getElementById("txtsearch").value = '';
  document.getElementById("txtmainpidn").focus();

  } 
  catch(err){ alert(err.message); }
}
