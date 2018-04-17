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

$ds_name[] = 'Cassandra Heap Memory';
$opt[] = "--base 1024 --vertical-label \"bytes\" --title \"Cassandra Heap Memory for $hostname\" ";
$def[] = ""
	. "DEF:heap_mem_total=$RRD[heap_mem_total] "
	. "AREA:heap_mem_total#74C366:\"Heap Memory Total\" "
	. "GPRINT:heap_mem_total:LAST:\"Cur\: %5.2lf %s\" "
	. "GPRINT:heap_mem_total:AVERAGE:\"Avg\: %5.2lf %s\" "
	. "GPRINT:heap_mem_total:MAX:\"Max\: %5.2lf %s\\n\" "
	
	. "DEF:heap_mem_used=$RRD[heap_mem_used] "
	. "AREA:heap_mem_used#FFC3C0:\"Heap Memory Used \" "
	. "GPRINT:heap_mem_used:LAST:\"Cur\: %5.2lf %s\" "
	. "GPRINT:heap_mem_used:AVERAGE:\"Avg\: %5.2lf %s\" "
	. "GPRINT:heap_mem_used:MAX:\"Max\: %5.2lf %s\\n\" "
	
	. "";

$ds_name[] = 'Cassandra Exceptions';
$opt[] = "--vertical-label \"exceptions/sec\" --title \"Cassandra Exceptions for $hostname\" ";
$def[] = ""
	. "DEF:exceptions=$RRD[exceptions] "
	. "LINE:exceptions#FF3932:\"Exceptions\" "
	. "GPRINT:exceptions:LAST:\"Cur\: %5.2lf %s\" "
	. "GPRINT:exceptions:AVERAGE:\"Avg\: %5.2lf %s\" "
	. "GPRINT:exceptions:MAX:\"Max\: %5.2lf %s\\n\" "
	
	. "";

if (isset($RRD["key_cache_size"])) {
	$ds_name[] = 'Cassandra Key Cache';
	$opt[] = "--vertical-label \"ops/sec\" --title \"Cassandra Key Cache for $hostname\" ";
	$def[] = ""
		. "DEF:key_cache_hits=$RRD[key_cache_hits] "
		. "LINE:key_cache_hits#EAAF00:\"Key Cache Hits    \" "
		. "GPRINT:key_cache_hits:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:key_cache_hits:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:key_cache_hits:MAX:\"Max\: %6.2lf%s\\n\" "
		
		. "DEF:key_cache_requests=$RRD[key_cache_requests] "
		. "LINE:key_cache_requests#00A0C1:\"Key Cache Requests\" "
		. "GPRINT:key_cache_requests:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:key_cache_requests:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:key_cache_requests:MAX:\"Max\: %6.2lf%s\\n\" "

		. "";

	$ds_name[] = 'Cassandra Key Cache Memory';
	$opt[] = "--base 1024 --vertical-label \"bytes\" --title \"Cassandra Key Cache Memory for $hostname\" ";
	$def[] = ""
		. "DEF:key_cache_entries=$RRD[key_cache_entries] "
		. "LINE:key_cache_entries#8D00BA:\"Key Cache Entries\" "
		. "GPRINT:key_cache_entries:LAST:\"Cur\: %6.0lf \" "
		. "GPRINT:key_cache_entries:AVERAGE:\"Avg\: %6.0lf \" "
		. "GPRINT:key_cache_entries:MAX:\"Max\: %6.0lf \\n\" "
		
		. "DEF:key_cache_size=$RRD[key_cache_size] "
		. "AREA:key_cache_size#74C366:\"Key Cache Size   \" "
		. "GPRINT:key_cache_size:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:key_cache_size:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:key_cache_size:MAX:\"Max\: %6.2lf%s\\n\" "

		. "DEF:key_cache_used=$RRD[key_cache_used] "
		. "AREA:key_cache_used#FFC3C0:\"Key Cache Used   \" "
		. "GPRINT:key_cache_used:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:key_cache_used:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:key_cache_used:MAX:\"Max\: %6.2lf%s\\n\" "

		. "";
	}

if (isset($RRD["row_cache_size"])) {
	$ds_name[] = 'Cassandra Row Cache';
	$opt[] = "--vertical-label \"ops/sec\" --title \"Cassandra Row Cache for $hostname\" ";
	$def[] = ""
		. "DEF:row_cache_hits=$RRD[row_cache_hits] "
		. "LINE:row_cache_hits#EAAF00:\"Row Cache Hits    \" "
		. "GPRINT:row_cache_hits:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:row_cache_hits:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:row_cache_hits:MAX:\"Max\: %6.2lf%s\\n\" "
		
		. "DEF:row_cache_requests=$RRD[row_cache_requests] "
		. "LINE:row_cache_requests#00A0C1:\"Row Cache Requests\" "
		. "GPRINT:row_cache_requests:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:row_cache_requests:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:row_cache_requests:MAX:\"Max\: %6.2lf%s\\n\" "

		. "";

	$ds_name[] = 'Cassandra Row Cache Memory';
	$opt[] = "--base 1024 --vertical-label \"bytes\" --title \"Cassandra Row Cache Memory for $hostname\" ";
	$def[] = ""
		. "DEF:row_cache_entries=$RRD[row_cache_entries] "
		. "LINE:row_cache_entries#8D00BA:\"Row Cache Entries\" "
		. "GPRINT:row_cache_entries:LAST:\"Cur\: %6.0lf \" "
		. "GPRINT:row_cache_entries:AVERAGE:\"Avg\: %6.0lf \" "
		. "GPRINT:row_cache_entries:MAX:\"Max\: %6.0lf \\n\" "
		
		. "DEF:row_cache_size=$RRD[row_cache_size] "
		. "AREA:row_cache_size#74C366:\"Row Cache Size   \" "
		. "GPRINT:row_cache_size:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:row_cache_size:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:row_cache_size:MAX:\"Max\: %6.2lf%s\\n\" "

		. "DEF:row_cache_used=$RRD[row_cache_used] "
		. "AREA:row_cache_used#FFC3C0:\"Row Cache Used   \" "
		. "GPRINT:row_cache_used:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:row_cache_used:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:row_cache_used:MAX:\"Max\: %6.2lf%s\\n\" "

		. "";
	}

if (isset($RRD["counter_cache_size"])) {
	$ds_name[] = 'Cassandra Counter Cache';
	$opt[] = "--vertical-label \"ops/sec\" --title \"Cassandra Counter Cache for $hostname\" ";
	$def[] = ""
		. "DEF:counter_cache_hits=$RRD[counter_cache_hits] "
		. "LINE:counter_cache_hits#EAAF00:\"Counter Cache Hits    \" "
		. "GPRINT:counter_cache_hits:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:counter_cache_hits:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:counter_cache_hits:MAX:\"Max\: %6.2lf%s\\n\" "
		
		. "DEF:counter_cache_requests=$RRD[counter_cache_requests] "
		. "LINE:counter_cache_requests#00A0C1:\"Counter Cache Requests\" "
		. "GPRINT:counter_cache_requests:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:counter_cache_requests:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:counter_cache_requests:MAX:\"Max\: %6.2lf%s\\n\" "

		. "";

	$ds_name[] = 'Cassandra Counter Cache Memory';
	$opt[] = "--base 1024 --vertical-label \"bytes\" --title \"Cassandra Counter Cache Memory for $hostname\" ";
	$def[] = ""
		. "DEF:counter_cache_entries=$RRD[counter_cache_entries] "
		. "LINE:counter_cache_entries#8D00BA:\"Counter Cache Entries\" "
		. "GPRINT:counter_cache_entries:LAST:\"Cur\: %6.0lf \" "
		. "GPRINT:counter_cache_entries:AVERAGE:\"Avg\: %6.0lf \" "
		. "GPRINT:counter_cache_entries:MAX:\"Max\: %6.0lf \\n\" "
		
		. "DEF:counter_cache_size=$RRD[counter_cache_size] "
		. "AREA:counter_cache_size#74C366:\"Counter Cache Size   \" "
		. "GPRINT:counter_cache_size:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:counter_cache_size:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:counter_cache_size:MAX:\"Max\: %6.2lf%s\\n\" "

		. "DEF:counter_cache_used=$RRD[counter_cache_used] "
		. "AREA:counter_cache_used#FFC3C0:\"Counter Cache Used   \" "
		. "GPRINT:counter_cache_used:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:counter_cache_used:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:counter_cache_used:MAX:\"Max\: %6.2lf%s\\n\" "

		. "";
	}



?>
