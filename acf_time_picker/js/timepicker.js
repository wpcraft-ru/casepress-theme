/*
Attach a jQuery.datetimepicker() to "input[type=text].time_picker" fields. Will also attach to dynamic added fields.
*/
jQuery(function() {
	jQuery("body").on("focusin", "input[type=text].time_picker",  function(){
		self = jQuery(this);
		self.datetimepicker({
			timeOnly: (self.attr('data-date_format') == undefined),
			timeFormat: self.attr('data-time_format'),
			dateFormat: 'dd.mm.yy',
			showWeek: (self.attr('data-show_week_number') != "true") ? 0 : 1,
			ampm: (self.attr('data-time_format').search(/t/i) != -1),
			timeOnlyTitle: self.attr('title'),
			closeText: 'Выбрать',
			currentText: 'Сейчас',
			prevText: 'Предыдущий',
			nextText: 'Следующий',
			monthNames: timepicker_objectL10n.monthNames,
			monthNamesShort: timepicker_objectL10n.monthNamesShort,
			dayNames: timepicker_objectL10n.dayNames,
			dayNamesShort: timepicker_objectL10n.dayNamesShort,
			dayNamesMin: timepicker_objectL10n.dayNamesMin,
			weekHeader: timepicker_objectL10n.weekHeader,
			firstDay: timepicker_objectL10n.firstDay,
			isRTL: timepicker_objectL10n.isRTL,			
			timeText:   'Время',
			hourText:   'Часы',
			minuteText: 'Минуты',
			secondText: timepicker_objectL10n.secondText,
			millisecText: timepicker_objectL10n.millisecText,
			timezoneText: timepicker_objectL10n.timezoneText
		});
	});
});

