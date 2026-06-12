//// Konversi ke rupiah
function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
}
/// Konversi ke angka
function convertToAngka(rupiah) {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}

/// Konversi tanggal now to yyyy-mm-dd
/// contoh 
///    var todaynow = new Date()
///    var today = convertDate(todaynow);

function convertDate(date) {
    var yyyy = date.getFullYear().toString();
    var mm = (date.getMonth() + 1).toString();
    var dd = date.getDate().toString();

    var mmChars = mm.split('');
    var ddChars = dd.split('');

    return yyyy + '-' + (mmChars[1] ? mm : "0" + mmChars[0]) + '-' + (ddChars[1] ? dd : "0" + ddChars[0]);
}

document.addEventListener("DOMContentLoaded", function () {

    const layout = document.getElementById("layout");
    const menuBtn = document.getElementById("menuLink");

    menuBtn.addEventListener("click", function (e) {

        // cegah behaviour PureCSS lama
        e.preventDefault();
        e.stopPropagation();

        layout.classList.toggle("menu-collapsed");

    });

});
