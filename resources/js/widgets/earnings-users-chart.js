'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options = {
      chart: {
        type: 'line',
        height: 200,
        toolbar: {
          show: false
        }
      },
      colors: ['#0d6efd'],
      dataLabels: {
        enabled: false
      },
      markers: {
        size: 7,
        colors: '#0d6efd',
        strokeColors: '#fff',
        strokeWidth: 3,
        hover: {
          size: 4
        }
      },
      stroke: {
        width: 1,
        curve: 'smooth'
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
          data: [30, 60, 40, 70, 50, 90]
        }
      ],
      yaxis: {
        show: false
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        labels: {
          hideOverlappingLabels: true
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      }
    };
    var chart = new ApexCharts(document.querySelector('#earnings-users-chart'), options);
    chart.render();
  }, 500);
});