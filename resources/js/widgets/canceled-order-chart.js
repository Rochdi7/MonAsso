'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_canceled_order = {
      chart: {
        type: 'line',
        height: 60,
        stacked: true,
        sparkline: { enabled: true }
      },
      colors: ['#F44236'],
      stroke: { curve: 'smooth', width: 2 },
      series: [{ data: [0, 50, 4, 10, 3, 25, 5] }],
      tooltip: {
        x: { show: false },
        y: {
          title: {
            formatter: function (seriesName) {
              return '';
            }
          }
        },
        marker: { show: false }
      }
    };
    var chart_canceled_order = new ApexCharts(document.querySelector('#canceled-order-chart'), options_canceled_order);
    chart_canceled_order.render();
  }, 500);
});