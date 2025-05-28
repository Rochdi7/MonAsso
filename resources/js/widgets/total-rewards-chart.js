'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options_rewards = {
      chart: {
        type: 'line',
        height: 100,
        stacked: true,
        sparkline: { enabled: true }
      },
      colors: ['#F4C22B'],
      stroke: { curve: 'smooth', width: 2 },
      series: [{ data: [30, 60, 40, 70, 50, 90, 50, 55, 45, 60, 50, 65, 30, 60, 40, 70, 50] }]
    };
    var chart_rewards = new ApexCharts(document.querySelector('#total-rewards-chart'), options_rewards);
    chart_rewards.render();
  }, 500);
});