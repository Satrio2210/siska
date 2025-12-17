<?php
include "conf/config.php";
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
  <th style="width: 500px;">ANAMNESA TEXT</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT DISTINCT(TRXA_EXAM_ANAM) AS EXAM_ANAM 
              FROM trxaexam 
              WHERE TRXA_VIEW_STAT = 'Y'
              ORDER by TRXA_EXAM_ANAM LIMIT 20";    
  }
  else
  {
  $xquery = "SELECT DISTINCT(TRXA_EXAM_ANAM) AS EXAM_ANAM 
              FROM trxaexam 
              WHERE TRXA_EXAM_ANAM LIKE '$kata%'  
              AND TRXA_VIEW_STAT = 'Y'
              ORDER by TRXA_EXAM_ANAM";        
  }

$q = $db->query($xquery) or die("Gagal ambil teks anamnesa !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outexamanam = $k['EXAM_ANAM'];

echo '<tr>';
echo '<td style="width: 500px;" onClick="isiexamanam(\''.$outexamanam.'\');" 
      style="cursor:pointer">'.$k['EXAM_ANAM'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


