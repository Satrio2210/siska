<?php
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
#screen {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#screen td, #screen th {
    border: 1px solid #ddd;
    padding: 4px;
}


#screen tr:nth-child(even){background-color: #f3f2f2;}

#screen tr:hover {background-color: #ddd;}

#screen th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}
#screen tbody, #screen thead
{
    display:block;
}
#screen tbody 
{
  overflow: auto;
  height: 200px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
        <!--<marquee style="color: red;" direction="RLEFT" scrollamount="10">-->
        <!--  *HARGA YANG TERTARA ADALAH HARGA ASLI BUKAN HARGA RESEP-->
        <!--</marquee>-->
  <th style="width: 550px;">E-RESEP</th>
  </tr>
    <thead>
        <tr>
          <th style="width: 200px">Nama Obat</th>
          <th style="width: 100px">Batch</th>
          <th style="width: 100px">Update</th>
          <th style="width: 100px">Harga/tab</th>
    </thead>
  </thead>
  <tbody>
<?php
  $rawdata = $_POST['q'];
  list($kata, $regipoli, $regipaym) = explode("|",$rawdata);

  if (strlen($kata) == 1)
  {

        if ($regipaym == 'U')
        {
          $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY, INVE_UPDT_DATE,
                    (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
                    (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC 
                    FROM investock 
                    WHERE INVE_WARE_CODE = '$gudang_farmasi' 
                    AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'ST'
                    AND INVE_STOCK_QUTY > 0
                    AND INVE_VIEW_STAT IN ('R','Y')
                    ORDER by INVE_STOCK_CODE, INVE_UPDT_DATE DESC";    

        }
        else
        {
          $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY,  INVE_UPDT_DATE,
                  (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
                  (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC 
                  FROM investock 
                  WHERE INVE_WARE_CODE = '$gudang_farmasi' 
                  AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'ST'
                  AND INVE_STOCK_QUTY > 0
                  AND INVE_VIEW_STAT IN ('R','Y')
                  AND INVE_STOCK_CODE IN (SELECT TRXA_INVE_CODE FROM trxacust WHERE TRXA_CUST_TYPE='$regipaym' AND TRXA_VIEW_STAT='Y')
                  ORDER by INVE_STOCK_CODE, INVE_UPDT_DATE DESC";    
        }

  }
  else
  {
        if ($regipaym == 'U')
        {
          $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY,  INVE_UPDT_DATE,
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC   
              FROM investock 
              WHERE INVE_STOCK_NAME LIKE '$kata%'
              AND INVE_WARE_CODE = '$gudang_farmasi'
              AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'ST'
              AND INVE_STOCK_QUTY > 0  
              AND INVE_VIEW_STAT IN ('R','Y')
              ORDER by INVE_STOCK_CODE, INVE_UPDT_DATE DESC";        

        }
        else
        {
          $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY,  INVE_UPDT_DATE,
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC   
              FROM investock 
              WHERE INVE_STOCK_NAME LIKE '$kata%'
              AND INVE_WARE_CODE = '$gudang_farmasi'
              AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'ST'
              AND INVE_STOCK_QUTY > 0  
              AND INVE_VIEW_STAT IN ('R','Y')
              -- AND INVE_STOCK_CODE IN (SELECT TRXA_INVE_CODE FROM trxacust WHERE TRXA_CUST_TYPE='$regipaym' AND TRXA_VIEW_STAT='Y')
              ORDER by INVE_STOCK_CODE, INVE_UPDT_DATE DESC";        

        }  

  }


$q = $db->query($xquery) or die("Gagal ambil item Obat !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outstockcode = $k['INVE_STOCK_CODE'];
  $outstockbtch = $k['INVE_STOCK_BTCH'];
  $outstockname = $k['INVE_STOCK_NAME'];
  $outstockpric = $k['INVE_STOCK_PRIC'];
  $outstockquty = $k['INVE_STOCK_QUTY'];

$xprice = round($k['INVE_STOCK_PRIC']);
$xint = (int)$xprice;

$price = $xint;
$sub_total = ($price * $profit) * 1.30;

$finaltotal = pembulatan($sub_total);

$viewprice = number_format(pembulatan($price), 0, '', '.');
$viewtotal = number_format($sub_total, 0, '', '.');


echo '<tr>';
    echo '<td style="width: 200px;" onClick="isiresep(\''.$outstockcode.'\',\''.$outstockbtch.'\',\''.$outstockname.'\',\''.$outstockpric.'\',\''.$outstockquty.'\');" style="cursor:pointer">'.$k['INVE_STOCK_NAME'].' | '.$k['NAME_SPEC'].'</td>';
    echo '<td style="width: 100px;" onClick="isiresep(\''.$outstockcode.'\',\''.$outstockbtch.'\',\''.$outstockname.'\',\''.$outstockpric.'\',\''.$outstockquty.'\');" style="cursor:pointer">'.$k['INVE_STOCK_BTCH'].'</td>';
    echo '<td style="width: 100px;" onClick="isiresep(\''.$outstockcode.'\',\''.$outstockbtch.'\',\''.$outstockname.'\',\''.$outstockpric.'\',\''.$outstockquty.'\');" style="cursor:pointer">'.$k['INVE_UPDT_DATE'].'</td>';
    echo '<td style="width: 100px;" onClick="isiresep(\''.$outstockcode.'\',\''.$outstockbtch.'\',\''.$outstockname.'\',\''.$outstockpric.'\',\''.$outstockquty.'\');" style="cursor:pointer">Rp. '.$viewtotal.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


