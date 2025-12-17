  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="REPOACCT03X-AKSES.php";
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
        document.getElementById('tglstartdate').focus();
      }
      else
      {
        document.getElementById('tglstartdate').setAttribute('disabled','true');
        document.getElementById('tglenddate').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


	// Tampilkan Tabel Report
var drz;
function ambilviewrepo(startdate,enddate)
{
  //if(kata.length > 13)
  //{
  //document.getElementById("tblviewrepo").style.visibility = "hidden";
  //}
  //else
  //{
  drz = buatajaxviewrepo();
  var url="REPOACCT03V.php";
  drz.onreadystatechange=stateChangedviewrepo;
  var params = "q="+startdate+"|"+enddate;
  //alert(params);
  drz.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  //}
} 

  function buatajaxviewrepo()
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

function stateChangedviewrepo()
{
  var datapost;
  if (drz.readyState==4 && drz.status==200)
  {
  datapost=drz.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tblviewrepo").innerHTML = datapost;
    document.getElementById("tblviewrepo").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblviewrepo").innerHTML = "";
    document.getElementById("tblviewrepo").style.visibility = "hidden";
    }
  }
}

