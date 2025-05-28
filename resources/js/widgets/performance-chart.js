'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_performance = {
      chart: {
        height: 250,
        type: 'donut'
      },
      series: [27, 23, 20, 17],
      colors: ['#04A9F5', '#F4C22B', '#1DE9B6', '#04A9F5'],
      labels: ['Total income', 'Total rent', 'Download', 'Views'],
      fill: {
        opacity: [1, 1, 1, 0.3]
      },
      legend: {
        show: false
      },
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
            labels: {
              show: true,
              name: {
                show: true
              },
              value: {
                show: true
              }
            }
          }
        }
      },
      dataLabels: {
        enabled: false
      },
      responsive: [
        {
          breakpoint: 575,
          options: {
            chart: {
              height: 250
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '65%',
                  labels: {
                    show: false
                  }
                }
              }
            }
          }
        },
        {
          breakpoint: 1182,
          options: {
            chart: {
              height: 190
            }
          }
        }
      ]
    };
    var chart_performance = new ApexCharts(document.querySelector('#performance-chart'), options_performance);
    chart_performance.render();
  }, 500);
});