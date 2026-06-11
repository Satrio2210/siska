// periksa akses
function periksaakses(fieldid) {
  $.post(
    "TRXADRUG01X-AKSES.php",
    { q: fieldid },
    function (data) {

      data = $.trim(data);

      if (data.length > 1) {
        ambilscreen('');
      } else {
        alert("Anda tidak memiliki hak akses");
        window.location.href = "index.php";
      }

    }
  );
}

// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(kata) {
  if (kata.length > 13) {
    document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else {
    drz = buatajaxscreen();
    var url = "TRXADRUG01V.php";
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

// function viewresep(prsccode) {
//   $.ajax({
//     type: "POST",
//     url: "TRXADRUG01-DETAIL.php",
//     data: {
//       q: prsccode
//     },
//     success: function (data) {
//       $("#resepdetail")
//         .html(data)
//         .show();

//       document
//         .getElementById("resepdetail")
//         .scrollIntoView({
//           behavior: "smooth",
//           block: "start"
//         });
//     }
//   });
// }

function viewresep(prsccode) {
  $.ajax({
    type: "POST",
    url: "TRXADRUG01-DETAIL.php",
    data: {
      q: prsccode
    },
    success: function (data) {

      $("#resepdetail").html(data).show();

      setTimeout(function () {

        window.scrollTo({
          top: $("#resepdetail").offset().top - 20,
          behavior: "smooth"
        });
      }, 100);
    }
  });
}

function editobat(prsccode, stockcode) {
  $.ajax({
    type: "POST",
    url: "TRXADRUG01-EDIT-V.php",
    data: {
      prsccode: prsccode,
      stockcode: stockcode
    },
    success: function (data) {
      var obj = JSON.parse(data);

      $("#edit_prsccode").val(obj.prsccode);
      $("#edit_stockcode").val(obj.stockcode);

      $("#edit_stockname").val(obj.stockname);
      $("#edit_qty").val(obj.qty);
      $("#edit_batch").val(obj.batch);
      $("#edit_conc").val(obj.conc);

      $("#modalEditObat").fadeIn(150);
    }
  });
}

function closemodal() {
  $("#modalEditObat").fadeOut(150);
}

function simpanobat() {
  $.ajax({
    type: "POST",
    url: "TRXADRUG01-EDIT-U.php",
    data: {

      prsccode: $("#edit_prsccode").val(),
      stockcode: $("#edit_stockcode").val(),

      qty: $("#edit_qty").val(),
      batch: $("#edit_batch").val(),
      conc: $("#edit_conc").val()

    },
    success: function (data) {
      if ($.trim(data) == "OK") {
        var prsccode = $("#edit_prsccode").val();

        closemodal();

        viewresep(prsccode);

        alert("Data berhasil disimpan");
      }
      else {
        alert(data);
      }
    }
  });
}

function hapusobat(prsccode, stockcode) {
  if (!confirm('Hapus obat ini ?')) {
    return;
  }

  $.ajax({
    type: "POST",
    url: "TRXADRUG01-HAPUS.php",
    data: {
      prsccode: prsccode,
      stockcode: stockcode
    },
    success: function (data) {
      if ($.trim(data) == "OK") {
        viewresep(prsccode);
      }
      else {
        alert(data);
      }
    }
  });
}

function siapkansemua(prsccode) {
  if (!confirm('Semua obat dalam resep ini akan ditandai SIAP. Lanjutkan ?')) {
    return;
  }

  $.ajax({
    type: "POST",
    url: "TRXADRUG01-SIAPKAN.php",
    data: {
      prsccode: prsccode
    },
    success: function (data) {
      if ($.trim(data) == "OK") {
        alert("Resep berhasil disiapkan");
        // viewresep(prsccode);
        ambilscreen('');

        $("#resepdetail").slideUp(200, function () {
          $(this).html("").hide();
        });

      }
      else {
        alert(data);
      }
    }
  });
}