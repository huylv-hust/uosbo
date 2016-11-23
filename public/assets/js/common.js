var message_confirm_del = '削除します、よろしいですか？';
var message_confirm_save = '保存します、よろしいですか？';
var message_approval_confirm = '承認します、よろしいですか？';
$(function() {
    $('.dateform').datepicker();

    //field required contain all space
    jQuery.validator.addMethod("check_all_space", function(value,element) {
        if(value.trim() != '') return true;
        return false;
    },'取引先区分を入力して下さい');
    //date format
    jQuery.validator.addMethod("date_format", function(value,element) {
        var list_month_30 = [4,6,9,11],
            list_month_31 = [1,3,5,7,8,10,12],
            leap_year = false;
        if(value == '') return true;
        if(value.match(/^\d{4}-\d{2}-\d{2}$/))
        {
            var arr = value.split('-'),
                year = parseInt(arr[0]),
                month = parseInt(arr[1]),
                day = parseInt(arr[2]);
            if((year % 100 != 0 && year % 4 == 0) || year % 400 == 0) leap_year = true;
            if(((month < 1 || month > 12) || day < 1 || year < 1)
                || (leap_year == true && month == 2 && day > 29)
                || (leap_year == false && month == 2 && day > 28)
                || ($.inArray(month,list_month_30) >=0 && day > 30)
                || ($.inArray(month,list_month_31) >=0 && day > 31))
                return false;

            return true;
        }
        return false;
    });

    //date time format
    jQuery.validator.addMethod("date_time_format", function(value,element) {
        var list_month_30 = [4,6,9,11],
            list_month_31 = [1,3,5,7,8,10,12],
            leap_year = false;
        if(value == '') return true;
        if(value.match(/^\d{4}-\d{2}-\d{2}\s([01]?[0-9]|2[0-3]):[0-5][0-9]:\d{2}$/)){
            var arr = value.split('-'),
                year = parseInt(arr[0]),
                month = parseInt(arr[1]),
                day = parseInt(arr[2]);
            if((year % 100 != 0 && year % 4 == 0) || year % 400 == 0) leap_year = true;
            if(((month < 1 || month > 12) || day < 1 || year < 1)
                || (leap_year == true && month == 2 && day > 29)
                || (leap_year == false && month == 2 && day > 28)
                || ($.inArray(month,list_month_30) >=0 && day > 30)
                || ($.inArray(month,list_month_31) >=0 && day > 31))
                return false;

            return true;
        }
        return false;
    });

    //HH validate
    jQuery.validator.addMethod("date_hh_format", function(value,element) {
        if(value == '') return true;
        if(value.match(/^([01]?[0-9]|2[0-3])$/) || value.match(/^[0-9]$/)){
            return true;
        }
        return false;
    });
    //MM validate
    jQuery.validator.addMethod("date_mm_format", function(value,element) {
        if(value == '') return true;
        if(value.match(/^([0-5][0-9])$/) || value.match(/^[0-9]$/)  ){
            return true;
        }
        return false;
    });

	//phone format
	jQuery.validator.addMethod("tel_format", function(value,element) {
		if(value == '') return true;
		if(value.length == 10 || value.length == 11)
		{
			var first_char = value.substr(0, 1);
			if(first_char == 0)
				return true;
		}
		return false;
	},'正しい電話番号をご入力下さい。');

	jQuery.validator.addMethod("maxlength_sjis", function(value,element,params) {
		var maxlen = 10;
		if (params === undefined)
		{
			 maxlen = $(element).attr('maxlength');
		}
		else
		{
			maxlen = params;
		}
		return this.optional(element) || utility.getSjisLength(value) <= maxlen;
	},'文字数オーバーです');

	jQuery.validator.addMethod("maxlength_textarea", function(value,element,params) {
		var length = utility.getTextareaLength(value);
		if(params == undefined || length > params) {
			return false;
		}
		return true;
	});

	$('button[name=filter-clear-btn]').on('click', function()
	{
		window.location.href = window.location.href.replace(/\?.*$/, '');
	});

	if (window.location.href.match(/\?.*$/) === null)
	{
		$('button[name=filter-clear-btn]').hide();
	}

	$.widget("custom.combobox", {
		_create: function()
		{
			this.wrapper = $("<span>").addClass("custom-combobox")
			.insertAfter( this.element );

			this.element.hide();
			this._createAutocomplete();
			this._createShowAllButton();
		},
		_createAutocomplete: function()
		{
			var
				selected = this.element.children(":selected"),
				value = selected.val() ? selected.text() : "";

			this.input = $("<input>")
				.appendTo(this.wrapper)
				.val(value)
				.attr("title", "")
				.addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
				.autocomplete({
					delay: 0,
					minLength: 0,
					source: $.proxy(this, "_source")
				})
				.tooltip({
					tooltipClass: "ui-state-highlight"
				});

			this._on( this.input, {
				autocompleteselect: function(event, ui)
				{
					ui.item.option.selected = true;
					this._trigger("select", event, {
						item: ui.item.option
					});
				},

				autocompletechange: "_removeIfInvalid"
			});
		},

		_createShowAllButton: function()
		{
			var input = this.input, wasOpen = false;

			$("<a>")
				.attr("tabIndex", -1)
				.attr("title", "全てのデータを表示します")
				.tooltip()
				.appendTo(this.wrapper)
				.button({
					icons: {
						primary: "ui-icon-triangle-1-s"
					},
					text: false
				})
				.removeClass("ui-corner-all")
				.addClass("custom-combobox-toggle ui-corner-right")
				.mousedown(function()
				{
					wasOpen = input.autocomplete( "widget" ).is( ":visible" );
				})
				.click(function()
				{
					input.focus();

					// Close if already visible
					if ( wasOpen ) {
						return;
					}

					// Pass empty string as value to search for, displaying all results
					input.autocomplete( "search", "" );
				});
		},

		_source: function(request, response)
		{
			var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
			response(this.element.children("option").map(function()
			{
				var text = $( this ).text();
				if (this.value && ( !request.term || matcher.test(text)))
				return {
					label: text,
					value: text,
					option: this
				};
			}));
		},

		_removeIfInvalid: function(event, ui)
		{
			// Selected an item, nothing to do
			if ( ui.item ) {
				return;
			}

			// Search for a match (case-insensitive)
			var
				value = this.input.val(),
				valueLowerCase = value.toLowerCase(),
				valid = false;

			this.element.children("option").each(function()
			{
				if ($(this).text().toLowerCase() === valueLowerCase) {
					this.selected = valid = true;
					return false;
				}
			});

			// Found a match, nothing to do
			if (valid) {
				return;
			}

			// Remove invalid value
			this.input
				.val("")
				.attr("title", "「" + value + "」に該当するデータがありません")
				.tooltip("open");
			this.element.val("");
			this._delay(function()
			{
				this.input.tooltip("close").attr("title", "");
			}, 2500);
			this.input.autocomplete("instance").term = "";
		},

		_destroy: function()
		{
			this.wrapper.remove();
			this.element.show();
		}
	});

});