jQuery(document).ready(function ($) {

  $( window ).resize(function() {
    if($('.carousel').length) {
      $('.carousel').each(function() {
        if($(this).attr('id') != 'carousel-bootstrap') {
          $(this).css('height', 'auto');
        }
      });
    }
  });

  $('a.back').click(function(){
      parent.history.back();
      return false;
  });

  $('#content').scrollspy();

  // Create the measurement node
  var scrollDiv = document.createElement("div");
  scrollDiv.className = "scrollbar-measure";
  document.body.appendChild(scrollDiv);
  // Get the scrollbar width
  var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
  $('#nav-fixed').css('padding-right', scrollbarWidth + 'px');
  // Delete the DIV 
  document.body.removeChild(scrollDiv);

  if($('.block > .subnav').length) {
    var $subnav = $('.block > .subnav').clone();
    $('#nav-fixed').html($subnav);
    if($subnav.hasClass('visible-xs') == true) {
      $('#nav-fixed').addClass('visible-xs');
    }
  }

  var snapper = new Snap({
    element: document.getElementById('content'),
    disable: 'right',
    touchToDrag: false
  });


  $(".snap-left").click(function(e) {
    e.preventDefault();
    if(snapper.state().state == 'left')
    {
      snapper.close();
//      $('.snap-left').parent('li').removeClass('highlight');
    }
    else
    {
      snapper.open('left');
//      $('.snap-left').parent('li').addClass('highlight');
    }
  });
  snapper.on('close', function(){
//    $('.snap-left').parent('li').removeClass('highlight');
  });

  // fix sub nav on scroll
  if($('#content .block > .subnav').length) {

    var $win = $('#content')
      , $nav = $('#content .subnav')
      , navTop = $('#content .subnav').length && $('#content .subnav').offset().top + 30
      , isFixed = 0


    function processScroll() {
      var i, scrollTop = $win.scrollTop();
      if (scrollTop >= navTop && !isFixed) {
        isFixed = 1
        //$nav.addClass('subnav-fixed')
        //console.log('show nav-fixed');
        $('#nav-fixed').stop().animate({
          top: 0,
          opacity: 1
        }, 800);

        $('.snap-drawer-left').css({ 'padding-top' : '50px' });
        
      } else if (scrollTop <= navTop && isFixed) {
        isFixed = 0
        //$nav.removeClass('subnav-fixed')
        //console.log('hide nav-fixed');
        $('#nav-fixed').stop().css({
          top: '-40px',
          opacity: 0
        });

        $('.snap-drawer-left').css({ 'padding-top' : '146px' });
      }
    }

    $win.on('scroll', processScroll);

    processScroll();
  } // end if subnav
  
  /**
   * Contact us form. Displays the correct form
   * base on which radio button in pressed.
   */
  if($('#sb-contact-form').length) {
    $('#sb-contact-form input:radio').change(function() {
      var form_selection = $(this).val(),
          form_selection = '#sb-contact-' + form_selection.split("_").join("-") + '-form';

      $('.contact-stage-1').removeClass('contact-stage-active');
      $('.contact-stage-2')
        .addClass('contact-stage-active')
        .find('form')
        .hide();

      $(form_selection)
        .removeClass('display-none')
        .slideDown('slow');
    });
  }

  /**
   * Bootstrap carousel configuration script.
   */
  if($('.carousel').length) {
    $('.carousel').each(function() {
      // homepage slider
      if($(this).attr('id') == 'carousel-bootstrap') {
        $(this).carousel({
          interval: 8000,
          pause: "false"
        })
        .bind('slide.bs.carousel', function(event) {
          // end animate
          var slide_id = $(event.target).find('.carousel-inner > .item.active').index();
          var el = $('.carousel-indicators').children('li[data-slide-to=' + slide_id + ']');

          if(event.direction == "right") {
            el.find("em").stop().css({
              left: 0,
              right: "auto"
            }).animate({
              width: 0
            }, 400);
          }
          else
          {
            el.find("em").stop().css({
              width: "100%",
              left: "auto",
              right: 0
            }).animate({
              width: 0
            }, 400);
          }
        })
        .bind('slid.bs.carousel', function(event) {
          // start animate
          var slide_id = $(event.target).find('.carousel-inner > .item.active').index();
          var el = $('.carousel-indicators').children('li[data-slide-to=' + slide_id + ']');

          el.find("em").css({
            right: "auto",
            left: 0
          }).animate({
            width: "100%"
          }, 7500, "linear");
          /* keep
             var active = $(event.target).find('.carousel-inner > .item.active');
             var from = active.index();
             var next = $(event.relatedTarget);
             var to = next.index();
             var direction = event.direction;
             */
        });
        // animate on start
        $('.carousel-indicators li:first-child').find('em').css({
          right: "auto",
          left: 0
        }).animate({
          width: "100%"
        }, 7600, "linear");
      } // end if homepage
      else {
        // every other slider
        $(this).carousel({
          interval: 9999999, // yeah false wasnt working?
          pause: "false"
        })
        .bind('slide.bs.carousel', function(event) {
          var height = $(this).css('height');
          $(this).css('height', height);
        })
        .bind('slid.bs.carousel', function(event) {
        });

      }

    }); // each carousel

  }

  if($('.carrot').length) {
    $('.carrot').each(function() {
      // every other slider
      $(this).carousel({
        interval: 9999999, // yeah false wasnt working?
        pause: "false"
      })
      .bind('slide.bs.carousel', function(event) {
        var height = $(this).css('height');
        $(this).css('height', height);
      })
      .bind('slid.bs.carousel', function(event) {
      });
    });
  }

    // still broken
    /*
    $('.carousel-control.left')
      .unbind()
      .click(function(event) {
        event.preventDefault();
        $('.carousel').carousel('prev');
    });
    */

  /**
   * Used JS, uses mixtup
   */
  if($('.mixem').length) {
    $('.mixem').each(function() {
      var filterSel = "#" + $(this).attr('id') + " .filter";

      $(this).mixitup({
        filterSelector: filterSel,
        onmixstart: function(config){
          var i = 0,
              group = config.filter;

          if(group == 'all')
          {
            group = 'mix_all';
          }

          return config;
        },
        onMixStart: function(config) {
          // fade out
          $(config.container).find(".carousel-inner").fadeOut();
          // pause carousel
          $(config.container).find(".carousel").carousel('pause');
        },
        onMixEnd: function(config){

          var visible_vehicles = 0,
              $show = $("<div>"),
              $the_carousel = $(config.container).find(".carousel");

          // if we sorted before use the hidden give inside the carousel
          if($the_carousel.find(".hidden").length) {
            var $hidden = $the_carousel.find(".hidden");
          }
          else {
            // else make a hidden div
            var $hidden = $("<div>", { "class" : "hidden" });
          }

          // each slide
          $the_carousel.find('.mix').each(function(index, value) {

            // if its hidden put it in the $hidden container div
            if($(value).css('opacity') == "0") {
              $hidden.append($(value));
            }
            else {
              // else put it in the $show container div
              $show.append($(value));
              visible_vehicles++;
            }

          });

          // ok so we have them sorted into $show and $hidden
          // now lets make a new carousel inner
          $carousel_inner = $("<div>", { "class" : "carousel-inner" });
          // lets make an item to start
          $current_item = $("<div>", { "class" : "item active" });
          var i = 1;
          // foreach $show vehicle
          $show.find('.mix').each(function(index, value) {
            $current_item.append($(value));
            if(((i % 2) == 0) && ((i % 6) != 0)) {
              $current_item.append($("<div>", { "class": "clearfix" }));
            }
            if(((i % 6) == 0) && i != visible_vehicles) {
              $carousel_inner.append($current_item);
              $current_item = $("<div>", { "class" : "item" });
            }
            i++;
          });
          if($current_item.find(".mix").length > 0) {
            $carousel_inner.append($current_item);
          }

          // forgot to add rows inside $items
          $carousel_inner.find(".item").each(function(index, item) {
            // make row
            $row = $("<div>", { "class" : "row" });
            // add all inner item divs to row
            $row.append($(item).children("div"));
            // append row to .item
            $(item).append($row);
            // append item to carousel
            $carousel_inner.append($(item));
          });

          // sort out the visual
          $the_carousel.find(".carousel-inner")
            .html( $carousel_inner.html() )
            .fadeIn();

          // add $hidden to the carousel if it isnt allready there
          if($the_carousel.find(".hidden").length == 0) {
            $the_carousel.append($hidden);
          }

          // start the carousel as its paused on mixstart
          if(visible_vehicles > 6) {
            $the_carousel.carousel('cycle');
          }

        },
      });
    });

    var $filters = $('ul.mix-filters').find('li');
    $filters.on('click', function () {
      $ul = $(this).parent('ul');
      if($(this).data('filter') == "all") {
        $ul.find('.indicator').html('<i class="fa fa-check-square-o"></i>');
      }
      else {
        $ul.find('.indicator').html('<i class="fa fa-square-o"></i>');
        $(this).find('.indicator').html('<i class="fa fa-check-square-o"></i>');
      }
    });
  }
    





  if($('#vehicles-used-listing').length) {

    // INSTANTIATE MIXITUP for individual used pages
    $('#vehicles-used-listing').mixitup({});

    var $filters = $('.mix-filters').find('li');
    $filters.on('click', function () {
      $ul = $(this).parent('ul');
      if($(this).data('filter') == "all") {
        $ul.find('.indicator').html('<i class="fa fa-check-square-o"></i>');
      }
      else {
        $ul.find('.indicator').html('<i class="fa fa-square-o"></i>');
        $(this).find('.indicator').html('<i class="fa fa-check-square-o"></i>');
      }
    });

  }

  /*
   * modal click tracking 
   */
  $('.modal').on('shown.bs.modal', function (e) {
    var page_section = $(e.relatedTarget).data("section"),
        $input = $(this).find("input[name='request_page_section"),
        modal = $(this).attr('id');

    // set the hidden $input to the page section the user has clicked on
    if(($input.length) && (typeof page_section != 'undefined')) { 
      $input.val(page_section);
    }

    // select the vehicle on the test drive dropdown
    if((modal == "modalTestdrive") && ($('#edit-vehicle').length)) {
      $("#edit-vehicle").val(page_section);
    }
  })

});

(function ($) {
  if(typeof Drupal != 'undefined') {
    if(typeof Drupal.ajax != 'undefined') {
      Drupal.ajax.prototype.commands.customViewsScrollTop = function (ajax, response, status) {
        if($(ajax.selector).parent().attr('id') == 'block-views-blog-news') {
          window.location.hash = '';
          window.location.hash = '#news';
        }
        else {
          // Scroll to the top of the view. This will allow users
          // to browse newly loaded content after e.g. clicking a pager
          // link.
          var offset = $(response.selector).offset();
          // We can't guarantee that the scrollable object should be
          // the body, as the view could be embedded in something
          // more complex such as a modal popup. Recurse up the DOM
          // and scroll the first element that has a non-zero top.
          var scrollTarget = response.selector;
          while ($(scrollTarget).scrollTop() == 0 && $(scrollTarget).parent()) {
            scrollTarget = $(scrollTarget).parent();
          }
          var header_height = 0;
          // Only scroll upward
          if (offset.top - header_height < $(scrollTarget).scrollTop()) {
            $(scrollTarget).animate({scrollTop: (offset.top - header_height)}, 500);
          }
        }
      };
    }
  }
})(jQuery);
