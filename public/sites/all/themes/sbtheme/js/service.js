// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};
var inBasket = new Array();
var basketItems = new Array();
var loadBasket = function() {
	if(inBasket.length > 0) {
		var html = "";
    $('tr.basketitem').remove();
		$.each(basketItems, function(index, item) {
			html += "<tr class='basketitem'><td>" + item.description + "</td>";
      html += "<td class='right'>&#163;" + item.price;
			html += "<input type='hidden' name='" + item.id + "' value='1'></td></tr>";
		});
		$('#order').append(html);
	}
	else {
		// no items hide basket
    $('tr.basketitem').remove();
	}
}
$(document).ready(function() {
  /**
   * service extras cart
   */
  if($('#service-extras').length) {
    $("#baskethide").css("display", "none");

    $(".sel").mouseenter(function(){
      $(this).addClass("selon");
    }).mouseleave(function(){
      $(this).removeClass("selon");
    });

    $("#diagnostic_reveal").mouseenter(function(){
      $(this).addClass("selon");
    }).mouseleave(function(){
      $(this).removeClass("selon");
    }).click(function(){
      $("#make_form").show();
    });

    $(".fpr").click(function() {
      // DRY
      var thisid = $(this).attr('id');
      var description = $(this).find('.pname').html();
      var price = $(this).find('.pprice').html();
      if(jQuery.inArray(thisid,inBasket) > -1) {
        // its already in the basket, deselect
        var pos = jQuery.inArray(thisid,inBasket);
        inBasket.remove(pos);
        basketItems.remove(pos);
        $(this).find('.lbl').html('Order');
        $('#' + thisid).removeClass("selselected");
      }
      else {
        // add
        inBasket.push(thisid);
        basketItems.push({ id: thisid, "description": description, "price": price });
        $(this).find('.lbl').html('Remove');
        $('#' + thisid).addClass("selselected");
      }

      loadBasket();
    });
    $(".mot").click(function() {
      // DRY
      var thisid = $(this).attr('id');
      var description = $(this).find('.pname').html();
      var price = $(this).find('.pprice').html();
      if(jQuery.inArray(thisid,inBasket) > -1) {
        // its already in the basket, deselect
        var pos = jQuery.inArray(thisid,inBasket);
        inBasket.remove(pos);
        basketItems.remove(pos);
        $(this).find('.lbl').html('Order');
        $('#' + thisid).removeClass("selselected");
      }
      else {
        // add
        inBasket.push(thisid);
        basketItems.push({ id: thisid, "description": description, "price": price });
        $(this).find('.lbl').html('Remove');
        $('#' + thisid).addClass("selselected");
      }
      loadBasket();
    });

    /* DIAGNOSIS - VAN DIAGRAM */
    $('.vandiagram td').click(function() { // selections
      if($(this).hasClass('van_selected')) {
        var cararea = $(this).removeClass('van_selected').fadeTo('fast',0.0).attr('id');
        $('.'+cararea).val('');
      }
      else {
        var cararea = $(this).addClass('van_selected').css({'background' : 'red'}).fadeTo('fast',0.5).attr('id');
        $('.'+cararea).val('1');
      }
    });
    $('.vanbox').each(function(i) { // previous selections
      if($(this).val() == '1') {
        var id = $(this).attr('name');
        $('#'+id).addClass('van_selected').css({'background' : 'red'}).fadeTo('fast',0.5).attr('id');
      }
    });
  }

  /*
   * service bookings
   */
  if($('#service-booking').length) {
    function noSundays(date) {
      return [date.getDay() != 0, ''];
    }

    // Datepicker
    $('#datepicker').datepicker({
      inline: true,
      minDate: 3, // tomorrow onwards
      beforeShowDay: noSundays, // no sunday
      onSelect: function(dateText, inst) {
        //formatDate Requires a new date object to work
        var myDate = new Date(dateText);
        $("#date").val($.datepicker.formatDate("yy-mm-dd", myDate));
        //Set a new var with different format to use
        var newFormat = '<span>Selected Date: </span>' + $.datepicker.formatDate("DD, d MM, yy", myDate);
        //Choose the div you want to replace
        $("#selected_date").html(newFormat);
      }

    });

  }
});
