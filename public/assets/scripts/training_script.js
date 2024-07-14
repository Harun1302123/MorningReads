// training details information
$('.training_heading').click(function () {
    $(this).hide();
    $(this).parent().parent().find('.training_details').show();
    return false;
});

// Training Schedule for public users
$(document).on('click', '.scheduleDetails', function (e) {
    btn = $(this);
    btn_content = btn.html();
    btn.html('<i class="fa fa-spinner fa-spin"></i> &nbsp;' + btn_content);
    var training_id = btn.attr('id');
    $.ajax({
        url: '/training-public/get-training-public-schedule',
        type: 'GET',
        data: {
            training_id: training_id
        },
        success: function (response) {
            btn.html(btn_content);
            $(".scheduleInfo").html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

        },
        beforeSend: function (xhr) {
            console.log('before send');
        },
        complete: function () {
            //completed
        }
    });
});

// Training application form for public users
$(document).on('click', '.applyForTraining', function (e) {

    var schedule_id = $(this).attr('id');
    btn = $(this);
    btn_content = btn.html();
    btn.html('<i class="fa fa-spinner fa-spin"></i> &nbsp;' + btn_content);
    btn.prop('disabled', true);

    $.ajax({
        url: '/training-public/application-form',
        type: 'POST',
        dataType: 'json',
        data: {
            _token: $('input[name="_token"]').val(),
            schedule_id: schedule_id
        },
        success: function (response) {
            btn.html(btn_content);
            if (response.responseCode == 1) {
                $(".scheduleInfo").html(response.public_html);
                $(".scheduleInfo").load();

                // Triggering on datepicker on-success
                $('.datepicker').datetimepicker({
                    viewMode: 'years',
                    format: 'DD-MMM-YYYY',
                    maxDate: (new Date()),
                    minDate: '01/01/1905'
                });
            } else {
                btn.prop('disabled', false);
                alert(response.msg);
                return false;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

        },
        beforeSend: function (xhr) {
            console.log('before send'.xhr);
        },
        complete: function () {
            //completed
        }
    });
});