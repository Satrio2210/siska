// Request push Notification permission
if (window.Notification && Notification.permission !== "granted" && Notification.permission !== "denied") {
  Notification.requestPermission();
}

var lastExamCode = '';
var notifku;

// periksa akses
var aksesku;
function periksaakses(fieldid) {
  aksesku = buatajaxakses();
  var url = "TRXADRUG01X-AKSES.php";
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

      document.getElementById('txtstockcode').setAttribute('disabled', 'true');
      document.getElementById('txtstockquty').setAttribute('disabled', 'true');
      document.getElementById('txtsigna').setAttribute('disabled', 'true');
      // document.getElementById('txtusage').setAttribute('disabled','true');
      //var dokter = document.getElementById('hidprscdoct').value;
      ambilregicode('X');

    }
    else {
      document.getElementById('txtsearch').setAttribute('disabled', 'true');
      document.getElementById('txtstockcode').setAttribute('disabled', 'true');
      document.getElementById('txtstockquty').setAttribute('disabled', 'true');
      document.getElementById('txtsigna').setAttribute('disabled', 'true');
      // document.getElementById('txtusage').setAttribute('disabled','true');


    }
  }
}
// end periksa akses  

// ambil data pendaftaran
var regiku;
function ambilregicode(kata) {
  if (kata.length > 20) {
    return;
    // document.getElementById("tblregi").innerHTML = "";
    // document.getElementById("tblregi").style.visibility = "hidden";
  }
  else {
    regiku = buatajaxregi();
    //var url="TRXAPOLI04C-REGI.php";
    var url = "TRXADRUG00C-REGI.php";
    regiku.onreadystatechange = stateChangedregi;
    var params = "q=" + kata;
    regiku.open("POST", url, true);
    regiku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    regiku.setRequestHeader("Content-length", params.length);
    regiku.setRequestHeader("Connection", "close");
    regiku.send(params);
  }
}

function buatajaxregi() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

// function stateChangedregi() {
//   var data;
//   if (regiku.readyState == 4 && regiku.status == 200) {
//     data = regiku.responseText;

//     if (data.length > 3) {
//       document.getElementById("tblregi").innerHTML = data;
//       // document.getElementById("tblregi").style.visibility = "";
//     }
//     else {
//       document.getElementById("tblregi").innerHTML = "";
//       // document.getElementById("tblregi").style.visibility = "hidden";
//     }
//   }
// }

function stateChangedregi() {
  if (regiku.readyState == 4 && regiku.status == 200) {
    var data = regiku.responseText;

    document.getElementById("tblregi").innerHTML = data;
  }
}

function isiregi(outprsccode, outpaticode, outmainname, outmaingend, outmainage, outregipaym, outpaymcode, outregipoli, outexamprsc, outexamdiag) {
  try {
    document.getElementById("txtprsccode").value = outprsccode;
    document.getElementById("txtpaticode").value = outpaticode;
    document.getElementById("txtmainname").value = outmainname;
    document.getElementById("txtmaingend").value = outmaingend;
    document.getElementById("txtmainage").value = outmainage;
    document.getElementById("txtregipaym").value = outregipaym;
    document.getElementById("hidregipaym").value = outpaymcode;
    document.getElementById("hidmediroom").value = outregipoli;
    document.getElementById("txtexamprsc").value = outexamprsc;
    document.getElementById("txtexamdiag").value = outexamdiag;

    ambilscreen(outprsccode);

    // Inisialisasi racikan
    try {
      loadRacikanHead();
      document.getElementById('section_racik_detail').style.display = 'none';
      document.getElementById('hidselectedracikid').value = '';
      document.getElementById('lblSelectedRacik').innerHTML = 'Racikan Terpilih: -';
    } catch(e) {}

    document.getElementById("txtstockcode").removeAttribute('disabled');
    document.getElementById("txtstockquty").removeAttribute('disabled');

    document.getElementById("txtsigna").removeAttribute('disabled');
    //   document.getElementById("txtusage").removeAttribute('disabled');

    document.getElementById("txtsearch").value = '';

    document.getElementById("txtstockcode").focus();
    document.getElementById("inputresep").scrollIntoView({
      behavior: "smooth",
      block: "start"
    });
    // document.getElementById("tblregi").style.visibility = "hidden";
    // document.getElementById("tblregi").innerHTML = "";

  }
  catch (err) { alert(err.message); }
}

// ambil List Resep

var resepku;
function ambilresep(kata, regipoli, regipaym) {
  resepku = buatajaxresep();
  var url = "TRXADRUG00C-RESEP.php";
  resepku.onreadystatechange = stateChangedResep;
  var params = "q=" + kata + "|" + regipoli + "|" + regipaym;
  resepku.open("POST", url, true);
  resepku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  resepku.setRequestHeader("Content-length", params.length);
  resepku.setRequestHeader("Connection", "close");
  resepku.send(params);
}

function buatajaxresep() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedResep() {
  var data;
  if (resepku.readyState == 4 && resepku.status == 200) {
    data = resepku.responseText;
    if (data.length > 3) {
      document.getElementById("tblresep").innerHTML = data;
      document.getElementById("tblresep").style.display = "block";
    }
    else {
      document.getElementById("tblresep").innerHTML = "";
      document.getElementById("tblresep").style.display = "none";
    }
  }
}

function isiresep(outstockcode, outstockbtch, outstockname, outstockpric, outstockamnt) {
  try {

    document.getElementById("txtstockcode").value = outstockname;

    document.getElementById("hidstockcode").value = outstockcode;

    document.getElementById("hidstockbtch").value = outstockbtch;

    document.getElementById("hidstockpric").value = outstockpric;

    document.getElementById("hidstockamnt").value = outstockamnt;

    document.getElementById("txtstockquty").focus();
    document.getElementById("tblresep").style.display = "block";
    document.getElementById("tblresep").innerHTML = "";

  }
  catch (err) { alert(err.message); }
}

// isi data signa
var signaku;
function ambilsignacode(kata) {
  if (kata.length > 30) {
    document.getElementById("tblsigna").innerHTML = "";
    document.getElementById("tblsigna").style.display = "none";
  }
  else {
    signaku = buatajaxsigna();
    //var url="TRXAPOLI04C-SIGNA.php";
    var url = "TRXADRUG00C-SIGNA.php";
    signaku.onreadystatechange = stateChangedsigna;
    var params = "q=" + kata;
    signaku.open("POST", url, true);
    signaku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    signaku.setRequestHeader("Content-length", params.length);
    signaku.setRequestHeader("Connection", "close");
    signaku.send(params);
  }
}

function buatajaxsigna() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedsigna() {
  var data;
  if (signaku.readyState == 4 && signaku.status == 200) {
    data = signaku.responseText;

    if (data.length > 3) {
      document.getElementById("tblsigna").innerHTML = data;
      document.getElementById("tblsigna").style.display = "block";
    }
    else {
      document.getElementById("tblsigna").innerHTML = "";
      document.getElementById("tblsigna").style.display = "none";
    }
  }
}

function isisigna(outsgnacode, outsgnaname, outsgnausag) {
  try {
    document.getElementById("txtsigna").value = outsgnaname;

    document.getElementById("hidsigna").value = outsgnacode;

    document.getElementById("txtusage").value = outsgnausag;


    document.getElementById("txtsigna").removeAttribute('disabled');

    document.getElementById("txtsearch").value = '';

    //   document.getElementById("txtusage").focus();
    document.getElementById("tblsigna").style.display = "none";
    document.getElementById("tblsigna").innerHTML = "";

  }
  catch (err) { alert(err.message); }
}


// Input Data Posisi dari form ke Tabel 
//  inprsccode,inprscdoct,instockcode,instockbtch,instockpric,instockquty,inprscconc, inprscsgna, inprscusag, inmediroom
var ajaxinput;
function input(prsccode, prscdoct, stockcode, stockbtch, stockpric, stockquty, prscconc, prscsgna, mediroom, sgnausag) {
  ajaxinput = buatajaxinput();
  //var url="TRXAPOLI04E.php";
  var url = "TRXADRUG00E.php";
  ajaxinput.onreadystatechange = stateChangedInput;
  var params = "q=" + prsccode + "|" + prscdoct + "|" + stockcode + "|" + stockbtch + "|" + stockpric + "|" + stockquty + "|" + prscconc + "|" + prscsgna + "|" + mediroom + "|" + sgnausag;
  //alert(params);
  ajaxinput.open("POST", url, true);
  ajaxinput.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  //ajaxinput.setRequestHeader("Content-length", params.length);
  //ajaxinput.setRequestHeader("Connection", "close");
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
  if (ajaxinput.readyState == 4) {

    document.getElementById('txtstockcode').value = '';
    document.getElementById('hidstockcode').value = '';
    document.getElementById('hidstockpric').value = '';
    document.getElementById('hidstockamnt').value = '';
    document.getElementById('txtstockquty').value = '1';

    document.getElementById('txtsigna').value = '';
    document.getElementById('hidsigna').value = '';

    // document.getElementById('txtusage').value = '';


    var prsccode = document.getElementById('txtprsccode').value;
    ambilscreen(prsccode);

    document.getElementById('txtstockcode').focus();

    //}
  }
}
// Selesai Input Data

// Tampilkan Data Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(tretcode, paticode) {
  try {
    ajaxview = buatajaxview();
    var url = "TRXAPOLI01C.php";
    ajaxview.onreadystatechange = stateChangedView;
    var params = "q=" + regicode + "|" + paticode;
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
      //      1        2          3       4        5         6        7        8         9         10       11
      //|$regicode|$paticode|$mainname|$fullage|$gender|$regipaym|$examhght|$examwght|$examblod|$examanam|$examdiag|

      var res = data.split("|");
      document.getElementById("txtexamcode").value = res[1];

      document.getElementById("txtpaticode").value = res[2];

      document.getElementById("txtmainname").value = res[3];

      document.getElementById("txtmaingend").value = res[5];

      document.getElementById("txtmainage").value = res[4];

      document.getElementById("txtregipaym").value = res[6];

      document.getElementById("txtexamhght").removeAttribute('disabled');
      document.getElementById("txtexamhght").value = res[7];

      document.getElementById("txtexamwght").removeAttribute('disabled');
      document.getElementById("txtexamwght").value = res[8];

      document.getElementById("txtexamblod").removeAttribute('disabled');
      document.getElementById("txtexamblod").value = res[9];

      document.getElementById("txtexamanam").removeAttribute('disabled');
      document.getElementById("txtexamanam").value = res[10];

      document.getElementById("txtexamdiag").removeAttribute('disabled');
      document.getElementById("txtexamdiag").value = res[11];

      document.getElementById("txtexamhght").focus();

    }
    //}
  }
}



// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(prsccode) {
  if (prsccode.length > 14) {
    document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else {
    drz = buatajaxscreen();
    //var url="TRXAPOLI04V.php";
    var url = "TRXADRUG00V.php";
    drz.onreadystatechange = stateChangedscreen;
    var params = "q=" + prsccode;
    //alert(params);

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


// Hapus 
var ajaxhapus;
function hapuscode(prsccode, stockcode) {
  ajaxhapus = buatajaxhapus();
  //var url="TRXAPOLI04D.php";
  var url = "TRXADRUG00D.php";
  ajaxhapus.onreadystatechange = stateChangedhapus;
  var params = "q=" + prsccode + "|" + stockcode;
  //alert(params);
  ajaxhapus.open("POST", url, true);
  ajaxhapus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajaxhapus.setRequestHeader("Content-length", params.length);
  ajaxhapus.setRequestHeader("Connection", "close");
  ajaxhapus.send(params);
}

function buatajaxhapus() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedhapus() {
  var data;
  if (ajaxhapus.readyState == 4) {
    var inprsccode = document.getElementById('txtprsccode').value;
    ambilscreen(inprsccode);
    document.getElementById('txtstockcode').focus();
  }
}
// Selesai hapus Data 

// Cek Resep baru untuk notif
function cekResepBaru() {
  console.log('CEK NOTIF JALAN');
  notifku = new XMLHttpRequest();

  notifku.onreadystatechange = function () {

    if (notifku.readyState == 4 &&
      notifku.status == 200) {

      var examCode =
        notifku.responseText.trim();

      console.log(
        'Resep Baru : ' + examCode
      );

      if (lastExamCode != '') {

        if (examCode != '' &&
          examCode != lastExamCode) {

          playNotif();

          // Push Notification ke Windows Desktop
          if (window.Notification && Notification.permission === "granted") {
            try {
              var parts = examCode.split("|");
              var regCode = parts[0] || "";
              var patientName = parts[1] || "Pasien";
              
              var options = {
                body: "Ada resep dokter baru masuk untuk pasien:\n" + patientName + " (" + regCode + ")",
                icon: "img/icon.png",
                tag: "resep-baru-" + regCode,
                requireInteraction: true // Notif tetap tampil di layar windows sampai diklik
              };
              var notif = new Notification("SISKA - Resep Baru Masuk!", options);
              notif.onclick = function() {
                window.focus();
                try {
                  ambilregicode('X');
                } catch(err){}
                notif.close();
              };
            } catch(e) {
              console.log("Gagal memunculkan push notification: " + e.message);
            }
          }

          ambilregicode('X');
        }
      }

      lastExamCode = examCode;
    }
  };

  notifku.open(
    "POST",
    "TRXADRUG00C-NOTIF.php",
    true
  );

  notifku.send();
}

setInterval(
  cekResepBaru,
  2000
);






/* =========================================================================
   LAJU BARU: LOGIC UNTUK FORM INPUT RESEP RACIKAN
   ========================================================================= */

// Autocomplete Signa Racikan
var signaku_racik;
function ambilsignacode_racik(kata) {
  if (kata.length > 30) {
    document.getElementById("tblsigna_racik").innerHTML = "";
    document.getElementById("tblsigna_racik").style.display = "none";
  } else {
    signaku_racik = buatajaxsigna_racik();
    var url = "TRXADRUG00C-SIGNA-RACIK.php";
    signaku_racik.onreadystatechange = stateChangedsigna_racik;
    var params = "q=" + kata;
    signaku_racik.open("POST", url, true);
    signaku_racik.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    signaku_racik.setRequestHeader("Content-length", params.length);
    signaku_racik.setRequestHeader("Connection", "close");
    signaku_racik.send(params);
  }
}

function buatajaxsigna_racik() {
  if (window.XMLHttpRequest) return new XMLHttpRequest();
  if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
  return null;
}

function stateChangedsigna_racik() {
  if (signaku_racik.readyState == 4 && signaku_racik.status == 200) {
    var data = signaku_racik.responseText;
    if (data.length > 3) {
      // Perbaiki pemanggilan javascript dengan unescape kutipan jika ada
      data = data.split('isisigna_racik(\'').join('isisigna_racik_clean(\'');
      document.getElementById("tblsigna_racik").innerHTML = data;
      document.getElementById("tblsigna_racik").style.display = "block";
    } else {
      document.getElementById("tblsigna_racik").innerHTML = "";
      document.getElementById("tblsigna_racik").style.display = "none";
    }
  }
}

// Fungsi pembantu agar pemanggilan string aman
function isisigna_racik_clean(code, name, usag) {
  isisigna_racik(code, name, usag);
}

function isisigna_racik(outsgnacode, outsgnaname, outsgnausag) {
  try {
    document.getElementById("txtraciksigna").value = outsgnaname;
    document.getElementById("hidraciksignacode").value = outsgnacode;
    document.getElementById("hidracikusage").value = outsgnausag;
    document.getElementById("tblsigna_racik").style.display = "none";
    document.getElementById("tblsigna_racik").innerHTML = "";
  } catch (err) { alert(err.message); }
}

// Autocomplete Obat Racikan Compositions
var resepku_racik;
function ambilresep_racik(kata, regipoli, regipaym) {
  resepku_racik = buatajaxresep_racik();
  var url = "TRXADRUG00C-RESEP-RACIK.php";
  resepku_racik.onreadystatechange = stateChangedResep_racik;
  var params = "q=" + kata + "|" + regipoli + "|" + regipaym;
  resepku_racik.open("POST", url, true);
  resepku_racik.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  resepku_racik.setRequestHeader("Content-length", params.length);
  resepku_racik.setRequestHeader("Connection", "close");
  resepku_racik.send(params);
}

function buatajaxresep_racik() {
  if (window.XMLHttpRequest) return new XMLHttpRequest();
  if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
  return null;
}

function stateChangedResep_racik() {
  if (resepku_racik.readyState == 4 && resepku_racik.status == 200) {
    var data = resepku_racik.responseText;
    if (data.length > 3) {
      document.getElementById("tblresep_racik").innerHTML = data;
      document.getElementById("tblresep_racik").style.display = "block";
    } else {
      document.getElementById("tblresep_racik").innerHTML = "";
      document.getElementById("tblresep_racik").style.display = "none";
    }
  }
}

function isiresep_racik(outstockcode, outstockbtch, outstockname, outstockpric, outstockamnt) {
  try {
    document.getElementById("txtracikstockname").value = outstockname;
    document.getElementById("hidracikstockcode").value = outstockcode;
    document.getElementById("hidracikstockbtch").value = outstockbtch;
    document.getElementById("hidracikstockpric").value = outstockpric;
    document.getElementById("hidracikstockamnt").value = outstockamnt;
    document.getElementById("tblresep_racik").style.display = "none";
    document.getElementById("tblresep_racik").innerHTML = "";
    document.getElementById("txtracikstockqty").focus();
  } catch (err) { alert(err.message); }
}

// Logic load list kepala racikan
function loadRacikanHead() {
  var prsccode = document.getElementById("txtprsccode").value;
  if (prsccode == "") return;
  
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "TRXADRUG00_RACIK.php?action=tmpl_head", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementById("tblracikhead").innerHTML = xhr.responseText;
    }
  };
  xhr.send("prsccode=" + prsccode);
}

// Logic add kepala racikan
function tambahRacikanHead() {
  var prsccode = document.getElementById("txtprsccode").value;
  var nama = document.getElementById("txtracikname").value;
  var signa = document.getElementById("txtraciksigna").value;
  var qty = document.getElementById("txtracikqty").value;
  
  if (prsccode == "") {
    swal({ title: "Gagal", text: "Pilih pasien terlebih dahulu", icon: "warning" });
    return;
  }
  if (nama == "") {
    swal({ title: "Gagal", text: "Nama racikan wajib diisi", icon: "warning" });
    return;
  }
  
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "TRXADRUG00_RACIK.php?action=add_head", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var res = xhr.responseText.split("|");
      if (res[0] === "OK") {
        document.getElementById("txtracikname").value = "";
        document.getElementById("txtraciksigna").value = "";
        document.getElementById("hidraciksignacode").value = "";
        document.getElementById("hidracikusage").value = "";
        document.getElementById("txtracikqty").value = "1";
        
        loadRacikanHead();
        
        // Otomatis select racikan yang baru dibuat
        var newId = res[1];
        setTimeout(function() {
          selectRacikanRow(newId, nama);
        }, 300);
      } else {
        alert(xhr.responseText);
      }
    }
  };
  var params = "prsccode=" + prsccode + "&nama=" + encodeURIComponent(nama) + "&signa=" + encodeURIComponent(signa) + "&qty=" + qty;
  xhr.send(params);
}

// Logic hapus kepala racikan
function hapusRacikan(id) {
  if (!confirm("Hapus racikan beserta seluruh obat di dalamnya?")) return;
  
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "TRXADRUG00_RACIK.php?action=del_head", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      if (xhr.responseText.trim() === "OK") {
        // Reset selection if the deleted one was selected
        var curSelected = document.getElementById("hidselectedracikid").value;
        if (curSelected == id) {
          document.getElementById("section_racik_detail").style.display = "none";
          document.getElementById("hidselectedracikid").value = "";
          document.getElementById("lblSelectedRacik").innerHTML = "Racikan Terpilih: -";
        }
        loadRacikanHead();
        var prsccode = document.getElementById("txtprsccode").value;
        ambilscreen(prsccode); // Refresh list resep total
      } else {
        alert(xhr.responseText);
      }
    }
  };
  xhr.send("id=" + id);
}

// Logic pilih kepala racikan
function selectRacikanRow(id, nama) {
  // Remove active class from all rows
  var rows = document.querySelectorAll(".tbl-racik tbody tr");
  rows.forEach(function(r) {
    r.classList.remove("active-row");
  });
  
  var activeRow = document.getElementById("row_racik_" + id);
  if (activeRow) {
    activeRow.classList.add("active-row");
  }
  
  document.getElementById("hidselectedracikid").value = id;
  document.getElementById("lblSelectedRacik").innerHTML = "Racikan Terpilih: " + nama;
  document.getElementById("section_racik_detail").style.display = "block";
  
  loadRacikanDetail(id);
}

// Logic load obat-obat racikan
function loadRacikanDetail(id) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "TRXADRUG00_RACIK.php?action=tmpl_detail", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementById("tblracikdetail").innerHTML = xhr.responseText;
    }
  };
  xhr.send("racik_id=" + id);
}

// Logic add obat ke racikan
function tambahObatKeRacikan() {
  var prsccode = document.getElementById("txtprsccode").value;
  var racik_id = document.getElementById("hidselectedracikid").value;
  
  var stockcode = document.getElementById("hidracikstockcode").value;
  var stockname = document.getElementById("txtracikstockname").value;
  var stockbtch = document.getElementById("hidracikstockbtch").value;
  var stockpric = document.getElementById("hidracikstockpric").value;
  var qty = document.getElementById("txtracikstockqty").value;
  var tersedia = parseInt(document.getElementById("hidracikstockamnt").value || 0);
  
  if (prsccode == "" || racik_id == "") {
    swal({ title: "Gagal", text: "Pilih racikan terlebih dahulu", icon: "warning" });
    return;
  }
  if (stockcode == "" || stockname == "") {
    swal({ title: "Gagal", text: "Pilih obat terlebih dahulu", icon: "warning" });
    return;
  }
  if (parseInt(qty) <= 0 || qty == "") {
    swal({ title: "Gagal", text: "Qty obat tidak valid", icon: "warning" });
    return;
  }
  if (parseInt(qty) > tersedia) {
    swal({ title: "Stok Kurang", text: "Stok obat hanya tersedia " + tersedia, icon: "warning" });
    return;
  }
  
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "TRXADRUG00_RACIK.php?action=add_detail", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      if (xhr.responseText.trim() === "OK") {
        // Reset input fields
        document.getElementById("txtracikstockname").value = "";
        document.getElementById("hidracikstockcode").value = "";
        document.getElementById("hidracikstockbtch").value = "";
        document.getElementById("hidracikstockpric").value = "";
        document.getElementById("txtracikstockqty").value = "1";
        
        loadRacikanDetail(racik_id);
        ambilscreen(prsccode); // Refresh list resep total
      } else {
        alert(xhr.responseText);
      }
    }
  };
  var params = "prsccode=" + prsccode + "&racik_id=" + racik_id + "&stockcode=" + stockcode + "&stockbtch=" + stockbtch + "&stockpric=" + stockpric + "&stockqty=" + qty;
  xhr.send(params);
}

// Logic hapus obat dari racikan
function hapusObatKomposisi(prsccode, stockcode) {
  var racik_id = document.getElementById("hidselectedracikid").value;
  if (racik_id == "") return;
  if (!confirm("Hapus obat ini dari racikan?")) return;
  
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "TRXADRUG00_RACIK.php?action=del_detail", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      if (xhr.responseText.trim() === "OK") {
        loadRacikanDetail(racik_id);
        ambilscreen(prsccode); // Refresh list resep total
      } else {
        alert(xhr.responseText);
      }
    }
  };
  var params = "prsccode=" + prsccode + "&stockcode=" + stockcode + "&racik_id=" + racik_id;
  xhr.send(params);
}



