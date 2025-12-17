<?php

//data awal
$tgl_mulai='2021-12-01';
$tgl_selesai='2021-12-01';
 
//convert
$timeStart = strtotime($tgl_mulai);
$timeEnd = strtotime($tgl_selesai);
 
// Menambah bulan ini + semua bulan pada tahun sebelumnya
$numBulan = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
 
// hitung selisih bulan
$numBulan += date("m",$timeEnd)-date("m",$timeStart);

if ($numBulan == 1)
{
	echo "Expired";
	echo "<br>";	
	echo $numBulan;	
} 
else if ($numBulan > 1)
{
	if ($numBulan <= 6)
	{
	echo "Waspada";
	echo "<br>";
	echo $numBulan;		
	}
	else
	{
	echo "Aman";
	echo "<br>";
	echo $numBulan;		
	}
}
else
{
	echo "No Data";
	echo "<br>";
	echo $numBulan;
}


?>