var plan = function(){
    var ready = function(){
      $(function(){
          var year = $('#form_filter_date').val();
          data_filter(year);
      });
    };
    var validate = function(){
        $('#form-plan').validate({
        });
        $('#form-plan input.job_cost').each(function(){
            $(this).on('change', function () {
                utility.zen2han(this);
            });
            $(this).rules("add", {
                digits: true,
                max: 2147483647,
                messages: {
                    digits: "数字のみで入力して下さい",
                    max: "範囲内の数値を入力してください"
                }
            });
        });
        $('#form-plan input.expenses').each(function(){
            $(this).on('change', function () {
                utility.zen2han(this);
            });
            $(this).rules("add", {
                digits: true,
                max: 2147483647,
                messages: {
                    digits: "数字のみで入力して下さい",
                    max: "範囲内の数値を入力してください"
                }
            });
        });
    };
    var submit = function(){
        var form = $('#form-plan'),
            valid;
        form.on('submit', function() {
            valid = form.valid();
            if(valid == false)
                return false;

            if(confirm(message_confirm_save))
                return true;

            return false;
        });
    };
    var data_filter = function(year){
        $('input[id^="form_job_cost"]').attr('value','');
        $('input[id^="form_expenses"]').attr('value','');
        $.ajax({
            url: baseUrl+'job/plan/loaddata',
            method: 'post',
            data: {year: year},
            dataType: 'json'
        })
            .success(function (data) {
                $('#form_have_data').attr('value',data.have_data);
                var data_plan = data.data_plan;
                data_plan.forEach(function(entry){
                    var id = entry.area_id;
                    $('#form_job_cost'+entry.area_id).attr('value',entry.job_cost);
                    $('#form_expenses'+entry.area_id).attr('value',entry.expenses);
                })
            });

    };
    var filter = function(){
        $('#form_filter_date').on('change',function(){
            $('#form-plan .alert').hide();
            var year = $(this).val();
            data_filter(year);
        });
    };
    return{
        init: function(){
            ready();
            validate();
            submit();
            filter();
        }
    };
}();

$(function(){
    plan.init();
});
