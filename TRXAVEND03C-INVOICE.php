<?php
include "conf/config.php";
include 'inc/sanie.php';
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
  <th style="width: 100px;">INVOICE</th>
  <th style="width: 100px;">PO</th>  
  <th style="width: 100px;">DUED DATE</th>
  <th style="width: 150px;">OUTSTANDING</th>
  </tr>
  </thead>
  <tbody>
<?php
  //$rawinput = xss_clean($_POST['q']);
  //$rawinput = 'i|VE-0003';
  //list($kata, $suplcode) = explode("|",$rawinput);
  $kata = xss_clean($_POST['q']);

  if (strlen($kata) == 1)
  {

  $xxxquery = "SELECT TRXA_VEND_CODE, TRXA_VEND_DATE, TRXA_SUPL_CODE,
            (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,
            TRXA_PROC_VATX, TRXA_DOWN_PAID, TRXA_REMA_PAID, TRXA_INVC_CODE, TRXA_DUED_DATE
            FROM trxavend 
            WHERE TRXA_VEND_STAT = 'A'
            AND TRXA_VIEW_STAT = 'Y'
            ORDER BY TRXA_VEND_DATE DESC, TRXA_ENTR_TIME DESC";

  $xquery = "SELECT TRXA_VEND_CODE, TRXA_VEND_DATE, TRXA_PROC_CODE, TRXA_SUPL_CODE,
            (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,
            TRXA_PROC_VATX, TRXA_DOWN_PAID, TRXA_REMA_PAID, TRXA_INVC_CODE, TRXA_DUED_DATE,
            (SELECT ITEM_SUMM_AMNT FROM itemvend WHERE ITEM_VEND_CODE=TRXA_VEND_CODE ORDER BY ITEM_ENTR_DATE DESC, ITEM_ENTR_TIME DESC LIMIT 1) AS OUTSTANDING
            FROM trxavend 
            WHERE TRXA_VEND_STAT = 'A'
            AND TRXA_VIEW_STAT = 'Y'
            ORDER BY TRXA_VEND_DATE DESC, TRXA_ENTR_TIME DESC"; 
  }
  else
  {
  $xquery = "SELECT TRXA_VEND_CODE, TRXA_VEND_DATE, TRXA_SUPL_CODE,
            (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,
            TRXA_PROC_VATX, TRXA_DOWN_PAID, TRXA_REMA_PAID, TRXA_INVC_CODE, TRXA_DUED_DATE,
            (SELECT ITEM_SUMM_AMNT FROM itemvend WHERE ITEM_VEND_CODE=TRXA_VEND_CODE ORDER BY ITEM_ENTR_DATE DESC, ITEM_ENTR_TIME DESC LIMIT 1) AS OUTSTANDING
            FROM trxavend 
            WHERE TRXA_INVC_CODE LIKE '$kata%' 
            AND TRXA_VEND_STAT = 'A'
            AND TRXA_VIEW_STAT = 'Y'
            ORDER BY TRXA_VEND_DATE DESC, TRXA_ENTR_TIME DESC";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outvendcode = $k['TRXA_VEND_CODE'];
  $outvenddate = $k['TRXA_VEND_DATE'];
  $outproccode = $k['TRXA_PROC_CODE'];
  $outsuplcode = $k['TRXA_SUPL_CODE'];
  $outsuplname = $k['SUPL_NAME'];
  $outinvccode = $k['TRXA_INVC_CODE'];
  $outdueddate = $k['TRXA_DUED_DATE'];
  $outstanding = $k['OUTSTANDING'];


  if ($k['TRXA_PROC_VATX'] == 'E') 
  {
    $dpp = ($k['TRXA_DOWN_PAID'] + $k['TRXA_REMA_PAID']);
    $ppn = (($dpp * 10) /100);
    $amount = (($dpp + $ppn) - $k['TRXA_DOWN_PAID']);  
  }
  else if ($k['TRXA_PROC_VATX'] == 'I')
  {
    $dpp = (($k['TRXA_DOWN_PAID'] + $k['TRXA_REMA_PAID']) * (100/110));
    $ppn = (($dpp * 10) /100);
    $amount = (($dpp + $ppn) - $k['TRXA_DOWN_PAID']);  
  }
  else
  {
    $amount = $k['TRXA_REMA_PAID'];
  }

  if(isset($k['OUTSTANDING']) && ($k['OUTSTANDING'] != '')) 
  {
    $view_amount = number_format($outstanding, 0, '', '.');
  }
  else
  {
    $view_amount = number_format($amount, 0, '', '.');     
  }

    

echo '<tr>';

echo '<td style="width: 100px;" onClick="isiinvccode(\''.$outvendcode.'\',\''.$outvenddate.'\',\''.$outsuplcode.'\',\''.$outsuplname.'\',\''.$outinvccode.'\',\''.$outdueddate.'\',\''.$view_amount.'\');" 
      style="cursor:pointer">'.$k['TRXA_INVC_CODE'].'</td>';

echo '<td style="width: 100px;" onClick="isiinvccode(\''.$outvendcode.'\',\''.$outvenddate.'\',\''.$outsuplcode.'\',\''.$outsuplname.'\',\''.$outinvccode.'\',\''.$outdueddate.'\',\''.$view_amount.'\');" 
      style="cursor:pointer">'.$k['TRXA_PROC_CODE'].'</td>';

echo '<td style="width: 100px;" onClick="isiinvccode(\''.$outvendcode.'\',\''.$outvenddate.'\',\''.$outsuplcode.'\',\''.$outsuplname.'\',\''.$outinvccode.'\',\''.$outdueddate.'\',\''.$view_amount.'\');" 
      style="cursor:pointer">'.$k['TRXA_DUED_DATE'].'</td>';

echo '<td style="width: 150px; text-align: right;" onClick="isiinvccode(\''.$outvendcode.'\',\''.$outvenddate.'\',\''.$outsuplcode.'\',\''.$outsuplname.'\',\''.$outinvccode.'\',\''.$outdueddate.'\',\''.$view_amount.'\');" 
      style="cursor:pointer">Rp.'.$view_amount.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


