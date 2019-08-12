<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe-2LZ0JETWPTXcBkdnz8LuMltiTIhbyE&callback=initMap"></script>
<!--<link rel="stylesheet" type="text/css" href="dist/css/map-icons.css">-->
<link rel="stylesheet" type="text/css" href="dist/css/map-icons.css">
<script type="text/javascript" src="dist/js/map-icons.js"></script>

<style>
    #map-canvas {
      /*width: 1000px;*/
      height: 583px;
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
    var dataPnm;
    
    var marker;
    var map;
    var markersArray = [];
    var mapCanvas = document.getElementById('map-canvas');
    var latlng = new google.maps.LatLng(3.13900,101.68685);
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
    content.push('<p><img src="img/maps/5.png" height="20" width="20"> Success</p>');
    content.push('<p><img src="img/maps/7.png" height="20" width="20"> Wrong Format</p>');
    content.push('<p><img src="img/maps/6.png" height="20" width="20"> Not Received</p>');
    content.push('<p><img src="img/maps/G.png" height="20" width="20"> JAS Building</p>');
    legend.innerHTML = content.join('');
    legend.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
    var infoWindow = new google.maps.InfoWindow;      
    var bounds = new google.maps.LatLngBounds();
    var colorIcons = ['f02c2c', 'ffb8c4', '309f42', '0099FF'];
//    var info_html = "<table>" +
//        "<tr><td>Name:</td> <td><input type='text' id='name'/> </td> </tr>" +
//        "<tr><td>Description:</td> <td><input type='text' id='description'/></td> </tr>" +
//        "<tr><td></td><td><input type='button' value='Save & Close' onclick='saveData()'/></td></tr>";
//    infowindow = new google.maps.InfoWindow({
//        content: info_html
//    });
    
    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
        //show_marker_detail(marker.get('location_id'));
      });
    } 
        
    function addMarker(lat, lng, info, numbers, ids) {
//            var jenis = 3;
//            if (numbers > 10)
//                jenis = 0;
//            else if (numbers > 5)
//                jenis = 1;
//            else if (numbers > 1)
//                jenis = 2;
        //icon: 'http://www.googlemapsmarkers.com/v1/15/0099FF/'
        var pt = new google.maps.LatLng(lat, lng);
        bounds.extend(pt);
//                marker = new Marker({
//                    map: map,
//                    position: new google.maps.LatLng(lat, lng),
//                    icon: {
//                            path: MAP_PIN,
//                            fillColor: '#'+colorIcons[jenis],
//                            fillOpacity: 0.9,
//                            strokeColor: '',
//                            strokeWeight: 0
//                    },
//                    map_icon_label: '<span class="map-icon map-icon-store"></span>'
//                });
        var icon = {
                url:'img/maps/'+numbers+'.png',
                scaledSize: new google.maps.Size(25, 25)
            };
        marker = new google.maps.Marker({
            map: map,
            position: pt,
            location_id:ids,
            icon: icon
            //icon: 'img/maps/'+numbers+'.png'
//                    label: {
//                        text: '23',
//                        color: 'purple'
//                    }
            //icon: 'http://www.googlemapsmarkers.com/v1/'+numbers+'/'+colorIcons[jenis]
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
        
    function load_map(param){
        clearOverlays();
        bounds = new google.maps.LatLngBounds();
        var map_data = f_get_general_info_multiple('vw_map_pooling_status', {location_id:'>'+param});
        $.each(map_data,function(u) {
            addMarker(map_data[u].location_latitude, map_data[u].location_longitude, map_data[u].location_desc, map_data[u].totals, map_data[u].location_id);
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
            closeText:'Clear',
            beforeShow: function( input ) {
		setTimeout(function() {
                    var clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                    clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                    }, 1 );
            },
            onSelect: function( input ) {
                //
            }
        });
        
        
            
        
        //load_map();
        
        var datatable_pmn = undefined;  
        dataPnm = $('#datatable_pmn').DataTable({
            "aaSorting": [[0]],
            "ordering": false,
            "bPaginate": false,
            "sDom": "<'dt-toolbar'>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-12 hidden-xs'i>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_pmn) {
                    datatable_pmn = new ResponsiveDatatablesHelper($('#datatable_pmn'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_pmn.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_pmn.respond();
            },
            "aoColumns":
                [                   
                    {mData: 'aa', bSortable: false},
                    {mData: 'bb', sClass: 'text-center', bSortable: false},
                    {mData: 'cc', sClass: 'text-center', bSortable: false},
                    {mData: 'dd', sClass: 'text-center', bSortable: false}
                ]
        });   
        
        datas = [{aa:'Johor', bb:'256', cc:'323', dd:'2'},
            {aa:'Kedah', bb:'545', cc:'323', dd:'1'},
            {aa:'Kelantan', bb:'65', cc:'323', dd:'32'},
            {aa:'Kuala Lumpur', bb:'77', cc:'78', dd:'43'},
            {aa:'Melaka', bb:'887', cc:'38', dd:'55'},
            {aa:'N Sembilan', bb:'9', cc:'87', dd:'34'},
            {aa:'Pahang', bb:'98', cc:'76', dd:'45'},
            {aa:'Perak', bb:'99', cc:'4', dd:'22'},
            {aa:'Perlis', bb:'13', cc:'3', dd:'56'},
            {aa:'Pulau Pinang', bb:'32', cc:'323', dd:'87'},
            {aa:'Sabah', bb:'55', cc:'68', dd:'98'},
            {aa:'Sarawak', bb:'66', cc:'565', dd:'43'},
            {aa:'Selangor', bb:'143', cc:'12', dd:'3'},
            {aa:'Terengganu', bb:'77', cc:'45', dd:'65'},
            {aa:'Wilayah P', bb:'877', cc:'5', dd:'14'}]
        f_dataTable_draw(dataPnm, datas);
        
        var datatable_poo = undefined;  var cnt_poo = 1;
        dataNew = $('#datatable_poo').DataTable({
            "aaSorting": [[3,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_poo'>><'col-sm-6 hidden-xs'lTC>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_poo) {
                    datatable_poo = new ResponsiveDatatablesHelper($('#datatable_poo'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_poo.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_poo.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_poo)
                                cnt_poo = 1;
                            if ( iColumn === 0 )
                                return cnt_poo++;
                            else if ( iColumn === 9 )
                                return '';
                            return sValue;
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {                            
                            if (datas.length < cnt_poo)
                                cnt_poo = 1;
                            if ( iColumn === 0 )
                                return cnt_poo++;
                            else if ( iColumn === 9 )
                                return '';
                            return sValue;
                        }
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
                    {mData: 'data1'},
                    {mData: 'data2'},
                    {mData: 'data3'},
                    {mData: 'data4'},
                    {mData: 'data5'},
                    {mData: 'status_desc'},
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" id="poo_btn_info" title="Industrial Info" onclick="f_load_cems (3);"><i class="fa fa-info-circle"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_poo thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_poo thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_poo thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        datas = [{data1:'Gas Asli Sdn Bhd', data2:'ABCDEF', data3:'Fuel Burning Equipment', data4:'Selangor', data5:'Hulu Langat', status_desc:'Not Received'},
           {data1:'MTBE Petronas', data2:'DEFGHI', data3:'Water Incinerator', data4:'Pahang', data5:'Kuantan', status_desc:'No Connection'}];
        f_dataTable_draw(dataNew, datas);
        
    });
    
    
        
</script>