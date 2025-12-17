  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TBLEDIVI03X-AKSES.php";
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
        document.getElementById('txtdivicode').focus();
        document.getElementById('txtdiviname').setAttribute('disabled','true');      
      }
      else
      {
        document.getElementById('txtdivicode').setAttribute('disabled','true');
        document.getElementById('txtdiviname').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

    var ajaxku;
  function periksadivi(divicode)
  {
    ajaxku = buatajax();
    var url="TBLEDIVI03X.php";
    url=url+"?q="+divicode;
    url=url+"&sid="+Math.random();
    ajaxku.onreadystatechange=stateChanged;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
  }

  function buatajax()
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

  function stateChanged()
  {
  var data;
  if (ajaxku.readyState==4)
    {
    data=ajaxku.responseText;
    if(data.length>3)
      { 
        var res = data.split("|");
        document.getElementById("hiddivicode").value = res[1];
        document.getElementById("txtdiviname").disabled = false;
        document.getElementById("txtdiviname").value = res[2];
      }
      else
      {
        document.getElementById("txtdiviname").disabled = true;
        document.getElementById("txtdiviname").value = '';
        document.getElementById("labelmessage").style.visibility =  "";
      }
    }
  }

