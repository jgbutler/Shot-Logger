<?php
    ini_set("display_errors","1");
    error_reporting(E_ALL);
    define("EXEC",TRUE);
    include_once("statistics.class.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Statistics Class</title>
    </head>
    <body>
        <h2>Statistics Class</h2>
        <?php
            $scores = array(7,3.4,4,6.9,4,2.2,7.8);
            $stats = new Statistics($scores);

            $stats->q = $stats->Find_Q();
            $stats->max = $stats->Find_Max();
            $stats->min = $stats->Find_Min();
            $stats->fx = $stats->Calculate_FX();
            $stats->mean = $stats->Find_Mean();
            $stats->median = $stats->Find_Median();
            $stats->mode = $stats->Find_Mode();
            $stats->range = $stats->Find_Range();
            $stats->iqr = $stats->Find_IQR();
            $stats->pv = $stats->Find_V('p');
            $stats->sv = $stats->Find_V('s');
            $stats->psd = $stats->Find_SD('p');
            $stats->ssd = $stats->Find_SD('s');
            $stats->XminA = $stats->Calculate_XminAvg(false);
            $stats->XminAsqr = $stats->Calculate_XminAvg(true);
            $stats->rf = $stats->Calculate_RF();
            $stats->rfp = $stats->Calculate_RFP();
            $stats->cf = $stats->Calculate_CF();

            echo "<pre>";
            print_r($stats);
            echo "</pre>";
			
            echo $stats->mean;
            echo "<br />";
            echo $stats->Get_Mean();

        ?>
    </body>
</html>