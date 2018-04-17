def perfometer_check_mk_mysql_performance(row, check_command, perf_data):

    qps = int(float(perf_data[0][1]))
    warn_level = 750
    crit_level = 1500

    if qps > crit_level:
        color = '#FF0000'
    elif qps > warn_level:
        color = '#FFFF00'
    else:
        color = '#00FF00'

    text = "%d QPS" % qps
    return text, perfometer_logarithmic( qps, 250, 2, color )

perfometers["check_mk-mysql.performance"] = perfometer_check_mk_mysql_performance
perfometers["check_mk-mysql_multi.performance"] = perfometer_check_mk_mysql_performance
