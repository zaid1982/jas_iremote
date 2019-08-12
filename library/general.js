var cntRow = 1;
var $taskNew;
var dataNew;
var dataHistory;
var data2nd;
var errMsg_default = 'Error on system. Please contact Administrator!';
var errMsg_validation = 'Please fill in correctly in the marked fields!';
var datas;
var dataSeries;
var color_set = ['RoyalBlue', 'PINK', 'Salmon', 'DarkKhaki', 'LawnGreen', 'RebeccaPurple', 'MediumOrchid', 'DarkOliveGreen', 'Indigo', 'MediumTurquoise'];
var bg_color_set = ['pink', 'greenLight', 'blueLight', 'blueDark', 'red', 'teal', 'orange', 'green', 'yellow', 'blue', 'magenta', 'redLight', 'greenLight', 'pinkDark'];
var monthname = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

$(document).ready(function () {
    $('#btn_clear').click(function() {
        $('#form_main').trigger('reset'); 
    });     
});

function f_logout() {
    //auditAction_id = '2'; 
    f_save_audit('2');
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function formattedNumber(num, fix) {
    if (num == null) 	num = 0;
    num = parseFloat(num);
    var p = num.toFixed(fix).split(".");
    return p[0].split("").reduceRight(function(acc, num, i, orig) {
        var pos = orig.length - i - 1;
        return  num + (pos && !(pos % 3) ? "," : "") + acc;
    }, "") + (p[1] ? "." + p[1] : "");
}

function removeComma(numStr) {
    return numStr.replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");
}

function replaceNull(val, repl) {
    if (val == null || val == '')	return repl;
    else	return val;
}

function allowNumeric(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode < 48 || charCode > 57)
        return false;
    return true;
}

function allowNumericDash(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 45  && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function allowNumericDot(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function number_formats(number, decimals, dec_point, thousands_sep) {
    var n = !isFinite(+number) ? 0 : +number, 
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        toFixedFix = function (n, prec) {
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            var k = Math.pow(10, prec);
            return Math.round(n * k) / k;
        },
        s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function currency_formats(field){
    field.value = number_formats(field.value,2);
}

function convert_date(date_in) {
    if (date_in == null) return '';
    var date_out = '';
    if (date_in.length == 10) date_out = date_in.substr(6,4) + '-' + date_in.substr(3,2) + '-'  + date_in.substr(0,2);    
    return date_out;
}

function convert_date2(date_in) {
    if (date_in == null) return '';
    var date_out = '';    
    if (date_in.length == 10) date_out = date_in.substr(6,4) + '-' + date_in.substr(0,2) + '-'  + date_in.substr(3,2);    
    return date_out;
}

function convert_date_to_picker(date_in) {
    if (date_in == null) return '';
    var date_out = '';
    if (date_in.length == 10) date_out = parseInt(date_in.substr(8,2)) + '/' + parseInt(date_in.substr(5,2)) + '/'  + date_in.substr(0,4);     
    else if (date_in.length > 10)   date_out = parseInt(date_in.substr(8,2)) + '/' + parseInt(date_in.substr(5,2)) + '/'  + date_in.substr(0,4) + ' ' + date_in.substr(11);
    return date_out;
}

function convert_date_to_datepicker(date_in) {
    if (date_in == null) return '';
    var date_out = '';
    if (date_in.length >= 10) date_out = date_in.substr(8,2) + '/' + date_in.substr(5,2) + '/'  + date_in.substr(0,4);     
    return date_out;
}

function convert_date_to_timepicker(date_in) {
    if (date_in == null) return '';
    var date_out = '';
    if (date_in.length > 10){
        var ampm = date_in.substr(11,2) > '11' ? ' PM' : ' AM';
        var hour = date_in.substr(11,2);
        if (hour > '11') {
            hour = hour - '12';
            hour = hour < '10' ? '0'+hour : hour;
        }
        date_out = hour + date_in.substr(13,3) + ampm;  
    }
    return date_out;
}
  
function convert_date_to_format(date_in) {
    if (date_in == null) return '';
    var date_out = '';
    if (date_in.length >= 10) {    
        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sept", "Oct", "Nov", "Dis"];
        var ampm = date_in.substr(11,2) > '11' ? ' PM' : ' AM';
        var hour = date_in.substr(11,2);
        if (hour > '11') {
            hour = hour - '12';
            hour = hour < '10' ? '0'+hour : hour;
        }
        date_out = months[parseInt(date_in.substr(5,2))-1] + ' ' + parseInt(date_in.substr(8,2)) + ', ' + date_in.substr(0,4) + ' ' + hour + date_in.substr(13,3) + ampm;
    }
    return date_out;
}

function convert_date_to_picker2(date_in) {
    if (date_in == null) return '';
    var date_out = '';
    if (date_in.length == 10) date_out = date_in.substr(5,2) + '/' + date_in.substr(8,2) + '/'  + date_in.substr(0,4);     
    else if (date_in.length > 10)   date_out = date_in.substr(5,2) + '/' + date_in.substr(8,2) + '/'  + date_in.substr(0,4) + ' ' + date_in.substr(11);
    return date_out;
}  
  
function get_today(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    return dd+'/'+mm+'/'+yyyy;
}
function get_today_format(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth(); //January is 0!
    var yyyy = today.getFullYear();
    var months = ["Januari", "Februari", "Mac", "April", "Mei", "Jun", "Julai", "Ogos", "September", "Oktober", "November", "Disember"];
    return dd+' '+months[mm]+' '+yyyy;
}
function get_today_mysql(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    return yyyy+'-'+mm+'-'+dd;
}
function get_yesterday(){
    var yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    var dd = yesterday.getDate();
    var mm = yesterday.getMonth()+1; //January is 0!
    var yyyy = yesterday.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    return dd+'/'+mm+'/'+yyyy;
}
function get_yesterday_mysql(){    
    var yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    var dd = yesterday.getDate();
    var mm = yesterday.getMonth()+1; //January is 0!
    var yyyy = yesterday.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    return yyyy+'-'+mm+'-'+dd;
}

function get_date_diff(date_in, expression) {
    var date_out = '';
    $.ajax({
        url: "process/p_referance.php",
        type: "POST",
        dataType : "json",
        async : false,
        data : {"funct" : "get_date_diff", "date_in" : date_in, "expression" : expression},
        success: function(resp){
            if (resp.success == true){ 
                date_out = convert_date_to_picker2(resp.result);
            } else {
                $('#lbl_modal_error').html(resp.errors);
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });
    return date_out;
}

function dateString2Date(dateString) {
    var dt  = dateString.split(/\-|\s/);
    return new Date(dateString);
}
    
function f_claim(wfTask_id) {
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "task_claim",
            "wfTask_id" : wfTask_id
        },
        success: function(resp){
            $('.btn').attr('disabled', false);
            if (resp.success == true){ 
                f_notify(1, 'Success', 'Task successfully claimed.');
                j = 1;
            } else {
                f_notify(2, 'Error', resp.errors);
            }
        },
        error: function() {
            $('.btn').attr('disabled', false);
            f_notify(2, 'Error', errMsg_default);
        }
    });     
    return j;
}

function f_unclaim(wfTask_id) {
    var j = 0;
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "task_unclaim",
            "wfTask_id" : wfTask_id
        },
        success: function(resp){
            $('.btn').attr('disabled', false);
            if (resp.success == true){ 
                f_notify(1, 'Success', 'Task successfully unclaimed.');
                j = 1;
            } else {
                f_notify(2, 'Error', resp.errors);
            }
        },
        error: function() {
            $('.btn').attr('disabled', false);
            f_notify(2, 'Error', errMsg_default);
        }
    });    
    return j;
}

var result_submit_task;
function f_submit(wfTask_id, wfTaskType_id, status, msg, remarks, condition_no, assigned_group, assigned_user, refName, refValue) {
    var j = false;
    result_submit_task = '';
    condition_no = typeof condition_no === 'undefined' ? '' : condition_no;
    assigned_group = typeof assigned_group === 'undefined' ? '' : assigned_group;
    assigned_user = typeof assigned_user === 'undefined' ? '' : assigned_user;
    refName = typeof refName === 'undefined' ? '' : refName;
    refValue = typeof refValue === 'undefined' ? '' : refValue;
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "task_submit",
            "wfTask_id" : wfTask_id,
            "wfTaskType_id" : wfTaskType_id,
            "status" : status,
            "remarks" : remarks,
            "condition_no" : condition_no,
            "assigned_group" : assigned_group,
            "assigned_user" : assigned_user,
            "refName" : refName,
            "refValue" : refValue
        },
        success: function(resp){
            $('.btn').attr('disabled', false);
            if (resp.success == true){ 
                f_smallBox(1,msg);
                j = true;
                result_submit_task = resp.result;
            } else {
                f_notify(2, 'Error', resp.errors);
            }
        },
        error: function() {
            $('.btn').attr('disabled', false);
            f_notify(2, 'Error', errMsg_default);
        }
    });   
    return j;
}

var is_return = false;
function f_return(wfTask_id, status, msg, remarks, refName, refValue) {
    if (is_return)
        return;
    is_return = true;
    refName = typeof refName === 'undefined' ? '' : refName;
    refValue = typeof refValue === 'undefined' ? '' : refValue;
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "task_return",
            "wfTask_id" : wfTask_id,
            "status" : status,
            "remarks" : remarks,
            "refName" : refName,
            "refValue" : refValue
        },
        success: function(resp){
            $('.btn').attr('disabled', false);
            if (resp.success == true){ 
                $('#lbl_modal_success').html(msg);
                $('#modal_success').modal('show');
            } else {
                $('#lbl_modal_error').html(resp.errors);
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('.btn').attr('disabled', false);
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });  
    if (typeof $taskNew !== 'undefined')
        $taskNew.fnDraw();
}

function f_get_wfGroup_id(wfTaskType_id) {
    var wfGroup_id = '';
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "get_wfGroup_id",
            "wfTaskType_id" : wfTaskType_id
        },
        success: function(resp){
            if (resp.success == true){ 
                wfGroup_id = resp.result;
                //$('#lbl_modal_success').html('Task Successfully Rejected.');
                //$('#modal_success').modal('show');
            } else {
                $('#lbl_modal_error').html('Pengguna tidak dibenarkan tambah permohonan!');
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });    
    return wfGroup_id;
}

function get_option(field, status, tablename, id_name, desc_name, status_name, defaults, sorts, extra_name, extra_value) {
    if (defaults !== null){
        defaults == '' ? $('#'+field).html('') : $('#'+field).html('<option value="" selected>'+defaults+'</option>');
    } else 
        $('#'+field).html('');
    sorts = typeof sorts === 'undefined' ? 'ref_desc' : sorts;
    var results;
    $.ajax({
        url: "process/p_referance.php",
        type: "POST",
        dataType : "json",
        async : false,
        data : {"funct" : "ref_general", "status" : status, "tablename" : tablename, "id_name" : id_name, "desc_name" : desc_name, "status_name" : status_name,
            "sorts" : sorts, "extra_name" : extra_name, "extra_value" : extra_value},
        success: function(resp){
            if (resp.success == true){ 
                var html = '';
                var rows = resp.result;
                $.each(rows,function(u) {
                    html = '<option value="'+rows[u].ref_id+'">' + rows[u].ref_desc + '</option>';  
                    $('#'+field).append(html);
                });
                results = rows;
            } else {
                f_notify(2, 'Error', errMsg_default);
            }
        },
        error: function() {
            f_notify(2, 'Error', errMsg_default);
        }
    });
    return results;
}

function get_option_data(field, data_array, id_name, desc_name, defaults) {
    defaults == '' ? $('#'+field).html('') : $('#'+field).html('<option value="" selected>'+defaults+'</option>');
    var html = '';
    $.each(data_array,function(u) {
        html = '<option value="'+data_array[u][id_name]+'">' + data_array[u][desc_name] + '</option>';  
        $('#'+field).append(html);
    });
}

function get_option_desc(field, tablename, desc_name, defaults, sorts, extra_name, extra_value) {
    defaults == '' ? $('#'+field).html('') : $('#'+field).html('<option value="" selected>'+defaults+'</option>');
    sorts = typeof sorts === 'undefined' ? 'ref_desc' : sorts;
    $.ajax({
        url: "process/p_referance.php",
        type: "POST",
        dataType : "json",
        async : false,
        data : {"funct" : "ref_general_group", "tablename" : tablename, "desc_name" : desc_name, "sorts" : sorts, "extra_name" : extra_name, "extra_value" : extra_value},
        success: function(resp){
            if (resp.success == true){ 
                var html = '';
                var rows = resp.result;
                $.each(rows,function(u) {
                    html = '<option value="'+rows[u].ref_id+'">' + rows[u].ref_desc + '</option>';  
                    $('#'+field).append(html);
                });
            } else {
                $('#lbl_modal_error').html(resp.errors);
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });
}

function f_set_option_group (field, desc) {
    var selected = $(':selected', field);
    $('#'+desc).val(selected.closest('optgroup').attr('label'));
}

function get_option_group (field, status, tablename, id_name, desc_name, parent_name, status_name) {
    $('#'+field).html('');
    var results;
    var columns = [];
    columns[status_name] = status;
    var data_db = f_get_general_info_multiple(tablename, columns, {}, '', parent_name+', '+desc_name);
    if (data_db.length == 0) {
        f_notify(2, 'Error', errMsg_default);
        return results;
    }
    var html = '';
    var parent_hold = '';
    $.each(data_db,function(u) {
        if (u == 0) {                
            parent_hold = data_db[u][parent_name];
            html = '<optgroup label="' + parent_hold + '">';
        } else if (parent_hold != data_db[u][parent_name]) {
            html += '</optgroup>';
            $('#'+field).append(html);
            parent_hold = data_db[u][parent_name];
            html = '<optgroup label="' + parent_hold + '">';
        }            
        html += '<option value="'+data_db[u][id_name]+'">' + data_db[u][desc_name] + '</option>';  
    });
    html += '</optgroup>';
    $('#'+field).append(html);
    return results;        
}

function get_radios(field, status, tablename, id_name, desc_name, status_name, defaults, sorts, extra_name, extra_value) {
    $('#span_'+field).html('');
    sorts = typeof sorts === 'undefined' ? 'ref_desc' : sorts;
    $.ajax({
        url: "process/p_referance.php",
        type: "POST",
        dataType : "json",
        async : false,
        data : {"funct" : "ref_general", "status" : status, "tablename" : tablename, "id_name" : id_name, "desc_name" : desc_name, "status_name" : status_name,
            "sorts" : sorts, "extra_name" : extra_name, "extra_value" : extra_value},
        success: function(resp){
            if (resp.success == true){ 
                var html = '';
                var rows = resp.result;
                var i = 0;
                $.each(rows,function(u) {
                    html = '<label><input type="radio" name="' + field + '" id="' + field + rows[u].ref_id + '" value="' + rows[u].ref_id + '">' + rows[u].ref_desc + '</input></label></br>';
                    $('#span_'+field).append(html);
                    i++;
                });
                if (i == 0)
                    $('#span_'+field).html('<i>'+defaults+'</i>');
            } else {
                $('#lbl_modal_error').html(resp.errors);
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });
}
    
function f_load_address(address_id, form_tag) {
    if (address_id == null) return 1;
    $.ajax({
        url: "process/p_referance.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "get_address",
            "address_id" : address_id
        },
        success: function(resp){
            if (resp.success == true){ 
                resp.result.state_id != '' ? get_option(form_tag+'_city_id', '1', 'ref_city', 'city_id', 'city_desc', 'city_status', '-- Sila Pilih --', 'ref_desc', 'state_id', resp.result.state_id) : set_option_empty(form_tag+'_city_id', '-- Sila Pilih --');
                $.each(resp.result, function(name, vals){
                    form_tag.substr(0,1) == 'l' ? $('#'+form_tag+'_'+name).html(replaceNull(vals, '-')) : $('#'+form_tag+'_'+name).val(vals);
                });
            } else {
                $('#lbl_modal_error').html('Kesilapan pada data. Sila hubungi sistem admin!');
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });   
}

function f_load_wfTask(wfTask_id, form_tag) {
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "get_task_info",
            "wfTask_id" : wfTask_id
        },
        success: function(resp){
            if (resp.success == true){ 
                $.each(resp.result, function(name, vals){
                    if (name == 'wfTask_timeSubmitted')
                        $('#'+form_tag+'_'+name).html(convert_date_to_picker(vals));
                    else
                        form_tag.substr(0,1) == 'l' ? $('#'+form_tag+'_'+name).html(replaceNull(vals, '-')) : $('#'+form_tag+'_'+name).val(vals);
                });
            } else {
                $('#lbl_modal_error').html('Kesilapan pada data. Sila hubungi sistem admin!');
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });   
}

function f_get_wfTask_id_previous(wfTask_id, wfTaskType_id) {
    var task_id = '';
    wfTaskType_id = typeof wfTaskType_id === 'undefined' ? '' : wfTaskType_id;
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "get_task_previous",
            "wfTask_id" : wfTask_id,
            "wfTaskType_id" : wfTaskType_id
        },
        success: function(resp){
            if (resp.success == true){ 
                task_id = resp.result;
            } else {
                $('#lbl_modal_error').html('Kesilapan pada data. Sila hubungi sistem admin!');
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    }); 
    return task_id;
}

function f_save_wfTask(wfTask_id, wfTask_status, wfTask_remark){
    var j = false;
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async: false,
        data: { 
            "funct" : "save_task_info",
            "wfTask_id" : wfTask_id,
            "wfTask_status" : wfTask_status,
            "wfTask_remark" : wfTask_remark
        },
        success: function(resp){
            if (resp.success == true){ 
                j = true;
            } else {
                $('#lbl_modal_error').html(resp.errors);
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });
    return j;
}

function set_option_empty(field, defaults) {
    $('#'+field).empty();
    $('#'+field).prop('disabled', true);
    $('#'+field).val('');
    if (typeof defaults !== 'undefined' && defaults != '') 
        $('#'+field).html('<option value="" selected>'+defaults+'</option>');
}

function f_validate_required(field, errField, errMsg) {
    if ($('#'+field).val() == '') {
        $('#'+errField).html('<i>'+errMsg+'</i>');
        return false;
    }
    return true;
}

function f_validateP_required(field, errMsg, errLabel, minLength, maxLength) {
    if ($('#'+field).val() == '') {
        if (typeof errLabel === 'undefined' || errLabel == '') {
            $('#lbl_modal_error').html(errMsg);
            $('#modal_error').modal('show');
        } else
            $('#'+errLabel).html(errMsg);
        return false;
    } else if (typeof minLength !== 'undefined' && $('#'+field).val().length < minLength) {        
        errMsg += ' Pastikan ianya tidak kurang dari '+minLength+' digit.';
        if (typeof errLabel === 'undefined' || errLabel == '') {
            $('#lbl_modal_error').html(errMsg);
            $('#modal_error').modal('show');
        } else 
            $('#'+errLabel).html(errMsg);
        return false;
    } else if (typeof minLength !== 'undefined' && $('#'+field).val().length > maxLength) {        
        errMsg += ' Pastikan ianya tidak melebihi '+maxLength+' digit.';
        if (typeof errLabel === 'undefined' || errLabel == '') {
            $('#lbl_modal_error').html(errMsg);
            $('#modal_error').modal('show');
        } else 
            $('#'+errLabel).html(errMsg);
        return false;
    }
    return true;
}

function f_validate_email(field, errMsg, errLabel) {
    if ($('#'+field).val() == '') {
        if (typeof errLabel === 'undefined' || errLabel == '') {
            $('#lbl_modal_error').html(errMsg);
            $('#modal_error').modal('show');
        } else
            $('#'+errLabel).html(errMsg);
        return false;
    } else {
        var email = $('#'+field).val();
        var n = email.indexOf('@');        
        var d = email.lastIndexOf('.');
        if (n < 1 || d <= (n+1) || d == (email.length-1)) {
            if (typeof errLabel === 'undefined' || errLabel == '') {
                $('#lbl_modal_error').html(errMsg);
                $('#modal_error').modal('show');
            } else
                $('#'+errLabel).html(errMsg);
            return false;
        }            
    }
    return true;
}

function f_validateN_required(field, errMsg) {
    if ($('#'+field).val() == '' || $('#'+field).val() == 0) {
        $('#lbl_modal_error').html(errMsg);
        $('#modal_error').modal('show');
        $('#'+field).val(0);
        return false;
    }
    return true;
}

function f_list_document_permohonan(field, permohonan_id, disabled) {
    $.ajax({
        url: "process/p_permohonan.php",
        type: "POST",
        dataType : "json",
        data: { 
            "funct" : "get_document_permohonan",
            "permohonan_id" : permohonan_id
        },
        success: function(resp){
            if (resp.success == true){ 
                $('#'+field).html('');
                var html = '';
                var rows = resp.result;
                $.each(rows,function(u) {
                    var deleteIcon = disabled == 0 ? '<a href="#"><i class="fa fa-fw fa-close" onclick="f_del_document_permohonan(\''+rows[u].document_id+'\', \''+rows[u].permohonan_id+'\', \''+field+'\');"></i></a>' : '';
                    html = (u+1)+'. <a href="process/download.php?doc_id='+rows[u].document_id+'">'+rows[u].document_name+'</a>'+deleteIcon+'</br>';
                    $('#'+field).append(html);
                });
                if (html == '')
                    $('#'+field).append('<i>Tiada dokumen</i>');
            } else {
                $('#lbl_modal_error').html('Kesilapan pada data. Sila hubungi sistem admin!');
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });   
}

function f_del_document_permohonan(document_id, permohonan_id, field){
    $.ajax({
        url: "process/p_permohonan.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "del_document_permohonan",
            "document_id" : document_id,
            "permohonan_id" : permohonan_id
        },
        success: function(resp){
            if (resp.success == true){ 
                $('#lbl_modal_success').html('Dokumen berjaya dihapus.');
                $('#modal_success').modal('show');
                f_list_document_permohonan(field, permohonan_id, 0);
            } else {
                $('#lbl_modal_error').html('Kesilapan pada proses. Sila hubungi sistem admin!');
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });    
}

function f_get_value_from_table(tablename, column_name, column_value, column_out){
    var j = '';
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async: false,
        data: { 
            "funct" : "get_value_from_table",
            "tablename" : tablename,
            "column_name" : column_name,
            "column_value" : column_value,
            "column_out" : column_out
        },
        success: function(resp){
            if (resp.success == true){ 
                j = resp.result;
            } else {
                $('#lbl_modal_error').html(resp.errors);
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });
    return j;
}

function f_validate_count_table(table_name, column_name, column_value, errMsg, errLabel){
    var j = false;
    $.ajax({
        url: "process/p_referance.php",
        type: "POST",
        dataType : "json",
        async: false,
        data: { 
            "funct" : "validate_count_table",
            "table_name" : table_name,
            "column_name" : column_name,
            "column_value" : column_value
        },
        success: function(resp){
            if (resp.success == true){ 
                if (resp.result == '0') {
                    if (typeof errLabel === 'undefined') {
                        $('#lbl_modal_error').html(errMsg);
                        $('#modal_error').modal('show');
                    } else
                        $('#'+errLabel).html(errMsg);                    
                } else
                    j = true;
            } else {
                $('#lbl_modal_error').html(resp.errors);
                $('#modal_error').modal('show');
            }
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });
    return j;
}

function f_load_sijil_surat(laporan_id, param_name, param_value){
    var laporan_rpt = f_get_value_from_table('ref_laporan', 'laporan_id', laporan_id, 'laporan_rpt');
    f_load_pentaho(laporan_rpt, '&'+param_name+'='+param_value);
}

var auditAction_id = '0';
function f_save_audit(auditAction_ids, audit_transNo){
    audit_transNo = typeof audit_transNo === 'undefined' ? '' : audit_transNo;
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        data: { 
            "funct" : "save_audit",
            "auditAction_id" : auditAction_ids,
            "audit_transNo" : audit_transNo
        },
        success: function(resp){
            if (resp.success == true){ 
                j = true;
            } 
        },
        error: function() {
            $('#lbl_modal_error').html('Error on system. Please contact Administrator!');
            $('#modal_error').modal('show');
        }
    });
    //auditAction_id = '0';
}

function f_get_general_info(tablename, columns, form_tag, disabled, param, status_name) {
    var returnVal = '';
    param = typeof param === 'undefined' ? {} : param;
    status_name = typeof status_name === 'undefined' ? '' : status_name;
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "get_general_info",
            "tablename" : tablename,
            "columns" : columns,
            "param" : param,
            "status_name" : status_name
        },
        success: function(resp){
            if (resp.success == true){ 
                if (typeof form_tag !== 'undefined') {
                    $.each(resp.result, function(name, vals){
                        $('#l'+form_tag+'_'+name).html(replaceNull(vals, '-'));
                        $('#'+form_tag+'_'+name).val(vals);
                        //$('#'+form_tag+'_'+name).change();
                        if (typeof disabled !== 'undefined' && disabled == 1) 
                            $('#'+form_tag+'_'+name).prop('disabled',true);
//                        } else
//                            $('#'+form_tag+'_'+name).attr('disabled',false);
                    });
                } 
                returnVal = resp.result;
            } else {
                f_notify(2, 'Error', resp.errors);
            }
        },
        error: function() {
            f_notify(2, 'Error', errMsg_default);
        }
    }); 
    return returnVal;
}
    
function f_get_general_info_multiple(tablename, columns, param, status_name, order) {
    columns = typeof columns === 'undefined' ? {} : columns;
    param = typeof param === 'undefined' ? {} : param;
    status_name = typeof status_name === 'undefined' ? '' : status_name;
    order = typeof order === 'undefined' ? '' : order;
    var returnVal = '';    
    $.ajax({
        url: "process/p_task.php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : "get_general_info_multiple",
            "tablename" : tablename,
            "columns" : columns,
            "param" : param,
            "status_name" : status_name,
            "order" : order
        },
        success: function(resp){
            if (resp.success == true){ 
                returnVal = resp.result;
            } else {
                f_notify(2, 'Error', resp.errors);
            }
        },
        error: function() {
            f_notify(2, 'Error', errMsg_default);
        }
    }); 
    return returnVal;
}

var result_submit_batch = '';
function f_lulus_batch(wfTaskType_id, status){      
    result_submit_batch = '';
    var is_lulus_batch = false;
    if (typeof wfTaskType_id === 'undefined' || typeof status === 'undefined' || wfTaskType_id == '' || status == '') {
        f_notify(2, 'Error', errMsg_default);
    } else {
        $.ajax({
            url: "process/p_task.php",
            type: "POST",
            dataType : "json",
            async : false,
            data: { 
                "funct" : "task_batch_approve",
                "wfTaskType_id" : wfTaskType_id,
                "status" : status
            },
            success: function(resp) {
                if (resp.success == true) {
                    result_submit_batch = resp.result;
                    is_lulus_batch = true;
                    f_notify(1, 'Success', 'Total of '+resp.result+' applications successfully approved.'); 
                } else 
                    f_notify(2, 'Error', resp.errors);
            },
            error: function() {
                f_notify(2, 'Error', errMsg_default);
            }
        });
    }
    return is_lulus_batch;
}

var is_submit_forms = false;
var result_submit_forms = '';
function f_submit_forms(form_name, process_name, successMsg, errMsg, modal_success_hide) {
    var j = false;
    result_submit_forms = '';
    if (is_submit_forms)
        return j;
    is_submit_forms = true;
    successMsg = typeof successMsg === 'undefined' ? '' : successMsg;
    modal_success_hide = typeof modal_success_hide === 'undefined' ? '' : modal_success_hide;
    $.ajax({
        url: "process/"+process_name+".php",
        type: "POST",
        dataType : "json",
        async : false,
        data :  $("#"+form_name).serializeArray(),
        success: function(resp){
            if (resp.success == true){        
                result_submit_forms = resp.result;
                if (successMsg != '') 
                    f_notify(1, 'Success', successMsg); 
                if (modal_success_hide != '')
                    $('#'+modal_success_hide).modal('hide');   
                j = true;
            } else {
                f_notify(2, 'Error', resp.errors);
            }
        },
        error: function() {
            errMsg = typeof errMsg === 'undefined' ? errMsg_default : errMsg;
            f_notify(2, 'Error', errMsg);
        }
    });
    is_submit_forms = false;
    return j;
}

var is_submit_normal = false;
var result_submit = '';
function f_submit_normal(funct_name, param, process_name, successMsg, errMsg, modal_success_hide) {
    var j = false;
    result_submit = '';
    if (is_submit_normal)
        return j;
    is_submit_normal = true;
    successMsg = typeof successMsg === 'undefined' ? '' : successMsg;
    modal_success_hide = typeof modal_success_hide === 'undefined' ? '' : modal_success_hide;
    $.ajax({
        url: "process/"+process_name+".php",
        type: "POST",
        dataType : "json",
        async : false,
        data: { 
            "funct" : funct_name,
            "param" : param
        },
        success: function(resp){
            if (resp.success == true){       
                result_submit = resp.result;
                if (successMsg != '') {
                    f_notify(1, 'Success', successMsg); }
                if (modal_success_hide != '') {
                    $('#'+modal_success_hide).modal('hide'); }
                j = true; 
            } else {
                f_notify(2, 'Error', resp.errors);
            }
        },
        error: function() {
            errMsg = typeof errMsg === 'undefined' ? errMsg_default : errMsg;
            f_notify(2, 'Error', errMsg);
        }
    });
    is_submit_normal = false;
    return j;
}

function f_update_status_ref(status,tablename, ref_id, prefix, msg_title, msg_action, dt_table){
    $('#modal_waiting').on('shown.bs.modal', function(e){ 
        f_submit_normal('update_status_ref', {status:status,tablename:tablename,ref_id:ref_id,prefix:prefix}, 'p_maintenance', msg_title+' successfully '+msg_action);
        datas = f_get_general_info_multiple(dt_table);
        f_dataTable_draw(dataNew, datas);
        $('#modal_waiting').modal('hide');
        $(this).unbind(e);
    }).modal('show');  
}

function load_reference_edit(ref_id, ref_desc, ref_table, col_shortName, ref_title) {
    $('#mre_id').val(ref_id);
    $('#mre_table').val(ref_table);
    $('#mre_col_shortName').val(col_shortName);
    $('#mre_desc').val(ref_desc);
    $('#mre_title').val(ref_title);
    $('#lre_title').html(ref_title);
    $('#lre_title2').html(ref_title);
    $('#modal_reference_edit').modal('show');
}

function f_dataTable_draw(data_table, dataSet, dt_id, cols) {
    dt_id = typeof dt_id === 'undefined' ? '' : dt_id;
    cols = typeof cols === 'undefined' ? 0 : cols;
    cntRow = 1;
    data_table.clear().draw(); 
    if (dataSet != '')
        data_table.rows.add(dataSet).draw();
    else if (dt_id != '') {
        $('#'+dt_id+' tbody').empty();
        if (cols > 0) {
            newRowContent = "<tr><td colspan='"+cols+"'>No data available in table</td></tr>";
            $(newRowContent).appendTo($('#'+dt_id));
        }
    }
}

function f_notify(types, title, content) {
    $('#modal_waiting').modal('hide');
    if (types == 2) {
        $.bigBox({
            title : title,
            content : content,
            color : "#C46A69",
            icon : "fa fa-warning shake animated", //  shake animated
            number : "",
            timeout : 6000
        });
    } else if (types == 1) {
        $.smallBox({
            title : title,
            content : "<i class='fa fa-info-circle'></i> <i>"+content+"</i>",
            color : "#2fbc10",
            icon : "fa fa-bell swing animated",
            timeout : 6000
        });
    }
}

function f_modal_reset(form_id) {
    $('#'+form_id).trigger('reset');
    $('#'+form_id).bootstrapValidator('resetForm', true); 
    $('.form-group').removeClass('has-error has-feedback has-success');
    $('.form-group').find('small.help-block').hide();
    $('.form-group').find('i.form-control-feedback').hide();    
}

function f_display_attachment(divName, dataAttach) {
    var html = '';
    $.each(dataAttach, function(u){
        html += '<p><a href="process/download.php?doc_id='+dataAttach[u].document_id+'">'+(u+1)+'. '+dataAttach[u].document_uplname+'</a>&nbsp;&nbsp;';
        html += '<button type="button" onclick="f_delete_attachment('+dataAttach[u].document_id+','+dataAttach[u].param_id+', \''+divName+'\')" class="btn btn-danger btn-xs mac_hideView map_hideView"><i class="fa fa-trash-o"></i></button></p>';
    });
    $('#'+divName).html(html);
}

function f_delete_attachment(document_id, param_id, className) {
    var dataAttach = [];
    if (f_submit_normal('delete_file', {document_id:document_id, param_id:param_id, flag:className}, 'p_upload', 'Document successfully deleted.', 'Document fail to delete.')) {
        if (className == 'mac_doc_catalogue')    
            dataAttach = f_get_general_info_multiple('vw_consultant_doc', {param_id:param_id})
        else
            return 1;
        f_display_attachment(className, dataAttach);
    }
}

function f_smallBox(types, msg) {
    var color = types==1?"#5F895F":"#C46A69";
    $.smallBox({
        title: msg,
        content: "<i class='fa fa-warning'></i> <i>1 seconds ago...</i>",
        color: color,
        iconSmall: "fa fa-check bounce animated",
        timeout: 4000
    });
}

function f_send_email(funct, param) {
    var result='';
    param = typeof param === 'undefined' ? {} : param;
    $.ajax({
        url: "process/p_email.php",
        type: "POST",
        dataType : "json",        
        async : true,
        data: { 
            "funct" : funct,
            "param" : param
        },
        success: function(resp){
            result = resp.result;
        }
    }); 
    return result;
}

function f_chart_color() { 
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, 	function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });
}
    
function chart_pie(chart_div, title, subtitle, data_chart, is_datalabel) {
    Highcharts.chart(chart_div, {
        chart: {
            type: 'pie',
//            options3d: {
//                enabled: true,
//                alpha: 60,
//                beta: 0
//            }
        },
        title: {
            text: title,
        },
        subtitle: {
            text: subtitle
        },
        credits:{
            enabled:false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: is_datalabel,
                    distance: 5,
                    format: '{point.short}: {y}',
                },
                showInLegend: true
            },
//            series: {
//                point: {
//                    events: {
//                        click: function (event) {
//                            event_chart_pie_3d(this.id);
//                        },
//                        legendItemClick: function () {
//                            return false; // <== returning false will cancel the default action
//                        }
//                    }
//                }
//            }
        },
        tooltip: {
            pointFormat: 'Total : <b>{point.y} ({point.percentage:.1f}%)</b>'
        },
        series: [{
            name: '',
            data: data_chart
        }]
    });
}

function chart_bar(chart_div, title, subtitle, data_cate, data_value, title_y) {
    Highcharts.chart(chart_div, {
        chart: {
            type: 'bar'
        },
        title: {
            text: title,
        },
        subtitle: {
            text: subtitle
        },
        xAxis: {
            categories: data_cate
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: title_y
            }
        },
        credits:{
            enabled:false
        },
        tooltip: {
            pointFormat: 'Total : <b>{point.y}</b>'
        },
        legend: {
            enabled: false
        },
        series: [{
            name: title_y,
            colorByPoint: true,
            data: data_value
        }]
    });
}

function chart_donut(chart_div, title, subtitle, dataset) {
    Highcharts.chart(chart_div, {
        chart: {
            type: 'pie',
//            options3d: {
//                enabled: true,
//                alpha: 60
//            }
        },
        title: {
            text: title
        },
        subtitle: {
            text: subtitle
        },
        credits:{
            enabled:false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                innerSize: 130,
                depth: 45,
                dataLabels: {
                    enabled: false,
                    distance: 5,
                    format: '{point.name}: {y}',
                },
                showInLegend: true
            },
//            series: {
//                point: {
//                    events: {
//                        legendItemClick: function () {
//                            return true; // <== returning false will cancel the default action
//                        }
//                    }
//                }
//            }
        },
        tooltip: {
            pointFormat: 'Total : <b>{point.y} ({point.percentage:.1f}%)</b>'
        },
        series: [{
            name: '',
            data: dataset
        }]
    });
}

function chart_bar_sub(chart_div, title, subtitle, data_chart, data_chart_sub, title_y) {
    var chart_obj = Highcharts.chart(chart_div, {
        chart: {
            type: 'bar',
            events: {
                drilldown: function(e) {
                    setTimeout(function() {             
                        chart_obj.xAxis[0].update({max: Object.keys(e.seriesOptions.data).length >= 15 ? 15 : Object.keys(e.seriesOptions.data).length - 1});
                     }, 0);                    
                },
                drillup: function(e) {
                    setTimeout(function() {
                        chart_obj.xAxis[0].update({max: 15});
                    }, 0);
                }
            }
//                events: {
//                    drilldown: function (event) {
//                        alert(event.seriesOptions.id);
//                    }
//                }
        },
        title: {
            text: title
        },
        subtitle: {
            text: subtitle
        },
        credits:{
            enabled:false
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: title_y
            }
        },
        legend: {
            enabled: false
        },
        scrollbar: {
            enabled: true
        },
        plotOptions: {
            series: {
                cropThreshold: 300,
                getExtremesFromAll: true,
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                },
                pointPadding: 0,
                turboThreshold:100
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>'
        },
        series: [{
            name: title_y,
            colorByPoint: true,
            data: data_chart
        }],
        drilldown: {
            series : data_chart_sub
        }
    });
}

function chart_pie_sub(chart_div, title, subtitle, data_chart, data_chart_sub, title_y) {
    Highcharts.chart(chart_div, {
        chart: {
            type: 'pie'
        },
        title: {
            text: title
        },
        subtitle: {
            text: subtitle
        },
        credits:{
            enabled:false
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: false
                },
                animation: true,
                showInLegend: true
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>'
        },
        series: [{
            name: title_y,
            colorByPoint: true,
            data: data_chart
        }],
        drilldown: {
            series : data_chart_sub
        }
    });
}

function chart_combine_line_bar(chart_div, title, subtitle, data_chart_1, data_chart_2, xAxis_type, tickInterval, stitle1, stitle2) {
    Highcharts.chart(chart_div, {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: title
        },
        subtitle: {
            text: subtitle
        },
        credits:{
          enabled:false
        },
        xAxis: [{
            type: xAxis_type,
            crosshair: true,
            tickInterval: tickInterval
        }],
        yAxis: [{ // Primary yAxis
                title: {
                    text: stitle2,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                allowDecimals: false,
                opposite: true
            },{ // Secondary yAxis
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[5]
                    }
                },
                title: {
                    text: stitle1,
                    style: {
                        color: Highcharts.getOptions().colors[5]
                    }
                },
                allowDecimals: false,
            }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 120,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        series: [{
            name: stitle1,
            type: 'column',
            yAxis: 1,
            pointPadding: 0,
            groupPadding: 0.2,
            color: Highcharts.getOptions().colors[9],
            data: data_chart_1
        }, {
            name: stitle2,
            type: 'spline',
            color: Highcharts.getOptions().colors[8],
            data: data_chart_2
        }]
    });
}
   
function chart_bar_stack(chart_div, title, subtitle, data_categories, data_series, title_y) {
    Highcharts.chart(chart_div, {
        chart: {
            type: 'bar'
        },
        title: {
            text: title
        },
        subtitle: {
            text: subtitle
        },
        xAxis: {
            categories: data_categories
        },
        yAxis: {
            min: 0,
            allowDecimals: false,
            title: {
                text: title_y
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: data_series
    });
}
    
function f_set_city(city_name, city_id, state_name, state_id) {
    set_option_empty(city_name);
    if ($('#'+state_name).val() != '') {   
        get_option (city_name, '1', 'ref_city', 'city_id', 'city_desc', 'city_status', ' ', 'ref_desc', 'state_id', state_id);
        $('#'+city_name).prop('disabled', false).val(city_id);
    }
}

function chart_complience(chart_div, title, subtitle, dataset, units) {
    Highcharts.chart(chart_div, {
        chart: {
            type: 'spline',
//            animation: Highcharts.svg,
            marginRight: 10
        },
        title: {
            text: title
        },
        subtitle: {
            text: subtitle
        },
        credits:{
          enabled:false
        },
        xAxis: {
            type: 'datetime',
            labels: {
                overflow: 'justify'
            }
        },
        yAxis: {
            title: {
                text: 'Concentration ('+units+')'
            },
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null//,
//            plotBands: [{ 
//                from: 0,
//                to: limitValue,
//                color: '#b0edbe',
//                label: {
//                    text: 'Comply',
//                    style: {
//                        color: '#606060'
//                    }
//                }
//            }, { 
//                from: limitValue,
//                to: 10000,
//                color: '#ffd6d7',
//                label: {
//                    text: 'Not Comply',
//                    style: {
//                        color: '#606060'
//                    }
//                }
//            }]
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        tooltip: {
            valueSuffix: units
        },
        plotOptions: {
            series: {
                turboThreshold: 0
            },
            spline: {
                lineWidth: 2,
                //color: 'blue',
                states: {
                    hover: {
                        lineWidth: 4
                    }
                },
                marker: {
                    radius: 3,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: dataset,
        navigation: {
            menuItemStyle: {
                fontSize: '10px'
            }
        }
    });
}

function f_steps (arr_steps, current_turn, step_id, is_end) {
    var html = '';
    $.each(arr_steps, function(u){
        var btn_type = parseInt(arr_steps[u].wfTaskType_turn) > current_turn ? 'btn-default' : 'btn-info';
        if (typeof is_end !== 'undefined' && is_end == 0 && u == arr_steps.length - 1)
            btn_type = 'btn-info';
        html += '<div class="process-step">' +
            '<button type="button" class="btn ' + btn_type + ' btn-circle" data-toggle="tab"><i class="fa ' + arr_steps[u].wfTaskType_icon + ' fa-2x"></i></button>' +
            '<p><small>' + arr_steps[u].wfTaskType_iconName + '</p>' +
            '</div>';
    });
    $('#'+step_id).html(html);
}

function f_switch(form_id, switch_id, switch_field, extra_field) {    
    if ($("#"+switch_id).is(':checked')) {
        $('#'+switch_field).prop('disabled', false);
        $('#'+form_id).bootstrapValidator('enableFieldValidators', switch_field, true);
        if (typeof extra_field !== 'undefined') {
            $('#'+extra_field).prop('disabled', false);
            $('#'+form_id).bootstrapValidator('enableFieldValidators', extra_field, true);
        }
    } else {
        $('#'+form_id).bootstrapValidator('enableFieldValidators', switch_field, false);
        $('#'+switch_field).prop('disabled', true);
        $('#'+switch_field).val('');
        if (typeof extra_field !== 'undefined') {
            $('#'+form_id).bootstrapValidator('enableFieldValidators', extra_field, false);
            $('#'+extra_field).prop('disabled', true);
            $('#'+extra_field).val('');
        }
    }
}    
    
$('.modal').on('shown.bs.modal', function () {
    if($(this).attr('id') != 'modal_waiting' && $(this).attr('id') != 'modal_consultant_existing') {
        $('.modal-body').scrollTop(0);
    }
});
