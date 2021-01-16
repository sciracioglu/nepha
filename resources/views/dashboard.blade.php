@extends('layouts.app')
@section('title')
<i class="fal fa-analytics"></i> Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    {!! $user_count !!}
                    <small class="m-0 l-h-n">son 6 aylık satış sayısı</small>
                </h3>
            </div>
            <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    {!! $medicine_count !!}
                    <small class="m-0 l-h-n">son 3 aylık satış sayısı</small>
                </h3>
            </div>
            <i class="fal fa-flask position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    {!! $sales_count !!}
                    <small class="m-0 l-h-n">satışı girilen ürün</small>
                </h3>
            </div>
            <i class="fal fa-handshake position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    % {!! $cancel_percent !!}
                    <small class="m-0 l-h-n">sipariş iptal oranı</small>
                </h3>
            </div>
            <i class="fal fa-chart-line-down position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
</div>
  <div class="row">
      <div class="col-lg-6">
        <div id="container" style='width:100%'></div>
      </div>
      <div class="col-lg-6">
        <div id="container1" style='width:100%'></div>
      </div>
  </div>
@endsection
@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Highcharts.chart('container', {
      title: {
          text: 'Aylara Göre Satış Miktarları'
      },
      xAxis: {
          categories: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs']
      },
      labels: {
          items: [{

              style: {
                  left: '50px',
                  top: '18px',
                  color: ( // theme
                      Highcharts.defaultOptions.title.style &&
                      Highcharts.defaultOptions.title.style.color
                  ) || 'pink'
              }
          }]
      },
      series: [{
          type: 'column',
          name: 'Ocak',
          data: [3, 2, 1, 3, 4]
      }, {
          type: 'column',
          name: 'Şubat',
          data: [2, 3, 5, 7, 6]
      }, {
          type: 'column',
          name: 'Mart',
          data: [4, 3, 3, 9, 0],
          color: Highcharts.getOptions().colors[7]
      }, {
          type: 'spline',
          name: 'Nisan',
          data: [3, 2.67, 3, 6.33, 3.33],
          marker: {
              lineWidth: 2,
              lineColor: Highcharts.getOptions().colors[4],
              fillColor: 'white'
          }
      }, {
          type: 'pie',
          name: 'Total consumption',
          data: [{
              name: 'OCTREOSCAN',
              y: 13,
              color: Highcharts.getOptions().colors[0] // Jane's color
          }, {
              name: 'TECHNESCAN® DMSA',
              y: 23,
              color: Highcharts.getOptions().colors[1] // John's color
          }, {
              name: 'TECHNESCAN® LYOMAA',
              y: 19,
              color: Highcharts.getOptions().colors[4] // Joe's color
          }],
          center: [100, 80],
          size: 100,
          showInLegend: false,
          dataLabels: {
              enabled: false
          }
      }]
  });
  Highcharts.chart('container1', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Satış yapılan iller'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
          point: {
              valueSuffix: '%'
          }
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
              name: 'Ankara',
              y: 61.41,
              sliced: true,
              selected: true,
              color:'#886ab5'
          }, {
              name: 'İstanbul',
              y: 11.84
          }, {
              name: 'Bursa',
              y: 10.85
          }, {
              name: 'İzmir',
              y: 4.67
          }, {
              name: 'Adana',
              y: 4.18
          }, {
              name: 'Diğer',
              y: 7.05
          }]
      }]
  });
});
</script>
@endsection