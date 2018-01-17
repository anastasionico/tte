// Simple JavaScript Templating
// John Resig - http://ejohn.org/ - MIT Licensed
(function(){
  var cache = {};
  
  this.tmpl = function tmpl(str, data){
    // Figure out if we're getting a template, or if we need to
    // load the template - and be sure to cache the result.
    var fn = !/\W/.test(str) ?
      cache[str] = cache[str] ||
        tmpl(document.getElementById(str).innerHTML) :
      
      // Generate a reusable function that will serve as a template
      // generator (and which will be cached).
      new Function("obj",
        "var p=[],print=function(){p.push.apply(p,arguments);};" +
        
        // Introduce the data as local variables using with(){}
        "with(obj){p.push('" +
        
        // Convert the template into pure JavaScript
        str
          .replace(/[\r\t\n]/g, " ")
          .split("<%").join("\t")
          .replace(/((^|%>)[^\t]*)'/g, "$1\r")
          .replace(/\t=(.*?)%>/g, "',$1,'")
          .split("\t").join("');")
          .split("%>").join("p.push('")
          .split("\r").join("\\'")
      + "');}return p.join('');");
    
    // Provide some basic currying to the user
    return data ? fn( data ) : fn;
  };
})();

if (! window.location.origin)
  window.location.origin = window.location.protocol + "//" + window.location.host;

var customer_url = window.location.origin + "/" + window.location.pathname.split( '/' )[1];
function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}
if(!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(what, i) {
        i = i || 0;
        var L = this.length;
        while (i < L) {
            if(this[i] === what) return i;
            ++i;
        }
        return -1;
    };
}



/*
 * Part Order functions
 */
var inBasket = new Array();
var basketItems = new Array();
var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();
var loadBasket = function() {
	var html = "";
	var total = 0;
  var totalQty = 0;
	$.each(basketItems, function(index, value){
		totalQty += this.qty;
    total += this.price * this.qty;
		html += tmpl("basketpart", this);
	});
  $('#part_basket tbody')
    .empty()
    .html(html);
  $('#totalQty')
    .empty()
    .html("&nbsp;" + totalQty)
    .addClass("pulse");

  ordertotal = total;
/*
	if(total >= 200) {
    var delivery = "FREE",
        ordertotal = total;
  }
	else {
    var delivery = 7.5,
        ordertotal = total + delivery,
        delivery = "£" + delivery.toFixed(2);
  }
  */

//  $('#total-net').html('&#163;' + total.toFixed(2));
//  $('#total-delivery').html(delivery);
  $('#total-total').html('&#163;' + ordertotal.toFixed(2));
	$('#finalorderbutton').css('display', 'inline-block');
	$('table#part_basket tfoot').css('display', 'table-footer-group');
  
}
var loadSessionBasket = function() {
  $.ajax({
    type: "GET",
    url: "/mercedes-parts/j/basket",
    cache: false,
    success: function( data ) {
      if( Object.prototype.toString.call( data.inBasket ) === '[object Array]'
       && Object.prototype.toString.call( data.basketItems ) === '[object Array]'
       && data.inBasket.length > 0 ) {
         inBasket = data.inBasket;
         basketItems = data.basketItems;
         $('.basket-count').html(inBasket.length);
         loadBasket();
      }
    }
  });
}
var syncBasket = function() {
  $.post( "/mercedes-parts/j/sync" , { basketItems: JSON.stringify(basketItems) } );
}



$(document).ready(function() {

  if($('img.nocopy').length > 0) {
    $('img.nocopy')
      .bind('contextmenu', function(e) {
        return false;
      })
      .bind("mousedown",function(e) {
        return false;
      })
      .live("dragstart", function(e) {
        return false;
      });
  }
  if($('#part_list').length > 0) {
    $('#part_list').mixitup({
      onMixStart: function(config){
        var i = 0,
            group = config.filter;

        if(group == 'all')
        {
          group = 'mix_all';
        }

        $("#part_list > .clearfix").remove();
        $("#part_list > ." + group).each(function(index) {
          i++;
          var rem_lg = i % 4;
          var rem_md = i % 3;
          if(rem_lg == 0) {
            $(this).after('<div class="clearfix visible-lg"></div>');
          }
          if(rem_md == 0) {
            $(this).after('<div class="clearfix visible-md"></div>');
          }
        });

        return config;
      }
    });
  /*
    $("#select-groups")
      .on("click", "li", function(event) {
        debugger;
        $('#select-groups li').removeClass('active');
        $(this).addClass('active');
        $('#part_list').mixitup('filter',$(this).data('sort'));
      });
    */
  }

  /*
   * Clickable tables module
   */
  $(".table-clickrow tbody")
    .on("click", "tr", function() {
      var address = window.location.pathname,
          n=$(this).attr('id').split("_");
      if(address.slice(-1) != '/') {
        address = address + '/';
      }
      window.location = address + n[1];
    });
  /*
   * The address_toggle dropdown used on part order/quote screen
   */
  if($(".address_toggle").length > 0 && typeof addresses !== 'undefined') {
    $(".address_toggle").on("change", function() {
      update_address($(this).val());
    });
  }

  /*
   * Part order screen js
   */
  if($('#scroll-basket').length > 0) {
    // Create the measurement node
    var scrollDiv = document.createElement("div");
    scrollDiv.className = "scrollbar-measure";
    document.body.appendChild(scrollDiv);
    // Get the scrollbar width
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
    $('#nav-fixed').css('padding-right', scrollbarWidth + 'px');
    // Delete the DIV 
    document.body.removeChild(scrollDiv);

    // fix sub nav on scroll

    var $win = $('#content')
      , checkoutTop = $('#scroll-basket').offset().top + 30
      , isFixed = 0

    processScroll()

    $win.on('scroll', processScroll)

    function processScroll() {
      var i, scrollTop = $win.scrollTop()
      if (scrollTop >= checkoutTop && !isFixed) {
        isFixed = 1
        $('#nav-fixed').stop().animate({
          top: 0,
          opacity: 1
        }, 800);
      } else if (scrollTop <= checkoutTop && isFixed) {
        isFixed = 0
        $('#nav-fixed').stop().css({
          top: '-70px',
          opacity: 0
        });
      }
    }
  }
  // end if subnav
  $("#nav-fixed")
    .on("click", ".basket", function(event) {
      $('#content').scrollTo('#scroll-basket', 1000);
    });


  $( document ).on( "submit", "form.cart", function(event) {
    event.preventDefault();
    
    splitid = $(this).parents('.partproduct').attr('id').split("_");
    thisid = Number(splitid[1]);
    title = $(this).parents('.partproduct').find('.ptitle').html();

    // THE FORM INPUT ID USED IN basketItems part_[part_id]
    inputid = "part_" + thisid;
    thisqty = Number($(this).parents('.partproduct').find("input[type=text][name=qty]").val());
    thisprice = Number($(this).parents('.partproduct').find('.pprice').html());
    thispnumber = $(this).parents('.partproduct').find('.pnumber').html();
    
    if(jQuery.inArray(inputid,inBasket) > -1) {
      $.each(basketItems, function(index, value) {
        if(this.id == inputid) {
          this.qty += thisqty;
        }
      });
    }
    else {
      inBasket.push(inputid);
      var part = { id: inputid, "part_no": thispnumber, "qty": thisqty, "price": thisprice, "title": title };
      basketItems.push(part);
    }
        
    

    $('.checkout_header .basket')
      .addClass("active")
      .delay(1000)
      .queue(function() {
        $(this).removeClass("active");
        $(this).dequeue();
        $('.basket-count').html(inBasket.length);
      });

    syncBasket();

    loadBasket();
  });
	// BASKET QUANTITY CHANGES
  $("form#basketform")
    .on("keyup", ".quantity", function(event) {
      //thisid = this.name.split('_'); thisid = Number(thisid[1]);
      thisid = this.name;
      thisqty = Number(this.value);
      $.each(basketItems, function(index, value) {
        if(this.id == thisid) {
          this.qty = thisqty;
        }
      });
      delay(loadBasket, 1000);
    });


  // checkout update
   $('#basketform #update_cart').click(function() { 
     
    
    $('input[name=update]').val('1');
    $('#basketform').submit();
    
  });

  // checkout delete
  $('#part_basket').on('touchstart click', '.checkout-delete', function (event) {
    event.preventDefault();
    inputname = $(this).parents('tr').find('input.quantity').attr('name');
    thisid = Number(inputname.split("_")[1]);
    var newBasketItems = new Array();
    $.each(basketItems, function(index, value) {
      if(this.id != inputname) {
        newBasketItems.push(this);
      }
    });
    basketItems = newBasketItems;
    removeA(inBasket, inputname);
    syncBasket();
    loadBasket();
  });

});
