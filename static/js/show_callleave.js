var date = new Date(),
		rank = $("#rank").text(),
		name = $("#name").text(),
		year = parseInt($("#year").text(), 10),
		month = parseInt($("#month").text(), 10),
		leaveDays = [10, 9, 10, 10, 10, 9, 10, 9, 10, 10, 9, 10],
		weeks = ['日', '一', '二', '三', '四', '五', '六'],
		accuLeave = parseInt($("#accuLeave").text(), 10),
		uncheckDays = parseInt($("#unchecked").text(), 10),
		holiday, endYear, endMonth, endDate, startYear, startMonth, startDate, graduate = false, graduateTD = false, uncheckOne, checkOne, fetch_data, fillMonthZero, Table;

$.ajaxSetup({
	cache: false
});

// Start/End Date Parse
endYear = ENDDATE.split('-');
endMonth = parseInt(endYear[1], 10);
endDate = parseInt(endYear[2], 10);
endYear = parseInt(endYear[0], 10) - 1911;

startYear = STARTDATE.split('-');
startMonth = parseInt(startYear[1], 10);
startDate = parseInt(startYear[2], 10);
startYear = parseInt(startYear[0], 10) - 1911;

// Table Model
Table = function (list, days, accuLeave) {
	this.list = _.map(list, function (day, key) {
		var tmp = day.split('-');
		return parseInt(tmp[2], 10);
	});
	this.days = days;
	this.accuLeave = accuLeave;
	this.table = $("<table>").addClass('table table-hover table-bordered');
}

Table.prototype.get_table = function () {
	this.table.append($("caption").clone().find('#year').text(year).end().find('#month').text(fillMonthZero(month)).end());
	this.table.append('<thead></thead>');
	this.table.append('<tbody></tbody>');
	
	var thead = this.table.find('thead').append('<tr><th rowspan="2">級職</th><th>日期</th></tr><tr><th>星期</th></tr>'),
			tbody = this.table.find('tbody').append('<tr><td class="head">' + rank + '</td><td class="head">' + name + '</td></tr><tr><td colspan="' + (parseInt(this.days, 10) + 2) + '"></td></tr>'),
			dayLine = thead.find('tr:first'),
			weekLine = thead.find('tr:eq(1)'),
			dataLine = tbody.find('tr:first'),
			accu = accuLeave,
			leaveFixed = leaveDays[month - 1],
			i, infoLine, tmp = '', tmp2 = '', tmp3, tmp4 = '';
			
	if (endYear == year && endMonth == month) {
		graduate = true;
		graduateTD = false;
	} else {
		graduate = false;
	}
	
	$(".change_month").show();
	if (startYear == year && startMonth == month) {
		$("#prevMonth").hide();
	}
			
	for (i = 1, l = this.days; i <= l; i += 1) {
		tmp += '<th>' + i + '</th>';
		tmp3 = new Date();
		tmp3.setFullYear(year + 1911);
        tmp3.setDate(1);
		tmp3.setMonth(month - 1);
		tmp3.setDate(i);
		tmp2 += '<th>' + weeks[tmp3.getDay()] + '</th>';
		
		if (graduate && i > endDate) {
			if (!graduateTD) {
				leaveFixed = Math.round(((i - 1) / this.days) * leaveFixed)
                tmp4 += '<td colspan="' + (TOTALDATE - endDate) + '">榮退</td>';
				graduateTD = true;
				$("#nextMonth").hide();
			}
		}	else {
			if ($.inArray(i, this.list) == -1) {
				tmp4 += '<td></td>';
			} else {
				if (accu) {
					tmp4 += '<td class="check">#</td>';
					accu--;
				} else {
					tmp4 += '<td class="check">v</td>';
				}
			}
		}
	}
	dayLine.append(tmp);
	weekLine.append(tmp2);
	dataLine.append(tmp4);
	
	infoLine = tbody.find('tr:eq(1) td').append($("table tbody tr:eq(1) td").html())
	infoLine.find('#leave-days').text(leaveFixed);
	infoLine.find('#checked').text(this.list.length);
	infoLine.find("#accuLeave").text(this.accuLeave);
	infoLine.find('#unchecked').text(leaveFixed - this.list.length + parseInt(this.accuLeave, 10));
	uncheckDays = leaveFixed - this.list.length + parseInt(this.accuLeave, 10);
	
	return this.table.html();
}

// Fill Zero for Month
fillMonthZero = function (m) {
	if (parseInt(m, 10) < 10) {
		return '0' + m;
	}
	return m;
}
		
// Fetch Callleave Date
fetch_data = function () {
	$.getJSON('/callleave/get_leave_date', {month: (year + 1911) + '-' + month}, function (json) {
		var callleave = _.pluck(json.list, 'date'),
				table = new Table(callleave, json.monthDays, json.accuLeave),
				date = new Date();
				
		accuLeave = parseInt(json.accuLeave, 10);
		$("table").html(table.get_table());
		date.setFullYear(year);
		date.setDate(1);
		date.setMonth(month - 2);
		$("#prevMonth").html("<i class='icon-chevron-left icon-white'></i> " + date.getFullYear() + '-' + fillMonthZero(date.getMonth() + 1));
		date.setFullYear(year);
		date.setMonth(month);
		$("#nextMonth").html(date.getFullYear() + '-' + fillMonthZero(date.getMonth() + 1) + " <i class='icon-chevron-right icon-white'></i>");
		holiday();
	});
}
		
// Uncheck Call
uncheckOne = function () {
	uncheckDays++;
	$("#checked").text($(".check").length);
	$("#unchecked").text(uncheckDays);
}

// Check Call
checkOne = function () {
	uncheckDays--;
	$("#checked").text($(".check").length);
	$("#unchecked").text(uncheckDays);
}
		
// Check Call Click Listener
$("table").delegate('tbody tr:first > td:not(.head)', 'click', function (e) {
	$this = $(this);
	
	if ($this.hasClass('check')) {
		$this.removeClass('check');
		$this.text('');
		$(".check").text('v');
		for (var i = 0; i < accuLeave; i++) {
			$(".check").eq(i).text('#');
		}
		uncheckOne();
	} else if (uncheckDays){
		$this.addClass('check');
		$(".check").text('v');
		for (var i = 0; i < accuLeave; i++) {
			$(".check").eq(i).text('#');
		}
		checkOne();
	} else {
		alert('大哥你沒假了喔!');
	}
});

// Previus Month
$(".change_month").click(function (e) {
	var $this = $(this),
        target = $this.text().split('-');
    
    submit(function () {
        year = parseInt(target[0], 10);
        month = parseInt(target[1], 10);
        
        fetch_data();
    });
});

$("#submit").click(function(){
    submit();
});

// Save Change
function submit(callback) {
	var callleave = [],
        deleteOnly = -1,
        mother = $("tbody tr:first > td:not(:first)"),
        alertShow = typeof callback === 'function' ? false : true;
	
    
    callback = callback || function(){};
    
	$(".check").each(function (e) {
		var date = new Date();
		date.setFullYear(year + 1911);
        date.setDate(1);
		date.setMonth(month - 1);
		date.setDate(mother.index($(this)));
		callleave.push(date.getTime());
	});
	
	if (0 > parseInt($("#unchecked").text(), 10)) {
		alert('您的放假天數超過規定，請修改後再送出');
		return;
	}
	
	if (!$(".check").length) {
		deleteOnly = 1;
		var date = new Date();
		date.setFullYear(year + 1911);
        date.setDate(1);
		date.setMonth(month - 1);
		callleave.push(date.getTime());
	}

	$.post('/callleave/set_leave', {date: callleave, deleteOnly: deleteOnly}, function (json) {
		if (json.status == 'success') {
            if (alertShow) {
                alert('已更新您的假表');
            }
        }
        if (json.status == 'deleted')
            alert('因為您本月的剩餘積休不足，使得未來假不夠用，所以已將未來預休假表清除\n麻煩您再重新填寫！');
        callback();
	}, 'json');
}

// Highlight Holiday
holiday = function () {
	var weeks = $("thead tr:eq(1) th:not(:first)"),
			memberRow = $("tbody tr:first td:not(.head)");
			
	weeks.each(function () {
		if ($(this).text() == '六' || $(this).text() == '日') {
			memberRow.eq(weeks.index($(this))).addClass('holiday');
		}
	});
}

holiday();
