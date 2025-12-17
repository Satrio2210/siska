<?php
include "conf/config.php";
?>
  <table class="pure-table pure-table-horizontal">
  <thead>
  <tr>
  <th style="width: 100px;">Kode</th>
  <th style="width: 100px;">Group</th>
  <th style="width: 200px;">Pemeriksaan</th>
  <th style="width: 100px;">Hasil</th>
  <th style="width: 100px;">Satuan</th>
  <th style="width: 100px;">Rujukan</th>
  <th style="width: 300px;">Status</th>
  <th style="width: 100px;">Action</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kodelb = $_POST['q'];
  $xquery = "SELECT TRXA_MAST_CODE AS MAST_CODE,
            (SELECT LABO_SUBS_CODE FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS SUBS_CODE,
            (SELECT TBLL_EXAM_NAME FROM tbllexam WHERE TBLL_EXAM_CODE = SUBS_CODE) AS SUBS_NAME,  
            (SELECT LABO_SIZE_NAME FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS SIZE_NAME,
            TRXA_LABO_RSLT, 
            (SELECT LABO_UNIT_NAME FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS UNIT_NAME,
            (SELECT LABO_VALU_MIN FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS VALU_MIN,
            (SELECT LABO_VALU_MAX FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS VALU_MAX,
            (SELECT LABO_VALU_STRG FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS VALU_STRG,
            TRXA_LABO_NOTE
            FROM trxalabo WHERE TRXA_LABO_REGI = '$kodelb' AND TRXA_LABO_STAT = 'I' 
            AND TRXA_VIEW_STAT='Y'
            ORDER BY TRXA_ENTR_DATE, TRXA_ENTR_TIME DESC";

  $q = $db->query($xquery) or die("Gagal ambil data !!");
  while ($k = $q->fetch(PDO::FETCH_ASSOC))
  {
    $outmastcode = $k['MAST_CODE'];
    $outsubsname = $k['SUBS_NAME'];
    $outsizename = $k['SIZE_NAME'];
    $outlaborslt = $k['TRXA_LABO_RSLT'];
    $outunitname = $k['UNIT_NAME'];
    $outvalumin = $k['VALU_MIN'];
    $outvalumax = $k['VALU_MAX'];
    $outvalustrg = $k['VALU_STRG'];
    $outlabonote = $k['TRXA_LABO_NOTE'];

    echo '<tr>';

    echo '<td style="width: 100px;">'.$outmastcode.'</td>';
    echo '<td style="width: 100px;">'.$outsubsname.'</td>';
    echo '<td style="width: 200px; text-align: left;">'.$outsizename.'</td>';
    echo '<td style="width: 100px; text-align: left;">'.$outlaborslt.'</td>';
    echo '<td style="width: 100px; text-align: left;">'.$outunitname.'</td>';
    if ($outvalumin == '>') 
      {
        echo '<td style="width: 100px; text-align: left;">'.$outvalumin.' '.$outvalumax.'</td>';   
      }
    else if ($outvalumin == '<')
      {
        echo '<td style="width: 100px; text-align: left;">'.$outvalumin.' '.$outvalumax.'</td>';
      }
    else if (($outvalumin == '') && ($outvalumax == ''))
     {
        echo '<td style="width: 100px; text-align: left;">'.$outvalustrg.'</td>'; 
     } 
    else
     {
        echo '<td style="width: 100px; text-align: left;">'.$outvalumin.' - '.$outvalumax.'</td>';
     }
    
    echo '<td style="width: 300px; text-align: left;">'.$outlabonote.'</td>';

    echo '<td style="width: 100px">';
    echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$kodelb.'\',\''.$outmastcode.'\');}
              else
              { document.getElementById(\'txtmastcode\').focus();}
              ">Delete</a>';

    echo '</td>';

    echo '</tr>';
  }
?>
  </tbody>
  </table>


