// Data Group
members = _.groupBy(members, function (member) {
	return member.dep_name;
});
_.each(graduate, function (elem, index, list) {
	list[index] = _.groupBy(elem, function(obj) {
		return obj.date;
	});
	_.each(list[index], function (date, i, month) {
		month[i] = _.pluck(date, 'name');
	});
});

// Render Table
(function () {
	var tbody = $("tbody"),
			monthTranslate = ['一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二'],
			lastDay = new Date(),
			outCount = [],
			leaveFixed = leaveDays, weekIndex, monthShift, bye, tmp, trMember, accuDays, todayLeave, dep, i, j, member, first, incampDays, html = '';
	
	lastDay.setFullYear(year);
	lastDay.setMonth(month);
	lastDay.setDate(0);
	
	// 退伍統計初始化
	for (i = 0; i < totalDays; i += 1) {
		outCount[i] = 0;
	}
			
	for (dep in members) {
		first = true;
		for (member in members[dep]) {
			leaveFixed = leaveDays;
			accuDays = members[dep][member].list.accuLeave;
			members[dep][member].list.days = _.pluck(members[dep][member].list.list, 'date');
			members[dep][member].list.days = _.map(members[dep][member].list.days, function (date) {
				return parseInt(date.split('-')[2], 10);
			});
			if (first) {
				html += '<tr class="member"><th class="head" rowspan="' + members[dep].length + '">' + dep + '</th>';
				first = false;
			} else {
				html += '<tr class="member">'
			}
			html += '<th class="head">' + members[dep][member].rank_name + '</th>';
			html += '<th class="head">' + members[dep][member].name + '</th>';
			
			// 取得退伍日
			bye = new Date();
			tmp = members[dep][member].end_date.split('-');
			bye.setFullYear(tmp[0]);
			bye.setMonth(parseInt(tmp[1], 10) - 1);
			bye.setDate(tmp[2]);
			if (bye.getFullYear() == lastDay.getFullYear() && bye.getMonth() == lastDay.getMonth()){
				incampDays = bye.getDate();
			} else {
				incampDays = totalDays;
			}
			
			// 顯示勾選假日
			for (i = 1; i <= totalDays; i += 1) {
				if (incampDays == 0) {
					for (j = i; j <= totalDays; j += 1) {
						outCount[j - 1] += 1;
					}
					leaveFixed = Math.floor((i / totalDays) * leaveDays);
					html += "<td class='head' colspan='" + (lastDay.getDate() - bye.getDate()) + "'>榮退</td>";
					break;
				}
				incampDays--;
				if ($.inArray(i, members[dep][member].list.days) == -1) {
					html += '<td></td>';
				} else {
					if (accuDays) {
						html += '<td class="check">#</td>';
						accuDays -= 1;
					} else {
						html += '<td class="check">v</td>';
					}
				}
			}
			
			html += '<td class="head">' + leaveFixed + '</td>';
			html += '<td class="head">' + (leaveFixed + members[dep][member].list.accuLeave - members[dep][member].list.days.length) + '</td>';
			html += '</tr>';
		}
	}
	tbody.append(html);
	
	// 月份偏移
	monthShift = function (start, shift) {
		var month;
		if ((start + shift) > 12) {
			month = (start + shift) % 12
		} else {
			month = start + shift;
		}
		return month;
	}
	
	// 在營人數
	html = '<tr><th></th><th colspan="2">在營人數</th>';
	trMember = $("tr.member");
	for (i = 0; i < totalDays; i += 1) {
		todayLeave = 0;
		trMember.each(function () {
			if ($(this).find('td').eq(i).hasClass('check')) {
				todayLeave += 1;
			}
		});
		html += '<td>' + (trMember.length - todayLeave - outCount[i]) + '</td>';
	}
	html += '<td colspan="2"></td></tr>';
	
	// 備考
	html += '<tr><th rowspan="2">備考</th><td style="text-align: left !important;" colspan="' + (4 + totalDays) + '">一、本表呈閱由中隊長核准後按表實施休假，非經中隊長同意不可擅自調休。</td></tr>'
	html += '<tr><td style="text-align: left !important;" colspan="' + (4 + totalDays) + '">二、休示例休，＃示積休。每年1、3、4、5、7、10、12月例假為10日，2、6、8、9、11月例假為9日，合計114日。</td></tr>'
	
	// 退伍弟兄
	html += '<tr><th colspan="10">' + monthTranslate[monthShift(month, 3) - 1] + '月份</th>';
	html += '<th colspan="' + (totalDays - 15) + '">' + monthTranslate[monthShift(month, 4) - 1] + '月份</th>';
	html += '<th colspan="10">' + monthTranslate[monthShift(month, 5) - 1] + '月份</th>';
	html += '</tr>';
	html += '<tr><td colspan="10">';
	for (i in graduate[monthShift(month, 3)]) {
		html += '<p class="text-left">' + i + ' ' + graduate[monthShift(month, 3)][i].join(', ') + '</p>'
	}
	html += '<p>※  請於' + month + '月5日前繳交退伍相關資料</p></td>';
	html += '<td colspan="' + (totalDays - 15) + '">';
	for (i in graduate[monthShift(month, 4)]) {
		html += '<p class="text-left">' + i + ' ' + graduate[monthShift(month, 4)][i].join(', ') + '</p>'
	}
	html += '<p>※  請於' + monthShift(month, 1) + '月5日前繳交退伍相關資料</p></td>';
	html += '<td colspan="10">';
	for (i in graduate[monthShift(month, 5)]) {
		html += '<p class="text-left">' + i + ' ' + graduate[monthShift(month, 5)][i].join(', ') + '</p>'
	}
	html += '<p>※  請於' + monthShift(month, 2) + '月5日前繳交退伍相關資料</p></td>';
	html += '</tr>';
	// 擬陳
	html += '<tr><td style="text-align: right !important;" colspan="' + (5 + totalDays) + '">擬陳核後按表排休：例假' + leaveDays + '日</td></tr>'
	tbody.append(html);
	
	// 標註假日
	weekIndex = $("#week th:not(:first)");
	$("tr.member").each(function () {
		var tr = $(this);
		$("th.holiday").each(function () {
			tr.find("td").eq(weekIndex.index($(this))).addClass('holiday');
		});
	});
})()