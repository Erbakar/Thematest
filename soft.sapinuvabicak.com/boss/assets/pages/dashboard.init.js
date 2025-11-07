/*
 Template Name: 
 Author: 
 File: Dashboard Init
 */


!function ($) {
  "use strict";

  var Dashboard = function () {
  };

      //creates area chart
      Dashboard.prototype.createAreaChart = function (element, pointSize, lineWidth, data, xkey, ykeys, labels, lineColors) {
          Morris.Area({
              element: element,
              pointSize: 0,
              lineWidth: 0,
              data: data,
              xkey: xkey,
              ykeys: ykeys,
              labels: labels,
              resize: true,
              gridLineColor: '#eef0f2',
              hideHover: 'auto',
              lineColors: lineColors,
              fillOpacity: .9,
              behaveLikeLine: true
          });
      },

      //creates Donut chart
      Dashboard.prototype.createDonutChart = function (element, data, colors) {
          Morris.Donut({
              element: element,
              data: data,
              resize: true,
              colors: colors
          });
      },
          //creates line chart Dark
    Dashboard.prototype.createLineChart1 = function(element, data, xkey, ykeys, labels, lineColors) {
      Morris.Line({
          element: element,
          data: data,
          xkey: xkey,
          ykeys: ykeys,
          labels: labels,
          gridLineColor: '#eef0f2',
          hideHover: 'auto',
          pointSize: 3,
          resize: true, //defaulted to true
          lineColors: lineColors
      });
  },


      // Grafik oluşturma fonksiyonu
      Dashboard.prototype.initCharts = function () {
          //creating area chart - sadece element varsa çalıştır
          if ($('#morris-area-example').length > 0) {
              var $areaData = [
                  {y: '2013', a: 0, b: 0, c:0},
                  {y: '2014', a: 150, b: 45, c:15},
                  {y: '2015', a: 60, b: 150, c:220},
                  {y: '2016', a: 180, b: 36, c:21},
                  {y: '2017', a: 90, b: 60, c:360},
                  {y: '2018', a: 75, b: 240, c:120},
                  {y: '2019', a: 30, b: 30, c:30}
              ];
              this.createAreaChart('morris-area-example', 0, 0, $areaData, 'y', ['a', 'b', 'c'], ['Series A', 'Series B', 'Series C'], ['#fcbe2d', '#02c58d', '#30419b']);
          }

          //creating donut chart - sadece element varsa çalıştır
          if ($('#morris-donut-example').length > 0) {
              var $donutData = [
                  {label: "Download Sales", value: 12},
                  {label: "In-Store Sales", value: 30},
                  {label: "Mail-Order Sales", value: 20}
              ];
              this.createDonutChart('morris-donut-example', $donutData, ['#fcbe2d', '#30419b', '#02c58d']);
          }

          //create line chart Dark - sadece element varsa çalıştır
          if ($('#morris-line-example').length > 0) {
              var $data1  = [
                  { y: '2009', a: 20, b: 5 },
                  { y: '2010', a: 45,  b: 35 },
                  { y: '2011', a: 50,  b: 40 },
                  { y: '2012', a: 75,  b: 65 },
                  { y: '2013', a: 50,  b: 40 },
                  { y: '2014', a: 75,  b: 65 },
                  { y: '2015', a: 100, b: 90 }
              ];
              this.createLineChart1('morris-line-example', $data1, 'y', ['a', 'b'], ['Series A', 'Series B'], ['#30419b', '#02c58d']);
          }
      },

      Dashboard.prototype.init = function () {

        this.updateSiparisBildirim = function() {
            $.ajax({
                url: 'assets/siparis-bildirim.php',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Ana menü güncelleme
                        $('#siparis-bildirim').html(response.html); 
                        
                        // Alt menüler güncelleme
                        if (response.alt_menuler) {
                            $('#yeni-siparis-bildirim').html(response.alt_menuler.yeni_siparisler.html);
                            $('#hazirlanan-siparis-bildirim').html(response.alt_menuler.hazirlanan_siparisler.html);
                            $('#kargolanan-siparis-bildirim').html(response.alt_menuler.kargolanan_siparisler.html); 
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Sipariş bildirim güncelleme hatası:');
                    console.log('Status:', status);
                    console.log('Error:', error);
                    console.log('Response:', xhr.responseText);
                    console.log('Status Code:', xhr.status);
                }
            });
        };

        this.updateSiparisBildirim();
        setInterval(this.updateSiparisBildirim, 10000);

        // Yorum bildirim sistemi
        this.updateYorumBildirim = function() {
            $.ajax({
                url: 'assets/yorum-bildirim.php',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Ana menü güncelleme
                        $('#yorum-bildirim').html(response.html); 
                        
                        // Alt menüler güncelleme
                        if (response.alt_menuler) {
                            $('#urun-yorumlari-bildirim').html(response.alt_menuler.urun_yorumlari.html);
                            $('#blog-yorumlari-bildirim').html(response.alt_menuler.blog_yorumlari.html);
                            $('#destek-merkezi-bildirim').html(response.alt_menuler.destek_merkezi.html);
                            $('#gelen-kutusu-bildirim').html(response.alt_menuler.gelen_kutusu.html);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Yorum bildirim güncelleme hatası:');
                    console.log('Status:', status);
                    console.log('Error:', error);
                    console.log('Response:', xhr.responseText);
                    console.log('Status Code:', xhr.status);
                }
            });
        };

        this.updateYorumBildirim();
        setInterval(this.updateYorumBildirim, 15000);



      },
      //init
      $.Dashboard = new Dashboard, $.Dashboard.Constructor = Dashboard
}(window.jQuery),

//initializing 
  function ($) {
      "use strict";
      $.Dashboard.init();
  }(window.jQuery);