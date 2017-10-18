/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
        window.twttr = (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0],
            t = window.twttr || {};
          if (d.getElementById(id)) {return t;}
          js = d.createElement(s);
          js.id = id;
          js.src = "https://platform.twitter.com/widgets.js";
          js.async = true;
          fjs.parentNode.insertBefore(js, fjs);

          t._e = [];
          t.ready = function(f) {
            t._e.push(f);
          };

          return t;
        }(document, "script", "twitter-wjs"));

        window.fbAsyncInit = function() {
          FB.init({
            appId            : '199633970568255',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v2.9'
          });
          FB.AppEvents.logPageView();
        };

        (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "//connect.facebook.net/en_US/sdk.js";
           js.async = true;
           fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));

        $('.share-fb').click(function() {
          event.preventDefault();
          FB.ui({
           method: 'share',
           display: 'popup',
           href: $(this).attr('href'),
           }, function(response){
             console.dir(response);
           });
        });

        $('.share-tb').click(function() {
          event.preventDefault();
          makepopup($(this));
        });

        var $stickyElement = $('.travel__navigation');
        var sticky;

        if ($stickyElement.length) {
          sticky = new Waypoint.Sticky({
            element: $stickyElement[0],
            wrapper: '<div class="sticky-wrapper waypoint" />'
          });
          $('button.destroy-sticky').on('click', function() {
            sticky.destroy();
          });
        }

        var $mapStickyElement = $('.travel__detail__map__map-wrapper');
        var mapSticky;

        if ($mapStickyElement.length) {
          mapSticky = new Waypoint.Sticky({
            stuckClass: 'map-stuck',
            element: $mapStickyElement[0],
            wrapper: '<div class="sticky-wrapper waypoint" />',
            offset: 48
          });
          $('button.destroy-sticky').on('click', function() {
            sticky.destroy();
          });
        }

        $('.link_search-form_opener > a').click(function(e) {
          e.preventDefault();
          $('.search-form').slideToggle('slow');
          e.stopPropagation();
        });

        //automatic slick gallery creation
        $('[id^=gallery-]').slick({
          dots: true,
          infinite: true,
          slidesToShow: 4,
          slidesToScroll: 4,
          rows: 0,
          responsive: [
            {
              breakpoint: 480,
              settings: {
                arrows: false,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 768,
              settings: {
                arrows: false,
                dots: true,
                slidesToShow: 3,
                slidesToScroll: 3,
              }
            }
          ]
        });


        $('.travel__navigation__button--browse').click( function() {
          $('.travel__slideout-menu').toggleClass('open');
          $('#panel').toggleClass('avoid-clicks');
        } );

        $('.travel__slideout-menu-close').click( function() {
          $('.travel__slideout-menu').toggleClass('open');
          $('#panel').toggleClass('avoid-clicks');
        } );

        $('.navbar-toggler').click(function() {
          $('.navbar__slideout-menu').toggleClass('open');
          $('#panel').toggleClass('avoid-clicks');
        });

        $(window).on('load', function() {
          if($(window).width() <= 768) {
            $('#travel-navigate').addClass('collapse');
          }
        });

        $(window).resize(function() {
          if($(window).width() <= 768) {
            $('#travel-navigate').collapse('hide');
          } else {
            $('#travel-navigate').collapse('show');
          }
        });

        var infinite;
        if( $('.editorial__block').length ) {
          infinite = new Waypoint.Infinite({
            element: $('.editorial__block')[0],
            more: '.infinite-more-link',
            items: '.col-xs-12.col-sm-4'
          });
        }
      },
      finalize: function() {
        $('.search-form__button-close').click(function(e){
          e.preventDefault();
          $('.search-form').slideToggle('slow');
        });

        $( '.city-filter-select' ).change(function(event) {
          var _origin = window.location.origin;
          var _url = _origin + window.location.pathname;
          var _params = getUrlVars();
          var _val = $( '.city-filter-select option:checked' ).val();
          // remove cat artist on new city filter change
          if(_params.hasOwnProperty('cat_artist')) {
            Reflect.deleteProperty( _params, 'cat_artist');
          }
          if(_val === 'All Cities...') {
            delete _params.cat_city;
          } else {
            _params.cat_city = _val;
          }

          var new_params = $.param(_params);
          var new_url = _url+'?'+new_params;
          window.location.replace(new_url);
        });

        $('.first-panel').waypoint({
          handler: function(direction) {
            if( direction === 'down' ) {
              $('.second-panel').toggleClass('slide-in');
            } else {
              $('.second-panel').toggleClass('slide-in');
            }
          },
          offset: 'right-in-view',
        });
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page

      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
        $('.feature-block__mobile').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          mobileFirst: true,
          arrows: false,
          dots: true,
          rows: 0,
          slide: '.feature-block_element',
          responsive: [
            {
              breakpoint: 769,
              settings: 'unslick'
            }
          ]
        });
        $('.home__city-guides-block__carousel-block__list').slick({
          infinite: true,
          slidesToShow: 5,
          slidesToScroll: 5,
          rows: 0,
          responsive: [
            {
              breakpoint: 480,
              settings: {
                arrows: false,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                // centerMode: true,
              }
            },
            {
              breakpoint: 768,
              settings: {
                arrows: false,
                dots: true,
                slidesToShow: 3,
                // centerMode: true,
              }
            },
            {
              breakpoint: 1024,
              settings: {
                arrows: true,
                dots: false,
                slidesToShow: 4,
                centerMode: true,
              }
            },
          ]
        });

        var related_content__settings = {
          arrows: false,
          dots: true,
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          rows: 0,
          responsive: [
            {
              breakpoint: 480,
              settings:  {
                  arrows: false,
                  dots: true,
                  slidesToShow: 1,
                  slidesToScroll: 1,
                }
            },
            {
              breakpoint: 768,
              settings: {
                infinite: true,
                arrows: false,
                dots: true,
                slidesToShow: 2,
                slidesToScroll: 2,
              }
            },
            {
              breakpoint: 1024,
              settings: "noslick"
            }
          ]
        };

        if ($(window).width() < 1024) {
          $('.related-content__carousel').slick(related_content__settings);
        }

        $(window).resize(function() {
          if($(window).width() >= 1024) {
            $('.related-content__carousel').unslick();
          } else if ($(window).width() < 1024) {
            $('.related-content__carousel').slick(related_content__settings);
          }
        });

      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    },
    'artist_template_default': {
      init: function() {
        $('.dropdown-menu').click(function(e) {
                e.stopPropagation(); //This will prevent the event from bubbling up and close the dropdown when you type/click on text boxes.
        });

        var map, mapoverlay, parsed_map_vars, markers;
        var pulseElement = document.createElement('div');
        pulseElement.classList.add('element');
        var thatMarker;

        showIconDetails = function(markerElement, thisMarker) {
          thatMarker = thisMarker;
          // thisMarker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
          $(markerElement).find('.cc-map-marker').addClass('img-icon-anim');
          $(markerElement).find('.cc-map-marker').append(pulseElement);
        };

        removeIconDetails = function(markerElement, thisMarker) {
          // thisMarker.setZIndex(thatMarker.getZIndex());
          $(markerElement).find('.cc-map-marker').removeClass('img-icon-anim');
          $(markerElement).find('.cc-map-marker').children('.element').remove();
        };

        loadMarker = function(_id) {
          var id = _id ||  _.keys(markers)[0];
          var marker = markers[id];
          var elements = document.getElementsByClassName('cc-map-marker '+id);

          var markerElement = elements[0];
          showIconDetails(markerElement, marker);
        };

        parsed_map_vars = JSON.parse(map_vars);

        var ccIcon = L.divIcon({
            html: '<div class="cc-map-marker"><img class="img-fluid" src="/app/themes/culturecollide-theme/dist/images/map_icon.png" srcset="/app/themes/culturecollide-theme/dist/images/map_icon.png 1x, /app/themes/culturecollide-theme/dist/images/map_icon@2x.png 2x" /></div>',
            iconSize: [34, 50],
            iconAnchor: [18, 49],
            popupAnchor: [0, -26]
        });
        $('#cc-map').ready(function() {
          map = L.map('cc-map',{scrollWheelZoom:false}).setView([parsed_map_vars.city.location.lat, parsed_map_vars.city.location.lng], 15);


          var mbURL = 'https://api.mapbox.com/styles/v1/pandabrand/cj5wzm2s57tap2rocbuf8j6no/tiles/512/{z}/{x}/{y}?access_token=',
          // var mbURL = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=',
          mbAttr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>';
          L.tileLayer(mbURL + parsed_map_vars.map_info.api_key, {attribution: mbAttr}).addTo(map);
          // L.tileLayer(mbURL + parsed_map_vars.map_info.api_key, {id: 'mapbox.light', attribution: mbAttr}).addTo(map);
          markers = L.featureGroup();
          for(var x = 0; x < parsed_map_vars.locations.length; x++) {
            var feature = parsed_map_vars.locations[x];
            var marker_place = L.marker([feature.coords.lat, feature.coords.lng],{icon:ccIcon, riseOnHover:true, riseOffset: 3000});
            marker_place.bindPopup('<div class=" cc-marker__popup strong">'+feature.title+'</div>');
            markers.addLayer(marker_place);
            feature.marker_id = markers.getLayerId(marker_place);
            $('#'+feature.location_id).attr('data-cc-marker', feature.marker_id);
            $('#'+feature.location_id).addClass(feature.marker_id);
            marker_place.on('click', scrollToDetail);
          }
          markers.addTo(map);
          map.fitBounds( markers.getBounds() );
        });

      scrollToDetail = function() {
        Waypoint.disableAll();
        var _id = this._leaflet_id;
        var scrollItem = $('[data-cc-marker="'+_id+'"]');
        var container = $('.travel__detail__map__list');
        $('*').removeClass('img-icon-anim');
        loadMarker(_id);
        container.animate({
          scrollTop: scrollItem.offset().top - container.offset().top + container.scrollTop()
        }, 2000, function() {
          Waypoint.enableAll();
        });
      };
      $.each(['.travel__detail__map__item'], function(i, classname) {
        var $elements = $(classname);
        var $v_context, $v_offset;
        if($(window).width() < 769) {
          $v_context = $(window)[0];
          $v_offset = 280;
        } else {
          $v_context = $('.travel__detail__map__list')[0];
          $v_offset = 20;
        }
        $elements.each(function() {
          new Waypoint({
            element: this,
            handler: function(direction) {
              var previousWaypoint = this.previous();
              var nextWaypoint = this.next();
              $elements.removeClass('np-previous np-current np-next');

              if (previousWaypoint && direction === 'down') {
                var _prevId = $(previousWaypoint.element).attr('data-cc-marker');
                var _prevMarker = markers.getLayer(_prevId);
               //  var _prevMarker = markers[Number.parseInt(_prevId)];
               //  removeIconDetails(_prevMarkerEl, _prevMarker)
                $(previousWaypoint.element).addClass('np-previous');
              }

              $(this.element).addClass('np-current');
              var _id = $(this.element).attr('data-cc-marker');
              var _marker = markers.getLayer(_id);
              var _markerEl = $(_marker._icon);
              showIconDetails(_markerEl, _marker);
              map.flyTo(_marker.getLatLng(), 15);


              if (nextWaypoint && direction === 'up') {
                $(nextWaypoint.element).addClass('np-next');
                var _nextId = $(nextWaypoint.element).attr('data-cc-marker');
               //  var _nextMarkerEl = $('.cc-map-marker.'+_nextId);
               //  var _nextMarker = markers[Number.parseInt(_nextId)];
               //  removeIconDetails(_nextMarkerEl, _nextMarker)
              }

            },
            offset: $v_offset,
            group: classname,
            context: $v_context,
          });
        });
      });
     }
   },
   'city_template_default': {
     init: function() {
       $('.dropdown-menu').click(function(e) {
               e.stopPropagation(); //This will prevent the event from bubbling up and close the dropdown when you type/click on text boxes.
       });
       var map, mapoverlay, parsed_map_vars, markers;
       var pulseElement = document.createElement('div');
       pulseElement.classList.add('element');
       var thatMarker;

       showIconDetails = function(markerElement, thisMarker) {
         thatMarker = thisMarker;
         // thisMarker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
         $(markerElement).find('.cc-map-marker').addClass('img-icon-anim');
         $(markerElement).find('.cc-map-marker').append(pulseElement);
       };

       removeIconDetails = function(markerElement, thisMarker) {
         // thisMarker.setZIndex(thatMarker.getZIndex());
         $(markerElement).find('.cc-map-marker').removeClass('img-icon-anim');
         $(markerElement).find('.cc-map-marker').children('.element').remove();
       };

       loadMarker = function(_id) {
         var id = _id ||  _.keys(markers)[0];
         var marker = markers[id];
         var elements = document.getElementsByClassName('cc-map-marker '+id);
         var markerElement = elements[0];
         showIconDetails(markerElement, marker);
       };

       parsed_map_vars = JSON.parse(map_vars);

       var ccIcon = L.divIcon({
           html: '<div class="cc-map-marker"><img class="img-fluid" src="/app/themes/culturecollide-theme/dist/images/map_icon.png" srcset="/app/themes/culturecollide-theme/dist/images/map_icon.png 1x, /app/themes/culturecollide-theme/dist/images/map_icon@2x.png 2x" /></div>',
           iconSize: [34, 50],
           iconAnchor: [18, 49],
           popupAnchor: [0, -26]
       });
       $('#cc-map').ready(function() {
         map = L.map('cc-map',{scrollWheelZoom:false}).setView([parsed_map_vars.city.location.lat, parsed_map_vars.city.location.lng], 12);

         var mbURL = 'https://api.mapbox.com/styles/v1/pandabrand/cj5wzm2s57tap2rocbuf8j6no/tiles/512/{z}/{x}/{y}?access_token=',
         mbAttr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>';
         L.tileLayer(mbURL + parsed_map_vars.map_info.api_key, {attribution: mbAttr}).addTo(map);
         markers = L.featureGroup();
         for(var x = 0; x < parsed_map_vars.locations.length; x++) {
           var feature = parsed_map_vars.locations[x];
           var marker_place = L.marker([feature.coords.lat, feature.coords.lng],{icon:ccIcon, riseOnHover:true, riseOffset: 3000});
           marker_place.bindPopup('<div class=" cc-marker__popup strong">'+feature.title+'</div>');
           markers.addLayer(marker_place);
           feature.marker_id = markers.getLayerId(marker_place);
           $('#'+feature.location_id).attr('data-cc-marker', feature.marker_id);
           $('#'+feature.location_id).addClass(feature.marker_id);
           marker_place.on('click', scrollToDetail);
         }
         markers.addTo(map);
         map.fitBounds( markers.getBounds() );
       });

     scrollToDetail = function() {
       Waypoint.disableAll();
       var _id = this._leaflet_id;
       var scrollItem = $('[data-cc-marker="'+_id+'"]');
       var container = $('.travel__detail__map__list');
       $('*').removeClass('img-icon-anim');
       loadMarker(_id);
       container.animate({
         scrollTop: scrollItem.offset().top - container.offset().top + container.scrollTop()
       }, 2000, function() {
         Waypoint.enableAll();
       });
     };
     $.each(['.travel__detail__map__item'], function(i, classname) {
       var $elements = $(classname);
       var $v_context, $v_offset;
       if($(window).width() < 769) {
         $v_context = $(window)[0];
         $v_offset = 280;
       } else {
         $v_context = $('.travel__detail__map__list')[0];
         $v_offset = 20;
       }
       $elements.each(function() {
         new Waypoint({
           element: this,
           handler: function(direction) {
             var previousWaypoint = this.previous();
             var nextWaypoint = this.next();
             $elements.removeClass('np-previous np-current np-next');

             if (previousWaypoint && direction === 'down') {
               var _prevId = $(previousWaypoint.element).attr('data-cc-marker');
               var _prevMarker = markers.getLayer(_prevId);
              //  var _prevMarker = markers[Number.parseInt(_prevId)];
              //  removeIconDetails(_prevMarkerEl, _prevMarker)
               $(previousWaypoint.element).addClass('np-previous');
             }

             $(this.element).addClass('np-current');
             var _id = $(this.element).attr('data-cc-marker');
             var _marker = markers.getLayer(_id);
             var _markerEl = $(_marker._icon);
             showIconDetails(_markerEl, _marker);
             map.flyTo(_marker.getLatLng(), 15);

             if (nextWaypoint && direction === 'up') {
               $(nextWaypoint.element).addClass('np-next');
               var _nextId = $(nextWaypoint.element).attr('data-cc-marker');
              //  var _nextMarkerEl = $('.cc-map-marker.'+_nextId);
              //  var _nextMarker = markers[Number.parseInt(_nextId)];
              //  removeIconDetails(_nextMarkerEl, _nextMarker)
             }

           },
           offset: $v_offset,
           group: classname,
           context: $v_context
         });
       });
     });
    }
  },
   'tax_location_types': {
     init: function() {
       $('.dropdown-menu').click(function(e) {
               e.stopPropagation(); //This will prevent the event from bubbling up and close the dropdown when you type/click on text boxes.
       });
       var map, mapoverlay, parsed_map_vars, markers;
       var pulseElement = document.createElement('div');
       pulseElement.classList.add('element');
       var thatMarker;

       showIconDetails = function(markerElement, thisMarker) {
         thatMarker = thisMarker;
         // thisMarker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
         $(markerElement).find('.cc-map-marker').addClass('img-icon-anim');
         $(markerElement).find('.cc-map-marker').append(pulseElement);
       };

       removeIconDetails = function(markerElement, thisMarker) {
         // thisMarker.setZIndex(thatMarker.getZIndex());
         $(markerElement).find('.cc-map-marker').removeClass('img-icon-anim');
         $(markerElement).find('.cc-map-marker').children('.element').remove();
       };

       loadMarker = function(_id) {
         var id = _id ||  _.keys(markers)[0];
         var marker = markers[id];
         var elements = document.getElementsByClassName('cc-map-marker '+id);

         var markerElement = elements[0];
         showIconDetails(markerElement, marker);
       };

       parsed_map_vars = JSON.parse(map_vars);

       var ccIcon = L.divIcon({
           html: '<div class="cc-map-marker"><img class="img-fluid" src="/app/themes/culturecollide-theme/dist/images/map_icon.png" srcset="/app/themes/culturecollide-theme/dist/images/map_icon.png 1x, /app/themes/culturecollide-theme/dist/images/map_icon@2x.png 2x" /></div>',
           iconSize: [34, 50],
           iconAnchor: [18, 49],
           popupAnchor: [0, -26]
       });
       $('#cc-map').ready(function() {
         map = L.map('cc-map',{scrollWheelZoom:false}).setView([parsed_map_vars.city.location.lat, parsed_map_vars.city.location.lng], 12);

         var mbURL = 'https://api.mapbox.com/styles/v1/pandabrand/cj5wzm2s57tap2rocbuf8j6no/tiles/512/{z}/{x}/{y}?access_token=',
         mbAttr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>';
         L.tileLayer(mbURL + parsed_map_vars.map_info.api_key, {attribution: mbAttr}).addTo(map);
         markers = L.featureGroup();
         for(var x = 0; x < parsed_map_vars.locations.length; x++) {
           var feature = parsed_map_vars.locations[x];
           var marker_place = L.marker([feature.coords.lat, feature.coords.lng],{icon:ccIcon, riseOnHover:true, riseOffset: 3000});
           marker_place.bindPopup('<div class=" cc-marker__popup strong">'+feature.title+'</div>');
           markers.addLayer(marker_place);
           feature.marker_id = markers.getLayerId(marker_place);
           $('#'+feature.location_id).attr('data-cc-marker', feature.marker_id);
           $('#'+feature.location_id).addClass(feature.marker_id);
           marker_place.on('click', scrollToDetail);
         }
         markers.addTo( map );
         map.fitBounds( markers.getBounds() );
       });

     scrollToDetail = function() {
       Waypoint.disableAll();
       var _id = this._leaflet_id;
       var scrollItem = $('[data-cc-marker="'+_id+'"]');
       var container = $('.travel__detail__map__list');
       $('*').removeClass('img-icon-anim');
       loadMarker(_id);
       container.animate({
         scrollTop: scrollItem.offset().top - container.offset().top + container.scrollTop()
       }, 2000, function() {
         Waypoint.enableAll();
       });
     };
     $.each(['.travel__detail__map__item'], function(i, classname) {
       var $elements = $(classname);
       var $v_context, $v_offset;
       if($(window).width() < 769) {
         $v_context = $(window)[0];
         $v_offset = 280;
       } else {
         $v_context = $('.travel__detail__map__list')[0];
         $v_offset = 20;
       }
       $elements.each(function() {
         new Waypoint({
           element: this,
           handler: function(direction) {
             var previousWaypoint = this.previous();
             var nextWaypoint = this.next();
             $elements.removeClass('np-previous np-current np-next');

             if (previousWaypoint && direction === 'down') {
               var _prevId = $(previousWaypoint.element).attr('data-cc-marker');
               var _prevMarker = markers.getLayer(_prevId);
              //  var _prevMarker = markers[Number.parseInt(_prevId)];
              //  removeIconDetails(_prevMarkerEl, _prevMarker)
               $(previousWaypoint.element).addClass('np-previous');
             }

             $(this.element).addClass('np-current');
             var _id = $(this.element).attr('data-cc-marker');
             var _marker = markers.getLayer(_id);
             var _markerEl = $(_marker._icon);
             showIconDetails(_markerEl, _marker);
             map.flyTo(_marker.getLatLng(), 15);

             if (nextWaypoint && direction === 'up') {
               $(nextWaypoint.element).addClass('np-next');
               var _nextId = $(nextWaypoint.element).attr('data-cc-marker');
              //  var _nextMarkerEl = $('.cc-map-marker.'+_nextId);
              //  var _nextMarker = markers[Number.parseInt(_nextId)];
              //  removeIconDetails(_nextMarkerEl, _nextMarker)
             }

           },
           offset: $v_offset,
           group: classname,
           context: $v_context
         });
       });
     });
    }
   },
   'travel': {
     init: function() {
       $('.dropdown-menu').click(function(e) {
               e.stopPropagation(); //This will prevent the event from bubbling up and close the dropdown when you type/click on text boxes.
       });
       $('.travel__artist-guides__carousel').slick({
         infinite: true,
         slidesToShow: 4,
         slidesToScroll: 4,
         rows: 0,
         responsive: [
           {
             breakpoint: 1025,
             settings: "noslick"
           },
           {
             breakpoint: 769,
             settings: {
               infinite: true,
               arrows: false,
               dots: true,
               slidesToShow: 2,
               slidesToScroll: 2,
             }
           },
           {
             breakpoint: 481,
             settings: {
               infinite: true,
               arrows: false,
               dots: true,
               slidesToShow: 1,
               slidesToScroll: 1,
             }
           }
         ]
       });
     }
   },
   'single': {
     init: function() {
      /* get width, height of window for caching */
      var width = $(window).width(), height = $(window).height();
    	/* Call the function */
      mediaSize();
      /* Attach the function to the resize event listener */
    	$(window).resize(function() {
        /* this is because resize is fired when scrolling, don't call mediaSize unless the width, height has actually changed */
        if($(window).width() !== width && $(window).height() !== height) {
          width = $(window).width();
          height = $(window).height();
          mediaSize();
        }
      });
     }
   }

  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
