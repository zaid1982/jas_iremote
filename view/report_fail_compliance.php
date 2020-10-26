<div id="ribbon">
    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>
    <ol class="breadcrumb">
        <li>Reporting</li><li>Industrial Reports</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-bar-chart-o fa-fw "></i>
                Reporting
                <span>>
                    Daily Fail Complience Report
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <h5> Total Fail Compliance <span class="txt-color-greenDark" id="gfc_count_approved"><i class="fa fa-warning"></i>&nbsp;&nbsp;132 cases</span></h5>
                </li>
            </ul>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total Fail Compliance by State and Source Activity</h2>
                        <div class="widget-toolbar">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-primary" data-toggle="dropdown">
                                    27 <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:void(0);">1</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">2</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">3</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">4</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">5</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">6</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">7</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">8</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">9</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">10</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">11</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">12</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">13</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">14</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">15</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">16</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">17</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">18</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">19</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">20</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">21</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">22</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">23</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">24</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">25</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">26</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">27</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">28</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">29</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">30</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">31</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-primary" data-toggle="dropdown">
                                    <span id="gfc1_opt_month"><?=date('F')?></span> <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('January');">January</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('February');">February</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('March');">March</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('April');">April</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('May');">May</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('June');">June</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('July');">July</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('August');">August</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('September');">September</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('October');">October</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('November');">November</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gfc1_opt_month').html('December');">December</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-primary" data-toggle="dropdown">
                                    <span id="gfc1_opt_year"><?=date('Y')?></span> <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <?php
                                    for ($i=intval(date('Y'));$i>=2010;$i--) {
                                        echo '<li><a href="javascript:void(0);" onclick="$(\'#gfc1_opt_year\').html(\''.$i.'\');">'.$i.'</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-success" onclick="f_gfc_1($('#gfc1_opt_year').html(), monthname.indexOf($('#gfc1_opt_month').html()));">Go</a>
                        </div>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-11 col-md-offset-1">
                                    <div id="gfc_chart_1" style="margin: 0 auto"></div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Source of Activity</th>
                                            <th class="text-center" style="width: 9.56%">Johor</th>
                                            <th class="text-center" style="width: 9.56%">Kedah</th>
                                            <th class="text-center" style="width: 9.56%">N.Sembilan</th>
                                            <th class="text-center" style="width: 9.56%">Pahang</th>
                                            <th class="text-center" style="width: 9.56%">Perak</th>
                                            <th class="text-center" style="width: 9.56%">Sabah</th>
                                            <th class="text-center" style="width: 9.56%">Sarawak</th>
                                            <th class="text-center" style="width: 9.56%">Selangor</th>
                                            <th class="text-center" style="width: 9.56%">Terengganu</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Fuel Burning Equipment</td>
                                            <td class="text-right">5</td>
                                            <td class="text-right">3</td>
                                            <td class="text-right">2</td>
                                            <td class="text-right">8</td>
                                            <td class="text-right">3</td>
                                            <td class="text-right">9</td>
                                            <td class="text-right">3</td>
                                            <td class="text-right">2</td>
                                            <td class="text-right">5</td>
                                        </tr>
                                        <tr>
                                            <td>Heat and Power Generation</td>
                                            <td class="text-right">2</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">2</td>
                                            <td class="text-right">4</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">3</td>
                                            <td class="text-right">1</td>
                                        </tr>
                                        <tr>
                                            <td>Production and Processing of Ferrous Metals</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">4</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">2</td>
                                        </tr>
                                        <tr>
                                            <td>Production and Processing of Non-Ferrous Metals</td>
                                            <td class="text-right">2</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">2</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">2</td>
                                        </tr>
                                        <tr>
                                            <td>Oil and Gas Industries</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">2</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                        </tr>
                                        <tr>
                                            <td>Non-Metallic Industry</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                        </tr>
                                        <tr>
                                            <td>Waste Incinerator</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Fail Compliance by Source Activity</h2>
                    </header>
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="gfc_chart_2" style="margin: 0 auto"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-condensed" width="100%" style="margin-top: 70px">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Source of Activity</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>Fuel Burning Equipment</td>
                                            <td class="text-right">40</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>Heat and Power Generation</td>
                                            <td class="text-right">15</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td>Production and Processing of Ferrous Metals</td>
                                            <td class="text-right">13</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td>Production and Processing of Non-Ferrous Metals</td>
                                            <td class="text-right">11</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td>Oil and Gas Industries</td>
                                            <td class="text-right">5</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">6</td>
                                            <td>Non-Metallic Industry</td>
                                            <td class="text-right">3</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">7</td>
                                            <td>Waste Incinerator</td>
                                            <td class="text-right">1</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>List of Fail Compliance Premises</h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <h6 class="margin-left-15 text-uppercase">Senarai Premis Tidak Patuh Nilai Batas PPKAS (Udara Bersih) 2014 Melalui Pemantauan CEMS</h6>
                            <h6 class="margin-left-15">Tarikh : 27 Oktober 2020</h6>
                            <div class="table-responsive bordered">
                                <table class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Bil.</th>
                                        <th class="text-center">Negeri</th>
                                        <th class="text-center">Nama Kilang</th>
                                        <th class="text-center">Jenis Industri</th>
                                        <th class="text-center">Fasiliti Parameter yg Tidak Patuh</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Johor</td>
                                        <td>EVERZINC MALAYSIA SDN. BHD.</td>
                                        <td>Fuel Burning Equipment</td>
                                        <td>STACK01: Total PM</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Johor</td>
                                        <td>FELDA PALM INDUSTRIES SDN BHD (KILANG SAWIT AIR TAWAR)</td>
                                        <td>Fuel Burning Equipment</td>
                                        <td>STACK 1: Opacity</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>Johor</td>
                                        <td>EVERGREEN FIBREBOARD BERHAD(KILANG PAPAN)</td>
                                        <td>Heat and Power Generation</td>
                                        <td>BOILER 1: Opacity</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
