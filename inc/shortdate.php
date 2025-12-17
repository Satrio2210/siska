<?php
function formatTanggal($date=null)
{
//buat array nama hari dalam bahasa Indonesia dengan urutan 1-7
$array_hari = array(1=>'Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
//buat array nama bulan dalam bahasa Indonesia dengan urutan 1-12
$array_bulan = array(1=>'Jan','Feb','Mar', 'Apr', 'Mei', 'Jun','Jul','Agu',
'Sep','Okt', 'Nov','Des');
if($date == null) {
//jika $date kosong, makan tanggal yang diformat adalah tanggal hari ini
$hari = $array_hari[date('N')];
$tanggal = date ('j');
$bulan = $array_bulan[date('n')];
$tahun = date('Y');
} else {
//jika $date diisi, makan tanggal yang diformat adalah tanggal tersebut
$date = strtotime($date);
$hari = $array_hari[date('N',$date)];
$tanggal = date ('j', $date);
$bulan = $array_bulan[date('n',$date)];
$tahun = date('Y',$date);
}
//$formatTanggal = $hari . ", " . $tanggal ." ". $bulan ." ". $tahun;
$formatTanggal = $tanggal ." ". $bulan ." ". $tahun;

return $formatTanggal;
}
 

?>