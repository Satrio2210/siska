  var ajaxku;
  function periksaid(kodeid,kodepass)
  {
    ajaxku = buatajax();
    var url="signx.php";
    url=url+"?q="+kodeid;
    url=url+"&r="+kodepass;
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
      //alert(data);  
      //  var res = data.split("|");   
        document.getElementById("labelmessage").style.visibility = "hidden";
        document.formlogin.submit();
      }
      else
      {
        //alert('No Data');
        document.getElementById("userid").value = '';
        document.getElementById("pass").value = '';
        document.getElementById("userid").focus();
        document.getElementById("labelmessage").style.visibility =  "";
      }
    }
  }
