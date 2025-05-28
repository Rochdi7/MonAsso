'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_yearly_summary = {
      chart: {
        height: 250,
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '75%',
          borderRadius: 2,
          borderRadiusApplication: 'end'
        }
      },
      legend: {
        show: true,
        position: 'bottom'
      },
      dataLabels: {
        enabled: false
      },
      colors: ['#1DE9B6', '#0398F2'],
      stroke: {
        show: true,
        width: 1,
        colors: ['transparent']
      },
      fill: {
        type: 'gradient',
        gradient: {
          type: 'vertical',
          stops: [0, 100],
          shadeIntensity: 0.5,
          gradientToColors: ['#1DC4E9', '#38B9E7']
        }
      },
      grid: {
        strokeDashArray: 4
      },
      series: [
        {
          name: 'Net Profit',
          data: [76, 85, 101, 98, 87]
        },
        {
          name: 'Revenue',
          data: [44, 55, 57, 56, 61]
        }
      ],
      xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return '$ ' + val;
          }
        }
      }
    };
    var chart_yearly_summary = new ApexCharts(document.querySelector('#yearly-summary-chart'), options_yearly_summary);
    chart_yearly_summary.render();
  }, 500);
});