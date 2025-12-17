  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="INVEMAST01X-AKSES.php";
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
          document.getElementById('txtmastcode').focus();

          document.getElementById('txttypename').setAttribute('disabled','true');
          document.getElementById('txtunitname').setAttribute('disabled','true');
          document.getElementById('txtsaleunit').setAttribute('disabled','true');
          document.getElementById('txtspecname').setAttribute('disabled','true');
          document.getElementById('txtvarnname').setAttribute('disabled','true');

          document.getElementById('optwithsrnm').setAttribute('disabled','true');

          document.getElementById('optstock').setAttribute('disabled','true');
          document.getElementById('optnonstock').setAttribute('disabled','true');
          document.getElementById('optfixedasset').setAttribute('disabled','true');

          document.getElementById('optweight').setAttribute('disabled','true');
          document.getElementById('optvolume').setAttribute('disabled','true');

          document.getElementById('txtpartname').setAttribute('disabled','true');
          document.getElementById('txtpartalias').setAttribute('disabled','true');
          document.getElementById('txthousname').setAttribute('disabled','true');
          document.getElementById('txtstockmini').setAttribute('disabled','true');
          document.getElementById('txtmainnote').setAttribute('disabled','true');

          document.getElementById('optprice').setAttribute('disabled','true');
          document.getElementById('optdiscount').setAttribute('disabled','true');

          document.getElementById('optpartguarantee').setAttribute('disabled','true');
          document.getElementById('optserviceguarantee').setAttribute('disabled','true');
          document.getElementById('optbothguarantee').setAttribute('disabled','true');
          document.getElementById('optnonguarantee').setAttribute('disabled','true');

          document.getElementById('txtgrtelimt').setAttribute('disabled','true');
          document.getElementById('txtexcercve').setAttribute('disabled','true');
          document.getElementById('txtlackrcve').setAttribute('disabled','true');

      }
      else
      {
          document.getElementById('txtmastcode').setAttribute('disabled','true');
          document.getElementById('txttypename').setAttribute('disabled','true');
          document.getElementById('txtunitname').setAttribute('disabled','true');
          document.getElementById('txtsaleunit').setAttribute('disabled','true');
          document.getElementById('txtspecname').setAttribute('disabled','true');
          document.getElementById('txtvarnname').setAttribute('disabled','true');

          document.getElementById('optwithsrnm').setAttribute('disabled','true');

          document.getElementById('optstock').setAttribute('disabled','true');
          document.getElementById('optnonstock').setAttribute('disabled','true');
          document.getElementById('optfixedasset').setAttribute('disabled','true');

          document.getElementById('optweight').setAttribute('disabled','true');
          document.getElementById('optvolume').setAttribute('disabled','true');

          document.getElementById('txtpartname').setAttribute('disabled','true');
          document.getElementById('txtpartalias').setAttribute('disabled','true');
          document.getElementById('txthousname').setAttribute('disabled','true');
          document.getElementById('txtstockmini').setAttribute('disabled','true');
          document.getElementById('txtmainnote').setAttribute('disabled','true');

          document.getElementById('optprice').setAttribute('disabled','true');
          document.getElementById('optdiscount').setAttribute('disabled','true');

          document.getElementById('optpartguarantee').setAttribute('disabled','true');
          document.getElementById('optserviceguarantee').setAttribute('disabled','true');
          document.getElementById('optbothguarantee').setAttribute('disabled','true');
          document.getElementById('optnonguarantee').setAttribute('disabled','true');

          document.getElementById('txtgrtelimt').setAttribute('disabled','true');
          document.getElementById('txtexcercve').setAttribute('disabled','true');
          document.getElementById('txtlackrcve').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  

// Ambil Data Inventory Master
var invemastku;
function ambilinvemastcode(invemastcode)
{
  if(invemastcode.length > 4)
  {
  document.getElementById("tblinvemast").style.visibility = "hidden";
  }
  else
  {
  invemastku = buatajaxinvemastcode();
  var url="INVEMAST02C.php";
  invemastku.onreadystatechange=stateChangedinvemastcode;
  var params = "q="+invemastcode;
  invemastku.open("POST",url,true);
  invemastku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  invemastku.setRequestHeader("Content-length", params.length);
  invemastku.setRequestHeader("Connection", "close");
  invemastku.send(params);
  }
} 

function buatajaxinvemastcode()
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


function stateChangedinvemastcode()
{
  var data;
  if (invemastku.readyState==4 && invemastku.status==200)
  {
  data=invemastku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblinvemast").innerHTML = data;
    document.getElementById("tblinvemast").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblinvemast").innerHTML = "";
    document.getElementById("tblinvemast").style.visibility = "hidden";
    }
  }
}

function isiinvemastcode(mastcode, typename, typecode, unitname, unitcode, saleunitname, saleunitcode, specname, speccode, varnname, varncode, withsrnm, parttype, costfrgt, partname, partalas, housname, houscode, stockmini, mainnote, mainpric, grtetype, grtelimt, excercve, lackrcve)
{
  document.getElementById("txtmastcode").value = mastcode;

  document.getElementById('txttypename').removeAttribute('disabled');
  document.getElementById("txttypename").value = typename;

  document.getElementById("hidtypecode").value = typecode;

  document.getElementById('txtunitname').removeAttribute('disabled');
  document.getElementById("txtunitname").value = unitname;

  document.getElementById("hidunitcode").value = unitcode;

  document.getElementById('txtsaleunit').removeAttribute('disabled');
  document.getElementById("txtsaleunit").value = saleunitname;

  document.getElementById("hidsaleunit").value = saleunitcode;

  document.getElementById('txtspecname').removeAttribute('disabled');
  document.getElementById("txtspecname").value = specname;
  document.getElementById("hidspeccode").value = speccode;

  document.getElementById('txtvarnname').removeAttribute('disabled');
  document.getElementById("txtvarnname").value = varnname;
  document.getElementById("hidvarncode").value = varncode;

  if (withsrnm == 'Y') 
    { 
      document.getElementById('optwithsrnm').removeAttribute('disabled');
      document.getElementById("optwithsrnm").checked = true;
      document.getElementById("hidwithsrnm").value = 'Y'; 
    }
    else
    {
      document.getElementById('optwithsrnm').removeAttribute('disabled');
      document.getElementById("optwithsrnm").checked = false;
      document.getElementById("hidwithsrnm").value = 'N'; 
    }

  if (parttype == 'ST')
    {
      document.getElementById('optstock').removeAttribute('disabled');
      document.getElementById("optstock").checked = true;

      document.getElementById('optnonstock').removeAttribute('disabled');
      document.getElementById("optnonstock").checked = false;

      document.getElementById('optfixedasset').removeAttribute('disabled');
      document.getElementById("optfixedasset").checked = false;

      document.getElementById("hidparttype").value = 'ST';
    } 
  else if (parttype == 'NS')
    {
      document.getElementById('optstock').removeAttribute('disabled');
      document.getElementById("optstock").checked = false;

      document.getElementById('optnonstock').removeAttribute('disabled');
      document.getElementById("optnonstock").checked = true;

      document.getElementById('optfixedasset').removeAttribute('disabled');
      document.getElementById("optfixedasset").checked = false;

      document.getElementById("hidparttype").value = 'NS';
    } 
  else if (parttype == 'FA')
    {
      document.getElementById('optstock').removeAttribute('disabled');
      document.getElementById("optstock").checked = false;

      document.getElementById('optnonstock').removeAttribute('disabled');
      document.getElementById("optnonstock").checked = false;

      document.getElementById('optfixedasset').removeAttribute('disabled');
      document.getElementById("optfixedasset").checked = true;

      document.getElementById("hidparttype").value = 'FA';
    } 
  else
    {
      document.getElementById('optstock').removeAttribute('disabled');
      document.getElementById("optstock").checked = false;

      document.getElementById('optnonstock').removeAttribute('disabled');
      document.getElementById("optnonstock").checked = false;

      document.getElementById('optfixedasset').removeAttribute('disabled');
      document.getElementById("optfixedasset").checked = false;

      document.getElementById("hidparttype").value = '';
    }

  if (costfrgt == 'W') 
    { 
      document.getElementById('optweight').removeAttribute('disabled');
      document.getElementById("optweight").checked = true;

      document.getElementById('optvolume').removeAttribute('disabled');
      document.getElementById("optvolume").checked = false;

      document.getElementById("hidcostfrgt").value = 'W'; 
    }
  else if (costfrgt == 'V')
    {
      document.getElementById('optweight').removeAttribute('disabled');
      document.getElementById("optweight").checked = false;

      document.getElementById('optvolume').removeAttribute('disabled');
      document.getElementById("optvolume").checked = true;

      document.getElementById("hidcostfrgt").value = 'V'; 
    }
  else
    {
      document.getElementById('optweight').removeAttribute('disabled');
      document.getElementById("optweight").checked = false;

      document.getElementById('optvolume').removeAttribute('disabled');
      document.getElementById("optvolume").checked = false;

      document.getElementById("hidcostfrgt").value = ''; 
    }

  document.getElementById('txtpartname').removeAttribute('disabled');
  document.getElementById("txtpartname").value = partname;

  document.getElementById('txtpartalias').removeAttribute('disabled');
  document.getElementById("txtpartalias").value = partalas;

  document.getElementById('txthousname').removeAttribute('disabled');  
  document.getElementById("txthousname").value = housname;

  document.getElementById("hidhouscode").value = houscode;

  document.getElementById('txtstockmini').removeAttribute('disabled');
  document.getElementById("txtstockmini").value = stockmini;

  document.getElementById('txtmainnote').removeAttribute('disabled');
  document.getElementById("txtmainnote").value = mainnote;

  if (mainpric == 'P') 
    { 
      document.getElementById('optprice').removeAttribute('disabled');
      document.getElementById("optprice").checked = true;

      document.getElementById('optdiscount').removeAttribute('disabled');
      document.getElementById("optdiscount").checked = false;

      document.getElementById("hidmainpric").value = 'P'; 
    }
  else if (mainpric == 'D')
    {
      document.getElementById('optprice').removeAttribute('disabled');
      document.getElementById("optprice").checked = false;

      document.getElementById('optdiscount').removeAttribute('disabled');
      document.getElementById("optdiscount").checked = true;

      document.getElementById("hidmainpric").value = 'D'; 
    }
  else
    {
      document.getElementById('optprice').removeAttribute('disabled');
      document.getElementById("optprice").checked = false;

      document.getElementById('optdiscount').removeAttribute('disabled');
      document.getElementById("optdiscount").checked = false;

      document.getElementById("hidmainpric").value = ''; 
    }

  if (grtetype == 'P') 
    { 
      document.getElementById('optpartguarantee').removeAttribute('disabled');
      document.getElementById('optpartguarantee').checked = true;

      document.getElementById('optserviceguarantee').removeAttribute('disabled');
      document.getElementById('optserviceguarantee').checked = false;

      document.getElementById('optbothguarantee').removeAttribute('disabled');
      document.getElementById('optbothguarantee').checked = false;

      document.getElementById('optnonguarantee').removeAttribute('disabled');
      document.getElementById('optnonguarantee').checked = false;

      document.getElementById('hidgrtetype').value = 'P';
    }
  else if (grtetype == 'S')
    {
      document.getElementById('optpartguarantee').removeAttribute('disabled');
      document.getElementById('optpartguarantee').checked = false;

      document.getElementById('optserviceguarantee').removeAttribute('disabled');
      document.getElementById('optserviceguarantee').checked = true;

      document.getElementById('optbothguarantee').removeAttribute('disabled');
      document.getElementById('optbothguarantee').checked = false;

      document.getElementById('optnonguarantee').removeAttribute('disabled');
      document.getElementById('optnonguarantee').checked = false;

      document.getElementById('hidgrtetype').value = 'S';
    }
  else if (grtetype == 'B')
    {
      document.getElementById('optpartguarantee').removeAttribute('disabled');
      document.getElementById('optpartguarantee').checked = false;

      document.getElementById('optserviceguarantee').removeAttribute('disabled');
      document.getElementById('optserviceguarantee').checked = false;

      document.getElementById('optbothguarantee').removeAttribute('disabled');
      document.getElementById('optbothguarantee').checked = true;

      document.getElementById('optnonguarantee').removeAttribute('disabled');
      document.getElementById('optnonguarantee').checked = false;

      document.getElementById('hidgrtetype').value = 'B';
    }
  else if (grtetype == 'N')
    {
      document.getElementById('optpartguarantee').removeAttribute('disabled');
      document.getElementById('optpartguarantee').checked = false;

      document.getElementById('optserviceguarantee').removeAttribute('disabled');
      document.getElementById('optserviceguarantee').checked = false;

      document.getElementById('optbothguarantee').removeAttribute('disabled');
      document.getElementById('optbothguarantee').checked = false;

      document.getElementById('optnonguarantee').removeAttribute('disabled');
      document.getElementById('optnonguarantee').checked = true;

      document.getElementById('hidgrtetype').value = 'N';
    }
  else
    {
      document.getElementById('optpartguarantee').removeAttribute('disabled');
      document.getElementById('optpartguarantee').checked = false;

      document.getElementById('optserviceguarantee').removeAttribute('disabled');
      document.getElementById('optserviceguarantee').checked = false;

      document.getElementById('optbothguarantee').removeAttribute('disabled');
      document.getElementById('optbothguarantee').checked = false;

      document.getElementById('optnonguarantee').removeAttribute('disabled');
      document.getElementById('optnonguarantee').checked = false;

      document.getElementById('hidgrtetype').value = '';
    }

  document.getElementById('txtgrtelimt').removeAttribute('disabled');
  document.getElementById("txtgrtelimt").value = grtelimt;

  document.getElementById('txtexcercve').removeAttribute('disabled');
  document.getElementById("txtexcercve").value = excercve;

  document.getElementById('txtlackrcve').removeAttribute('disabled');
  document.getElementById("txtlackrcve").value = lackrcve;

  document.getElementById("txtmastcode").focus();
  document.getElementById("tblinvemast").style.visibility = "hidden";
  document.getElementById("tblinvemast").innerHTML = "";

}
