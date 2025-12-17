  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TBLACOAC01X-AKSES.php";
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
        document.getElementById('txtcoaccode').focus();
        document.getElementById('txtcoacname').setAttribute('disabled','true');      
      }
      else
      {
        document.getElementById('optparentcode').setAttribute('disabled','true');
        document.getElementById('txtcoaccode').setAttribute('disabled','true');
        document.getElementById('txtcoacname').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  


    var ajaxku;
  function periksacoac(parentcode,coaccode)
  {
    ajaxku = buatajax();
    var url="TBLACOAC01X.php";
    url=url+"?q="+parentcode+coaccode;
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
        document.getElementById("labelmessage").style.visibility = "";
        document.getElementById('txtcoacname').setAttribute('disabled','true');
      }
      else
      {
        document.getElementById("txtcoacname").removeAttribute('disabled');
        document.getElementById("txtcoacname").value = '';
        document.getElementById("labelmessage").style.visibility =  "hidden";
      }
    }
  }
