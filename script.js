$(function(){

    //------------ GESTION AFFICHAGE SECTION HOME -------------------//
    $(document).hover(function(event) { 
        if(!$(event.target).closest('#monElement').length) {
        //Le clic s'est produit en dehors de l'élément monElement
        } 
    });

    $(".section").mouseleave(function(){
        $(this).children('.hover_section').slideUp('fast');
	});

    $('.section').mouseenter(function(){
        $(this).children('.hover_section').slideDown('fast');
    });

    //------------- GESTION SCROLL ------------------------//

    $('.scroll_barre').click(function(){
        $('html, body').animate({
            scrollTop: $("#go_to_photo").offset().top
        }, 500);
    });

    //------------- AJAX IMAGE PAR CATEGORIES -------------//

    $('.hover_section').click(function(){
        var categorie = $(this).attr('data-section');
            
        var request = $.ajax({
            url: "image_par_categorie.php",
            method: "POST",
            data: { categorie : categorie }
        });
        
        request.done(function( data ) {
            console.log(data);
            //$( ".container" ).html( data );
        });
        
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    });

});