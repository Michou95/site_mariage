$(function(){
    var rechercheOn = false;

    //------------ GESTION AFFICHAGE SECTION HOME -------------------//
    $(document).hover(function(event) { 
        if(!$(event.target).closest('#monElement').length) {
        //Le clic s'est produit en dehors de l'élément monElement
        } 
    });

    $(".section").mouseleave(function(){
        if(!rechercheOn)
        $(this).children('.hover_section').slideUp('fast');
	});

    $('.section').mouseenter(function(){
        if(rechercheOn){
            $('.section').children('.hover_section').slideUp('fast');
            rechercheOn = false;
        }
        $(this).children('.hover_section').slideDown('fast');
    });

    //------------- GESTION SON  ------------------------//

    $('.mute').click(function(){
        $('#audio').html("");
    })

    //------------- GESTION SCROLL ------------------------//

    $('.scroll_barre').click(function(){
    var scrollTo = ($(this).offset().top * 2);
        $('html, body').animate({ scrollTop: scrollTo }, 500);
    });

    //------------- AJAX IMAGE PAR CATEGORIES -------------//

    $('.hover_section').click(function(){
        var elementClick = $(this);
        var categorie = $(this).attr('data-section');
        console.log(categorie);
        var scrollTo = ($('.scroll_barre').offset().top * 2);
        var titre = '';
            
        var request = $.ajax({
            url: "image_par_categorie.php",
            method: "POST",
            data: { categorie : categorie }
        });
        
        request.done(function( data ) {
            console.log(data);
            rechercheOn = true;
            $('html, body').animate({ scrollTop: scrollTo }, 500);
            switch(categorie){
                case 'mairie' : 
                    titre = 'Photos Mairie';
                break;
                case 'vin_honneur' : 
                    titre = 'Photos vin d\'honneur';
                break;
                case 'salle' : 
                    titre = 'Photos Salle Des Fêtes';
                break;
            }
            $('.photo_title').html('<h2>' + titre + '</h2>');
            $('.container').html(data);
            //$( ".container" ).html( data );
        });
        
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    });

});
