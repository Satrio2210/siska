<?php
function pembulatan($uang)
{
 $ratusan = substr($uang, -2);
 if($ratusan<50)
 $akhir = $uang - $ratusan;
 else
 $akhir = $uang + (100-$ratusan);
 echo number_format($akhir, 2, ',', '.');;
}
$uang = 1913;
echo $uang;
echo '<br>';

pembulatan($uang); // hasilnya adalah 134.000,00
//kalau tanpa pembulatan
echo '<br>';
echo number_format($uang, 2, ',', '.'); // hasilnya 133.500,00
?>