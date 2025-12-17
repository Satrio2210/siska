  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="PASSIDEN03X-AKSES.php";
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
        document.getElementById('txtuseriden').focus();
        document.getElementById('txtusername').setAttribute('disabled','true');
        document.getElementById('txtuserpswd').setAttribute('disabled','true');      
      }
      else
      {
        document.getElementById('txtuseriden').setAttribute('disabled','true');
        document.getElementById('txtusername').setAttribute('disabled','true');
        document.getElementById('txtuserpswd').setAttribute('disabled','true');      

      }
    }
  }
// end periksa akses  

    
      var ajaxku;
  function periksaid(kodeid)
  {
    ajaxku = buatajax();
    var url="PASSIDEN03X.php";
    url=url+"?q="+kodeid;
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
        document.getElementById("txtusername").disabled = false;
        document.getElementById("txtusername").value = res[2];

        document.getElementById("txtuserpswd").disabled = false;
        document.getElementById("txtuserpswd").placeholder = res[3];

        document.getElementById("labelmessage").style.visibility =  "hidden";
      }
      else
      {
        document.getElementById("txtuseriden").value = '';

        document.getElementById("txtusername").disabled = true;
        document.getElementById("txtusername").value = '';
        
        document.getElementById("txtuserpswd").disabled = false;
        document.getElementById("txtuserpswd").placeholder = '';

        document.getElementById("labelmessage").style.visibility =  '';
      }
    }
  }

