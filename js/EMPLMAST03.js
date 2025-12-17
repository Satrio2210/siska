  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="EMPLMAST01X-AKSES.php";
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
    //alert(data);
    if(data.length>1)
      {
          document.getElementById('txtsearch').focus();

          document.getElementById('txtmastcode').setAttribute('disabled','true');
          document.getElementById('txtfrstname').setAttribute('disabled','true');
          document.getElementById('txtlastname').setAttribute('disabled','true');


          document.getElementById('opthigheduc').setAttribute('disabled','true');
          document.getElementById('txtlastschl').setAttribute('disabled','true');

          document.getElementById('optdocustat').setAttribute('disabled','true');


          document.getElementById('tglhiredate').setAttribute('disabled','true');
          document.getElementById('tglactidate').setAttribute('disabled','true');

          document.getElementById('txtinforefe').setAttribute('disabled','true');
          document.getElementById('txtinfospvs').setAttribute('disabled','true');
          document.getElementById('txtmaindivi').setAttribute('disabled','true');
          document.getElementById('txtmainpstn').setAttribute('disabled','true');

          document.getElementById('tglrsgndate').setAttribute('disabled','true');
          document.getElementById('txtrsgnnote').setAttribute('disabled','true');

      }
      else
      {
          document.getElementById('txtsearch').setAttribute('disabled','true');

          document.getElementById('txtmastcode').setAttribute('disabled','true');
          document.getElementById('txtfrstname').setAttribute('disabled','true');
          document.getElementById('txtlastname').setAttribute('disabled','true');


          document.getElementById('opthigheduc').setAttribute('disabled','true');
          document.getElementById('txtlastschl').setAttribute('disabled','true');

          document.getElementById('optdocustat').setAttribute('disabled','true');


          document.getElementById('tglhiredate').setAttribute('disabled','true');
          document.getElementById('tglactidate').setAttribute('disabled','true');

          document.getElementById('txtinforefe').setAttribute('disabled','true');
          document.getElementById('txtinfospvs').setAttribute('disabled','true');
          document.getElementById('txtmaindivi').setAttribute('disabled','true');
          document.getElementById('txtmainpstn').setAttribute('disabled','true');

          document.getElementById('tglrsgndate').setAttribute('disabled','true');
          document.getElementById('txtrsgnnote').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


// Ambil Data Employer Master
var emplmastku;
function ambilemplmastcode(emplmastcode)
{
  if(emplmastcode.length > 5)
  {
  document.getElementById("tblemplmast").style.visibility = "hidden";
  }
  else
  {
  emplmastku = buatajaxemplmastcode();
  var url="EMPLMAST03C.php";
  emplmastku.onreadystatechange=stateChangedemplmastcode;
  var params = "q="+emplmastcode;
  emplmastku.open("POST",url,true);
  emplmastku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  emplmastku.setRequestHeader("Content-length", params.length);
  emplmastku.setRequestHeader("Connection", "close");
  emplmastku.send(params);
  }
} 

function buatajaxemplmastcode()
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


function stateChangedemplmastcode()
{
  var data;
  if (emplmastku.readyState==4 && emplmastku.status==200)
  {
  data=emplmastku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblemplmast").innerHTML = data;
    document.getElementById("tblemplmast").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblemplmast").innerHTML = "";
    document.getElementById("tblemplmast").style.visibility = "hidden";
    }
  }
}

function isiemplmastcode(mastcode,frstname,lastname,higheduc,lastschl,docustat,hiredate,actidate,namedivi,maindivi,namepstn,mainpstn)
{
  document.getElementById('txtmastcode').removeAttribute('disabled');
  document.getElementById("txtmastcode").value = mastcode;

  document.getElementById('txtfrstname').removeAttribute('disabled');
  document.getElementById("txtfrstname").value = frstname;

  document.getElementById('txtlastname').removeAttribute('disabled');
  document.getElementById("txtlastname").value = lastname;

  document.getElementById('opthigheduc').removeAttribute('disabled');
  document.getElementById('opthigheduc').value = higheduc;

  document.getElementById('txtlastschl').removeAttribute('disabled');
  document.getElementById("txtlastschl").value = lastschl;

  document.getElementById('optdocustat').removeAttribute('disabled');

  if (docustat == 'Y') 
    { 
      document.getElementById("optdocustat").checked = true;
      document.getElementById("hiddocustat").value = 'Y'; 
    }
    else
    {
      document.getElementById("optdocustat").checked = false;
      document.getElementById("hiddocustat").value = 'N'; 
    }

  document.getElementById('tglhiredate').removeAttribute('disabled');
  document.getElementById("tglhiredate").value = hiredate;

  document.getElementById('tglactidate').removeAttribute('disabled');
  document.getElementById("tglactidate").value = actidate;

  document.getElementById('txtmaindivi').removeAttribute('disabled');
  document.getElementById("txtmaindivi").value = namedivi;
  document.getElementById("hidmaindivi").value = maindivi;

  document.getElementById('txtmainpstn').removeAttribute('disabled');
  document.getElementById("txtmainpstn").value = namepstn;
  document.getElementById("hidmainpstn").value = mainpstn;

  document.getElementById('tglrsgndate').removeAttribute('disabled');
  document.getElementById('txtrsgnnote').removeAttribute('disabled');

  document.getElementById("txtrsgnnote").focus();
  document.getElementById("tblemplmast").style.visibility = "hidden";
  document.getElementById("tblemplmast").innerHTML = "";

}
