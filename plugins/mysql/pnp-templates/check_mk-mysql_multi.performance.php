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
$item = (isset($parts[3]) ? "/ $parts[3]" : "");


$ds_name[1] = 'MySQL Command Counters';
$opt[1] = "-u 1 --title \"MySQL Commands for $hostname $item\" ";

$def[1] =  ""
	. "DEF:queries=$RRD[queries] "
	. "LINE2:queries#5858FA:\"Queries        \" "
	. "GPRINT:queries:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:queries:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:queries:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:questions=$RRD[questions] "
	. "AREA:questions#FFC3C0:\"Questions      \" "
	. "GPRINT:questions:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:questions:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:questions:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:selects=$RRD[selects] "
	. "AREA:selects#FF0000:\"Select         \" "
	. "GPRINT:selects:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:selects:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:selects:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:inserts=$RRD[inserts] "
	. "AREA:inserts#FFF200:\"Insert         \":STACK "
	. "GPRINT:inserts:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:inserts:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:inserts:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:updates=$RRD[updates] "
	. "AREA:updates#00CF00:\"Udpate         \":STACK "
	. "GPRINT:updates:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:updates:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:updates:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:replaces=$RRD[replaces] "
	. "AREA:replaces#2175D9:\"Replace        \":STACK "
	. "GPRINT:replaces:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:replaces:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:replaces:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:deletes=$RRD[deletes] "
	. "AREA:deletes#FF7D00:\"Deletes        \":STACK "
	. "GPRINT:deletes:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:deletes:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:deletes:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:calls=$RRD[calls] "
	. "AREA:calls#FF6347:\"Calls          \":STACK "
	. "GPRINT:calls:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:calls:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:calls:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:loads=$RRD[loads] "
	. "AREA:loads#55009D:\"Loads          \":STACK "
	. "GPRINT:loads:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:loads:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:loads:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:delete_multis=$RRD[delete_multis] "
	. "AREA:delete_multis#942D0C:\"Delete Multis  \":STACK "
	. "GPRINT:delete_multis:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:delete_multis:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:delete_multis:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:insert_selects=$RRD[insert_selects] "
	. "AREA:insert_selects#AAABA1:\"Insert Selects \":STACK "
	. "GPRINT:insert_selects:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:insert_selects:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:insert_selects:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:update_multis=$RRD[update_multis] "
	. "AREA:update_multis#D8ACE0:\"Update Multis  \":STACK "
	. "GPRINT:update_multis:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:update_multis:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:update_multis:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:replace_selects=$RRD[replace_selects] "
	. "AREA:replace_selects#00B99B:\"Replace Selects\":STACK "
	. "GPRINT:replace_selects:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:replace_selects:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:replace_selects:MAX:\"Max\: %6.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Binary/Relay Logs';
$opt[] = "--base 1024 --title \"MySQL Binary/Relay Logs for $hostname $item\" ";

$def[] =  ""
	. "DEF:binlog_cache_use=$RRD[binlog_cache_use] "
	. "LINE:binlog_cache_use#35962B:\"Binlog Cache Use     \" "
	. "GPRINT:binlog_cache_use:LAST:\"Cur\: %6.2lf%s\" "
	. "GPRINT:binlog_cache_use:AVERAGE:\"Avg\: %6.2lf%s\" "
	. "GPRINT:binlog_cache_use:MAX:\"Max\: %6.2lf%s\\n\" "

	. "DEF:binlog_cache_disk_use=$RRD[binlog_cache_disk_use] "
	. "LINE:binlog_cache_disk_use#FF0000:\"Binlog Cache Disk Use\" "
	. "GPRINT:binlog_cache_disk_use:LAST:\"Cur\: %6.2lf%s\" "
	. "GPRINT:binlog_cache_disk_use:AVERAGE:\"Avg\: %6.2lf%s\" "
	. "GPRINT:binlog_cache_disk_use:MAX:\"Max\: %6.2lf%s\\n\" "

        . "DEF:binlog_total_size=$RRD[binlog_total_size] "
        . "LINE:binlog_total_size#8D00BA:\"Binary Log Space     \" "
        . "GPRINT:binlog_total_size:LAST:\"Cur\: %6.2lf%s\" "
        . "GPRINT:binlog_total_size:AVERAGE:\"Avg\: %6.2lf%s\" "
        . "GPRINT:binlog_total_size:MAX:\"Max\: %6.2lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Connections';
$opt[] = "-u 1 --title \"MySQL Connections for $hostname $item\" ";

$def[] =  ""
	. "DEF:max_connections=$RRD[max_connections] "
	. "AREA:max_connections#C0C0C0:\"Max Connections     \" "
	. "GPRINT:max_connections:LAST:\"Cur\: %5.0lf\\n\" "

	. "DEF:max_used_connections=$RRD[max_used_connections] "
	. "AREA:max_used_connections#FFD660:\"Max Used Connections\" "
	. "GPRINT:max_used_connections:LAST:\"Cur\: %5.0lf\\n\" "

	. "DEF:aborted_clients=$RRD[aborted_clients] "
	. "LINE:aborted_clients#FF3932:\"Aborted Clients     \" "
	. "GPRINT:aborted_clients:LAST:\"Cur\: %5.1lf%s\" "
	. "GPRINT:aborted_clients:AVERAGE:\"Avg\: %5.1lf%s\" "
	. "GPRINT:aborted_clients:MAX:\"Max\: %5.1lf%s\\n\" "

	. "DEF:aborted_connects=$RRD[aborted_connects] "
	. "LINE:aborted_connects#00FF00:\"Aborted Connects    \" "
	. "GPRINT:aborted_connects:LAST:\"Cur\: %5.1lf%s\" "
	. "GPRINT:aborted_connects:AVERAGE:\"Avg\: %5.1lf%s\" "
	. "GPRINT:aborted_connects:MAX:\"Max\: %5.1lf%s\\n\" "

	. "DEF:threads_connected=$RRD[threads_connected] "
	. "LINE2:threads_connected#FF7D00:\"Threads Connected   \" "
	. "GPRINT:threads_connected:LAST:\"Cur\: %5.0lf \" "
	. "GPRINT:threads_connected:AVERAGE:\"Avg\: %5.1lf \" "
	. "GPRINT:threads_connected:MAX:\"Max\: %5.0lf \\n\" "

	. "DEF:connections=$RRD[connections] "
	. "LINE:connections#4444FF:\"New Connections     \" "
	. "GPRINT:connections:LAST:\"Cur\: %5.1lf%s\" "
	. "GPRINT:connections:AVERAGE:\"Avg\: %5.1lf%s\" "
	. "GPRINT:connections:MAX:\"Max\: %5.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Files and Tables';
$opt[] = "-u 1 --title \"MySQL Files and Tables for $hostname $item\" ";

$def[] =  ""
	. "DEF:table_open_cache=$RRD[table_open_cache] "
	. "AREA:table_open_cache#D09887:\"Table Open Cache\" "
	. "GPRINT:table_open_cache:LAST:\"Cur\: %5.0lf \" "
	. "GPRINT:table_open_cache:AVERAGE:\"Avg\: %5.0lf \" "
	. "GPRINT:table_open_cache:MAX:\"Max\: %5.0lf \\n\" "

	. "DEF:open_tables=$RRD[open_tables] "
	. "LINE:open_tables#4A6959:\"Open Tables     \" "
	. "GPRINT:open_tables:LAST:\"Cur\: %5.0lf \" "
	. "GPRINT:open_tables:AVERAGE:\"Avg\: %5.0lf \" "
	. "GPRINT:open_tables:MAX:\"Max\: %5.0lf \\n\" "

	. "DEF:open_files=$RRD[open_files] "
	. "LINE:open_files#1D1159:\"Open Files      \" "
	. "GPRINT:open_files:LAST:\"Cur\: %5.0lf \" "
	. "GPRINT:open_files:AVERAGE:\"Avg\: %5.0lf \" "
	. "GPRINT:open_files:MAX:\"Max\: %5.0lf \\n\" "

	. "DEF:opened_tables=$RRD[opened_tables] "
	. "LINE:opened_tables#DE0056:\"Opened Tables   \" "
	. "GPRINT:opened_tables:LAST:\"Cur\: %5.2lf%s\" "
	. "GPRINT:opened_tables:AVERAGE:\"Avg\: %5.2lf%s\" "
	. "GPRINT:opened_tables:MAX:\"Max\: %5.2lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Handlers';
$opt[] = "-u 1 --title \"MySQL Handlers for $hostname $item\" ";

$def[] =  ""
	. "DEF:handler_write=$RRD[handler_write] "
	. "AREA:handler_write#4D4A47:\"Handler Write        \" "
	. "GPRINT:handler_write:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_write:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_write:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:handler_update=$RRD[handler_update] "
	. "AREA:handler_update#C79F71:\"Handler Update       \":STACK "
	. "GPRINT:handler_update:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_update:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_update:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:handler_delete=$RRD[handler_delete] "
	. "AREA:handler_delete#BDB8B3:\"Handler Delete       \":STACK "
	. "GPRINT:handler_delete:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_delete:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_delete:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:handler_read_first=$RRD[handler_read_first] "
	. "AREA:handler_read_first#8C286E:\"Handler Read First   \":STACK "
	. "GPRINT:handler_read_first:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_read_first:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_read_first:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:handler_read_key=$RRD[handler_read_key] "
	. "AREA:handler_read_key#BAB27F:\"Handler Read Key     \":STACK "
	. "GPRINT:handler_read_key:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_read_key:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_read_key:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:handler_read_next=$RRD[handler_read_next] "
	. "AREA:handler_read_next#C02942:\"Handler Read Next    \":STACK "
	. "GPRINT:handler_read_next:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_read_next:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_read_next:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:handler_read_prev=$RRD[handler_read_prev] "
	. "AREA:handler_read_prev#FA6900:\"Handler Read Prev    \":STACK "
	. "GPRINT:handler_read_prev:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_read_prev:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_read_prev:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:handler_read_rnd=$RRD[handler_read_rnd] "
	. "AREA:handler_read_rnd#5A3D31:\"Handler Read Rnd     \":STACK "
	. "GPRINT:handler_read_rnd:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_read_rnd:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_read_rnd:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:handler_read_rnd_next=$RRD[handler_read_rnd_next] "
	. "AREA:handler_read_rnd_next#69D2E7:\"Handler Read Rnd Next\":STACK "
	. "GPRINT:handler_read_rnd_next:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:handler_read_rnd_next:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:handler_read_rnd_next:MAX:\"Max\: %6.1lf\\n\" "

	. "";

$ds_name[] = 'MySQL Network Traffic';
$opt[] = "--base 1024 --title \"MySQL Network Traffic for $hostname $item\" ";
$def[] =  ""
	. "DEF:bytes_sent=$RRD[bytes_sent] "
	. "AREA:bytes_sent#4B2744:\"Bytes Sent     \" "
	. "GPRINT:bytes_sent:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:bytes_sent:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:bytes_sent:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:bytes_received=$RRD[bytes_received] "
	. "CDEF:bytes_received_neg=bytes_received,-1,* "
	. "AREA:bytes_received_neg#E4C576:\"Bytes Received \" "
	. "GPRINT:bytes_received:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:bytes_received:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:bytes_received:MAX:\"Max\: %6.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Processlist';
$opt[] = "-u1 --title \"MySQL Processlist for $hostname $item\" ";
$def[] =  ""
        . "DEF:proc_closing_tables=$RRD[proc_closing_tables] "
        . "AREA:proc_closing_tables#DE0056:\"State Closing Tables      \" "
        . "GPRINT:proc_closing_tables:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_closing_tables:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_closing_tables:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_copying_to_tmp_table=$RRD[proc_copying_to_tmp_table] "
        . "AREA:proc_copying_to_tmp_table#784890:\"State Copying To Tmp Table\":STACK "
        . "GPRINT:proc_copying_to_tmp_table:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_copying_to_tmp_table:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_copying_to_tmp_table:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_end=$RRD[proc_end] "
        . "AREA:proc_end#D1642E:\"State End                 \":STACK "
        . "GPRINT:proc_end:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_end:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_end:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_freeing_items=$RRD[proc_freeing_items] "
        . "AREA:proc_freeing_items#487860:\"State Freeing Items       \":STACK "
        . "GPRINT:proc_freeing_items:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_freeing_items:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_freeing_items:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_init=$RRD[proc_init] "
        . "AREA:proc_init#907890:\"State Init                \":STACK "
        . "GPRINT:proc_init:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_init:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_init:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_locked=$RRD[proc_locked] "
        . "AREA:proc_locked#DE0056:\"State Locked              \":STACK "
        . "GPRINT:proc_locked:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_locked:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_locked:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_login=$RRD[proc_login] "
        . "AREA:proc_login#1693A7:\"State Login               \":STACK "
        . "GPRINT:proc_login:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_login:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_login:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_preparing=$RRD[proc_preparing] "
        . "AREA:proc_preparing#783030:\"State Preparing           \":STACK "
        . "GPRINT:proc_preparing:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_preparing:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_preparing:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_reading_from_net=$RRD[proc_reading_from_net] "
        . "AREA:proc_reading_from_net#FF7F00:\"State Reading From Net    \":STACK "
        . "GPRINT:proc_reading_from_net:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_reading_from_net:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_reading_from_net:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_sending_data=$RRD[proc_sending_data] "
        . "AREA:proc_sending_data#54382A:\"State Sending Data        \":STACK "
        . "GPRINT:proc_sending_data:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_sending_data:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_sending_data:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_sorting_result=$RRD[proc_sorting_result] "
        . "AREA:proc_sorting_result#B83A04:\"State Sorting Result      \":STACK "
        . "GPRINT:proc_sorting_result:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_sorting_result:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_sorting_result:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_statistics=$RRD[proc_statistics] "
        . "AREA:proc_statistics#6E3803:\"State Statistics          \":STACK "
        . "GPRINT:proc_statistics:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_statistics:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_statistics:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_updating=$RRD[proc_updating] "
        . "AREA:proc_updating#B56414:\"State Updating            \":STACK "
        . "GPRINT:proc_updating:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_updating:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_updating:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_writing_to_net=$RRD[proc_writing_to_net] "
        . "AREA:proc_writing_to_net#6E645A:\"State Writing To Net      \":STACK "
        . "GPRINT:proc_writing_to_net:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_writing_to_net:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_writing_to_net:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_none=$RRD[proc_none] "
        . "AREA:proc_none#521808:\"State None                \":STACK "
        . "GPRINT:proc_none:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_none:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_none:MAX:\"Max\: %6.1lf\\n\" "

        . "DEF:proc_other=$RRD[proc_other] "
        . "AREA:proc_other#194240:\"State Other               \":STACK "
        . "GPRINT:proc_other:LAST:\"Cur\: %6.1lf\" "
        . "GPRINT:proc_other:AVERAGE:\"Avg\: %6.1lf\" "
        . "GPRINT:proc_other:MAX:\"Max\: %6.1lf\\n\" "

	. "";

if (isset($RRD["qcache_queries"])) {
	$ds_name[] = 'MySQL Query Cache';
	$opt[] = "--title \"MySQL Query Cache for $hostname $item\" ";
	$def[] = ""
		. "DEF:qcache_queries=$RRD[qcache_queries] "
		. "LINE2:qcache_queries#4444FF:\"Qcache Queries In Cache\" "
		. "GPRINT:qcache_queries:LAST:\"Cur\: %5.0lf%s \" "
		. "GPRINT:qcache_queries:AVERAGE:\"Avg\: %5.0lf%s \" "
		. "GPRINT:qcache_queries:MAX:\"Max\: %5.0lf%s \\n\" "

		. "DEF:qcache_hits=$RRD[qcache_hits] "
		. "LINE2:qcache_hits#EAAF00:\"Qcache Hits            \" "
		. "GPRINT:qcache_hits:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:qcache_hits:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:qcache_hits:MAX:\"Max\: %6.2lf%s\\n\" "

		. "DEF:qcache_inserts=$RRD[qcache_inserts] "
		. "LINE:qcache_inserts#157419:\"Qcache Inserts         \" "
		. "GPRINT:qcache_inserts:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:qcache_inserts:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:qcache_inserts:MAX:\"Max\: %6.2lf%s\\n\" "

		. "DEF:qcache_not_cached=$RRD[qcache_not_cached] "
		. "LINE:qcache_not_cached#00A0C1:\"Qcache Not Cached      \" "
		. "GPRINT:qcache_not_cached:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:qcache_not_cached:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:qcache_not_cached:MAX:\"Max\: %6.2lf%s\\n\" "

		. "DEF:qcache_lowmem_prunes=$RRD[qcache_lowmem_prunes] "
		. "LINE:qcache_lowmem_prunes#FF0000:\"Qcache Lowmem Prunes   \" "
		. "GPRINT:qcache_lowmem_prunes:LAST:\"Cur\: %6.2lf%s\" "
		. "GPRINT:qcache_lowmem_prunes:AVERAGE:\"Avg\: %6.2lf%s\" "
		. "GPRINT:qcache_lowmem_prunes:MAX:\"Max\: %6.2lf%s\\n\" "

		. "";

	$ds_name[] = 'MySQL Query Cache Memory';
	$opt[] = "--base 1024 --title \"MySQL Query Cache Memory for $hostname $item\" ";
	$def[] = ""
		. "DEF:qcache_size=$RRD[qcache_size] "
		. "AREA:qcache_size#74C366:\"Qcache Size        \" "
		. "GPRINT:qcache_size:LAST:\"Cur\: %5.0lf%s\" "
		. "GPRINT:qcache_size:AVERAGE:\"Avg\: %5.0lf%s\" "
		. "GPRINT:qcache_size:MAX:\"Max\: %5.0lf%s\\n\" "

		. "DEF:qcache_freemem=$RRD[qcache_freemem] "
		. "AREA:qcache_freemem#FFC3C0:\"Qcache Free Memory \" "
		. "GPRINT:qcache_freemem:LAST:\"Cur\: %5.0lf%s\" "
		. "GPRINT:qcache_freemem:AVERAGE:\"Avg\: %5.0lf%s\" "
		. "GPRINT:qcache_freemem:MAX:\"Max\: %5.0lf%s\\n\" "

		. "DEF:qcache_total_blocks=$RRD[qcache_total_blocks] "
		. "LINE:qcache_total_blocks#8D00BA:\"Qcache Total Blocks\" "
		. "GPRINT:qcache_total_blocks:LAST:\"Cur\: %5.0lf%s\" "
		. "GPRINT:qcache_total_blocks:AVERAGE:\"Avg\: %5.0lf%s\" "
		. "GPRINT:qcache_total_blocks:MAX:\"Max\: %5.0lf%s\\n\" "

		. "DEF:qcache_free_blocks=$RRD[qcache_free_blocks] "
		. "LINE:qcache_free_blocks#837C04:\"Qcache Free Blocks \" "
		. "GPRINT:qcache_free_blocks:LAST:\"Cur\: %5.0lf%s\" "
		. "GPRINT:qcache_free_blocks:AVERAGE:\"Avg\: %5.0lf%s\" "
		. "GPRINT:qcache_free_blocks:MAX:\"Max\: %5.0lf%s\\n\" "

		. "";

	}

$ds_name[] = 'MySQL Select Types';
$opt[] = "-u1 --title \"MySQL Select Types for $hostname $item\" ";
$def[] = ""

	. "DEF:select_full_join=$RRD[select_full_join] "
	. "AREA:select_full_join#3D1500:\"Selects Full Join     \" "
	. "GPRINT:select_full_join:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:select_full_join:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:select_full_join:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:select_full_range_join=$RRD[select_full_range_join] "
	. "AREA:select_full_range_join#AA3B27:\"Select Full Range Join\":STACK "
	. "GPRINT:select_full_range_join:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:select_full_range_join:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:select_full_range_join:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:select_range=$RRD[select_range] "
	. "AREA:select_range#EDAA41:\"Select Range          \":STACK "
	. "GPRINT:select_range:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:select_range:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:select_range:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:select_range_check=$RRD[select_range_check] "
	. "AREA:select_range_check#13343B:\"Select Range Check    \":STACK "
	. "GPRINT:select_range_check:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:select_range_check:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:select_range_check:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:select_scan=$RRD[select_scan] "
	. "AREA:select_scan#686240:\"Select Scan           \":STACK "
	. "GPRINT:select_scan:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:select_scan:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:select_scan:MAX:\"Max\: %6.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Sorts';
$opt[] = "-u1 --title \"MySQL Sorts for $hostname $item\" ";
$def[] = ""

	. "DEF:sort_rows=$RRD[sort_rows] "
	. "AREA:sort_rows#FFAB00:\"Sort Rows        \" "
	. "GPRINT:sort_rows:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:sort_rows:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:sort_rows:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:sort_range=$RRD[sort_range] "
	. "LINE:sort_range#157419:\"Sort Range       \" "
	. "GPRINT:sort_range:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:sort_range:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:sort_range:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:sort_merge_passes=$RRD[sort_merge_passes] "
	. "LINE:sort_merge_passes#DA4725:\"Sort Merge Passes\" "
	. "GPRINT:sort_merge_passes:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:sort_merge_passes:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:sort_merge_passes:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:sort_scan=$RRD[sort_scan] "
	. "LINE:sort_scan#4444FF:\"Sort Scan        \" "
	. "GPRINT:sort_scan:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:sort_scan:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:sort_scan:MAX:\"Max\: %6.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Table Locks';
$opt[] = "-u1 --title \"MySQL Table Locks for $hostname $item\" ";
$def[] = ""

	. "DEF:table_locks_immediate=$RRD[table_locks_immediate] "
	. "AREA:table_locks_immediate#D2D8F9:\"Table Locks Immediate\\n\" "
	. "LINE:table_locks_immediate#002A8F:\"Table Locks Immediate\" "
	. "GPRINT:table_locks_immediate:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:table_locks_immediate:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:table_locks_immediate:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:table_locks_waited=$RRD[table_locks_waited] "
	. "AREA:table_locks_waited#FF3932:\"Table Locks Waited   \" "
	. "GPRINT:table_locks_waited:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:table_locks_waited:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:table_locks_waited:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:slow_queries=$RRD[slow_queries] "
	. "LINE:slow_queries#35962B:\"Slow Queries         \" "
	. "GPRINT:slow_queries:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:slow_queries:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:slow_queries:MAX:\"Max\: %6.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Temporary Objects';
$opt[] = "--title \"MySQL Temporary Objects for $hostname $item\" ";
$def[] = ""

	. "DEF:tmp_tables_created=$RRD[tmp_tables_created] "
	. "AREA:tmp_tables_created#FFAB00:\"Created Tmp Tables\\n\" "
	. "LINE:tmp_tables_created#837C04:\"Created Tmp Tables     \" "
	. "GPRINT:tmp_tables_created:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:tmp_tables_created:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:tmp_tables_created:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:tmp_disk_tables_created=$RRD[tmp_disk_tables_created] "
	. "LINE:tmp_disk_tables_created#F51D30:\"Created Tmp Disk Tables\" "
	. "GPRINT:tmp_disk_tables_created:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:tmp_disk_tables_created:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:tmp_disk_tables_created:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:tmp_files_created=$RRD[tmp_files_created] "
	. "LINE2:tmp_files_created#35962B:\"Created Tmp Files      \" "
	. "GPRINT:tmp_files_created:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:tmp_files_created:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:tmp_files_created:MAX:\"Max\: %6.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL Threads';
$opt[] = "--title \"MySQL Threads for $hostname $item\" ";
$def[] = ""

	. "DEF:thread_cache_size=$RRD[thread_cache_size] "
	. "AREA:thread_cache_size#E8CDEF:\"Thread Cache Size\" "
	. "GPRINT:thread_cache_size:LAST:\"Cur\: %6.0lf\\n\" "

	. "DEF:threads_connected=$RRD[threads_connected] "
	. "LINE:threads_connected#08A000:\"Threads Connected\" "
	. "GPRINT:threads_connected:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:threads_connected:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:threads_connected:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:threads_running=$RRD[threads_running] "
	. "LINE:threads_running#FF3932:\"Threads Running  \" "
	. "GPRINT:threads_running:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:threads_running:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:threads_running:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:threads_created=$RRD[threads_created] "
	. "LINE:threads_created#4444FF:\"Threads Created  \" "
	. "GPRINT:threads_created:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:threads_created:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:threads_created:MAX:\"Max\: %6.1lf\\n\" "

	. "DEF:threads_cached=$RRD[threads_cached] "
	. "LINE:threads_cached#F39034:\"Threads Cached   \" "
	. "GPRINT:threads_cached:LAST:\"Cur\: %6.1lf\" "
	. "GPRINT:threads_cached:AVERAGE:\"Avg\: %6.1lf\" "
	. "GPRINT:threads_cached:MAX:\"Max\: %6.1lf\\n\" "
	
	. "";

$ds_name[] = 'MySQL Transaction Handler';
$opt[] = "--title \"MySQL Transaction Handler for $hostname $item\" ";
$def[] = ""

	. "DEF:handler_commit=$RRD[handler_commit] "
	. "LINE:handler_commit#DE0056:\"Handler Commit            \" "
	. "GPRINT:handler_commit:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:handler_commit:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:handler_commit:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:handler_rollback=$RRD[handler_rollback] "
	. "LINE:handler_rollback#784890:\"Handler Rollback          \" "
	. "GPRINT:handler_rollback:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:handler_rollback:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:handler_rollback:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:handler_savepoint=$RRD[handler_savepoint] "
	. "LINE:handler_savepoint#D1642E:\"Handler Savepoint         \" "
	. "GPRINT:handler_savepoint:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:handler_savepoint:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:handler_savepoint:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:handler_savepoint_rollback=$RRD[handler_savepoint_rollback] "
	. "LINE:handler_savepoint_rollback#487860:\"Handler Savepoint Rollback\" "
	. "GPRINT:handler_savepoint_rollback:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:handler_savepoint_rollback:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:handler_savepoint_rollback:MAX:\"Max\: %6.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL InnoDB Buffer Pool';
$opt[] = " --base 1024 --title \"InnoDB Buffer Pool for $hostname $item\" ";
$def[] = ""

	. "DEF:innodb_buffer_pool_pages_total=$RRD[innodb_buffer_pool_pages_total] "
	. "AREA:innodb_buffer_pool_pages_total#3D1500:\"Pool Size     \" "
	. "GPRINT:innodb_buffer_pool_pages_total:LAST:\"Cur\: %6.1lf%s\\n\" "

	. "DEF:innodb_buffer_pool_pages_data=$RRD[innodb_buffer_pool_pages_data] "
	. "AREA:innodb_buffer_pool_pages_data#EDAA41:\"Database Pages\" "
	. "GPRINT:innodb_buffer_pool_pages_data:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:innodb_buffer_pool_pages_data:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:innodb_buffer_pool_pages_data:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:innodb_buffer_pool_pages_free=$RRD[innodb_buffer_pool_pages_free] "
	. "AREA:innodb_buffer_pool_pages_free#AA3B27:\"Free Pages    \":STACK "
	. "GPRINT:innodb_buffer_pool_pages_free:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:innodb_buffer_pool_pages_free:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:innodb_buffer_pool_pages_free:MAX:\"Max\: %6.1lf%s\\n\" "

	. "DEF:innodb_buffer_pool_pages_dirty=$RRD[innodb_buffer_pool_pages_dirty] "
	. "AREA:innodb_buffer_pool_pages_dirty#13343B:\"Modified Pages\":STACK "
	. "GPRINT:innodb_buffer_pool_pages_dirty:LAST:\"Cur\: %6.1lf%s\" "
	. "GPRINT:innodb_buffer_pool_pages_dirty:AVERAGE:\"Avg\: %6.1lf%s\" "
	. "GPRINT:innodb_buffer_pool_pages_dirty:MAX:\"Max\: %6.1lf%s\\n\" "

	. "";

$ds_name[] = 'MySQL InnoDB Buffer Pool Activity';
$opt[] = "--base 1024 --title \"InnoDB Buffer Pool Activity for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_pages_created=$RRD[innodb_pages_created] "
        . "LINE2:innodb_pages_created#D6883A:\"Pages Created\" "
        . "GPRINT:innodb_pages_created:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_pages_created:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_pages_created:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:innodb_pages_read=$RRD[innodb_pages_read] "
        . "LINE2:innodb_pages_read#E6D883:\"Pages Read   \" "
        . "GPRINT:innodb_pages_read:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_pages_read:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_pages_read:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:innodb_pages_written=$RRD[innodb_pages_written] "
        . "LINE2:innodb_pages_written#55AD84:\"Pages Written\" "
        . "GPRINT:innodb_pages_written:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_pages_written:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_pages_written:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Buffer Pool Efficiency';
$opt[] = "--title \"InnoDB Buffer Pool Efficiency for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_buffer_pool_read_requests=$RRD[innodb_buffer_pool_read_requests] "
        . "LINE:innodb_buffer_pool_read_requests#6EA100:\"Pool Read Requests\" "
        . "GPRINT:innodb_buffer_pool_read_requests:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_buffer_pool_read_requests:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_buffer_pool_read_requests:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:innodb_buffer_pool_reads=$RRD[innodb_buffer_pool_reads] "
        . "LINE:innodb_buffer_pool_reads#AA3B27:\"Pool Reads        \" "
        . "GPRINT:innodb_buffer_pool_reads:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_buffer_pool_reads:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_buffer_pool_reads:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Checkpoint Age';
$opt[] = "--base 1024 --title \"InnoDB Checkpoint Age for $hostname $item\" ";
$def[] = ""

        . "DEF:uncheckpointed_bytes=$RRD[uncheckpointed_bytes] "
        . "LINE:uncheckpointed_bytes#661100:\"Uncheckpointed Bytes\" "
        . "GPRINT:uncheckpointed_bytes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:uncheckpointed_bytes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:uncheckpointed_bytes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Current Lock Waits';
$opt[] = "--title \"InnoDB Current Lock Waits for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_lock_wait_secs=$RRD[innodb_lock_wait_secs] "
        . "LINE:innodb_lock_wait_secs#201A33:\"Innodb Lock Wait Secs\" "
        . "GPRINT:innodb_lock_wait_secs:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_lock_wait_secs:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_lock_wait_secs:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Insert Buffer';
$opt[] = "--title \"InnoDB Insert Buffer for $hostname $item\" ";
$def[] = ""

        . "DEF:ibuf_inserts=$RRD[ibuf_inserts] "
        . "LINE:ibuf_inserts#157419:\"Ibuf Inserts\" "
        . "GPRINT:ibuf_inserts:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:ibuf_inserts:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:ibuf_inserts:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:ibuf_merged=$RRD[ibuf_merged] "
        . "LINE:ibuf_merged#0000FF:\"Ibuf Merged \" "
        . "GPRINT:ibuf_merged:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:ibuf_merged:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:ibuf_merged:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:ibuf_merges=$RRD[ibuf_merges] "
        . "LINE:ibuf_merges#862F2F:\"Ibuf Merges \" "
        . "GPRINT:ibuf_merges:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:ibuf_merges:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:ibuf_merges:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Insert Buffer Usage';
$opt[] = "--title \"InnoDB Insert Buffer Usage for $hostname $item\" ";
$def[] = ""

        . "DEF:ibuf_cell_count=$RRD[ibuf_cell_count] "
        . "AREA:ibuf_cell_count#793A57:\"Ibuf Cell Count\" "
        . "GPRINT:ibuf_cell_count:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:ibuf_cell_count:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:ibuf_cell_count:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:ibuf_used_cells=$RRD[ibuf_used_cells] "
        . "AREA:ibuf_used_cells#8C873E:\"Ibuf Used Cells \" "
        . "GPRINT:ibuf_used_cells:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:ibuf_used_cells:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:ibuf_used_cells:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:ibuf_free_cells=$RRD[ibuf_free_cells] "
        . "AREA:ibuf_free_cells#A38A5F:\"Ibuf Free Cells \":STACK "
        . "GPRINT:ibuf_free_cells:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:ibuf_free_cells:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:ibuf_free_cells:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB I/O';
$opt[] = "--title \"InnoDB I/O for $hostname $item\" ";
$def[] = ""

        . "DEF:file_reads=$RRD[file_reads] "
        . "LINE:file_reads#402204:\"File Reads \" "
        . "GPRINT:file_reads:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:file_reads:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:file_reads:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:file_writes=$RRD[file_writes] "
        . "LINE:file_writes#B3092B:\"File Writes\" "
        . "GPRINT:file_writes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:file_writes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:file_writes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:log_writes=$RRD[log_writes] "
        . "LINE:log_writes#FFBF00:\"Log Writes \" "
        . "GPRINT:log_writes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:log_writes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:log_writes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:file_fsyncs=$RRD[file_fsyncs] "
        . "LINE:file_fsyncs#0ABFCC:\"File Fsyncs\" "
        . "GPRINT:file_fsyncs:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:file_fsyncs:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:file_fsyncs:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB I/O Pending';
$opt[] = "--title \"InnoDB I/O Pending for $hostname $item\" ";
$def[] = ""

        . "DEF:pending_aio_log_ios=$RRD[pending_aio_log_ios] "
        . "LINE:pending_aio_log_ios#FF0000:\"Pending Aio Log IOs      \" "
        . "GPRINT:pending_aio_log_ios:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_aio_log_ios:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_aio_log_ios:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:pending_aio_sync_ios=$RRD[pending_aio_sync_ios] "
        . "LINE:pending_aio_sync_ios#FF7D00:\"Pending Aio Sync IOs     \" "
        . "GPRINT:pending_aio_sync_ios:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_aio_sync_ios:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_aio_sync_ios:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:pending_buf_pool_flushes=$RRD[pending_buf_pool_flushes] "
        . "LINE:pending_buf_pool_flushes#FFF200:\"Pending Buf Pool Flushes \" "
        . "GPRINT:pending_buf_pool_flushes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_buf_pool_flushes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_buf_pool_flushes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:pending_chkp_writes=$RRD[pending_chkp_writes] "
        . "LINE:pending_chkp_writes#00A348:\"Pending Chkp Writes      \" "
        . "GPRINT:pending_chkp_writes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_chkp_writes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_chkp_writes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:pending_ibuf_aio_reads=$RRD[pending_ibuf_aio_reads] "
        . "LINE:pending_ibuf_aio_reads#6DC8FE:\"Pending Ibuf Aio Reads   \" "
        . "GPRINT:pending_ibuf_aio_reads:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_ibuf_aio_reads:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_ibuf_aio_reads:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:pending_log_flushes=$RRD[pending_log_flushes] "
        . "LINE:pending_log_flushes#4444FF:\"Pending Log Flushes      \" "
        . "GPRINT:pending_log_flushes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_log_flushes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_log_flushes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:pending_log_writes=$RRD[pending_log_writes] "
        . "LINE:pending_log_writes#55009D:\"Pending Log Writes       \" "
        . "GPRINT:pending_log_writes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_log_writes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_log_writes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:pending_normal_aio_reads=$RRD[pending_normal_aio_reads] "
        . "LINE:pending_normal_aio_reads#B90054:\"Pending Normal Aio Reads \" "
        . "GPRINT:pending_normal_aio_reads:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_normal_aio_reads:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_normal_aio_reads:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:pending_normal_aio_writes=$RRD[pending_normal_aio_writes] "
        . "LINE:pending_normal_aio_writes#8F9286:\"Pending Normal Aio Writes\" "
        . "GPRINT:pending_normal_aio_writes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:pending_normal_aio_writes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:pending_normal_aio_writes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Lock Structures';
$opt[] = "--title \"InnoDB Lock Structures for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_lock_structs=$RRD[innodb_lock_structs] "
        . "LINE:innodb_lock_structs#0C4E5D:\"InnoDB Lock Structs\" "
        . "GPRINT:innodb_lock_structs:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_lock_structs:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_lock_structs:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Log Activity';
$opt[] = "--base 1024 --title \"InnoDB Log Activity for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_log_buffer_size=$RRD[innodb_log_buffer_size] "
        . "AREA:innodb_log_buffer_size#6E3803:\"InnoDB Log Buffer Size  \" "
        . "GPRINT:innodb_log_buffer_size:LAST:\"Cur\: %6.1lf%s\\n\" "

        . "DEF:log_bytes_written=$RRD[log_bytes_written] "
        . "AREA:log_bytes_written#5B8257:\"InnoDB Log Bytes Written\" "
        . "GPRINT:log_bytes_written:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:log_bytes_written:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:log_bytes_written:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:log_bytes_flushed=$RRD[log_bytes_flushed] "
        . "LINE:log_bytes_flushed#AB4253:\"InnoDB Log Bytes Flushed\" "
        . "GPRINT:log_bytes_flushed:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:log_bytes_flushed:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:log_bytes_flushed:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:unflushed_log=$RRD[unflushed_log] "
        . "AREA:unflushed_log#AFECED:\"Unflushed Log           \" "
        . "GPRINT:unflushed_log:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:unflushed_log:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:unflushed_log:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Memory Allocation';
$opt[] = "--base 1024 --title \"InnoDB Memory Allocation for $hostname $item\" ";
$def[] = ""

        . "DEF:total_mem_alloc=$RRD[total_mem_alloc] "
        . "AREA:total_mem_alloc#53777A:\"Total Mem Alloc      \" "
        . "GPRINT:total_mem_alloc:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:total_mem_alloc:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:total_mem_alloc:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:additional_pool_alloc=$RRD[additional_pool_alloc] "
        . "LINE:additional_pool_alloc#C02942:\"Additional Pool Alloc\" "
        . "GPRINT:additional_pool_alloc:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:additional_pool_alloc:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:additional_pool_alloc:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Row Lock Time';
$opt[] = "--title \"InnoDB Row Lock Time for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_row_lock_time=$RRD[innodb_row_lock_time] "
        . "AREA:innodb_row_lock_time#B11D03:\"InnoDB Row Lock Time\" "
        . "GPRINT:innodb_row_lock_time:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_row_lock_time:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_row_lock_time:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Row Lock Waits';
$opt[] = "--title \"InnoDB Row Lock Waits for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_row_lock_waits=$RRD[innodb_row_lock_waits] "
        . "AREA:innodb_row_lock_waits#E84A5F:\"InnoDB Row Lock Waits\" "
        . "GPRINT:innodb_row_lock_waits:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_row_lock_waits:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_row_lock_waits:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Row Operations';
$opt[] = "--title \"InnoDB Row Operations for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_rows_read=$RRD[innodb_rows_read] "
        . "AREA:innodb_rows_read#AFECED:\"Rows Read    \" "
        . "GPRINT:innodb_rows_read:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_rows_read:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_rows_read:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:innodb_rows_deleted=$RRD[innodb_rows_deleted] "
        . "AREA:innodb_rows_deleted#DA4725:\"Rows Deleted \":STACK "
        . "GPRINT:innodb_rows_deleted:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_rows_deleted:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_rows_deleted:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:innodb_rows_updated=$RRD[innodb_rows_updated] "
        . "AREA:innodb_rows_updated#EA8F00:\"Rows Updated \":STACK "
        . "GPRINT:innodb_rows_updated:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_rows_updated:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_rows_updated:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:innodb_rows_inserted=$RRD[innodb_rows_inserted] "
        . "AREA:innodb_rows_inserted#35962B:\"Rows Inserted\":STACK "
        . "GPRINT:innodb_rows_inserted:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_rows_inserted:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_rows_inserted:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

# TODO InnoDB Semaphores

$ds_name[] = 'MySQL InnoDB Semaphore Wait Time';
$opt[] = "--title \"InnoDB Semaphore Wait Time for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_sem_wait_time_ms=$RRD[innodb_sem_wait_time_ms] "
        . "AREA:innodb_sem_wait_time_ms#708226:\"Semaphore Wait Time ms\" "
        . "GPRINT:innodb_sem_wait_time_ms:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_sem_wait_time_ms:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_sem_wait_time_ms:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Semaphore Waits';
$opt[] = "--title \"InnoDB Semaphore Waits for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_sem_waits=$RRD[innodb_sem_waits] "
        . "AREA:innodb_sem_waits#7020AF:\"Semaphore Waits\" "
        . "GPRINT:innodb_sem_waits:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_sem_waits:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_sem_waits:MAX:\"Max\: %6.1lf%s\\n\" "
        
        . "";

# TODO InnoDB Tables In Use

$ds_name[] = 'MySQL InnoDB Transactions';
$opt[] = "--title \"InnoDB Transactions for $hostname $item\" ";
$def[] = ""

        . "DEF:innodb_transactions=$RRD[innodb_transactions] "
        . "LINE:innodb_transactions#8F005C:\"InnoDB Transactions\" "
        . "GPRINT:innodb_transactions:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:innodb_transactions:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:innodb_transactions:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:history_list=$RRD[history_list] "
        . "LINE:history_list#FF7D00:\"History List       \" "
        . "GPRINT:history_list:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:history_list:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:history_list:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL InnoDB Transactions Active/Locked';
$opt[] = "--title \"InnoDB Transactions Active/Locked for $hostname $item\" ";
$def[] = ""

        . "DEF:active_transactions=$RRD[active_transactions] "
        . "AREA:active_transactions#C0C0C0:\"Active Transactions \" "
        . "GPRINT:active_transactions:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:active_transactions:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:active_transactions:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:locked_transactions=$RRD[locked_transactions] "
        . "LINE:locked_transactions#FF0000:\"Locked Transactions \" "
        . "GPRINT:locked_transactions:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:locked_transactions:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:locked_transactions:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:current_transactions=$RRD[current_transactions] "
        . "LINE:current_transactions#4444FF:\"Current Transactions\" "
        . "GPRINT:current_transactions:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:current_transactions:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:current_transactions:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:read_views=$RRD[read_views] "
        . "LINE:read_views#74C366:\"Read Views          \" "
        . "GPRINT:read_views:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:read_views:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:read_views:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";

$ds_name[] = 'MySQL MyISAM Indexes';
$opt[] = "--title \"MySQL MyISAM Indexes for $hostname $item\" ";
$def[] = ""

        . "DEF:key_read_requests=$RRD[key_read_requests] "
        . "AREA:key_read_requests#157419:\"Key Read Requests \" "
        . "GPRINT:key_read_requests:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:key_read_requests:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:key_read_requests:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:key_reads=$RRD[key_reads] "
        . "LINE:key_reads#AFECED:\"Key Reads         \" "
        . "GPRINT:key_reads:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:key_reads:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:key_reads:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:key_write_requests=$RRD[key_write_requests] "
        . "CDEF:key_write_requests_neg=key_write_requests,-1,* "
        . "AREA:key_write_requests_neg#862F2F:\"Key Write Requests\" "
        . "GPRINT:key_write_requests:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:key_write_requests:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:key_write_requests:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:key_writes=$RRD[key_writes] "
        . "CDEF:key_writes_neg=key_writes,-1,* "
        . "LINE:key_writes_neg#F51D30:\"Key Writes        \" "
        . "GPRINT:key_writes:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:key_writes:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:key_writes:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";


$ds_name[] = 'MySQL MyISAM Key Cache';
$opt[] = "--base 1024 --title \"MySQL MyISAM Key Cache for $hostname $item\" ";
$def[] = ""

        . "DEF:key_buffer_size=$RRD[key_buffer_size] "
        . "AREA:key_buffer_size#99B898:\"Key Buffer Size           \" "
        . "GPRINT:key_buffer_size:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:key_buffer_size:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:key_buffer_size:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:key_buf_bytes_used=$RRD[key_buf_bytes_used] "
        . "AREA:key_buf_bytes_used#2A363B:\"Key Buffer Bytes Used     \" "
        . "GPRINT:key_buf_bytes_used:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:key_buf_bytes_used:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:key_buf_bytes_used:MAX:\"Max\: %6.1lf%s\\n\" "

        . "DEF:key_buf_bytes_unflushed=$RRD[key_buf_bytes_unflushed] "
        . "AREA:key_buf_bytes_unflushed#FECEA8:\"Key Buffer Bytes Unflushed\" "
        . "GPRINT:key_buf_bytes_unflushed:LAST:\"Cur\: %6.1lf%s\" "
        . "GPRINT:key_buf_bytes_unflushed:AVERAGE:\"Avg\: %6.1lf%s\" "
        . "GPRINT:key_buf_bytes_unflushed:MAX:\"Max\: %6.1lf%s\\n\" "

        . "";


?>
