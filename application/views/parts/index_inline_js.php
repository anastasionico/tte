$(function() {

    $( "#vehicle_model" ).change(function() {
        var dropdown = $( this ).val();
        $( "form.vehicle_models" ).addClass( "hidden" );
        $( "form#" + dropdown )
            .removeClass( "hidden" )
            .addClass( "show" );
    });

});
