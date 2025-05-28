'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_time_spent = {
      chart: {
        type: 'line',
        height: 40,
        stacked: true,
        sparkline: { enabled: true }
      },
      colors: ['#1DE9B6'],
      stroke: { curve: 'smooth', width: 2 },
      series: [{ data: [5, 25, 3, 10, 4, 50, 0] }],
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
    var chart_time_spent = new ApexCharts(document.querySelector('#timesspent-chart'), options_time_spent);
    chart_time_spent.render();
  }, 500);
});