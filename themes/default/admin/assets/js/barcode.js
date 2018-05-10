$(document).ready(function() {
    var pressed = false; 
    var chars = []; 
    $(window).keypress(function(e) {
        chars.push(String.fromCharCode(e.which));
        if (pressed == false) {
            setTimeout(function(){
                if (chars.length >= 8) {
                    var barcode = chars.join("");
                    $( "#add_item" ).focus().autocomplete( "search", barcode );
                }
                chars = [];
                pressed = false;
            },200);
        }
        pressed = true;
    });
});
