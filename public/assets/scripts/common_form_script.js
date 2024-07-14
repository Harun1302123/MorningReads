
function loadApplicationForm(view_mode, open_mode, processType_id, form_url, app_id = '') {
    let url;
    const viewMode = view_mode;
    const openMode = open_mode;
    const process_type_id = processType_id;
    if (openMode == 'add') {
        url = form_url;
    } else {
        url = form_url + app_id + '/' + openMode;
    }

    if (url != '') {
        $.ajax({
            type: "get",
            dataType: "json",
            // async: false,
            url: "/" + url,
            data: {
                openMode: openMode,
                process_type_id: process_type_id
            },
            success: function (response) {
                if (response.html == undefined) {
                    $('.load_content').html("<h3 class='custom-err-msg'>Form not found!!</h3>");
                    $('.batch-process').hide();
                    $('.process-history').hide();
                } else {
                    $('.load_content').html(response.html);
                }
            },
            error: function (jqXHR, exception) {
                $('#loading').hide();
                clearTimeout(interval);

                let msg = "<h3 class='custom-err-msg'>Somthing was wrong!!!!</h3>";
                if (jqXHR.status === 0) {
                    msg = "<h3 class='custom-err-msg'>Not connect.\n Verify Network.</h3>";
                } else if (jqXHR.status == 404) {
                    msg = "<h3 class='custom-err-msg'>Requested page not found. [404]</h3>";
                } else if (jqXHR.status == 500) {
                    msg = "<h3 class='custom-err-msg'>Something was wrong!!!!</h3>Internal Server Error [500].";
                }
                // else if (exception === 'parsererror') {
                //     msg = "<h3 class='custom-err-msg'>Something was wrong!!!!</h3>Requested JSON parse failed.";
                // }
                else if (exception === 'timeout') {
                    msg = "<h3 class='custom-err-msg'>Time out error.</h3>";
                } else if (exception === 'abort') {
                    msg = "<h3 class='custom-err-msg'>Ajax request aborted.</h3>";
                } else {
                    msg = "<h3 class='custom-err-msg'>Uncaught Error.\n</h3>" + jqXHR.responseText;
                }

                $('.batch-process').hide();
                $('.process-history').hide();
                $('.load_content').html(msg);
            },
            complete: function (response) {
                form_load_status = 1;

                clearTimeout(interval);

                $('#loading').hide();

                if (viewMode === 'off') {
                    getHelpText();
                }
            }
        });
    } else {
        $('.load_content').html("<h3 class='custom-err-msg'>Undefined URL in Process Type!</h3>");
        $('.batch-process').hide();
        $('.process-history').hide();
        $('#loading').hide();
    }
}

// Help text show
function getHelpText() {
    // Get application module name
    let location = window.location.pathname;
    let splitted_uri = location.split('/')
    let uri = splitted_uri[1];
    if (uri == 'process') {
        uri = splitted_uri[2];
    } else if (uri == 'client') {
        uri = splitted_uri[3];
    }

    if (uri) {
        $.ajax({
            type: "POST",
            url: "/process/help-text", // checking open mode permission and get url
            data: {
                uri: uri
            },
            success: function (response) {
                $.each(response.data, function (key, value) {

                    // Define the Selector type
                    let selector;
                    if (value.field_id) {
                        selector = '#' + value.field_id;
                    } else if (value.field_class) {
                        selector = '.' + value.field_class;
                    } else {
                        return;
                    }

                    // If there have any validation rules, then apply the rules into Input element
                    if (value.validation_class) {
                        const closest_div = $(selector).closest("div");
                        (closest_div.hasClass('input-group') || closest_div.hasClass('intl-tel-input')) == false ?
                            closest_div.prev().addClass('required-star') :
                            closest_div.parent("div").prev().addClass('required-star');

                        $(selector).addClass(value.validation_class);
                    }

                    // If there have any help text, then apply the help text Input element
                    if (value.help_text) {
                        if (value.help_text_type == 'tooltip') {
                            if ($(selector).hasClass("date") || $(selector).hasClass("helpText15")) {
                                $(selector).before('<i class="fa fa-question-circle" style="cursor: pointer; position: absolute; top: 7px; left: -16px;" data-toggle="tooltip" data-placement="top" title="' + value.help_text + '" ></i>');
                            } else if ($(selector).hasClass("helpTextCom")) {
                                $(selector).before('<i class="fa fa-question-circle" style="cursor: pointer; position: absolute; top: 9px; right: -24px;" data-toggle="tooltip" data-placement="top" title="' + value.help_text + '" ></i>');
                            } else if ($(selector).hasClass("helpTextRadio")) {
                                $(selector).before('<i class="fa fa-question-circle" style="cursor: pointer; position: absolute; top: 3px; left: -24px;" data-toggle="tooltip" data-placement="top" title="' + value.help_text + '" ></i>');
                            } else {
                                $(selector).before('<i class="fa fa-question-circle" style="cursor: pointer; position: absolute; top: 9px; left: -5px;" data-toggle="tooltip" data-placement="top" title="' + value.help_text + '" ></i>');
                            }
                        } else if (value.help_text_type == 'bubble') {
                            $(selector).after('<i class="bubble' + key + ' fa fa-question-circle"  id="bubble' + key + " #" + value.help_text + '" style="cursor: pointer; position: absolute; top: 10px; right: 0px;"onclick="showHelpText(this.id)" data-toggle="tooltip" data-placement="top" title="Please click here"  ></i>');
                        } else if (value.help_text_type == 'normaltext') {
                            $(selector).after('<span style="font-weight: 600; color: #ff9800;">' + value.help_text + '</span>');
                        }
                    }
                });
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }
}

function showHelpText(datas) {
    const id = datas.split('#')[0];
    const description = datas.split('#')[1];
    const html = '<p class="triangle-right top">' + description + '</p>';
    $("." + id).after(html).toggle()
}


// payment load by ajax
// set flag for one time calling
let is_shadow_file_loaded = false;

function loadShadowFileHistory(process_type_id, ref_id) {
    if (!is_shadow_file_loaded) {
        $.ajax({
            url: "/process/get-shadow-file-hist/" + process_type_id + "/" + ref_id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $("#shadow_file_content_area").html(response.response);
                $("#shadow-file-loading").hide();
                is_shadow_file_loaded = true;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
        });
    }
}
let is_payment_file_loaded = false;
function loadPaymentInfo(process_type_id, ref_id) {
    if (!is_payment_file_loaded) {
        $.ajax({
            url: "/spg/get-payment-info/" + process_type_id + "/" + ref_id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $("#payment_content_area").html(response.response);
                $("#payment-loading").hide();
                is_payment_file_loaded = true;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
        });
    }
}

// Application history load by ajax
// set flag for one time calling
let is_app_history_loaded = false;

function loadApplicationHistory(process_list_id) {
    if (!is_app_history_loaded) {
        $.ajax({
            url: '/process/get-app-hist/' + process_list_id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $("#history_content_area").html(response.response);
                $("#history-loading").hide();
                is_app_history_loaded = true;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            complete: function () {
                // $('#app_history_table').DataTable({
                //     searching: false,
                //     paging: false,
                //     info: false,
                //     ordering: false,
                //     responsive: true
                // });
            }
        });
    }
}


// Process flow graph load
// set flag for one time calling
let is_map_draw = false;

function processPath(response) {

    const svg = d3.select("svg"),
        inner = svg.select("g");
    const zoom = d3.zoom().on("zoom", function () {
        inner.attr("transform", d3.event.transform);
    });

    svg.call(zoom);
    // Create the renderer
    const render = new dagreD3.render();
    const g = new dagreD3.graphlib.Graph().setGraph({});


    let i = 0;
    let finalResult = true;
    const message = '';
    response.desks.forEach(function (desk) {
        // console.log(response.passed_desks_id);
        if (i === 0) {
            // console.log(response.passed_status_id[i])
            if (response.passed_status_id[i] == 5) { //5= shortfall
                finalResult = false;
            }
        }
        // console.log(desk.desk_id)
        g.setNode(desk.name, { label: desk.label });
        if (response.passed_desks_id.indexOf(desk.desk_id) != -1 && finalResult === true) {
            g.node(desk.name).style = "fill: orange";
        } else {
            if (desk.desk_id == 0)
                g.node(desk.name).style = "fill: orange";
            else
                g.node(desk.name).style = "fill: #666";
        }
    });

    response.desk_action.forEach(function (action) {
        if (i === 0) {
            if (response.passed_status_id[i] == 5) { //5= shortfall
                finalResult = false;
            }
        }

        g.setNode(action.name, { label: action.label, shape: action.shape });
        if (response.passed_status_id.indexOf(action.action_id) != -1 && finalResult === true) {
            if (action.action_id === 5) {
                g.node(action.name).style = "fill: #666";
            } else {
                g.node(action.name).style = "fill: orange";
            }
        } else {
            g.node(action.name).style = "fill: #666";
        }

        i++
    });
    if (finalResult === false) {
        $('#mapShortfallStatus').html('The current status is "shortfall". Applicant has to Re-submit again');
    } else {
        $('#mapShortfallStatus').html('');
        $('#mapShortfallStatus').hide();
    }

    response.edge_path.forEach((edge) => {
        g.setEdge.apply(g, edge);
    });

    // Set the rankdir
    g.graph().rankdir = "LR";
    g.graph().nodesep = 60;

    // Set some general styles
    g.nodes().forEach(function (v) {
        const node = g.node(v);
        node.rx = node.ry = 5;
    });
    render(inner, g);
}

function sendRequestAndDraw(processId, app_id, cat_id) {
    if (!is_map_draw) {
        $.ajax({
            url: '/process/graph/' + processId + "/" + app_id + "/" + cat_id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $.when(
                    $.getScript("/assets/plugins/d3/d3.v4.min.js"),
                    $.getScript("/assets/plugins/dagrejs/dagre-d3.min.js"),
                    $.Deferred(function (deferred) {
                        $(deferred.resolve);
                    })
                ).done(function () {
                    processPath(response);
                    $("#map-loading").hide();
                    is_map_draw = true;
                }).fail(function () {
                    alert('Unknown error occurred while resource loading. Please try again');
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
        });
    }
}

function requestForShadowFile(acl_name, app_id, process_id, process_type_id) {
    const btn = $(this);
    const btn_content = btn.html();
    btn.prop('disabled', true);
    btn.html('<i class="fa fa-spinner fa-spin"></i> &nbsp;' + btn_content);

    $.ajax({
        type: "GET",
        url: "/process-path/request-shadow-file",
        data: {
            module_name: acl_name,
            ref_id: app_id,
            process_id: process_id,
            process_type_id: process_type_id
        },
        success: function (response) {
            if (response.responseCode == 1) {
                btn.prop('disabled', false);
                document.location.reload()
            } else if (response.responseCode == 0) {
                toastr.error("", response.messages,
                    {
                        timeOut: 6000,
                        extendedTimeOut: 1000,
                        positionClass: "toast-bottom-right"
                    });
                btn.prop('disabled', false);
            }
        }
    });
}
