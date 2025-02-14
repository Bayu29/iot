@extends('layouts.master')

@section('title', 'Dashboard')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/dashboard.css') }}">
    <style>
        .map-embed {
            width: 100%;
            height: 510px;
        }

        a.resultnya {
            color: #1e7ad3;
            text-decoration: none;
        }

        a.resultnya:hover {
            text-decoration: underline
        }

        .search-box {
            position: relative;
            margin: 0 auto;
            width: 300px;
        }

        .search-box input#search-loc {
            height: 26px;
            width: 100%;
            padding: 0 12px 0 25px;
            background: white url("https://cssdeck.com/uploads/media/items/5/5JuDgOa.png") 8px 6px no-repeat;
            border-width: 1px;
            border-style: solid;
            border-color: #a8acbc #babdcc #c0c3d2;
            border-radius: 13px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -moz-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -ms-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -o-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
        }

        .search-box input#search-loc:focus {
            outline: none;
            border-color: #66b1ee;
            -webkit-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -moz-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -ms-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -o-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
        }

        .search-box .results {
            display: none;
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            z-index: 9999;
            padding: 0;
            margin: 0;
            border-width: 1px;
            border-style: solid;
            border-color: #cbcfe2 #c8cee7 #c4c7d7;
            border-radius: 3px;
            background-color: #fdfdfd;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fdfdfd), color-stop(100%, #eceef4));
            background-image: -webkit-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -moz-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -ms-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -o-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: linear-gradient(top, #fdfdfd, #eceef4);
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -ms-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -o-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            overflow: hidden auto;
            max-height: 34vh;
        }

        .search-box .results li {
            display: block
        }

        .search-box .results li:first-child {
            margin-top: -1px
        }

        .search-box .results li:first-child:before,
        .search-box .results li:first-child:after {
            display: block;
            content: '';
            width: 0;
            height: 0;
            position: absolute;
            left: 50%;
            margin-left: -5px;
            border: 5px outset transparent;
        }

        .search-box .results li:first-child:before {
            border-bottom: 5px solid #c4c7d7;
            top: -11px;
        }

        .search-box .results li:first-child:after {
            border-bottom: 5px solid #fdfdfd;
            top: -10px;
        }

        .search-box .results li:first-child:hover:before,
        .search-box .results li:first-child:hover:after {
            display: none
        }

        .search-box .results li:last-child {
            margin-bottom: -1px
        }

        .search-box .results a {
            display: block;
            position: relative;
            margin: 0 -1px;
            padding: 6px 40px 6px 10px;
            color: #808394;
            font-weight: 500;
            text-shadow: 0 1px #fff;
            border: 1px solid transparent;
            border-radius: 3px;
        }

        .search-box .results a span {
            font-weight: 200
        }

        .search-box .results a:before {
            content: '';
            width: 18px;
            height: 18px;
            position: absolute;
            top: 50%;
            right: 10px;
            margin-top: -9px;
            background: url("https://cssdeck.com/uploads/media/items/7/7BNkBjd.png") 0 0 no-repeat;
        }

        .search-box .results a:hover {
            text-decoration: none;
            color: #fff;
            text-shadow: 0 -1px rgba(0, 0, 0, 0.3);
            border-color: #2380dd #2179d5 #1a60aa;
            background-color: #338cdf;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #59aaf4), color-stop(100%, #338cdf));
            background-image: -webkit-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -moz-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -ms-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -o-linear-gradient(top, #59aaf4, #338cdf);
            background-image: linear-gradient(top, #59aaf4, #338cdf);
            -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -moz-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -ms-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -o-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
        }

        .lt-ie9 .search input#search-loc {
            line-height: 26px
        }
    </style>
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
           <div class="row">
                <div class="col">

                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">Welcome, {{ Auth::user()->name }}</h4>
                                    </div>
                                    <div class="mt-3 mt-lg-0">
                                    </div>
                                </div><!-- end card header -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total
                                                    Instance</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="{{ $total_instance }}"></span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded fs-3">
                                                    <i class="bx bx-dollar-circle"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total
                                                    SubInstance</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="{{ $total_subinstance }}"></span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info rounded fs-3">
                                                    <i class="bx bx-shopping-bag"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total
                                                    Cluster</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="{{ $total_cluster }}"></span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-danger rounded fs-3">
                                                    <i class="bx bx-wallet"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total
                                                    Gateway</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="{{ $total_gateway }}"></span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-warning rounded fs-3">
                                                    <i class="bx bx-user-circle"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div> <!-- end row-->
                    </div>
                </div>
           </div>

            <div class="row">
                <div class="col-xl-8 col-50 box-col-8 des-xl-50">
                    <div class="card radius-10 border-start border-0 border-3" style="height: 450px">
                        <div class="card-body">
                            <h5>Tickets List</h5>
                            <hr>
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-xs table-bordered table-sm" id="">
                                    <thead>
                                        <tr>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Created at</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticket as $row)
                                            <tr>
                                                <td><a href="{{ url('/tickets?parsed_data=' . $row->id) }}">
                                                        <b>{{ $row->subject }}</b>
                                                    </a>
                                                </td>
                                                <td> <a href="{{ url('/tickets?parsed_data=' . $row->id) }}">
                                                        <b>{{ $row->created_at }}</b>
                                                    </a></td>
                                                @if ($row->status == 'Opened')
                                                    <td><a href="{{ url('/tickets?parsed_data=' . $row->id) }}"
                                                            class="btn btn-pill btn-success btn-air-success btn-xs"
                                                            type="button" title="">
                                                            Open</a>
                                                @else
                                                    <td><a href="{{ url('/tickets?parsed_data=' . $row->id) }}"
                                                            class="btn btn-pill btn-danger btn-air-danger btn-xs"
                                                            type="button" title="">
                                                            Close</a>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-50 box-col-4 des-xl-50">
                    <div class="card radius-10 border-start border-0 border-3" style="height: 450px">
                        <div class="card-body">
                            <script src="https://code.highcharts.com/highcharts.js"></script>
                            <script src="https://code.highcharts.com/modules/exporting.js"></script>
                            <script src="https://code.highcharts.com/modules/export-data.js"></script>
                            <script src="https://code.highcharts.com/modules/accessibility.js"></script>
                            <figure class="highcharts-figure">
                                <div id="container" style="width: 320px"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8" style="padding-right: 10px; padding-left:10px">
                    <div class="card radius-10 border-start border-0 border-3" style="height: 450px">
                        <div class="card-body">
                            <div class="map-embed" id="map" style="height: 100%; z-index: 0;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" style="padding-right: 10px">
                    <div class="card radius-10 border-start border-0 border-3" style="height: 450px">
                        <div class="card-body">
                            <h5>List Brances</h5>
                            <hr>
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-xs table-bordered" id="dataTables-example" style="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">App Id</th>
                                            <th scope="col">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($instances as $row)
                                            <tr>
                                                <td>{{ $row->appID }}</td>
                                                <td> {{ $row->instance_name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-50 box-col-4 des-xl-50">
                    <div class="card radius-10 border-start border-0 border-3" style="height: 450px">
                        <div class="card-body">
                            <h5>Device By Brances</h5>
                            <hr>
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-xs table-bordered" id="" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Branches</th>
                                            <th scope="col">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($TotalByBrances as $row)
                                            <tr>
                                                <td>{{ $row->instance_name }}</td>
                                                <td> <span class="badge bg-success pull-right">{{ $row->total }}
                                                        Device</span></td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-50 box-col-4 des-xl-50">
                    <div class="card radius-10 border-start border-0 border-3" style="height: 450px">
                        <div class="card-body">
                            <h5>Device By Cluster</h5>
                            <hr>
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-xs table-bordered" id="" style="width: 100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Cluster</th>
                                            <th scope="col">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($TotalByCluster as $row)
                                            <tr>
                                                <td>{{ $row->name }}</td>
                                                <td> <span class="badge bg-success pull-right">{{ $row->total }}
                                                        Device</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-50 box-col-4 des-xl-50">
                    <div class="card radius-10 border-start border-0 border-3" style="height: 450px">
                        <div class="card-body">
                            <h5>Device By Location</h5>
                            <hr>
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-xs table-bordered" id="" style="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Location</th>
                                            <th scope="col">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($TotalByLocation as $row)
                                            <tr>
                                                <td>{{ $row->kabupaten_kota }}</td>
                                                <td> <span class="badge bg-success pull-right">{{ $row->total }}
                                                        Device</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.knob/1.2.2/jquery.knob.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.knob/1.2.2/jquery.knob.js"></script>
<script>
    $(function() {
        $("#infinite").knob({
            'readOnly': true,
            'thickness': 0.2,
            'tickColorizeValues': true,
            'width': 100,
            'height': 100,
            'change': function(v) {
                console.log(v);
            },
            draw: function() {
                $(this.i).val(this.cv + '%');
            }
        });
    });
</script>
<script>
    $(function() {
        $("#infinite2").knob({
            'readOnly': true,
            'thickness': 0.2,
            'tickColorizeValues': true,
            'width': 100,
            'height': 100,
            'change': function(v) {
                console.log(v);
            },
            draw: function() {
                $(this.i).val(this.cv + '%');
            }
        });
    });
</script>
<script>
    $(function() {
        $("#infinite3").knob({
            'readOnly': true,
            'thickness': 0.2,
            'tickColorizeValues': true,
            'width': 100,
            'height': 100,
            'change': function(v) {
                console.log(v);
            },
            draw: function() {
                $(this.i).val(this.cv + '%');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var i = 1;

        function checkKosongLatLong() {
            if ($('#latitude').val() == '' || $('#longitude').val() == '') {
                $('.alert-choose-loc').show();
            } else {
                $('.alert-choose-loc').hide();
            }
        }
        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })()
        // initialize map
        const getLocationMap = L.map('map');
        // initialize OSM
        const osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        const osmAttrib = 'Leaflet © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
        const osm = new L.TileLayer(osmUrl, {
            // minZoom: 0,
            // maxZoom: 3,
            attribution: osmAttrib
        });
        // render map
        getLocationMap.scrollWheelZoom.disable()
        @foreach ($instances as $ins)
            getLocationMap.setView(new L.LatLng("{{ $ins->latitude }}", "{{ $ins->longitude }}"), 7);
        @endforeach
        getLocationMap.addLayer(osm)
        // initial hidden marker, and update on click
        let location = '';

        @foreach ($instances as $instance)
            getToLoc("{{ $instance->latitude }}", "{{ $instance->longitude }}", getLocationMap,
                "{{ $instance->id }}", "{{ $instance->instance_name }}");
        @endforeach

        function getToLoc(lat, lng, getLocationMap, id, instance_name) {
            const zoom = 17;
            var url_edit = "{{ url('/instances/') }}/" + id + "/edit";
            $.ajax({
                url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`,
                dataType: 'json',
                success: function(result) {
                    let marker = L.marker([lat, lng]).addTo(getLocationMap);
                    let list_of_location_html = '';
                    list_of_location_html += '<div>';
                    list_of_location_html += `<b>${instance_name}</b><br>`;
                    list_of_location_html += `<b>${result.display_name}</b><br>`;
                    list_of_location_html += `<span>latitude : ${result.lat}</span><br>`;
                    list_of_location_html += `<span>longitude: ${result.lon}</span><br>`;
                    list_of_location_html +=
                        `<a href="${url_edit}" target="_blank" class="btn btn-primary" style="color: white; margin-top: 1rem;">Edit</a>`;
                    list_of_location_html += '</div>';
                    marker.bindPopup(list_of_location_html);
                }
            });
        }
    });
</script>

<script>
    // Data retrieved from https://netmarketshare.com/
    // Build the chart
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Tickets Status',
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Open',
                y: {{ $ticketOpen }},
                color: '#24695c'
            }, {
                name: 'Close',
                y: {{ $ticketClose }},
                color: '#d22d3d'
            }]
        }]
    });
</script>
@endpush
