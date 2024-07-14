$(document).ready(function () {
    // $("input[type=text]:not([class*='textOnly'],[class*='email'],[class*='exam'],[class*='number'],[class*='bnEng'],[class*='textOnlyEng'],[class*='datepicker'],[class*='mobile_number_validation'])").addClass('engOnly');
    // Bootstrap Tooltip initialize
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // Bootstrap Tooltip initialize
    $('[data-toggle="tooltip"]').tooltip();

    // popover demo
    $("[data-toggle=popover]").popover()


    const checkSearchSession = localStorage.getItem("dropdownSearchBox");
    if (checkSearchSession) {
        $("#dropdown_search_icon").removeClass('fa-search');
        $("#dropdown_search_icon").addClass('fa-times');
        $("#dropdownSearchBox").closest('li').addClass('open');
        $("#dropdownSearchBox").attr('aria-expanded', 'true');
    }

    $("#dropdownSearchBox").click(function () {
        const getSearchSession = localStorage.getItem("dropdownSearchBox");
        if (getSearchSession) {
            $("#dropdown_search_icon").removeClass('fa-times');
            $("#dropdown_search_icon").addClass('fa-search');
            $(this).closest('li').removeClass('open');
            $(this).attr('aria-expanded', 'false');
            localStorage.removeItem("dropdownSearchBox");
        } else {
            localStorage.setItem("dropdownSearchBox", "open");
            $("#dropdown_search_icon").removeClass('fa-search');
            $("#dropdown_search_icon").addClass('fa-times');
            $(this).closest('li').addClass('open');
            $(this).attr('aria-expanded', 'true');
        }
    });

    feedbackmessage();

    $(".feedbackbtn2").click(function () {
        const featurId = $("#msg2").val();
        const value = $(this).val();
        $("#msgtost2").remove();
        $.ajax({
            url: '/settings/feedback',
            type: "get",
            data: {value: value, featurId: featurId},
            success: function (data) {
            }
        })
    })


    // Notification Count Script
    notificationCount();
    // End Notification Count Script

    // Unread Notification load Script
    let load_notification_flag = 0;
    $("#loadNotifications").click(function () {
        if (load_notification_flag == 0) {
            $.ajax({
                url: '/notifications/show',
                type: "get",
                success: function success(data) {
                    load_notification_flag = 1;
                    $.getScript("/assets/scripts/moment.min.js").done(function () {
                        if (data.length == 0) {
                            $("#notificationLoading").html('You have no new notification');
                        } else {
                            $.each(data, function (key, value) {
                                $("#notification").append('<li>' +
                                    '<a class="dropdown-item" href="/single-notification/' + value.id + '" class="notificationitem">' +
                                    '<i class="fas fa-envelope mr-2"></i>' + value.email_subject +
                                    ' <span class="float-right text-muted text-sm"><small class="text-muted"><i class="fa fa-clock-o"> ' + moment(value.created_at.date).fromNow() + '</i></small></span>' +
                                    '</a>' +
                                    '</li>')
                            });
                            $('#notificationLoading').hide();
                        }
                    });
                },
                error: function error(jqXHR, textStatus, errorThrown) {
                    load_notification_flag = 0;
                    console.log(errorThrown);
                }
            });
        }
    }); // End Unread Notification load Script
    // End Unread Notification load Script


    // User session cheking
    let setSession = '';

    function getSession() {
        $.get("/users/get-user-session", function (data, status) {
            if (data.responseCode == 1) {
                setSession = setTimeout(getSession, 6000);
            } else {
                // alert('Your session has been closed. Please login again');
                // window.location.replace('/login');
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Your session has been closed. Please login again',
                    footer: '<a href="/login">Login</a>'
                }).then((result) => {
                    if (result.value) {
                        window.location.replace('/login')
                    }
                })
            }
        });
    }

    setSession = setTimeout(getSession, 120000);
});

function feedbackmessage() {
    $.ajax({
        // url: '/settings/fMsgShow',
        type: "get",
        data: {},
        success: function (data) {
            if (data.id == 2) {
                $("#msgtost2").css('display', 'block');
                $("#feature_text2").html(data.feature_text);
            }

        }
    })
}

function notificationCount() {
    $.ajax({
        url: '/notifications/count',
        type: "get",
        success: function (result) {
            $('#notificationCount').html(result.length)
            $('.countPendingNotification').html(result)
        }
    })
}
