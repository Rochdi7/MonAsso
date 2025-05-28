'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_bitcoin_1 = {
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
    var chart_bitcoin_1 = new ApexCharts(document.querySelector('#bitcoin-chart-1'), options_bitcoin_1);
    chart_bitcoin_1.render();

    var options_bitcoin_2 = {
      chart: {
        type: 'line',
        height: 40,
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
    var chart_bitcoin_2 = new ApexCharts(document.querySelector('#bitcoin-chart-2'), options_bitcoin_2);
    chart_bitcoin_2.render();

    var options_bitcoin_3 = {
      chart: {
        type: 'line',
        height: 40,
        stacked: true,
        sparkline: { enabled: true }
      },
      colors: ['#04A9F5'],
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
    var chart_bitcoin_3 = new ApexCharts(document.querySelector('#bitcoin-chart-3'), options_bitcoin_3);
    chart_bitcoin_3.render();
  }, 500);
});