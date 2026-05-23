// periksa akses
var aksesku;
function periksaakses(fieldid) {
  aksesku = buatajaxakses();
  var url = "TRXAPATI02X-AKSES.php";
  aksesku.onreadystatechange = stateChangedAkses;
  var params = "q=" + fieldid;
  //alert('Parameter adalah '+fieldid);
  aksesku.open("POST", url, true);
  aksesku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aksesku.setRequestHeader("Content-length", params.length);
  aksesku.setRequestHeader("Connection", "close");
  aksesku.send(params);

}

function buatajaxakses() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedAkses() {
  var data;
  if (aksesku.readyState == 4) {

    xdata = aksesku.responseText;
    data = xdata.trim();

    if (data.length > 1) {
      document.getElementById('txtexamhght').setAttribute('disabled', 'true');
      document.getElementById('txtexamwght').setAttribute('disabled', 'true');
      document.getElementById('txtexamwaist').setAttribute('disabled', 'true');
      document.getElementById('txtexambmi').setAttribute('disabled', 'true');
      document.getElementById('txtexamblod').setAttribute('disabled', 'true');
      document.getElementById('txtexamtemp').setAttribute('disabled', 'true');
      document.getElementById('txtexamrr').setAttribute('disabled', 'true');
      document.getElementById('txtexamhr').setAttribute('disabled', 'true');
      document.getElementById('txtexamcomp').setAttribute('disabled', 'true');
      ambilscreen('');
    }
    else {
      document.getElementById('txtexamhght').setAttribute('disabled', 'true');
      document.getElementById('txtexamwght').setAttribute('disabled', 'true');
      document.getElementById('txtexamwaist').setAttribute('disabled', 'true');
      document.getElementById('txtexambmi').setAttribute('disabled', 'true');
      document.getElementById('txtexamblod').setAttribute('disabled', 'true');
      document.getElementById('txtexamtemp').setAttribute('disabled', 'true');
      document.getElementById('txtexamrr').setAttribute('disabled', 'true');
      document.getElementById('txtexamhr').setAttribute('disabled', 'true');
      document.getElementById('txtexamcomp').setAttribute('disabled', 'true');
    }
  }
}
// end periksa akses  



// Input Data Posisi dari form ke Tabel trxaregi
var ajaxinput;
function input(examcode, examhght, examwght, examwaist, exambmi, examblod, examtemp, examrr, examhr, examcomp) {
  ajaxinput = buatajaxinput();
  var url = "TRXAPATI07E.php";
  ajaxinput.onreadystatechange = stateChangedInput;
  var params = "q=" + examcode + "|" + examhght + "|" + examwght + "|" + examwaist + "|" + exambmi + "|" + examblod + "|" + examtemp + "|" + examrr + "|" + examhr + "|" + examcomp;
  //alert(params);
  ajaxinput.open("POST", url, true);
  ajaxinput.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  //ajaxinput.setRequestHeader("Content-length", params.length);
  //ajaxinput.setRequestHeader("Connection", "close");
  // console.log(params);
  ajaxinput.send(params);
}

function buatajaxinput() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedInput() {
  var data;
  if (ajaxinput.readyState == 4) {

    document.getElementById('txtexamhght').setAttribute('disabled', 'true');
    document.getElementById('txtexamwght').setAttribute('disabled', 'true');
    document.getElementById('txtexamwaist').setAttribute('disabled', 'true');
    document.getElementById('txtexambmi').setAttribute('disabled', 'true');
    document.getElementById('txtexamblod').setAttribute('disabled', 'true');
    document.getElementById('txtexamtemp').setAttribute('disabled', 'true');
    document.getElementById('txtexamrr').setAttribute('disabled', 'true');
    document.getElementById('txtexamhr').setAttribute('disabled', 'true');
    document.getElementById('txtexamcomp').setAttribute('disabled', 'true');

    document.getElementById('hidexamcode').value = '';
    document.getElementById('tglregidate').value = '';
    document.getElementById('txtmainname').value = '';
    document.getElementById('txtmastcode').value = '';
    document.getElementById('txtmainbirt').value = '';
    document.getElementById('txtmaingend').value = '';

    document.getElementById('txtexamhght').value = '';
    document.getElementById('txtexamwght').value = '';
    document.getElementById('txtexamwaist').value = '';
    document.getElementById('txtexambmi').value = '';
    document.getElementById('txtexamblod').value = '';
    document.getElementById('txtexamtemp').value = '';
    document.getElementById('txtexamrr').value = '';
    document.getElementById('txtexamhr').value = '';
    document.getElementById('txtexamcomp').value = '';

    ambilscreen('');

    //}
  }
}
// Selesai Input Data Wall ke Tabel trxaregi

// Tampilkan Data Posisi  yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(outregicode) {
  try {
    ajaxview = buatajaxview();
    var url = "TRXAPATI07C.php";
    ajaxview.onreadystatechange = stateChangedView;
    var params = "q=" + outregicode;
    //alert(params);
    ajaxview.open("POST", url, true);
    ajaxview.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxview.setRequestHeader("Content-length", params.length);
    ajaxview.setRequestHeader("Connection", "close");
    ajaxview.send(params);

  }
  catch (err) { alert(err.message); }
}

function buatajaxview() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedView() {
  var data;
  if (ajaxview.readyState == 4) {
    data = ajaxview.responseText;
    if (data.length > 1) {
      //alert(data);
      //     1         2        3         4          5         6        7          8      9          10        11  
      //|$regicode|$paticode|$patiname|$patibirt|$patigend|$regidate|$regidoct|$examhght|$examwght|$examblod|$examtemp|
      var res = data.split("|");
      document.getElementById('hidexamcode').value = res[1];

      document.getElementById('tglregidate').value = res[6];

      document.getElementById('txtmainname').value = res[3];

      document.getElementById('txtmastcode').value = res[2];

      document.getElementById('txtmainbirt').value = res[4];

      if (res[5] == 'M') {
        document.getElementById('txtmaingend').value = 'Pria';
      }
      else if (res[5] == 'F') {
        document.getElementById('txtmaingend').value = 'Wanita';
      }
      else {
        document.getElementById('txtmaingend').value = 'No Gender';
      }

      document.getElementById('txtexamhght').removeAttribute('disabled');
      document.getElementById('txtexamhght').value = res[8];

      document.getElementById('txtexamwght').removeAttribute('disabled');
      document.getElementById('txtexamwght').value = res[9];

      document.getElementById('txtexamblod').removeAttribute('disabled');
      document.getElementById('txtexamblod').value = res[10];

      document.getElementById('txtexamtemp').removeAttribute('disabled');
      document.getElementById('txtexamtemp').value = res[11];

      document.getElementById('txtexamwaist').removeAttribute('disabled');
      document.getElementById('txtexamwaist').value = res[12];

      document.getElementById('txtexambmi').removeAttribute('disabled');
      document.getElementById('txtexambmi').value = res[13];

      document.getElementById('txtexamrr').removeAttribute('disabled');
      document.getElementById('txtexamrr').value = res[14];

      document.getElementById('txtexamhr').removeAttribute('disabled');
      document.getElementById('txtexamhr').value = res[15];

      document.getElementById('txtexamcomp').removeAttribute('disabled');
      document.getElementById('txtexamcomp').value = res[16];

    }
    //}
  }
}


// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(kata) {
  if (kata.length > 13) {
    document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else {
    drz = buatajaxscreen();
    var url = "TRXAPATI07V.php";
    drz.onreadystatechange = stateChangedscreen;
    var params = "q=" + kata;
    drz.open("POST", url, true);
    //beberapa http header harus kita set kalau menggunakan POST
    drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    drz.setRequestHeader("Content-length", params.length);
    drz.setRequestHeader("Connection", "close");
    drz.send(params);
  }
}

function buatajaxscreen() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedscreen() {
  var datapost;
  if (drz.readyState == 4 && drz.status == 200) {
    datapost = drz.responseText;
    if (datapost.length > 0) {
      document.getElementById("tblscreen").innerHTML = datapost;
      document.getElementById("tblscreen").style.visibility = "";
    }
    else {
      document.getElementById("tblscreen").innerHTML = "";
      document.getElementById("tblscreen").style.visibility = "hidden";
    }
  }
}

