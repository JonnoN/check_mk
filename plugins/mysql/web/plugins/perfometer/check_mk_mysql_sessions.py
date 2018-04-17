def perfometer_check_mk_mysql_sessions(row, check_command, perf_data):

    running_threads = int(perf_data[1][1])
    warn_level = int(perf_data[1][3])
    crit_level = int(perf_data[1][4])

    if running_threads > crit_level:
        color = '#FF0000'
    elif running_threads > warn_level:
        color = '#FFFF00'
    else:
        color = '#00FF00'

    text = "%d running" % running_threads
    return text, perfometer_linear( running_threads, color )

perfometers["check_mk-mysql.sessions"] = perfometer_check_mk_mysql_sessions
perfometers["check_mk-mysql_multi.sessions"] = perfometer_check_mk_mysql_sessions
