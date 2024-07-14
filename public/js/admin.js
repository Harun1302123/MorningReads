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

// Url storing in self database

$('body a').click(function (e) {
    var _token = $('input[name="_token"]').val();
    var action = $(this).text();
    var url = $(this).attr('href');

    if (typeof action === "undefined") {
        action = $(this).attr('id');
        if (typeof action === "undefined") {
            action = $(this).attr('name');
        }
    }

    $.ajax({
        url: '/api/action/new-job',
        type: 'post',
        data: {
            _token: _token,
            project: project_name,
            user_id: user_id,
            url: url,
            message: message,
            ip_address: ip_address,
            action: action
        },
        success: function (response) {

        },

    });

});

$('body button').click(function (e) {
    var _token = $('input[name="_token"]').val();
    var action = $(this).text();
    var url = $(this).attr('href');

    if (typeof action === "undefined") {
        action = $(this).attr('id');
        if (typeof action === "undefined") {
            action = $(this).attr('name');
        }
    }
    $.ajax({
        url: '/api/action/new-job',
        type: 'post',
        data: {
            _token: _token,
            project: project_name,
            user_id: user_id,
            url: url,
            message: message,
            ip_address: ip_address,
            action: action
        },
        success: function (response) {

        },

    });

});


$(window).bind("load", function () {
    var _token = $('input[name="_token"]').val();
    var url = window.location.href;

    $.ajax({
        _token: _token,
        url: '/api/new-job',
        type: 'post',
        async: false,
        crossDomain: true,
        data: {
            project: project_name,
            user_id: user_id,
            url: url,
            message: message,
            ip_address: ip_address
        },
        success: function (response) {
        },
    });
});

/* Function to allow numeric entries only with decimal points (.) */
$(document).ready(function () {
    $('.onlyNumber').on('keydown', function (e) {
        //period decimal
        if ((e.which >= 48 && e.which <= 57)
            //numpad decimal
            || (e.which >= 96 && e.which <= 105)
            // Allow: backspace, delete, tab, escape, enter and .
            || $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1
            // Allow: Ctrl+A
            || (e.keyCode == 65 && e.ctrlKey === true)
            // Allow: Ctrl+C
            || (e.keyCode == 67 && e.ctrlKey === true)
            // Allow: Ctrl+V
            || (e.keyCode == 86 && e.ctrlKey === true)
            // Allow: Ctrl+X
            || (e.keyCode == 88 && e.ctrlKey === true)
            // Allow: home, end, left, right
            || (e.keyCode >= 35 && e.keyCode <= 39)) {

            var thisVal = $(this).val();
            if (thisVal.indexOf(".") != -1 && e.key == '.') {
                return false;
            }
            $(this).removeClass('error');
            return true;
        } else {
            $(this).addClass('error');
            $(this).attr('placeholder', ' ইংরেজিতে  নম্বর  টাইপ  করুন ...');
            return false;
        }
    }).on('paste', function (e) {
        var $this = $(this);
        setTimeout(function () {
            $this.val($this.val().replace(/[^0-9\.]/g, ''));
        }, 4);
    }).on('keyup', function (e) {
        var $this = $(this);
        setTimeout(function () {
            $this.val($this.val().replace(/[^0-9\.]/g, ''));
        }, 4);
    });
});

function getDistrictByDivisionId(division_id, division_value, district_div, old_data) {
    // define old_data as an optional parameter
    if (typeof old_data === 'undefined') {
        old_data = 0;
    }

    var _token = $('input[name="_token"]').val();
    if (division_value !== '') {
        $("#" + division_id).after('<span class="loading_data">Loading...</span>');
        // $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url(); ?>/public/assets/images/ajax-loader.gif' alt='loading' />");
        $.ajax({
            type: "GET",
            url: "/users/get-district-by-division",
            data: {
                _token: _token,
                divisionId: division_value
            },
            success: function (response) {
                var option = '<option value="">জেলা নির্বাচন করুন</option>';
                if (response.responseCode == 1) {
                    $.each(response.data, function (id, value) {
                        if (id.trim() == old_data) {
                            option += '<option value="' + id + '" selected>' + value + '</option>';
                        } else {
                            option += '<option value="' + id + '">' + value + '</option>';
                        }
                    });
                }
                $("#" + district_div).html(option);
                $("#" + division_id).next().hide('slow');
            }
        });
    } else {
        // console.log('Please select a valid district');
    }
}

function getThanaByDistrictId(district_id, district_value, thana_div, old_data) {
    // define old_data as an optional parameter
    if (typeof old_data === 'undefined') {
        old_data = 0;
    }

    var _token = $('input[name="_token"]').val();
    if (district_value !== '') {
        $("#" + district_id).after('<span class="loading_data">Loading...</span>');
        // $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url(); ?>/public/assets/images/ajax-loader.gif' alt='loading' />");
        $.ajax({
            type: "GET",
            url: "/users/get-thana-by-district-id",
            data: {
                _token: _token,
                districtId: district_value
            },
            success: function (response) {
                var option = '<option value="">থানা নির্বাচন করুন</option>';
                if (response.responseCode == 1) {
                    $.each(response.data, function (id, value) {
                        if (id.trim() == old_data) {
                            option += '<option value="' + id + '" selected>' + value + '</option>';
                        } else {
                            option += '<option value="' + id + '">' + value + '</option>';
                        }
                    });
                }
                $("#" + thana_div).html(option);
                $("#" + district_id).next().hide('slow');
            }
        });
    } else {
        // console.log('Please select a valid district');
    }
}

// Application Document upload script via ajax
var pagecount = 0;
var ready = false;

function readFile(file, onLoadCallback) {
    var reader = new FileReader();
    reader.onloadend = onLoadCallback;
    reader.readAsText(file);
}
$('#attachment').click(function () {
    $('#output_pdf_page_count').val(0);
});

function uploadAppDocument(targets, id, vField, isRequired, maxSize, minSize) {
    const inputFile = $("#" + id).val();
    var file_size = $("#" + id).prop('files')[0].size;
    if (inputFile == '') {
        $("#" + id).html('');
        document.getElementById("isRequired").value = '';
        document.getElementById("selected_file").value = '';
        document.getElementById("validateFieldName").value = '';
        document.getElementById(targets).innerHTML = '<input type="hidden" class="required" value="" id="' + vField + '" name="' + vField + '">';
        if ($('#label_' + id).length) $('#label_' + id).remove();
        return false;
    }

    if (file_size / 1024 > maxSize || (file_size / 1024 < minSize)) {
        alert("Please upload files between " + minSize + " KB - " + (maxSize / 1024).toFixed(2) + " MB. Thanks!!");
        $("#" + id).val('');
        return false;
    } else {
        var obj = $("#" + id);
        readFile(obj.prop('files')[0], function (e) {
            // use result in callback...
            pagecount = e.target.result.match(/\/Type[\s]*\/Page[^s]/g).length;
            $('#output_pdf_page_count').val(pagecount);
            ready = true;
        });
        var check = function () {
            if (ready === true) {
                var countPage = $('#output_pdf_page_count').val();
                if (countPage > 0) {
                    if (countPage >= 6) {
                        if (countPage >= 11) {
                            if ((file_size / countPage) / 1024 > 500 || file_size / 1024 < minSize) {
                                obj.val('');
                                alert("Please upload files between " + minSize + "-" + 500 + " KB. Per Page Thanks!!");
                            } else {
                                uploadFile(targets, id, vField, isRequired, maxSize, minSize)
                            }
                        } else {
                            if ((file_size / countPage) / 1024 > 500 || file_size / 1024 < minSize) {
                                obj.val('');
                                alert("Please upload files between " + minSize + "-" + 500 + " KB. Per Page Thanks!!");
                            } else {
                                uploadFile(targets, id, vField, isRequired, maxSize, minSize)
                            }
                        }
                    } else if (countPage > 1) {
                        if ((file_size / countPage) / 1024 > 500 || file_size / 1024 < minSize) {
                            alert("Please upload files between " + minSize + "-" + 500 + " KB. Per Page Thanks!!");
                            obj.val('');
                        } else {
                            uploadFile(targets, id, vField, isRequired, maxSize)
                        }
                    } else {
                        if (file_size / 1024 > maxSize || file_size / 1024 < minSize) {
                            alert("Please upload files between " + minSize + "-" + (maxSize / 1024).toFixed(2) + " MB. Thanks!!");
                            obj.val('');
                        } else {
                            uploadFile(targets, id, vField, isRequired, maxSize, minSize)
                        }
                    }
                }
                ready = false;
            } else {
                setTimeout(check, 1000);
            }
        }
        check();
    }

}

function uploadFile(targets, id, vField, isRequired, maxSize, minSize) {
    const inputFile = $("#" + id).val();
    try {
        document.getElementById("isRequired").value = isRequired;
        document.getElementById("selected_file").value = id;
        document.getElementById("validateFieldName").value = vField;
        document.getElementById(targets).style.color = "red";
        const action = '/documents/upload-document';
        const max_size = maxSize;

        $("#" + targets).html('Uploading....');
        const file_data = $("#" + id).prop('files')[0];
        const form_data = new FormData();
        form_data.append('max_size', max_size);
        form_data.append('selected_file', id);
        form_data.append('isRequired', isRequired);
        form_data.append('validateFieldName', vField);
        form_data.append(id, file_data);
        $.ajax({
            target: '#' + targets,
            url: action,
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (response) {
                $('#' + targets).html(response);
                const fileNameArr = inputFile.split("\\");
                const l = fileNameArr.length;
                if ($('#label_' + id).length)
                    $('#label_' + id).remove();
                const newInput = $('<label id="label_' + id + '"><br/><b>File: ' + fileNameArr[l - 1] + '</b></label>');
                $("#" + id).after(newInput);
                const validate_field = $('#' + vField).val();
                if (validate_field == '') {
                    document.getElementById(id).value = '';
                }
            }
        });
    } catch (err) {
        document.getElementById(targets).innerHTML = "Sorry! Something Wrong.";
    }
}

// Application Document remove
function removeAttachedFile(docID, doc_priority) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $('#validate_field_' + docID).val('');
            $('.saved_file_' + docID).html('');
            $('#other_doc_name_' + docID).val('');

            if (doc_priority == 1) {
                $("#file" + docID).addClass('required');
            }
            swal(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        } else {
            return false;
        }
    })
}

/*****************End of the functionality to allow the applicants to remove their attached documents*******************/

/****************For showing tooltips in the function list page*******************/
function toolTipFunction() {
    $('[data-toggle="tooltip"]').tooltip();
}

/*****************For advance search for getting industrial categories in each economic zone*******************/

// Add table Row script
function addTableRow(tableID, template_row_id) {

    let i;
    // Copy the template row (first row) of table and reset the ID and Styling
    const new_row = document.getElementById(template_row_id).cloneNode(true);
    new_row.id = "";
    new_row.style.display = "";

    // Get the total row number, and last row number of table
    let current_total_row = $('#' + tableID).find('tbody tr').length;
    let final_total_row = current_total_row + 1;


    // Generate an ID of the new Row, set the row id and append the new row into table
    let last_row_number = $('#' + tableID).find('tbody tr').last().attr('data-number');
    if (last_row_number != '' && typeof last_row_number !== "undefined") {
        last_row_number = parseInt(last_row_number) + 1;
    } else {
        last_row_number = Math.floor(Math.random() * 101);
    }

    const new_row_id = 'rowCount' + tableID + last_row_number;
    new_row.id = new_row_id;
    $("#" + tableID).append(new_row);

    //for bootstrap 4 new datepicker replace
    $("#" + tableID).find("#" + new_row_id).find('#datepicker0').children().next().attr('data-target', '#datepicker'+last_row_number+'');
    $("#" + tableID).find("#" + new_row_id).find('#datepicker0').attr('id', 'datepicker'+last_row_number+'');


    // Convert the add button into remove button of the new row
    $("#" + tableID).find('#' + new_row_id).find('.addTableRows').removeClass('btn-primary').addClass('btn-danger')
        .attr('onclick', 'removeTableRow("' + tableID + '","' + new_row_id + '")');

    // Icon change of the remove button of the new row
    $("#" + tableID).find('#' + new_row_id).find('.addTableRows > .fa').removeClass('fa-plus').addClass('fa-times');
    // data-number attribute update of the new row
    $('#' + tableID).find('tbody tr').last().attr('data-number', last_row_number);


    // Get all select box elements from the new row, reset the selected value, and change the name of select box
    const all_select_box = $("#" + tableID).find('#' + new_row_id).find('select');
    all_select_box.val(''); // value reset
    all_select_box.prop('selectedIndex', 0);
    for (i = 0; i < all_select_box.length; i++) {
        const name_of_select_box = all_select_box[i].name;
        const updated_name_of_select_box = name_of_select_box.replace('[0]', '[' + final_total_row + ']'); //increment all array element name
        all_select_box[i].name = updated_name_of_select_box;
    }


    // Get all input box elements from the new row, reset the value, and change the name of input box
    const all_input_box = $("#" + tableID).find('#' + new_row_id).find('input');
    all_input_box.val(''); // value reset
    for (i = 0; i < all_input_box.length; i++) {
        const name_of_input_box = all_input_box[i].name;
        const updated_name_of_input_box = name_of_input_box.replace('[0]', '[' + final_total_row + ']');
        all_input_box[i].name = updated_name_of_input_box;
    }


    // Get all textarea box elements from the new row, reset the value, and change the name of textarea box
    const all_textarea_box = $("#" + tableID).find('#' + new_row_id).find('textarea');
    all_textarea_box.val(''); // value reset
    for (i = 0; i < all_textarea_box.length; i++) {
        const name_of_textarea = all_textarea_box[i].name;
        const updated_name_of_textarea = name_of_textarea.replace('[0]', '[' + final_total_row + ']');
        all_textarea_box[i].name = updated_name_of_textarea;
        $('#' + new_row_id).find('.readonlyClass').prop('readonly', true);
    }


    // var TotalRows = parseInt(rowCount) + 2;
    // var ChakingArray = [10,20,30,40,50,60,70,80,90,100,110,120,130,140,150,160,170,180,190,200];
    //
    // if(jQuery.inArray(TotalRows, ChakingArray) !== -1){
    //     $("#" + tableID).find('#' + idText).find('.addTableRows').removeClass('btn-danger').addClass('btn-primary');
    // }else{
    //     $("#" + tableID).find('#' + idText).find('.addTableRows').removeClass('btn-primary').addClass('btn-danger')
    //         .attr('onclick', 'removeTableRow("' + tableID + '","' + idText + '")');
    //     $("#" + tableID).find('#' + idText).find('.addTableRows > .fa').removeClass('fa-plus').addClass('fa-times');
    // }


    // Table footer adding with add more button
    if (final_total_row > 3) {
        const check_tfoot_element = $('#' + tableID + ' tfoot').length;
        if (check_tfoot_element === 0) {
            const table_header_columns = $('#' + tableID).find('thead th');
            let table_footer = document.getElementById(tableID).createTFoot();
            table_footer.setAttribute('id', 'autoFooter')
            let table_footer_row = table_footer.insertRow(0);
            for (i = 0; i < table_header_columns.length; i++) {
                const table_footer_th = table_footer_row.insertCell(i);
                // if this is the last column, then push add more button
                if (i === (table_header_columns.length - 1)) {
                    table_footer_th.innerHTML = '<a class="btn btn-sm btn-primary addTableRows" title="Add more" onclick="addTableRow(\'' + tableID + '\', \'' + template_row_id + '\')"><i class="fa fa-plus"></i></a>';
                } else {
                    table_footer_th.innerHTML = '<b>' + table_header_columns[i].innerHTML + '</b>';
                }
            }
        }
    }


    $("#" + tableID).find('#' + new_row_id).find('.onlyNumber').on('keydown', function (e) {
        //period decimal
        if ((e.which >= 48 && e.which <= 57)
            //numpad decimal
            || (e.which >= 96 && e.which <= 105)
            // Allow: backspace, delete, tab, escape, enter and .
            || $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1
            // Allow: Ctrl+A
            || (e.keyCode == 65 && e.ctrlKey === true)
            // Allow: Ctrl+C
            || (e.keyCode == 67 && e.ctrlKey === true)
            // Allow: Ctrl+V
            || (e.keyCode == 86 && e.ctrlKey === true)
            // Allow: Ctrl+X
            || (e.keyCode == 88 && e.ctrlKey === true)
            // Allow: home, end, left, right
            || (e.keyCode >= 35 && e.keyCode <= 39)) {
            var $this = $(this);
            setTimeout(function () {
                $this.val($this.val().replace(/[^0-9.]/g, ''));
            }, 4);
            var thisVal = $(this).val();
            if (thisVal.indexOf(".") != -1 && e.key == '.') {
                return false;
            }
            $(this).removeClass('error');
            return true;
        } else {
            $(this).addClass('error');
            return false;
        }
    }).on('paste', function (e) {
        var $this = $(this);
        setTimeout(function () {
            $this.val($this.val().replace(/[^.0-9]/g, ''));
        }, 4);
    });

    var today = new Date();
    var yyyy = today.getFullYear();

    // Datepicker initialize of the new row
    $("#" + tableID).find('.datetimepicker4').datetimepicker({
        format: 'DD-MMM-YYYY',
        maxDate: 'now',
        minDate: '01/01/' + (yyyy - 110),
        ignoreReadonly: true,
    });
} // end of addTableRow() function


// Remove Table row script
function removeTableRow(tableID, removeNum) {
    $('#' + tableID).find('#' + removeNum).remove();
    let current_total_row = $('#' + tableID).find('tbody tr').length;
    if (current_total_row <= 3) {
        const tableFooter = document.getElementById('autoFooter');
        if (tableFooter) {
            tableFooter.remove();
        }
    }

    calculateMachineryTotal('local_machinery_price', 'local_machinery_total');
    calculateMachineryTotal('import_machinery_price', 'imported_machinery_total');

    calculateMachineryTotal('apc_amount_bdt', 'apc_price_total');
}

/**
 * Bangladeshi currency format
 * @param data
 * @param decimal_part
 * @returns {string}
 */
function bd_currency_format(data, decimal_part) {
    const decimal = parseInt(decimal_part);
    let currency_amount = parseFloat(data).toFixed(decimal);
    const split_data = (currency_amount + "").split(".");
    const left_part = split_data[0];
    let fraction_part = split_data[1];
    const left_part_length = left_part.length;

    if (left_part_length) {
        let str = '';
        for (let i = 0, pointer = 1; i < left_part_length; i++, pointer++) {
            // After every 3 character, add a comma (,) and reset the pointer
            if (pointer === 4) {
                str = "," + str;
                pointer = 0;
            }
            str = left_part.charAt(left_part_length - (1 + i)).toString() + str;
        }

        if (fraction_part) {
            str = str + "." + fraction_part;
        }
        return str;
    } else {
        return currency_amount;
    }
}
