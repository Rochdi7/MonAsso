'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_total_sales = {
      chart: {
        type: 'line',
        height: 265,
        toolbar: {
          show: false
        }
      },
      colors: ['#0d6efd', '#748892'],
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2
      },
      plotOptions: {
        bar: {
          columnWidth: '45%',
          borderRadius: 4
        }
      },
      grid: {
        strokeDashArray: 4
      },
      series: [
        {
          name: 'Today',
          data: [0, 0, 90, 50, 55, 0, 0, 0, 0, 60, 0, 0]
        },
        {
          name: 'Yesterday',
          data: [0, 0, 30, 60, 40, 50, 0, 0, 0, 0, 0, 0]
        }
      ],
      xaxis: {
        labels: {
          hideOverlappingLabels: true
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      },
      responsive: [
        {
          breakpoint: 1182,
          options: {
            chart: {
              height: 230
            }
          }
        }
      ]
    };
    var chart_total_sales = new ApexCharts(document.querySelector('#total-sales-chart'), options_total_sales);
    chart_total_sales.render();
  }, 500);
});