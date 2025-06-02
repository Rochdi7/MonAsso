/**
=========================================================================
=========================================================================
Template Name: Light Able - Bootstrap Admin Template
Author: Phoenixcoded
Support: https://phoenixcoded.authordesk.app
File: script.js
Description:  this file will contains code for handling Buynow link.
=========================================================================
=========================================================================
*/
function getQueryStringParameters() {
  var BuyNowLink = '';
  var isp = '';

  if (sessionStorage.getItem('isp', isp)) {
    var BuyNowLink = sessionStorage.getItem('BuyNowLink');
    var isp = sessionStorage.getItem('isp');
  } else {
    try {
      const queryString = window.location.search;
      const params = new URLSearchParams(queryString);

      if (params.get('isp') == 1) {
        // is single product
        isp = '?isp=1';
        BuyNowLink = 'https://1.envato.market/baeyGk';

        sessionStorage.setItem('isp', isp);
        sessionStorage.setItem('BuyNowLink', BuyNowLink);

      } else {
        BuyNowLink = 'https://1.envato.market/EKD9M4';
      }
    } catch (err) {
      BuyNowLink = 'https://1.envato.market/EKD9M4';
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    var elem = document.querySelectorAll('.buynowlinks');
    for (var j = 0; j < elem.length; j++) {
      elem[j].setAttribute('href', BuyNowLink);
    }
  });
  document.addEventListener('DOMContentLoaded', function () {
    var elem = document.querySelectorAll('.tech-links a, .pages-link a');
    for (var j = 0; j < elem.length; j++) {
      var dattr = elem[j].getAttribute('href');
      elem[j].setAttribute('href', dattr + isp);
    }
  });
}

getQueryStringParameters();
