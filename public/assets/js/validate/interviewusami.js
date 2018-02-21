var interviewusami = function () {

	var validate = function () {
		jQuery.validator.addMethod("start_end_format1", function (value, element) {
			var start_hour = ($('#start_hour1').val() == '') ? '0' : $('#start_hour1').val(),
					start_minute = ($('#start_minute1').val() == '') ? '0' : ($('#start_minute1').val().length > 1 ? $('#start_minute1').val() : '0' + $('#start_minute1').val()),
					end_hour = $('#end_hour1').val() == '' ? '0' : $('#end_hour1').val(),
					end_minute = $('#end_minute1').val() == '' ? '0' : ($('#end_minute1').val().length > 1 ? $('#end_minute1').val() : '0' + $('#end_minute1').val()),
					start_int = parseInt(start_hour + start_minute),
					end_int = parseInt(end_hour + end_minute);

			if (start_hour == '0' && start_minute == '0' && end_hour == '0' && end_minute == '0')
				return true;
			if (end_int > start_int)
				return true;
			return false
		});
		jQuery.validator.addMethod("start_end_format2", function (value, element) {
			var start_hour = ($('#start_hour2').val() == '') ? '0' : $('#start_hour2').val(),
					start_minute = ($('#start_minute2').val() == '') ? '0' : ($('#start_minute2').val().length > 1 ? $('#start_minute2').val() : '0' + $('#start_minute2').val()),
					end_hour = $('#end_hour2').val() == '' ? '0' : $('#end_hour2').val(),
					end_minute = $('#end_minute2').val() == '' ? '0' : ($('#end_minute2').val().length > 1 ? $('#end_minute2').val() : '0' + $('#end_minute2').val()),
					start_int = parseInt(start_hour + start_minute),
					end_int = parseInt(end_hour + end_minute);

			if (start_hour == '0' && start_minute == '0' && end_hour == '0' && end_minute == '0')
				return true;
			if (end_int > start_int)
				return true;
			return false
		});
		jQuery.validator.addMethod("start_end_format3", function (value, element) {
			var start_hour = ($('#start_hour3').val() == '') ? '0' : $('#start_hour3').val(),
					start_minute = ($('#start_minute3').val() == '') ? '0' : ($('#start_minute3').val().length > 1 ? $('#start_minute3').val() : '0' + $('#start_minute3').val()),
					end_hour = $('#end_hour3').val() == '' ? '0' : $('#end_hour3').val(),
					end_minute = $('#end_minute3').val() == '' ? '0' :($('#end_minute3').val().length > 1 ? $('#end_minute3').val() : '0' + $('#end_minute3').val()),
					start_int = parseInt(start_hour + start_minute),
					end_int = parseInt(end_hour + end_minute);

			if (start_hour == '0' && start_minute == '0' && end_hour == '0' && end_minute == '0')
				return true;
			if (end_int > start_int)
				return true;
			return false
		});
		jQuery.validator.addMethod("start_end_format4", function (value, element) {
			var start_hour = ($('#start_hour4').val() == '') ? '0' : $('#start_hour4').val(),
					start_minute = ($('#start_minute4').val() == '') ? '0' : ($('#start_minute4').val().length > 1 ? $('#start_minute4').val() : '0' + $('#start_minute4').val()),
					end_hour = $('#end_hour4').val() == '' ? '0' : $('#end_hour4').val(),
					end_minute = $('#end_minute4').val() == '' ? '0' : ($('#end_minute4').val().length > 1 ? $('#end_minute4').val() : '0' + $('#end_minute4').val()),
					start_int = parseInt(start_hour + start_minute),
					end_int = parseInt(end_hour + end_minute);

			if (start_hour == '0' && start_minute == '0' && end_hour == '0' && end_minute == '0')
				return true;
			if (end_int > start_int)
				return true;
			return false
		});
		jQuery.validator.addMethod("start_end_format5", function (value, element) {
			var start_hour = ($('#start_hour5').val() == '') ? '0' : $('#start_hour5').val(),
					start_minute = ($('#start_minute5').val() == '') ? '0' : ($('#start_minute5').val().length > 1 ? $('#start_minute5').val() : '0' + $('#start_minute5').val()),
					end_hour = $('#end_hour5').val() == '' ? '0' : $('#end_hour5').val(),
					end_minute = $('#end_minute5').val() == '' ? '0' : ($('#end_minute5').val().length > 1 ? $('#end_minute5').val() : '0' + $('#end_minute5').val()),
					start_int = parseInt(start_hour + start_minute),
					end_int = parseInt(end_hour + end_minute);

			if (start_hour == '0' && start_minute == '0' && end_hour == '0' && end_minute == '0')
				return true;
			if (end_int > start_int)
				return true;
			return false
		});
		jQuery.validator.addMethod("start_end_format6", function (value, element) {
			var start_hour = ($('#start_hour6').val() == '') ? '0' : $('#start_hour6').val(),
					start_minute = ($('#start_minute6').val() == '') ? '0' : ($('#start_minute6').val().length > 1 ? $('#start_minute6').val() : '0' + $('#start_minute6').val()),
					end_hour = $('#end_hour6').val() == '' ? '0' : $('#end_hour6').val(),
					end_minute = $('#end_minute6').val() == '' ? '0' : ($('#end_minute6').val().length > 1 ? $('#end_minute6').val() : '0' + $('#end_minute6').val()),
					start_int = parseInt(start_hour + start_minute),
					end_int = parseInt(end_hour + end_minute);

			if (start_hour == '0' && start_minute == '0' && end_hour == '0' && end_minute == '0')
				return true;
			if (end_int > start_int)
				return true;
			return false
		});
		jQuery.validator.addMethod('myfloat',function(value,element){
			if(value == '' || value == 0 || value.match(/^(\d)*$/) || value.match(/^\d.\d{1}$/) || value.match(/^(\d)*.\d{1}$/))
			{
				return true;
			}
			else
			{
				return false;
			}
		});
		jQuery.validator.addMethod('latin',function(value,element){
                    if(value == '' || value.match(/^([A-Za-z0-9]+)*$/))
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });
		jQuery.validator.addMethod("start_end_format7", function (value, element) {
			var start_hour = ($('#start_hour7').val() == '') ? '0' : $('#start_hour7').val(),
					start_minute = ($('#start_minute7').val() == '') ? '0' : ($('#start_minute7').val().length > 1 ? $('#start_minute7').val() : '0' + $('#start_minute7').val()),
					end_hour = $('#end_hour7').val() == '' ? '0' : $('#end_hour7').val(),
					end_minute = $('#end_minute7').val() == '' ? '0' : ($('#end_minute7').val().length > 1 ? $('#end_minute7').val() : '0' + $('#end_minute7').val()),
					start_int = parseInt(start_hour + start_minute),
					end_int = parseInt(end_hour + end_minute);

			if (start_hour == '0' && start_minute == '0' && end_hour == '0' && end_minute == '0')
				return true;
			if (end_int > start_int)
				return true;
			return false
		});
		jQuery.validator.addMethod("required_one_working_arrangement", function (value, element) {
			if ($('[id^=working_arrangements]:checked').length > 0)
				return true;
			return false;
		});
		jQuery.validator.addMethod("day_min_max", function (value, element) {
			var min_day = $('#work_day_week_min').val(),
					max_day = $('#work_day_week_max').val();

			if (min_day != '' && max_day != '' && parseInt(min_day) >= parseInt(max_day))
				return false;
			return true;
		});
		jQuery.validator.addMethod("hour_min_max", function (value, element) {
			var min_hour = $('#work_day_month_min').val(),
					max_hour = $('#work_day_month_max').val();

			if (min_hour != '' && max_hour != '' &&  parseInt(min_hour) >= parseInt(max_hour))
				return false;
			return true;
		});
		$('#interviewusami_form').validate({
			groups: {
				zipcode: 'data[zipcode_1] data[zipcode_2]',
				time1: 'data[start_hour1] data[start_minute1] data[end_hour1] data[end_minute1] data[working_arrangements1]',
				time2: 'data[start_hour2] data[start_minute2] data[end_hour2] data[end_minute2] data[working_arrangements2]',
				time3: 'data[start_hour3] data[start_minute3] data[end_hour3] data[end_minute3] data[working_arrangements3]',
				time4: 'data[start_hour4] data[start_minute4] data[end_hour4] data[end_minute4] data[working_arrangements4]',
				time5: 'data[start_hour5] data[start_minute5] data[end_hour5] data[end_minute5] data[working_arrangements5]',
				time6: 'data[start_hour6] data[start_minute6] data[end_hour6] data[end_minute6] data[working_arrangements6]',
				time7: 'data[start_hour7] data[start_minute7] data[end_hour7] data[end_minute7] data[working_arrangements7]',
				experience_year_month: 'data[experience_year] data[experience_month]',
				work_starttime: 'data[work_starttime_date] data[work_starttime_hour] data[work_starttime_minute]',
				day_min_max: 'data[work_day_week_min] data[work_day_week_max]',
				hour_min_max: 'data[work_day_month_min] data[work_day_month_max]',
				student: 'data[occupation_student_grade] data[occupation_student_year]'
			},
			rules: {
				'data[interview_day]': {
					date_format: true
				},
				'data[zipcode_1]': {
					required: function () {
						if ($('#zipcode_2').val() != '')
							return true;
						return false;
					},
					digits: true,
					minlength: 3,
					maxlength: 3
				},
				'data[zipcode_2]': {
					required: function () {
						if ($('#zipcode_1').val() != '')
							return true;
						return false;
					},
					digits: true,
					minlength: 4,
					maxlength: 4
				},
				'data[commuting_means_bus]': {
					required: function (element) {
						if ($('input[id=commuting5]').is(':checked'))
							return true;
						else
							return false;
					},
					digits: true,
					max: 2147483647
				},
				'data[commuting_means_train]': {
					required: function (element) {
						if ($('input[id=commuting6]').is(':checked'))
							return true;
						else
							return false;
					},
					digits: true,
					max: 2147483647
				},
				'data[work_location_hope1]': {
					required: true
				},
                                'data[commute_dis]': {
					required: true,
                                        digits: false,
                                        myfloat:true,
                                        max:2147483647
				},
				'data[work_location_hope1_time]': {
					required: true,
					digits: true,
					max: 2147483647
				},
				'data[work_location_hope2_time]': {
					digits: true,
					max: 2147483647
				},
				'data[working_arrangements1]': {
					required_one_working_arrangement: true
				},
				'data[working_arrangements2]': {
					required_one_working_arrangement: true
				},
				'data[working_arrangements3]': {
					required_one_working_arrangement: true
				},
				'data[working_arrangements4]': {
					required_one_working_arrangement: true
				},
				'data[working_arrangements5]': {
					required_one_working_arrangement: true
				},
				'data[working_arrangements6]': {
					required_one_working_arrangement: true
				},
				'data[working_arrangements7]': {
					required_one_working_arrangement: true
				},
				//time 1
				'data[start_hour1]': {
					required: function () {
						if($('#working_arrangements1:checked').length > 0)
							return true;
						return false
					},
					date_hh_format: true,
					start_end_format1: true
				},
				'data[start_minute1]': {
					required: function () {
						if($('#working_arrangements1:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format1: true
				},
				'data[end_hour1]': {
					required: function () {
						if($('#working_arrangements1:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format1: true
				},
				'data[end_minute1]': {
					required: function () {
						if($('#working_arrangements1:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format1: true
				},
				//time2
				'data[start_hour2]': {
					required: function () {
						if($('#working_arrangements2:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format2: true
				},
				'data[start_minute2]': {
					required: function () {
						if($('#working_arrangements2:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format2: true
				},
				'data[end_hour2]': {
					required: function () {
						if($('#working_arrangements2:checked').length > 0)
							return true;
						return false
					},
					date_hh_format: true,
					start_end_format2: true
				},
				'data[end_minute2]': {
					required: function () {
						if($('#working_arrangements2:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format2: true
				},
				//time3
				'data[start_hour3]': {
					required: function () {
						if($('#working_arrangements3:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format3: true
				},
				'data[start_minute3]': {
					required: function () {
						if($('#working_arrangements3:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format3: true
				},
				'data[end_hour3]': {
					required: function () {
						if($('#working_arrangements3:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format3: true
				},
				'data[end_minute3]': {
					required: function () {
						if($('#working_arrangements3:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format3: true
				},
				//time4
				'data[start_hour4]': {
					required: function () {
						if($('#working_arrangements4:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format4: true
				},
				'data[start_minute4]': {
					required: function () {
						if($('#working_arrangements4:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format4: true
				},
				'data[end_hour4]': {
					required: function () {
						if($('#working_arrangements4:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format4: true
				},
				'data[end_minute4]': {
					required: function () {
						if($('#working_arrangements4:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format4: true
				},
				//time5
				'data[start_hour5]': {
					required: function () {
						if($('#working_arrangements5:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format5: true
				},
				'data[start_minute5]': {
					required: function () {
						if($('#working_arrangements5:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format5: true
				},
				'data[end_hour5]': {
					required: function () {
						if($('#working_arrangements5:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format5: true
				},
				'data[end_minute5]': {
					required: function () {
						if($('#working_arrangements5:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format5: true
				},
				//time6
				'data[start_hour6]': {
					required: function () {
						if($('#working_arrangements6:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format6: true
				},
				'data[start_minute6]': {
					required: function () {
						if($('#working_arrangements6:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format6: true
				},
				'data[end_hour6]': {
					required: function () {
						if($('#working_arrangements6:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format6: true
				},
				'data[end_minute6]': {
					required: function () {
						if($('#working_arrangements6:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format6: true
				},
				//time7
				'data[start_hour7]': {
					required: function () {
						if($('#working_arrangements7:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format7: true
				},
				'data[start_minute7]': {
					required: function () {
						if($('#working_arrangements7:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format7: true
				},
				'data[end_hour7]': {
					required: function () {
						if($('#working_arrangements7:checked').length > 0)
							return true;
						return false;
					},
					date_hh_format: true,
					start_end_format7: true
				},
				'data[end_minute7]': {
					required: function () {
						if($('#working_arrangements7:checked').length > 0)
							return true;
						return false;
					},
					date_mm_format: true,
					start_end_format7: true
				},
				'data[work_day_week_min]': {
					digits: true,
					max: 7,
					day_min_max: true
				},
				'data[work_day_week_max]': {
					digits: true,
					max: 7,
					day_min_max: true
				},
				'data[work_day_month_min]': {
					digits: true,
					max: 744,
					hour_min_max: true
				},
				'data[work_day_month_max]': {
					digits: true,
					max: 200,
					hour_min_max: true
				},
				'data[month_wage]': {
					digits: true,
					max: 2147483647
				},
				'data[time_of_service]': {
					required: true
				},
				'data[employment_month]': {
					digits: true,
					max: 2147483647
				},
				'data[employment_day]': {
					digits: true,
					max: 2147483647
				},
				'data[media_app]': {
					required: true
				},
				'data[media_app_other]': {
					required: function () {
						return $('#media_app_4').is(':checked');
					}
				},
				'data[experience_year_position_before]': {
					digits: true,
					max: 2147483647
				},
				'data[experience_year]': {
					digits: true,
					max: 2147483647
				},
				'data[experience_month]': {
					digits: true,
					max: 2147483647
				},
				'data[pc_skin_other]': {
					required: function () {
						return $('#pc_skill3').is(':checked');
					}
				},
				'data[occupation]': {
					required: true
				},
				'data[occupation_company_name]': {
					required: function () {
						return $('#occupation option[value=10]').is(':selected');
					}
				},
				'data[occupation_student_year]': {
					required: function () {
						if ($('#occupation option[value=1]').is(':selected') || $('#occupation option[value=2]').is(':selected') || $('#occupation option[value=3]').is(':selected') || $('#occupation option[value=4]').is(':selected') || $('#occupation option[value=5]').is(':selected') || $('#occupation option[value=6]').is(':selected'))
							return true;
						else
							return false;
					},
					digits: true,
					max: 2147483647
				},
				'data[occupation_student_grade]': {
					required: function () {
						if ($('#occupation option[value=1]').is(':selected') || $('#occupation option[value=2]').is(':selected') || $('#occupation option[value=3]').is(':selected') || $('#occupation option[value=4]').is(':selected') || $('#occupation option[value=5]').is(':selected') || $('#occupation option[value=6]').is(':selected'))
							return true;
						else
							return false;
					},
					digits: true,
					max: 2147483647
				},
				'data[disease_name]': {
					required: function () {
						return $('#anamnesis2').is(':checked');
					}
				},
				'data[partner_dependents_person]': {
					required: function () {
						return $('#partner2').is(':checked')
					},
					digits: true,
					max: 2147483647
				},
				'data[uniform_rental_h]': {
					digits: true,
					max: 2147483647
				},
				'data[uniform_rental_shoe_size]': {
					number: true,
                                        myfloat:true,
					max: 2147483647
				},
				'data[uniform_rental_up]': {
					digits: false,
                                        latin:true
				},
				'data[uniform_rental_under]': {
					digits: false,
                                        latin :true
				},
				'data[salary_hour_wage]': {
					required: true,
					digits: true,
					max: 2147483647
				},
				'data[salary_role_wage]': {
					required: true,
					number: true,
					max: 2147483647,
                                        min: -2147483646
				},
				'data[salary_evaluation_wage]': {
					required: true,
					number: true,
					max: 2147483647,
                                        min: -2147483646
				},
				'data[salary_special_wage]': {
					required: true,
					number: true,
					max: 2147483647,
                                        min: -2147483646
				},
				'data[adoption_rank]': {
					required: true
				},
				'data[confirmation_shop_date]': {
					date_format: true
				},
				'data[work_starttime_date]': {
					required: function () {
						if ($('#work_starttime_hour').val().trim() != '' || $('#work_starttime_minute').val().trim() != '')
							return true;
						return false;
					},
					date_format: true
				},
				'data[work_starttime_hour]': {
					date_hh_format: true
				},
				'data[work_starttime_minute]': {
					date_mm_format: true
				},
				'data[ss_match_other]': {
					required: function () {
						return $('input[name^="data[ss_match]"]:last').is(':checked');
					}
				},
				'data[qualification_b]': {
					required: function () {
						return $('#qualification2').is(':checked');
					}
				},
                                'data[driver_license_date1]':{
                                    required: function () {
                                        return $('input[rel=driver_license_1]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[driver_license_date2]':{
                                    required: function () {
                                        return $('input[rel=driver_license_2]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[driver_license_date3]':{
                                    required: function () {
                                        return $('input[rel=driver_license_3]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[driver_license_date4]':{
                                    required: function () {
                                        return $('input[rel=driver_license_4]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[driver_license_date5]':{
                                    required: function () {
                                        return $('input[rel=driver_license_5]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[driver_license_date6]':{
                                    required: function () {
                                        return $('input[rel=driver_license_6]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[driver_license_date7]':{
                                    required: function () {
                                        return $('input[rel=driver_license_7]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_date1]':{
                                    required: function () {
                                        return $('input[rel=qualification_date_1]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_date2]':{
                                    required: function () {
                                        return $('input[rel=qualification_date_2]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_date3]':{
                                    required: function () {
                                        return $('input[rel=qualification_date_3]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_date4]':{
                                    required: function () {
                                        return $('input[rel=qualification_date_4]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_mechanic_date1]':{
                                    required: function () {
                                        return $('input[rel=qualification_mechanic_date_1]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_mechanic_date2]':{
                                    required: function () {
                                        return $('input[rel=qualification_mechanic_date_2]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_mechanic_date3]':{
                                    required: function () {
                                        return $('input[rel=qualification_mechanic_date_3]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_mechanic_date4]':{
                                    required: function () {
                                        return $('input[rel=qualification_mechanic_date_4]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_mechanic_date5]':{
                                    required: function () {
                                        return $('input[rel=qualification_mechanic_date_5]').is(':checked');
                                    },
                                    date_format: true
                                },
                                'data[qualification_mechanic_date6]':{
                                    required: function () {
                                        return $('input[rel=qualification_mechanic_date_6]').is(':checked');
                                    },
                                    date_format: true
                                }
                                
			},
			messages: {
				'data[driver_license_date1]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[driver_license_date2]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[driver_license_date3]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[driver_license_date4]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                    
                                },
                                'data[driver_license_date5]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[driver_license_date6]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[driver_license_date7]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_date1]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_date2]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_date3]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_date4]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_mechanic_date1]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_mechanic_date2]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_mechanic_date3]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_mechanic_date4]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_mechanic_date5]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[qualification_mechanic_date6]':{
                                    date_format: '正しくありません',
                                    required: '必要です'
                                },
                                'data[interview_day]': {
					date_format: '面接日が正しくありません'
				},
				'data[zipcode_1]': {
					required: '郵便番号の指定が正しくありません',
					digits: '郵便番号の指定が正しくありません',
					minlength: '郵便番号の指定が正しくありません',
					maxlength: '郵便番号の指定が正しくありません'
				},
				'data[zipcode_2]': {
					required: '郵便番号の指定が正しくありません',
					digits: '郵便番号の指定が正しくありません',
					minlength: '郵便番号の指定が正しくありません',
					maxlength: '郵便番号の指定が正しくありません'
				},
				'data[commuting_means_bus]': {
					required: 'バスを入力して下さい',
					digits: 'バスは数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[commuting_means_train]': {
					required: '電車を入力して下さい',
					digits: '電車は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[work_location_hope1]': {
					required: '希望①を入力して下さい'
				},
				'data[work_location_hope1_time]': {
					required: '片道を入力して下さい',
					digits: '片道は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[work_location_hope2_time]': {
					digits: '片道は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[start_hour1]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format1: '期間の指定が正しくありません'
				},
				'data[start_hour2]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format2: '期間の指定が正しくありません'
				},
				'data[start_hour3]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format3: '期間の指定が正しくありません'
				},
				'data[start_hour4]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format4: '期間の指定が正しくありません'
				},
				'data[start_hour5]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format5: '期間の指定が正しくありません'
				},
				'data[start_hour6]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format6: '期間の指定が正しくありません'
				},
				'data[start_hour7]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format7: '期間の指定が正しくありません'
				},
				'data[end_hour1]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format1: '期間の指定が正しくありません'
				},
				'data[end_hour2]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format2: '期間の指定が正しくありません'
				},
				'data[end_hour3]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format3: '期間の指定が正しくありません'
				},
				'data[end_hour4]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format4: '期間の指定が正しくありません'
				},
				'data[end_hour5]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format5: '期間の指定が正しくありません'
				},
				'data[end_hour6]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format6: '期間の指定が正しくありません'
				},
				'data[end_hour7]': {
					required: '必要です',
					date_hh_format: '期間の指定が正しくありません',
					start_end_format7: '期間の指定が正しくありません'
				},
				'data[start_minute1]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format1: '期間の指定が正しくありません'
				},
				'data[start_minute2]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format2: '期間の指定が正しくありません'
				},
				'data[start_minute3]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format3: '期間の指定が正しくありません'
				},
				'data[start_minute4]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format4: '期間の指定が正しくありません'
				},
				'data[start_minute5]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format5: '期間の指定が正しくありません'
				},
				'data[start_minute6]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format6: '期間の指定が正しくありません'
				},
				'data[start_minute7]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format7: '期間の指定が正しくありません'
				},
				'data[end_minute1]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format1: '期間の指定が正しくありません'
				},
				'data[end_minute2]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format2: '期間の指定が正しくありません'
				},
				'data[end_minute3]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format3: '期間の指定が正しくありません'
				},
				'data[end_minute4]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format4: '期間の指定が正しくありません'
				},
				'data[end_minute5]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format5: '期間の指定が正しくありません'
				},
				'data[end_minute6]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format6: '期間の指定が正しくありません'
				},
				'data[end_minute7]': {
					required: '必要です',
					date_mm_format: '期間の指定が正しくありません',
					start_end_format7: '期間の指定が正しくありません'
				},
				'data[work_day_week_min]': {
					digits: '月収希望額は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。',
					day_min_max: '終了は開始より入力してください。'
				},
				'data[work_day_week_max]': {
					digits: '希望勤務日数は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。',
					day_min_max: '終了は開始より入力してください'
				},
				'data[work_day_month_min]': {
					digits: '希望勤務日数は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。',
					hour_min_max: '終了は開始より入力してください'
				},
				'data[work_day_month_max]': {
					digits: '希望勤務日数は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。',
					hour_min_max: '終了は開始より入力してください'
				},
				'data[month_wage]': {
					digits: '希望勤務日数は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[time_of_service]': {
					required: '勤務期間は必要です。'
				},
				'data[employment_month]': {
					digits: '就労希望日は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[employment_day]': {
					digits: '就労希望日は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[media_app]': {
					required: '応募媒体は必要です。'
				},
				'data[media_app_other]': {
					required: '名称(ネット/紙媒体/紹介など)は必要です。'
				},
				'data[experience_year_position_before]': {
					digits: 'SSでの職務経験は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[experience_year]': {
					digits: 'SSでの職務経験は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[experience_month]': {
					digits: 'SSでの職務経験は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[pc_skin_other]': {
					required: 'その他の場合は必要です。'
				},
				'data[occupation]': {
					required: '職業は必要です'
				},
				'data[occupation_company_name]': {
					required: '会社名は必要です。'
				},
				'data[occupation_student_year]': {
					required: '年制は必要です。',
					digits: '学生の場合は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[occupation_student_grade]': {
					required: '年生は必要です。',
					digits: '年制のは数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[disease_name]': {
					required: '病名は必要です。'
				},
				'data[partner_dependents_person]': {
					required: '配偶者以外の扶養人数必要です。',
					digits: '配偶者以外の扶養人数は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[uniform_rental_h]': {
					digits: '身長は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。'
				},
				'data[uniform_rental_shoe_size]': {
					number: '靴サイズは数字のみで入力して下さい',
                                        myfloat: '数字のみで入力してください',
					max: '範囲内の数値を入力してください。'
				},
				'data[uniform_rental_up]': {
					latin: '半角文字・数字のみを入力してください'
				},
				'data[uniform_rental_under]': {
					latin: '半角文字・数字のみを入力してください'
				},
				'data[salary_hour_wage]': {
					required: '①契約(基本)時給は必要です。',
					digits: '①契約(基本)時給は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。',
                                        min: '範囲内の数値を入力してください。'
				},
				'data[salary_role_wage]': {
					required: '②役割(研修)時給は必要です。',
					number: '②役割(研修)時給は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。',
                                        min: '範囲内の数値を入力してください。'
				},
				'data[salary_evaluation_wage]': {
					required: '③評価時給は必要です。',
					number: '③評価時給は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。',
                                        min: '範囲内の数値を入力してください。'
				},
				'data[salary_special_wage]': {
					required: '④特別時給は必要です。',
					number: '④特別時給は数字のみで入力して下さい',
					max: '範囲内の数値を入力してください。',
                                        min: '範囲内の数値を入力してください。'
				},
				'data[adoption_rank]': {
					required: '採用ランクは必要です。'
				},
                                'data[commute_dis]': {
                                    required: '通勤距離は必要です。',
                                    digits: '0 以上の数字で入力してください',
                                    myfloat: '小数点第一まで入力してください。',
                                    max: '範囲内の数値を入力してください。'
				},
				'data[confirmation_shop_date]': {
					date_format: '確認日が正しくありません'
				},
				'data[work_starttime_date]': {
					required: '開始日は必要です。',
					date_format: '勤務開始日が正しくありません'
				},
				'data[work_starttime_hour]': {
					date_hh_format: '勤務開始日が正しくありません'
				},
				'data[work_starttime_minute]': {
					date_mm_format: '勤務開始日が正しくありません'
				},
				'data[working_arrangements1]': {
					required_one_working_arrangement: '必要です'
				},
				'data[working_arrangements2]': {
					required_one_working_arrangement: '必要です'
				},
				'data[working_arrangements3]': {
					required_one_working_arrangement: '必要です'
				},
				'data[working_arrangements4]': {
					required_one_working_arrangement: '必要です'
				},
				'data[working_arrangements5]': {
					required_one_working_arrangement: '必要です'
				},
				'data[working_arrangements6]': {
					required_one_working_arrangement: '必要です'
				},
				'data[working_arrangements7]': {
					required_one_working_arrangement: '必要です'
				},
				'data[ss_match_other]': {
					required: 'その他の場合は必要です。'
				},
				'data[qualification_b]': {
					required: '乙保有の場合は必要です。'
				}
			}
		});
	};

	var _experience = function () {
		if ($('#experience1').is(':checked'))
		{
			$('#experience-block input').removeAttr('readonly');
		}
		else
		{
			$('#experience-block input').val('').attr('readonly', '');
		}
	};

	var onchange_experience = function () {
		$('#experience1, #experience0').on('change', function () {
			_experience();
		});
	};

	var convert_zen2han = function () {
		$('#interview_day').on('change', function () {
			utility.zen2han(this);
		});
		$('#zipcode_1').on('change', function () {
			utility.zen2han(this);
		});
		$('#zipcode_2').on('change', function () {
			utility.zen2han(this);
		});
		$('#commuting_means_bus').on('change', function () {
			utility.zen2han(this);
		});
		$('#commuting_means_train').on('change', function () {
			utility.zen2han(this);
		});
		$('#work_location_hope1_time').on('change', function () {
			utility.zen2han(this);
		});
		$('#work_location_hope2_time').on('change', function () {
			utility.zen2han(this);
		});
		$('[id^=start_hour]').on('change', function () {
			utility.zen2han(this);
		});
		$('[id^=start_minute]').on('change', function () {
			utility.zen2han(this);
		});
		$('[id^=end_hour]').on('change', function () {
			utility.zen2han(this);
		});
		$('[id^=end_minute]').on('change', function () {
			utility.zen2han(this);
		});
		$('#work_day_week_min, #work_day_week_max, #work_day_month_min, #work_day_month_max').on('change', function () {
			utility.zen2han(this);
		});
		$('#month_wage, #experience_year_position_before, #experience_year, #experience_month').on('change', function () {
			utility.zen2han(this);
		});
		$('#occupation_student_year, #occupation_student_grade, #partner_dependents_person').on('change', function () {
			utility.zen2han(this);
		});
		$('#uniform_rental_h, #uniform_rental_shoe_size, #uniform_rental_up, #uniform_rental_under').on('change', function () {
			utility.zen2han(this);
		});
		$('#salary_hour_wage, #salary_role_wage, #salary_evaluation_wage, #salary_special_wage').on('change', function () {
			utility.zen2han(this);
			sum_salary();
		});
		$('#confirmation_shop_date').on('change', function () {
			utility.zen2han(this);
		});
                $('#uniform_rental_up').on('change', function () {
			utility.zen2han(this);
		});
                $('#uniform_rental_under').on('change', function () {
			utility.zen2han(this);
		});
                $('#commute_dis').on('change', function () {
			utility.zen2han(this);
		});


                $('#salary_role_wage').on('change', function () {
                    var vals = parseFloat($(this).val());
                    $(this).val(vals.toFixed(0));
		});
                $('#salary_evaluation_wage').on('change', function () {
                    var vals = parseFloat($(this).val());
                    $(this).val(vals.toFixed(0));
		});
                $('#salary_special_wage').on('change', function () {
                    var vals = parseFloat($(this).val());
                    $(this).val(vals.toFixed(0));
		});



	};

	var sum_salary = function () {
		var salary_hour_wage = parseInt($('#salary_hour_wage').val() == '' ? 0 : $('#salary_hour_wage').val()),
				salary_role_wage = parseInt($('#salary_role_wage').val() == '' ? 0 : $('#salary_role_wage').val()),
				salary_evaluation_wage = parseInt($('#salary_evaluation_wage').val() == '' ? 0 : $('#salary_evaluation_wage').val()),
				salary_special_wage = parseInt($('#salary_special_wage').val() == '' ? 0 : $('#salary_special_wage').val()),
				sum = salary_hour_wage + salary_role_wage + salary_evaluation_wage + salary_special_wage;
		$('#sum_salary').text(sum + '円');
	};

	var submit = function () {
		$('#interviewusami_form').on('submit', function () {
			var valid = $(this).valid();
			if (valid)
			{
				if (confirm(message_confirm_save))
					return true;
			}
			return false;
		});
	};
	return {
		init: function () {
                        validate();
			submit();
			convert_zen2han();
			sum_salary();
			onchange_experience();
			_experience();
		}
	}
}();

$(function () {
	interviewusami.init();
});
