<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe-2LZ0JETWPTXcBkdnz8LuMltiTIhbyE&callback=initMap"></script>
<link rel="stylesheet" type="text/css" href="dist/css/map-icons.css">
<script type="text/javascript" src="dist/js/map-icons.js"></script>

<style>
    #map-canvas {
      /*width: 1000px;*/
      height: 623px;
    }
    #legend {
      background: #FFF;
      padding: 10px;
      margin: 5px;
      font-size: 12px;
      font-family: Arial, sans-serif;
    }
    .color {
      border: 1px solid;
      height: 12px;
      width: 12px;
      margin-right: 3px;
      float: left;
    }
    .red {
      background: #f02c2c;
    }
    .pink {
      background: #ffb8c4;
    }
    .green {
      background: #309f42;
    }
    .blue {
      background: #0099FF;
    }
</style>

<script type="text/javascript">
    
    var datas;
    var jenis = 1;
    var data_poo_byState;
    var poo_otable_byState;
    var data_poo_status;
    var poo_otable_status;
    var data_poo_param;
    var poo_otable_param;
    var data_poo_opacity;
    var poo_otable_opacity;
    var cur_state;
    var cur_parlimen;
    var cur_date = get_today_mysql();
    var poo_limit_value = [0,0,0,0,0,0,0,0,0,0,0];
    
    var marker;
    var map;
    var markersArray = [];
    var mapCanvas = document.getElementById('map-canvas');
    var latlng = new google.maps.LatLng(4.00000,109.50000);
    var mapOptions = {
        zoom: 6,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }    
    map = new google.maps.Map(mapCanvas, mapOptions);

    // Create the legend and display on the map
    var legend = document.createElement('div');
    legend.id = 'legend';
    var content = [];
    content.push('<p><img src="img/maps/1.png" height="20" width="20"> <a href="#" onclick="f_poo_select_status(1);">Received</a></p>');
    content.push('<p><img src="img/maps/2.png" height="20" width="20"> <a href="#" onclick="f_poo_select_status(2);">Data Short</a></p>');
    content.push('<p><img src="img/maps/3.png" height="20" width="20"> <a href="#" onclick="f_poo_select_status(3);">Not Received</a></p>');
    //content.push('<p><img src="img/maps/G.png" height="20" width="20"> JAS Building</p>');
    legend.innerHTML = content.join('');
    legend.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
    var infoWindow = new google.maps.InfoWindow;      
    var bounds = new google.maps.LatLngBounds();
    
    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    } 
        
    function addMarker(lat, lng, info, numbers) {
        var pt = new google.maps.LatLng(lat, lng);
        bounds.extend(pt);
        var icon = {
                url:'img/maps/'+numbers+'.png',
                scaledSize: new google.maps.Size(25, 25)
            };
        marker = new google.maps.Marker({
            map: map,
            position: pt,
            icon: icon,
            marker_type: numbers
        });    
        markersArray.push(marker);
        map.fitBounds(bounds);
        bindInfoWindow(marker, map, infoWindow, info);            
    }    
    
    function clearOverlays(){
        if (markersArray) {
            for (i in markersArray) {
                markersArray[i].setMap(null);
            }
        }
    }
        
    function load_map(date_pooling, state_id, parlimen_id, wfGroup_name){
        clearOverlays();
        map = new google.maps.Map(mapCanvas, mapOptions);
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
        bounds = new google.maps.LatLngBounds();
        var map_data = f_get_general_info_multiple('vw_map_pooling_status', {state_id:state_id, parlimen_id:parlimen_id, wfGroup_name:'%'+wfGroup_name+'%'}, {pool_date:date_pooling, short_year:date_pooling.substr(2,2)});
        $.each(map_data,function(u) {
            var marker_img = '3';
            if (map_data[u].total_data !== null && map_data[u].total_data != '0') {
                marker_img = parseInt(map_data[u].total_data) < parseInt(map_data[u].total_needed) ? '2' : '1';
            }
            var marker_detail = '<strong>'+map_data[u].wfGroup_name+'</strong></br>Stack ID : <strong><a href="#" onclick="f_poo_stack_detail('+map_data[u].indAll_id+','+map_data[u].total_needed+','+map_data[u].total_data+','+marker_img+')">'+map_data[u].indAll_stackNo+'</a></strong></br>' +
                'Total Needed : '+formattedNumber(map_data[u].total_needed)+'</br>Total Received : '+formattedNumber(map_data[u].total_data);
            addMarker(map_data[u].indAll_stackLatitude, map_data[u].indAll_stackLongitude, marker_detail, marker_img);
        }); 
    }
    
    $(document).ready(function () { 
        
        pageSetUp();
        
        $("#poo_dateMap").datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            maxDate: '0', 
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: true,
            beforeShow: function( input ) {
		setTimeout(function() {
                    var clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                    clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                    }, 1 );
            },
            onSelect: function( input ) {
                if (input) {
                    cur_date = input;
                    $('#modal_waiting').on('shown.bs.modal', function(e){
                        load_map(cur_date, cur_state, cur_parlimen, $('#poo_wfGroup_name').val());
                        data_poo_byState = f_get_general_info_multiple('dt_pooling_by_state', {}, {pool_date:cur_date, short_year:cur_date.substr(2,2)});
                        f_dataTable_draw(poo_otable_byState, data_poo_byState);
                        $('#poo_div_stack_detail').hide();
                        $('#modal_waiting').modal('hide');
                        $(this).unbind(e);
                    }).modal('show'); 
                } else {
                    $("#poo_dateMap").val(cur_date);
                }
            }
        });
        
        $('#poo_widget_parlimen, #poo_div_stack_detail').hide();
        $('#poo_state_id').html('<li><a href="javascript:void(0);" onclick="f_poo_select_state(\'\',\'All States\');">All States</a></li>');
        var arr_state = f_get_general_info_multiple('ref_state', {state_status:'1'}, null, null, 'state_desc');
        $.each(arr_state, function(u){  
            $('#poo_state_id').append('<li><a href="javascript:void(0);" onclick="f_poo_select_state(\''+arr_state[u].state_id+'\',\''+arr_state[u].state_desc+'\');">'+arr_state[u].state_desc+'</a></li>');
        });
        
        $('#ipoo_btn_search_map').on('click', function () { 
            $('#modal_waiting').on('shown.bs.modal', function(e){
                load_map(cur_date, cur_state, cur_parlimen, $('#poo_wfGroup_name').val());
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show'); 
        });
    
        var datatable_poo_byState = undefined;  
        poo_otable_byState = $('#datatable_poo_byState').DataTable({
            "aaSorting": [[0]],
            "ordering": false,
            "paging": false,
            "sDom": "<'dt-toolbar'<'col-xs-12'T>r>" + "t",
            "bFilter": false,
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_poo_byState) {
                    datatable_poo_byState = new ResponsiveDatatablesHelper($('#datatable_poo_byState'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_poo_byState.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_poo_byState.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all"
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible"
                    },
                    {
                        "sExtends": "print",
                        "sTitle": "iRemote_print",
                        "sMessage": "iRemote System"
                    }
                ],
               "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "aoColumns":
                [                   
                    {mData: 'state_desc'},
                    {mData: 'data_green', sClass: 'text-right'},
                    {mData: 'data_orange', sClass: 'text-right'},
                    {mData: 'data_red', sClass: 'text-right'}
                ]
        });   
        
        var datatable_poo_status = undefined;  
        poo_otable_status = $('#datatable_poo_status').DataTable({
            "aaSorting": [[0]],
            "sDom": "<'dt-toolbar'<'col-xs-12'T>r>" + "t",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_poo_status) {
                    datatable_poo_status = new ResponsiveDatatablesHelper($('#datatable_poo_status'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_poo_status.createExpandIcon(nRow);
                var info = poo_otable_status.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_poo_status.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all"
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible"
                    },
                    {
                        "sExtends": "print",
                        "sTitle": "iRemote_print",
                        "sMessage": "iRemote System"
                    }
                ],
               "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "aoColumns":
                [                   
                    {mData: null, bSortable: false},
                    {mData: 'inputParam_desc'},
                    {mData: null, sClass: 'text-right',
                        mRender: function (data, type, row) {
                            return '1,440';
                        }
                    },
                    {mData: 'input_01', sClass: 'text-right',
                        mRender: function (data, type, row) {
                            return formattedNumber(data);
                        }
                    },
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var marker_img = '3';
                            var marker_label = 'Not Received';
                            if (parseInt(row.input_01)>=1440) {
                                marker_img = '1';
                                marker_label = 'Received';
                            } else if (parseInt(row.input_01)>0) {
                                marker_img = '2';
                                marker_label = 'Short';
                            }
                            return '<img src="img/maps/'+marker_img+'.png" height="20" width="20" /> '+marker_label;
                        }
                    },
                    {mData: 'reasonFail_desc'}
                ]
        });   
        
        var datatable_poo_param = undefined;  
        poo_otable_param = $('#datatable_poo_param').DataTable({
           "ordering":false,
            "scrollY": "400px",
            "scrollCollapse": true,
            "paging": false,
            "sDom": "<'dt-toolbar'<'col-sm-12 hidden-xs'T>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-12'i>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_poo_param) {
                    datatable_poo_param = new ResponsiveDatatablesHelper($('#datatable_poo_param'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_poo_param.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_poo_param.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all"
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible"
                    },
                    {
                        "sExtends": "print",
                        "sTitle": "iRemote_print",
                        "sMessage": "iRemote System"
                    }
                ],
               "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "aoColumns":
                [                   
                    {mData: 'list_time', sClass: 'padding-5 text-center'},
                    {mData: 'sum_1', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_poo_data_listing(1, data, row);
                        }
                    },
                    {mData: 'sum_2', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_poo_data_listing(2, data, row);
                        }
                    },
                    {mData: 'sum_3', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_poo_data_listing(3, data, row);
                        }
                    },
                    {mData: 'sum_4', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_poo_data_listing(4, data, row);
                        }
                    },
                    {mData: 'sum_5', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_poo_data_listing(5, data, row);
                        }
                    },
                    {mData: 'sum_6', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_poo_data_listing(6, data, row);
                        }
                    },
                    {mData: 'sum_7', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_poo_data_listing(7, data, row);
                        }
                    }
                ]
        });   
        
        var datatable_poo_opacity = undefined;  
        poo_otable_opacity = $('#datatable_poo_opacity').DataTable({
            "ordering":false,
            "scrollY": "400px",
            "scrollCollapse": true,
            "paging": false,
            "sDom": "<'dt-toolbar'<'col-sm-12 hidden-xs'T>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-12'i>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_poo_opacity) {
                    datatable_poo_opacity = new ResponsiveDatatablesHelper($('#datatable_poo_opacity'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_poo_opacity.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_poo_opacity.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all"
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible"
                    },
                    {
                        "sExtends": "print",
                        "sTitle": "iRemote_print",
                        "sMessage": "iRemote System"
                    }
                ],
               "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "aoColumns":
                [                   
                    {mData: 'list_time', sClass: 'padding-5 text-center'},                        
                    {mData: 'data_1', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[1] != 0 && parseFloat(data) > poo_limit_value[1])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_2', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[2] != 0 && parseFloat(data) > poo_limit_value[2])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_3', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[3] != 0 && parseFloat(data) > poo_limit_value[3])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_4', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[4] != 0 && parseFloat(data) > poo_limit_value[4])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_5', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[5] != 0 && parseFloat(data) > poo_limit_value[5])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_6', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[6] != 0 && parseFloat(data) > poo_limit_value[6])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_7', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[7] != 0 && parseFloat(data) > poo_limit_value[7])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_8', sClass: 'padding-5 text-right',
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[8] != 0 && parseFloat(data) > poo_limit_value[8])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_9', sClass: 'padding-5 text-right',
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[9] != 0 && parseFloat(data) > poo_limit_value[9])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    },
                    {mData: 'data_10', sClass: 'padding-5 text-right',
                        mRender: function (data, type, row) {
                            $label = (data != null && parseFloat(data) != 0) ? formattedNumber(data,3) : '-';
                            if (data != null && poo_limit_value[10] != 0 && parseFloat(data) > poo_limit_value[10])
                                $label = '<b class="badge bg-color-red"> '+formattedNumber(data,3)+' </b>';
                            return $label;
                        }
                    }
                ]
        }); 
        
        $('#modal_waiting').on('shown.bs.modal', function(e){          
            load_map(cur_date, '', '', '');   
            data_poo_byState = f_get_general_info_multiple('dt_pooling_by_state', {}, {pool_date:cur_date, short_year:cur_date.substr(2,2)});
            f_dataTable_draw(poo_otable_byState, data_poo_byState);   
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    });
    
    function f_poo_select_status (marker_type) {
        for (i in markersArray) {
            if (markersArray[i].marker_type == marker_type) 
                markersArray[i].setVisible(!markersArray[i].getVisible());
        }    
    }    
    
    function f_poo_stack_detail (indAll_id, total_needed, total_data, marker_img) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_poo_selected').trigger('reset');
            var stack_info = f_get_general_info('vw_pooling_selected_stack', {indAll_id:indAll_id}, 'poo');  
            $('#lpoo_pooling_date').html(cur_date);
            $('#lpoo_data_needed').html(formattedNumber(total_needed));
            $('#lpoo_data_received').html(formattedNumber(total_data));
            $('#lpoo_image_status').attr('src', 'img/maps/'+marker_img+'.png');
            if (marker_img == '1') 
                $('#lpoo_data_status').html('Data Received');
            else if (marker_img == '2') 
                $('#lpoo_data_status').html('Data Short');
            else
                $('#lpoo_data_status').html('Data Not Received');
            var input_parameter = f_get_general_info('vw_pooling_selected_param', {}, '', '', {indAll_id:indAll_id});  
            $('#lpoo_param_needed').html(input_parameter.param_list);
            poo_limit_value = [0,0,0,0,0,0,0,0,0,0,0];
            var is_data = false;        
            for (var i=1;i<8;i++) {
                poo_otable_param.columns(i).visible(false);
            }
            var industrial_param = f_get_general_info_multiple('vw_compliance_param_list', {indAll_id:indAll_id}, '', '', 'inputParam_id');
            $.each(industrial_param, function(u){ 
                if (parseInt(industrial_param[u].inputParam_id) < 8) {
                    is_data = true;
                    poo_otable_param.columns(industrial_param[u].inputParam_id).visible(true);
                }
                poo_limit_value[parseInt(industrial_param[u].inputParam_id)] = industrial_param[u].indParam_limitValue;
            });
            // -- 30-minute-- \\
            data_poo_status = f_get_general_info_multiple('dt_pooling_selected_param_summary', {}, {indAll_id:indAll_id, pool_date:cur_date, short_year:cur_date.substr(2,2)});
            f_dataTable_draw(poo_otable_status, data_poo_status); 
            data_poo_param = '';
            if (is_data)
                data_poo_param = f_get_general_info_multiple('dt_data_30', {}, {short_year:cur_date.substr(2,2), data_date:cur_date, premise_no:stack_info.industrial_premiseId, indAll_stackNo:stack_info.indAll_stackNo});
            f_dataTable_draw(poo_otable_param, data_poo_param); 
            // -- 1-minute-- \\
            for (var i=1;i<10;i++) {
                poo_otable_opacity.columns(i).visible(false);
            }
            $.each(industrial_param, function(u){ 
                poo_otable_opacity.columns(industrial_param[u].inputParam_id).visible(true);
            });  
            data_poo_opacity = f_get_general_info_multiple('dt_data_01', {}, {short_year:cur_date.substr(2,2), data_date:cur_date, premise_no:stack_info.industrial_premiseId, indAll_stackNo:stack_info.indAll_stackNo});
            f_dataTable_draw(poo_otable_opacity, data_poo_opacity, '', 10);             
            $('#poo_div_stack_detail').show();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_poo_data_listing(param_id, data, rows){
        var label = '-';
        if (data != null) {
            var final_data = param_id < 8 ? parseFloat(rows['sum_'+param_id])/parseInt(rows['count_'+param_id]) : parseFloat(data);
            var format_data = formattedNumber(final_data,3);
            if (final_data <= 0)
                label = '<b class="badge bg-color-pinkDark"> '+format_data+' </b>';
            else if (final_data > poo_limit_value[param_id] && param_id >= 8)
                label = '<b class="badge bg-color-red"> '+format_data+' </b>';
            else if (final_data > 2*poo_limit_value[param_id] && param_id <8)
                label = '<b class="badge bg-color-red"> '+format_data+' </b>';
            else 
                label = format_data;
        }
        return label;
    }
    
    function f_poo_select_state (state_id, state_desc) {
        cur_state = state_id;
        $('#poo_state_desc').html(state_desc);
        $('#poo_parlimen_id').html('');
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (state_id == '') {
                $('#poo_widget_parlimen').hide();
            } else {
                $('#poo_widget_parlimen').show();
                $('#poo_parlimen_desc').html('Parliament');
                $('#poo_parlimen_id').html('<li><a href="javascript:void(0);" onclick="f_poo_select_parlimen(\'\',\'All Parliament\', \''+state_id+'\');">All Parliament</a></li>');
                var arr_parlimen = f_get_general_info_multiple('ref_parlimen', {state_id:state_id, parlimen_status:1}, null, null, 'parlimen_desc');
                $.each(arr_parlimen, function(u){  
                    $('#poo_parlimen_id').append('<li><a href="javascript:void(0);" onclick="f_poo_select_parlimen(\''+arr_parlimen[u].parlimen_id+'\',\''+arr_parlimen[u].parlimen_desc+'\', \''+state_id+'\');">'+arr_parlimen[u].parlimen_desc+'</a></li>');
                });
            }        
            load_map(cur_date, state_id, '', '', $('#poo_wfGroup_name').val());
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_poo_select_parlimen (parlimen_id, parlimen_desc, state_id) {
        cur_parlimen = parlimen_id;
        $('#poo_parlimen_desc').html(parlimen_desc);
        $('#modal_waiting').on('shown.bs.modal', function(e){
            load_map(cur_date, state_id, parlimen_id, $('#poo_wfGroup_name').val());
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
        
</script>