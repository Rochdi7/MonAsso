'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_transactions = {
      chart: { type: 'bar', height: 60, sparkline: { enabled: true } },
      colors: ['#04A9F5'],
      plotOptions: { bar: { borderRadius: 2, columnWidth: '80%' } },
      series: [
        {
          data: [10, 30, 40, 20, 60, 50, 20, 15, 20, 25, 30, 25]
        }
      ],
      xaxis: { crosshairs: { width: 1 } },
      tooltip: {
        fixed: { enabled: false },
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
    var chart_transactions = new ApexCharts(document.querySelector('#transactions-chart'), options_transactions);
    chart_transactions.render();
  }, 500);
});