  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPATI04X-AKSES.php";
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
        document.getElementById('txtdoctname').focus();
        document.getElementById('txtmediroom').setAttribute('disabled','true');
        document.getElementById('optminggu').setAttribute('disabled','true');
        document.getElementById('optsenin').setAttribute('disabled','true');
        document.getElementById('optselasa').setAttribute('disabled','true');
        document.getElementById('optrabu').setAttribute('disabled','true');
        document.getElementById('optkamis').setAttribute('disabled','true');
        document.getElementById('optjumat').setAttribute('disabled','true');
        document.getElementById('optsabtu').setAttribute('disabled','true');
        document.getElementById('tmschdstart').setAttribute('disabled','true');
        document.getElementById('tmschdend').setAttribute('disabled','true');
        document.getElementById('txtschdnote').setAttribute('disabled','true');
        ambilscreen('');      
      }
      else
      {
        document.getElementById('txtdoctname').setAttribute('disabled','true');
        document.getElementById('txtmediroom').setAttribute('disabled','true');
        document.getElementById('optminggu').setAttribute('disabled','true');
        document.getElementById('optsenin').setAttribute('disabled','true');
        document.getElementById('optselasa').setAttribute('disabled','true');
        document.getElementById('optrabu').setAttribute('disabled','true');
        document.getElementById('optkamis').setAttribute('disabled','true');
        document.getElementById('optjumat').setAttribute('disabled','true');
        document.getElementById('optsabtu').setAttribute('disabled','true');
        document.getElementById('tmschdstart').setAttribute('disabled','true');
        document.getElementById('tmschdend').setAttribute('disabled','true');
        document.getElementById('txtschdnote').setAttribute('disabled','true');
        document.getElementById('txtsearch').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  

var userku;
function ambilusercode(usercode)
{
  if(usercode.length > 8)
  {
  document.getElementById("tbluser").style.visibility = "hidden";
  }
  else
  {
  userku = buatajaxusercode();
  var url="TRXAPATI04C-USER.php";
  userku.onreadystatechange=stateChangedusercode;
  var params = "q="+usercode;
  userku.open("POST",url,true);
  userku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  userku.setRequestHeader("Content-length", params.length);
  userku.setRequestHeader("Connection", "close");
  userku.send(params);
  }
} 

function buatajaxusercode()
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

function stateChangedusercode()
{
  var data;
  if (userku.readyState==4 && userku.status==200)
  {
  data=userku.responseText;
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

function isiusercode(outusercode,outusername)
{
  try 
  {
  document.getElementById("txtdoctname").value = outusername;
  document.getElementById("hiddoctuser").value = outusercode;
  document.getElementById("txtmediroom").removeAttribute('disabled');

  document.getElementById("optminggu").removeAttribute('disabled');
  document.getElementById("optsenin").removeAttribute('disabled');
  document.getElementById("optselasa").removeAttribute('disabled');
  document.getElementById("optrabu").removeAttribute('disabled');
  document.getElementById("optkamis").removeAttribute('disabled');
  document.getElementById("optjumat").removeAttribute('disabled');
  document.getElementById("optsabtu").removeAttribute('disabled');

  document.getElementById("tmschdstart").removeAttribute('disabled');
  document.getElementById("tmschdend").removeAttribute('disabled');

  document.getElementById("txtschdnote").removeAttribute('disabled');


  document.getElementById("tbluser").style.visibility = "hidden";
  document.getElementById("tbluser").innerHTML = "";
  document.getElementById("txtmediroom").focus();

  } 
  catch(err){ alert(err.message); }
}
  
// Layer Control End
// tabel Poli

var poliku;
function ambilpolicode(policode)
{
  if(policode.length > 5)
  {
  document.getElementById("tblpoli").style.visibility = "hidden";
  }
  else
  {
  poliku = buatajaxpolicode();
  var url="TRXAPATI04C-POLI.php";
  poliku.onreadystatechange=stateChangedpolicode;
  var params = "q="+policode;
  poliku.open("POST",url,true);
  poliku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  poliku.setRequestHeader("Content-length", params.length);
  poliku.setRequestHeader("Connection", "close");
  poliku.send(params);
  }
} 
function buatajaxpolicode()
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

function stateChangedpolicode()
{
  var data;
  if (poliku.readyState==4 && poliku.status==200)
  {
  data=poliku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblpoli").innerHTML = data;
    document.getElementById("tblpoli").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblpoli").innerHTML = "";
    document.getElementById("tblpoli").style.visibility = "hidden";
    }
  }
}

function isipolicode(outpolicode,outpoliname)
{
  try 
  {
  document.getElementById("txtmediroom").value = outpoliname;
  document.getElementById("hidmediroom").value = outpolicode;
  document.getElementById("txtmediroom").focus();
  document.getElementById("tblpoli").style.visibility = "hidden";
  document.getElementById("tblpoli").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}




  // Input Data Posisi dari form ke Tabel trxaschd
//indoctuser,indoctname,inmediroom,inschddays,inschdstart,cekschdstart,inschdend,cekschdend,inschdnote
  var ajaxinput;
  function input(doctuser,doctname,mediroom,schddays,xschddays,schdstart,xschdstart,schdend,xschdend,schdnote,xentrtime)

  {
    ajaxinput = buatajaxinput();
    var url="TRXAPATI04E.php";
    //var url="TBLIUNIT01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+doctuser+"|"+doctname+"|"+mediroom+"|"+schddays+"|"+xschddays+"|"+schdstart+"|"+xschdstart+"|"+schdend+"|"+xschdend+"|"+schdnote+"|"+xentrtime;
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

        document.getElementById('txtdoctname').value = '';
        document.getElementById('hiddoctuser').value = '';
        document.getElementById('txtmediroom').value = '';
        document.getElementById('hidmediroom').value = '';

        document.getElementById('optminggu').checked = false;
        document.getElementById('optsenin').checked = false;
        document.getElementById('optselasa').checked = false;
        document.getElementById('optrabu').checked = false;
        document.getElementById('optkamis').checked = false;
        document.getElementById('optjumat').checked = false;
        document.getElementById('optsabtu').checked = false;

        document.getElementById('hidschddays').value = '';

        document.getElementById('tmschdstart').value = '';
        document.getElementById('hidschdstart').value = '';

        document.getElementById('tmschdend').value = '';
        document.getElementById('hidschdend').value = '';

        document.getElementById('txtschdnote').value = '';
        document.getElementById('hidentrtime').value = '';

        let carix = document.getElementById('txtsearch').value;

        document.getElementById('txtmediroom').setAttribute('disabled','true');

        document.getElementById('optminggu').setAttribute('disabled','true');
        document.getElementById('optsenin').setAttribute('disabled','true');
        document.getElementById('optselasa').setAttribute('disabled','true');
        document.getElementById('optrabu').setAttribute('disabled','true');
        document.getElementById('optkamis').setAttribute('disabled','true');
        document.getElementById('optjumat').setAttribute('disabled','true');
        document.getElementById('optsabtu').setAttribute('disabled','true');

        document.getElementById('tmschdstart').setAttribute('disabled','true');
        document.getElementById('tmschdend').setAttribute('disabled','true');
        document.getElementById('txtschdnote').setAttribute('disabled','true');
        
        ambilscreen(carix);
        document.getElementById('txtdoctname').focus();
        //}
    }
  }
  // Selesai Input Data Wall ke Tabel tblepost

// Tampilkan Data Posisi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(outdoctuser,outschddays,outschdstart,outschdend,outentrtime)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPATI04C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+outdoctuser+"|"+outschddays+"|"+outschdstart+"|"+outschdend+"|"+outentrtime;
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
      var res = data.split("|");
        document.getElementById('txtdoctname').removeAttribute('disabled');
        document.getElementById('txtdoctname').value = res[2];
        document.getElementById('hiddoctuser').value = res[1];

        document.getElementById('txtmediroom').removeAttribute('disabled');
        document.getElementById('txtmediroom').value = res[4];
        document.getElementById('hidmediroom').value = res[3];

        document.getElementById('optminggu').removeAttribute('disabled');
        document.getElementById('optsenin').removeAttribute('disabled');
        document.getElementById('optselasa').removeAttribute('disabled');
        document.getElementById('optrabu').removeAttribute('disabled');
        document.getElementById('optkamis').removeAttribute('disabled');
        document.getElementById('optjumat').removeAttribute('disabled');
        document.getElementById('optsabtu').removeAttribute('disabled');

        if (res[5] == '0') 
        {
          document.getElementById('optminggu').checked = true;
          document.getElementById('optsenin').checked = false;
          document.getElementById('optselasa').checked = false;
          document.getElementById('optrabu').checked = false;
          document.getElementById('optkamis').checked = false;
          document.getElementById('optjumat').checked = false;
          document.getElementById('optsabtu').checked = false;
        }
        else if (res[5] == '1')
        {
          document.getElementById('optminggu').checked = false;
          document.getElementById('optsenin').checked = true;
          document.getElementById('optselasa').checked = false;
          document.getElementById('optrabu').checked = false;
          document.getElementById('optkamis').checked = false;
          document.getElementById('optjumat').checked = false;
          document.getElementById('optsabtu').checked = false;
        } 
        else if (res[5] == '2')
        {
          document.getElementById('optminggu').checked = false;
          document.getElementById('optsenin').checked = false;
          document.getElementById('optselasa').checked = true;
          document.getElementById('optrabu').checked = false;
          document.getElementById('optkamis').checked = false;
          document.getElementById('optjumat').checked = false;
          document.getElementById('optsabtu').checked = false;
        } 
        else if (res[5] == '3')
        {
          document.getElementById('optminggu').checked = false;
          document.getElementById('optsenin').checked = false;
          document.getElementById('optselasa').checked = false;
          document.getElementById('optrabu').checked = true;
          document.getElementById('optkamis').checked = false;
          document.getElementById('optjumat').checked = false;
          document.getElementById('optsabtu').checked = false;
        } 
        else if (res[5] == '4')
        {
          document.getElementById('optminggu').checked = false;
          document.getElementById('optsenin').checked = false;
          document.getElementById('optselasa').checked = false;
          document.getElementById('optrabu').checked = false;
          document.getElementById('optkamis').checked = true;
          document.getElementById('optjumat').checked = false;
          document.getElementById('optsabtu').checked = false;
        } 
        else if (res[5] == '5')
        {
          document.getElementById('optminggu').checked = false;
          document.getElementById('optsenin').checked = false;
          document.getElementById('optselasa').checked = false;
          document.getElementById('optrabu').checked = false;
          document.getElementById('optkamis').checked = false;
          document.getElementById('optjumat').checked = true;
          document.getElementById('optsabtu').checked = false;
        } 
        else if (res[5] == '6')
        {
          document.getElementById('optminggu').checked = false;
          document.getElementById('optsenin').checked = false;
          document.getElementById('optselasa').checked = false;
          document.getElementById('optrabu').checked = false;
          document.getElementById('optkamis').checked = false;
          document.getElementById('optjumat').checked = false;
          document.getElementById('optsabtu').checked = true;
        } 

        document.getElementById('hidschddays').value = res[5];
        document.getElementById('hidxschddays').value = res[5];

        document.getElementById('tmschdstart').removeAttribute('disabled');
        document.getElementById('tmschdstart').value = res[6];
        document.getElementById('hidschdstart').value = res[6];
        
        document.getElementById('tmschdend').removeAttribute('disabled');
        document.getElementById('tmschdend').value = res[7];
        document.getElementById('hidschdend').value = res[7];

        document.getElementById('txtschdnote').removeAttribute('disabled');
        document.getElementById('txtschdnote').value = res[8];                     

        document.getElementById('hidentrtime').value = res[9];                     

      }      
        //}
    }
  }

// Hapus 
  var ajaxhapus;
  function hapuscode(outdoctuser,outschddays,outschdstart,outschdend,outentrtime)
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAPATI04D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+outdoctuser+"|"+outschddays+"|"+outschdstart+"|"+outschdend+"|"+outentrtime;
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
        let carix = document.getElementById('txtsearch').value;
        ambilscreen(carix);
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
  var url="TRXAPATI04V.php";
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

