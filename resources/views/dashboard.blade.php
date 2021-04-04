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
                    {!! $sales_6 !!}
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
                    {!! $sales_3 !!}
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
          name: 'Sehirler',
          colorByPoint: true,
          data: {!! $cities !!}
      }]
  });
  Highcharts.chart('container', {
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
          title: {
              text: 'Satılan Ürünler'
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
              name: 'İlaçlar',
              colorByPoint: true,
              data: {!! $medicines !!}
          }]
      });
});
</script>
@endsection
