'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_total_earning = {
      series: [30],
      chart: {
        height: 150,
        type: 'radialBar'
      },
      plotOptions: {
        radialBar: {
          hollow: {
            margin: 0,
            size: '60%',
            background: 'transparent',
            imageOffsetX: 0,
            imageOffsetY: 0,
            position: 'front'
          },
          track: {
            background: '#F4C22B50',
            strokeWidth: '50%'
          },

          dataLabels: {
            show: true,
            name: {
              show: false
            },
            value: {
              formatter: function (val) {
                return parseInt(val);
              },
              offsetY: 7,
              color: '#F4C22B',
              fontSize: '20px',
              fontWeight: '700',
              show: true
            }
          }
        }
      },
      colors: ['#F4C22B'],
      fill: {
        type: 'solid'
      },
      stroke: {
        lineCap: 'round'
      }
    };
    var chart_total_earning = new ApexCharts(document.querySelector('#total-earning-chart-1'), options_total_earning);
    chart_total_earning.render();
  }, 500);
});