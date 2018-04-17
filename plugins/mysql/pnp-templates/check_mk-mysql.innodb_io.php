<?php
# +------------------------------------------------------------------+
# |             ____ _               _        __  __ _  __           |
# |            / ___| |__   ___  ___| | __   |  \/  | |/ /           |
# |           | |   | '_ \ / _ \/ __| |/ /   | |\/| | ' /            |
# |           | |___| | | |  __/ (__|   <    | |  | | . \            |
# |            \____|_| |_|\___|\___|_|\_\___|_|  |_|_|\_\           |
# |                                                                  |
# | Copyright Mathias Kettner 2012             mk@mathias-kettner.de |
# +------------------------------------------------------------------+
#
# This file is part of Check_MK.
# The official homepage is at http://mathias-kettner.de/check_mk.
#
# check_mk is free software;  you can redistribute it and/or modify it
# under the  terms of the  GNU General Public License  as published by
# the Free Software Foundation in version 2.  check_mk is  distributed
# in the hope that it will be useful, but WITHOUT ANY WARRANTY;  with-
# out even the implied warranty of  MERCHANTABILITY  or  FITNESS FOR A
# PARTICULAR PURPOSE. See the  GNU General Public License for more de-
# ails.  You should have  received  a copy of the  GNU  General Public
# License along with GNU Make; see the file  COPYING.  If  not,  write
# to the Free Software Foundation, Inc., 51 Franklin St,  Fifth Floor,
# Boston, MA 02110-1301 USA.

// new version of diskstat
if (isset($DS[2])) {

    // Make data sources available via names
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
	$item = (isset($parts[3]) ? "/ $parts[3]" : "");

    $ds_name[1] = 'InnoDB IO';
    $opt[1] = "--base 1024 --vertical-label 'bytes/sec'  --title \"InnoDB IO for $hostname $item\" ";

    $def[1]  = 
               "HRULE:0#a0a0a0 ".
    # read
               "DEF:read=$RRD[read] ".
               "AREA:read#40c080:\"Read \" ".
               "GPRINT:read:LAST:\"Cur\: %6.1lf %sB/s\" ".
               "GPRINT:read:AVERAGE:\"Avg\: %6.1lf %sB/s\" ".
               "GPRINT:read:MAX:\"Max\: %6.1lf %sB/s\\n\" ";

    # read average as line in the same graph
    if (isset($RRD["read.avg"])) {
        $def[1] .= 
               "DEF:read_avg=${RRD['read.avg']} ".
               "LINE:read_avg#202020 ";
    }

    # write
    $def[1] .=
               "DEF:write=$RRD[write] ".
               "CDEF:write_neg=write,-1,* ".
               "AREA:write_neg#4080c0:\"Write\"  ".
               "GPRINT:write:LAST:\"Cur\: %6.1lf %sB/s\" ".
               "GPRINT:write:AVERAGE:\"Avg\: %6.1lf %sB/s\" ".
               "GPRINT:write:MAX:\"Max\: %6.1lf %sB/s\\n\" ";
               "";

    # write average
    if (isset($DS["write.avg"])) {
        $def[1] .= 
               "DEF:write_avg=${RRD['write.avg']} ".
               "CDEF:write_avg_neg=write_avg,-1,* ".
               "LINE:write_avg_neg#202020 ";
    }

            
}

// legacy version of diskstat
else {
    $opt[1] = "--vertical-label 'Througput (MByte/s)' -l0  -u 1 --title \"Disk throughput $hostname / $servicedesc\" ";

    $def[1]  = "DEF:kb=$RRDFILE[1]:$DS[1]:AVERAGE " ;
    $def[1] .= "CDEF:mb=kb,1024,/ " ;
    $def[1] .= "AREA:mb#40c080 " ;
    $def[1] .= "GPRINT:mb:LAST:\"%6.1lf MByte/s last\" " ;
    $def[1] .= "GPRINT:mb:AVERAGE:\"%6.1lf MByte/s avg\" " ;
    $def[1] .= "GPRINT:mb:MAX:\"%6.1lf MByte/s max\\n\" ";
}
?>

