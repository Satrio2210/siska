<?php
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");
        $timeinput->add(new DateInterval('PT10S'));
        echo 'Waktu awal '. $timeinput .'<br>';
       //$timeinput->add(new DateInterval('PT5S'));

       echo 'Waktu akhir ' . $timeinput .'<br>';
       //$timeinput2 = $timeinput->format('Y-m-d H:i');
?>