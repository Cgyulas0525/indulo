@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="pubic/css/app.css">
    <link rel="stylesheet" href="public/css/Highcharts.css">
    @include('layouts.costumcss')
@endsection

@section('content')
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary" >
            <div class="box-body">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <section class="content-header">
                        <h4>Árbevétel</h4>
                    </section>
                    @include('flash::message')
                    <div class="clearfix"></div>
                    <div class="box box-primary">
                        <div class="box-body"  >
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header p-2">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item"><a class="nav-link active" href="#napi" data-toggle="tab">Napi</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#heti" data-toggle="tab">Heti</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#havi" data-toggle="tab">Havi</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#fizetesi" data-toggle="tab">Fizetési mód</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#twoyear" data-toggle="tab">Elmúlt 2 év</a></li>
                                                <li class="nav-item"><a class="nav-link" href="#bevki" data-toggle="tab">Bevétel/Kiadás</a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                @include('riports.TurnoverItem', ['title' => 'Árbevétel alakulás az elmúlt 30 napban',
                                                                                  'id' => 'napi',
                                                                                  'tabPane' => 'active tab-pane',
                                                                                  'chartId' => 'haviNapiArbevetel'])
                                                @include('riports.TurnoverItem', ['title' => 'Árbevétel alakulás heti bontásban',
                                                                                  'id' => 'heti',
                                                                                  'tabPane' => 'tab-pane',
                                                                                  'chartId' => 'hetiArbevetel'])
                                                @include('riports.TurnoverItem', ['title' => 'Árbevétel alakulás havi bontásban',
                                                                                  'id' => 'havi',
                                                                                  'tabPane' => 'tab-pane',
                                                                                  'chartId' => 'haviArbevetel'])
                                                @include('riports.TurnoverItem', ['title' => 'Fizetési mód az elmúlt 30 napban',
                                                                                  'id' => 'fizetesi',
                                                                                  'tabPane' => 'tab-pane',
                                                                                  'chartId' => 'fizetesimod'])
                                                @include('riports.TurnoverItem', ['title' => 'Bevétel alakulás az elmúlt 2 évben',
                                                                                  'id' => 'twoyear',
                                                                                  'tabPane' => 'tab-pane',
                                                                                  'chartId' => 'twoyears'])
                                                @include('riports.TurnoverItem', ['title' => 'Bevétel/Kiadás az elmúlt évben',
                                                                                  'id' => 'bevki',
                                                                                  'tabPane' => 'tab-pane',
                                                                                  'chartId' => 'bevkiad'])

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('/public/js/highchart/highchartLine.js') }} " type="text/javascript"></script>
    <script src="{{ asset('/public/js/highchart/categoryUpload.js') }} " type="text/javascript"></script>
    <script src="{{ asset('/public/js/highchart/chartDataUpload.js') }} " type="text/javascript"></script>

    <script type="text/javascript">
        $(function () {

            var chart_napi = highchartLine( 'haviNapiArbevetel', 'line', 450, categoryUpload(<?php echo RiportsClass::TurnoverLast30Days(); ?>, 'nap'),
                chartDataUpload(<?php echo RiportsClass::TurnoverLast30Days(); ?>, ['osszeg'], ['Bevétel']), 'Aktuális havi árbevétel', 'napi bontás', 'forint');
            var chart_heti = highchartLine( 'hetiArbevetel', 'line', 450, categoryUpload(<?php echo RiportsClass::TurnoverLast26Weeks(); ?>, 'nap'),
                chartDataUpload(<?php echo RiportsClass::TurnoverLast26Weeks(); ?>, ['osszeg'], ['Bevétel']), 'Havi árbevétel', 'havi bontás', 'forint');
            var chart_havi = highchartLine( 'haviArbevetel', 'line', 450, categoryUpload(<?php echo RiportsClass::TurnoverLast12Month(); ?>, 'nap'),
                chartDataUpload(<?php echo RiportsClass::TurnoverLast12Month(); ?>, ['osszeg'], ['Bevétel']), 'Heti árbevétel', 'heti bontás', 'forint');
            var chart_fizm = highchartLine( 'fizetesimod', 'line', 450, categoryUpload(<?php echo RiportsClass::PaymentMethodLast30days(); ?>, 'nap'),
                chartDataUpload(<?php echo RiportsClass::PaymentMethodLast30days(); ?>, ['cash', 'card', 'szcard'], ['Készpénz', 'Kártya', 'SZÉP kártya']), 'Fizetési mód', 'napi bontás', 'forint');
            var chart_twoy = highchartLine( 'twoyears', 'line', 450, categoryUpload(<?php echo RiportsClass::TurnoverLastTwoYears(); ?>, 'nap'),
                chartDataUpload(<?php echo RiportsClass::TurnoverLastTwoYears(); ?>, ['elso', 'masodik'], ['-1 év', '-2 év']), 'Fizetési mód', 'napi bontás', 'forint');
            var chart_bevk = highchartLine( 'bevkiad', 'line', 450, categoryUpload(<?php echo RiportsClass::monthInviocesResult(); ?>, 'nap'),
                chartDataUpload(<?php echo RiportsClass::monthInviocesResult(); ?>, ['elso', 'masodik'], ['Kiadás', 'Bevétel']), 'Fizetési mód', 'napi bontás', 'forint');

        });
    </script>
@endsection

