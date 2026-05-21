<?php
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
    /* #screen {
    font-family: Arial, Helvetica, sans-serif;
    font-size:11;
    border-collapse: collapse;
    width: 100%;
}


#screen th {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 3px;
    padding-bottom: 3px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}

#screen td {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 6px;
    padding-bottom: 6px;
    text-align: center;
}

#screen tr:nth-child(even){background-color: #f3f2f2;}

#screen tr:hover {background-color: #ddd;}

table tbody, table thead
{
    left: 160px;
}

table tbody 
{
  overflow: auto;
  height: 200px;
}

/*Punya saya*/
    /* #screendiag {
    font-family: Arial, Helvetica, sans-serif;
    font-size:11;
    border-collapse: collapse;
    width: 100%;
}


#screendiag th {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 3px;
    padding-bottom: 3px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}

#screendiag td {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 6px;
    padding-bottom: 6px;
    text-align: center;
}

#screendiag tr:nth-child(even){background-color: #f3f2f2;}

#screendiag tr:hover {background-color: #ddd;}

#screendiag thead {
    position: relative;
    left: 180px;
}
#screendiag tbody {
    position: relative;
    left: 180px;
    height: 110px;
}
 */
    #screendiag {
        width: 100%;
        border-collapse: collapse;
    }

    #screendiag thead {
        background: #10b981;
        color: white;
    }

    #screendiag th {
        padding: 12px;
        font-size: 13px;
        text-align: left;
    }

    #screendiag td {
        padding: 12px;
        font-size: 13px;
        border-bottom: 1px solid #e5e7eb;
    }

    #screendiag tr:hover {
        background: #f9fafb;
    }
</style>
<table id="screendiag">
    <thead>
        <tr>
            <th style="width: 50px">Code</th>
            <th style="width: 300px">Diagnosa</th>
            <th style="width: 100px">Action</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $examcode = $_POST['q'];

        $xquery = "SELECT TRXA_EXAM_CODE, TRXA_DIAG_CODE, TRXA_DIAG_NAME
FROM trxadiag WHERE TRXA_VIEW_STAT='Y'
AND TRXA_EXAM_CODE =  '$examcode'
ORDER BY TRXA_DIAG_CODE
";

        $q = $db->query($xquery) or die("Gagal Maning!!");
        while ($k = $q->fetch(PDO::FETCH_ASSOC)) {

            echo '<tr>';
            $examcode = $k['TRXA_EXAM_CODE'];
            $diagcode = $k['TRXA_DIAG_CODE'];
            $diagname = $k['TRXA_DIAG_NAME'];
            echo '<td style="width: 50px">' . $k['TRXA_DIAG_CODE'] . '</td>';
            echo '<td style="width: 300px">' . $k['TRXA_DIAG_NAME'] . '</td>';

            echo '<td style="width: 100px">';

            echo '<a class="button-delete pure-button" onclick="hapuscode(\'' . $examcode . '\',\'' . $diagcode . '\');">Delete</a>';

            echo '</td>';

            echo '</tr>';
        }
        ?>
    </tbody>
</table>