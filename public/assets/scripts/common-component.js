/*!
 * common-component.js
 * Version: 1.0
 * Copyright 2020 Reyad
 */

function uploadDocument(targets, id, vField, isRequired) {

    var inputFile = $("#" + id).val();
    if (inputFile == '') {
        $("#" + id).html('');
        document.getElementById("isRequired").value = '';
        document.getElementById("selected_file").value = '';
        document.getElementById("validateFieldName").value = '';

        document.getElementById(targets).innerHTML = '<input type="hidden" class="required" value="" id="' + vField + '" name="' + vField + '">';
        if ($('#label_' + id).length)
            $('#label_' + id).remove();
        return false;
    }

    try {

        document.getElementById("isRequired").value = isRequired;
        document.getElementById("selected_file").value = id;
        document.getElementById("validateFieldName").value = vField;

//                document.getElementById(targets).style.color = "red";

        var action = "/client/company-profile/upload-document";
        $("#" + targets).html('Uploading....');

        var file_data = $("#" + id).prop('files')[0];

        var form_data = new FormData();
        form_data.append('selected_file', id);
        form_data.append('isRequired', isRequired);
        form_data.append('validateFieldName', vField);
        form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        form_data.append(id, file_data);

        $.ajax({
            target: '#' + targets,
            url: action,
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (response) {
                $('#' + targets).html(response);
                var fileNameArr = inputFile.split("\\");
                var l = fileNameArr.length;
                if ($('#label_' + id).length)
                    $('#label_' + id).remove();

                var doc_id = parseInt(id.substring(4));
                var newInput = $('<label class="saved_file_' + doc_id + '" id="label_' + id + '"><br/><b>File: ' + fileNameArr[l - 1] + ' <a href="javascript:void(0)" onclick="EmptyFile(' + doc_id + ')"><span class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span> </a></b></label>');
                $("#" + id).after(newInput);
                //check valid data
                var validate_field = $('#' + vField).val();
                if (validate_field == '') {
                    document.getElementById(id).value = '';
                }
            }
        });
    } catch (err) {
        console.log(err.lineNumber);
        document.getElementById(targets).innerHTML = "Sorry! Something Wrong.";
    }
}


function addTableRowCommon(tableID, templateRow){
    //rowCount++;
    //Direct Copy a row to many times
    var x = document.getElementById(templateRow).cloneNode(true);
    x.id = "";
    x.style.display = "";
    var table = document.getElementById(tableID);
    var rowCount = $('#' + tableID).find('tr').length - 2; // -2 as tfoot
    var lastTr = $('#' + tableID).find('tr').last().attr('data-number');
    var rowCo = rowCount;
    var idText = 'rowCount'+tableID + rowCount;
    x.id = idText;
    $("#" + tableID).append(x);
    //get select box elements
    var attrSel = $("#" + tableID).find('#' + idText).find('select');
    //edited by ishrat to solve select box id auto increment related bug
    for (var i = 0; i < attrSel.length; i++){
        var nameAtt = attrSel[i].name;
        var id = attrSel[i].id;
        var repText = nameAtt.replace('[0]', '[' + rowCo + ']'); //increment all array element name
        attrSel[i].name = repText;
        var id = id.replace('0', rowCo); //increment all array element name
        attrSel[i].id = id;
    }
    attrSel.val(''); //value reset
    // end of  solving issue related select box id auto increment related bug by ishrat

    //get input elements
    var attrInput = $("#" + tableID).find('#' + idText).find('input');
    for (var i = 0; i < attrInput.length; i++){
        var nameAtt = attrInput[i].name;
        var idAtt = attrInput[i].id;
        //increment all array element name
        var repText = nameAtt.replace('[0]', '[' + rowCo + ']');
        attrInput[i].name = repText;
        var id = idAtt.replace('0', rowCo); //increment all array element name
        attrInput[i].id = id;
    }
    attrInput.val(''); //value reset
    //edited by ishrat to solve textarea id auto increment related bug
    //get textarea elements
    var attrTextarea = $("#" + tableID).find('#' + idText).find('textarea');
    for (var i = 0; i < attrTextarea.length; i++){
        var nameAtt = attrTextarea[i].name;
        //increment all array element name
        var repText = nameAtt.replace('[0]', '[' + rowCo + ']');
        attrTextarea[i].name = repText;
        var id = id.replace('0', rowCo); //increment all array element name
        attrTextarea[i].id = id;
        $('#' + idText).find('.readonlyClass').prop('readonly',true);
    }
    attrTextarea.val(''); //value reset
    // end of  solving issue related textarea id auto increment related bug by ishrat
    attrSel.prop('selectedIndex', 0);

    //$('.m_currency ').prop('selectedIndex', 102);
    //Class change by btn-danger to btn-primary
    $("#" + tableID).find('#' + idText).find('.addTableRows').removeClass('btn-primary').addClass('btn-danger')
        .attr('onclick', 'removeTableRowCommon("' + tableID + '","' + idText + '")');
    $("#" + tableID).find('#' + idText).find('.addTableRows > .fa').removeClass('fa-plus').addClass('fa-times');
    $('#' + tableID).find('tr').last().attr('data-number', rowCount);

    $("#" + tableID).find('#' + idText).find('.onlyNumber').on('keydown', function (e) {
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
            || (e.keyCode >= 35 && e.keyCode <= 39))
        {
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
        }else {
            $(this).addClass('error');
            return false;
        }
    }).on('paste', function (e) {
        var $this = $(this);
        setTimeout(function () {
            $this.val($this.val().replace(/[^.0-9]/g, ''));
        }, 4);
    });

}



function removeTableRowCommon(tableID, removeNum) {
    $('#' + tableID).find('#' + removeNum).remove();
}