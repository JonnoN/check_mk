<?php

# The number of data source various due to different
# settings (such as averaging). We rather work with names
# than with numbers.
$RRD = array();
foreach ($NAME as $i => $n) {
        $RRD[$n] = "$RRDFILE[$i]:$DS[$i]:MAX";
        $WARN[$n] = $WARN[$i];
        $CRIT[$n] = $CRIT[$i];
        $MIN[$n]  = $MIN[$i];
        $MAX[$n]  = $MAX[$i];
}

# if this is mysql_multi, get the db name, otherwise leave blank
$parts = explode("_", $servicedesc);
$item = (isset($parts[2]) ? "/ $parts[2]" : "");


$ds_name[] = 'MySQL Connections';
$opt[] = "-u 1 --title \"MySQL Connections for $hostname $item\" ";

$def[] =  ""
        . "DEF:running=$RRD[running] "
        . "LINE:running#00FF00:\"Threads Running  \" "
        . "GPRINT:running:LAST:\"Cur\: %5.1lf%s\" "
        . "GPRINT:running:AVERAGE:\"Avg\: %5.1lf%s\" "
        . "GPRINT:running:MAX:\"Max\: %5.1lf%s\\n\" "

        . "DEF:total=$RRD[total] "
        . "LINE:total#FF7D00:\"Threads Connected\" "
        . "GPRINT:total:LAST:\"Cur\: %5.0lf \" "
        . "GPRINT:total:AVERAGE:\"Avg\: %5.1lf \" "
        . "GPRINT:total:MAX:\"Max\: %5.0lf \\n\" "

        . "DEF:connections=$RRD[connections] "
        . "LINE:connections#4444FF:\"New Connections  \" "
        . "GPRINT:connections:LAST:\"Cur\: %5.1lf%s\" "
        . "GPRINT:connections:AVERAGE:\"Avg\: %5.1lf%s\" "
        . "GPRINT:connections:MAX:\"Max\: %5.1lf%s\\n\" "

        . "";
