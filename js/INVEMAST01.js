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
          periksaitem('1');
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


  // periksa Kode Master Item 
    var itemku;
  function periksaitem(limit)
  {
    itemku = buatajaxitem();
    var url="INVEMAST01X.php";
    itemku.onreadystatechange=stateChangeditem;
    var params = "q="+limit;
    //alert(params);
    itemku.open("POST",url,true);
    itemku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    itemku.setRequestHeader("Content-length", params.length);
    itemku.setRequestHeader("Connection", "close");
    itemku.send(params);

  }

  function buatajaxitem()
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

  function stateChangeditem()
  {
  var data;
  if (itemku.readyState==4)
    {

    xdata=itemku.responseText;
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
// end periksa Kode item  


    // ambil Kode Type dari tabel tblitype
var typeku;
function ambiltypecode(typecode)
{
  if(typecode.length > 5)
  {
  document.getElementById("tbltype").style.visibility = "hidden";
  }
  else
  {
  typeku = buatajaxtypecode();
  //var url="INVEMAST01X.php";
  var url="INVEMAST01C-TYPE.php";
  typeku.onreadystatechange=stateChangedtypecode;
  var params = "q="+typecode;
  typeku.open("POST",url,true);
  typeku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  typeku.setRequestHeader("Content-length", params.length);
  typeku.setRequestHeader("Connection", "close");
  typeku.send(params);
  }
} 

function buatajaxtypecode()
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

function stateChangedtypecode()
{
  var data;
  if (typeku.readyState==4 && typeku.status==200)
  {
  data=typeku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbltype").innerHTML = data;
    document.getElementById("tbltype").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbltype").innerHTML = "";
    document.getElementById("tbltype").style.visibility = "hidden";
    }
  }
}

function isitypecode(outtypecode,outtypename)
{
  try 
  {
  document.getElementById("txttypename").value = outtypename;
  document.getElementById("hidtypecode").value = outtypecode;
  document.getElementById("txtunitname").focus();
  document.getElementById("tbltype").style.visibility = "hidden";
  document.getElementById("tbltype").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
  
    // ambil Kode Satuan Unit Pada saat Purchase dari tabel tbliunit

var unitku;
function ambilunitcode(unitcode)
{
  if(unitcode.length > 5)
  {
  document.getElementById("tblunit").style.visibility = "hidden";
  }
  else
  {
  unitku = buatajaxunitcode();
  //var url="INVEMAST01XX.php";
  var url="INVEMAST01C-UNIT.php";
  unitku.onreadystatechange=stateChangedunitcode;
  var params = "q="+unitcode;
  unitku.open("POST",url,true);
  unitku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  unitku.setRequestHeader("Content-length", params.length);
  unitku.setRequestHeader("Connection", "close");
  unitku.send(params);
  }
} 

function buatajaxunitcode()
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

function stateChangedunitcode()
{
  var data;
  if (unitku.readyState==4 && unitku.status==200)
  {
  data=unitku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblunit").innerHTML = data;
    document.getElementById("tblunit").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblunit").innerHTML = "";
    document.getElementById("tblunit").style.visibility = "hidden";
    }
  }
}

function isiunitcode(outunitcode,outunitname,outsubunitname)
{
  try 
  {
  document.getElementById("txtunitname").value = outunitname;
  document.getElementById("hidunitcode").value = outunitcode;
  document.getElementById("hidsubunitname").value = outsubunitname;
  document.getElementById("txtsaleunit").value = '';
  document.getElementById("txtsaleunit").focus();
  document.getElementById("tblunit").style.visibility = "hidden";
  document.getElementById("tblunit").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

    // ambil Kode Satuan Unit Pada saat Penjualan dari tabel tbliunit

var unitmu;
function ambilsaleunit(saleunit,subunit)
{
  if(saleunit.length > 5)
  {
  document.getElementById("tblunit").style.visibility = "hidden";
  }
  else
  {
  unitmu = buatajaxsaleunit();
  //var url="INVEMAST01XX.php";
  var url="INVEMAST01C-SALE-UNIT.php";
  unitmu.onreadystatechange=stateChangedsaleunit;
  var params = "q="+saleunit+"|"+subunit;
  unitmu.open("POST",url,true);
  unitmu.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  unitmu.setRequestHeader("Content-length", params.length);
  unitmu.setRequestHeader("Connection", "close");
  unitmu.send(params);
  }
} 

function buatajaxsaleunit()
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

function stateChangedsaleunit()
{
  var data;
  if (unitmu.readyState==4 && unitmu.status==200)
  {
  data=unitmu.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblunit").innerHTML = data;
    document.getElementById("tblunit").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblunit").innerHTML = "";
    document.getElementById("tblunit").style.visibility = "hidden";
    }
  }
}

function isisaleunit(outsaleunit,outunitname)
{
  try 
  {
  document.getElementById("txtsaleunit").value = outunitname;
  document.getElementById("hidsaleunit").value = outsaleunit;
  document.getElementById("txtspecname").focus();
  document.getElementById("tblunit").style.visibility = "hidden";
  document.getElementById("tblunit").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

    // ambil Kode Spec dari tabel tblispec
var specku;
function ambilspeccode(speccode)
{
  if(speccode.length > 3)
  {
  document.getElementById("tblspec").style.visibility = "hidden";
  }
  else
  {
  specku = buatajaxspeccode();
  var url="INVEMAST01C-SPEC.php";
  specku.onreadystatechange=stateChangedspeccode;
  var params = "q="+speccode;
  specku.open("POST",url,true);
  specku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  specku.setRequestHeader("Content-length", params.length);
  specku.setRequestHeader("Connection", "close");
  specku.send(params);
  }
} 

function buatajaxspeccode()
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

function stateChangedspeccode()
{
  var data;
  if (specku.readyState==4 && specku.status==200)
  {
  data=specku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblspec").innerHTML = data;
    document.getElementById("tblspec").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblspec").innerHTML = "";
    document.getElementById("tblspec").style.visibility = "hidden";
    }
  }
}

function isispeccode(outspeccode,outspecname)
{
  try 
  {
  document.getElementById("txtspecname").value = outspecname;
  document.getElementById("hidspeccode").value = outspeccode;
  document.getElementById("txtvarnname").focus();
  document.getElementById("tblspec").style.visibility = "hidden";
  document.getElementById("tblspec").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

    // ambil Kode Unit dari tabel tblivarn
var varnku;
function ambilvarncode(varncode)
{
  if(varncode.length > 3)
  {
  document.getElementById("tblvarn").style.visibility = "hidden";
  }
  else
  {
  varnku = buatajaxvarncode();
  var url="INVEMAST01C-VARN.php";
  varnku.onreadystatechange=stateChangedvarncode;
  var params = "q="+varncode;
  varnku.open("POST",url,true);
  varnku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  varnku.setRequestHeader("Content-length", params.length);
  varnku.setRequestHeader("Connection", "close");
  varnku.send(params);
  }
} 

function buatajaxvarncode()
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

function stateChangedvarncode()
{
  var data;
  if (varnku.readyState==4 && varnku.status==200)
  {
  data=varnku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblvarn").innerHTML = data;
    document.getElementById("tblvarn").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblvarn").innerHTML = "";
    document.getElementById("tblvarn").style.visibility = "hidden";
    }
  }
}

function isivarncode(outvarncode,outvarnname)
{
  try 
  {
  document.getElementById("txtvarnname").value = outvarnname;
  document.getElementById("hidvarncode").value = outvarncode;
  document.getElementById("txtvarnname").focus();
  document.getElementById("tblvarn").style.visibility = "hidden";
  document.getElementById("tblvarn").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

    // ambil Kode Unit dari tabel waremast
var housku;
function ambilhouscode(houscode)
{
  if(houscode.length > 5)
  {
  document.getElementById("tblhous").style.visibility = "hidden";
  }
  else
  {
  housku = buatajaxhouscode();
  //var url="INVEMAST01XXXXX.php";
  var url="INVEMAST01C-HOUSE.php";
  housku.onreadystatechange=stateChangedhouscode;
  var params = "q="+houscode;
  housku.open("POST",url,true);
  housku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  housku.setRequestHeader("Content-length", params.length);
  housku.setRequestHeader("Connection", "close");
  housku.send(params);
  }
} 

function buatajaxhouscode()
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

function stateChangedhouscode()
{
  var data;
  if (housku.readyState==4 && housku.status==200)
  {
  data=housku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblhous").innerHTML = data;
    document.getElementById("tblhous").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblhous").innerHTML = "";
    document.getElementById("tblhous").style.visibility = "hidden";
    }
  }
}

function isihouscode(outhouscode,outhousname)
{
  try 
  {
  document.getElementById("txthousname").value = outhousname;
  document.getElementById("hidhouscode").value = outhouscode;
  document.getElementById("txtstockmini").focus();
  document.getElementById("tblhous").style.visibility = "hidden";
  document.getElementById("tblhous").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
