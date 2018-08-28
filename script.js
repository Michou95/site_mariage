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
        var categorie = $(this).attr('data-section');
        //console.log(categorie);
        var scrollTo = ($('.scroll_barre').offset().top * 2);
        var titre = '';

        var request = $.ajax({
            url: "image_par_categorie.php",
            method: "POST",
            data: { categorie : categorie }
        });

        request.done(function( data ) {
            var tabPhoto = JSON.parse(data); //On transforme le json en tableau
            rechercheOn = true;
            $('html, body').animate({ scrollTop: scrollTo }, 500); // on scrolle la page sur les photos
            switch(categorie){ //choix du titre a afficher
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
            $('.photo_title').fadeOut('fast',function(){ //modification du titre
                $('.photo_title').html('<h2>' + titre + '</h2>');
                $('.photo_title').fadeIn('slow');
            });
            $('.container').fadeOut('fast',function(){ //Chargement et affichage des photo
                //console.log(addPhotoAndPaginate(tabPhoto));
                $('.container').html(addPhotoAndPaginate(tabPhoto));
                $('.container').fadeIn('slow');
            });
            //$( ".container" ).html( data );
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    });
    //--------- GESTION AFFICHAGE ET PAGINATION IMAGE ------------//

    function addPhotoAndPaginate(tabPhoto,page = 1){
        var html = '';
        var none = '';
        var page = Math.floor(tabPhoto.length/12); //compte du nombre de page
        //console.log(page);
        for(var i = 0; i < tabPhoto.length ; i++){

            if(i >= 12){
                none = 'style="display:none"';
            }

            html += '<div id="'+i+'" class="section col-md-4 col-xs-12 photo-random" '+none+'><img src="' + tabPhoto[i].url + '"></div>';
        }

        if(page > 1) //pagination
        html += '<div class="col-md-10 col-md-offset-1"><a class="paginate btn btn-primary" type="button"> <</a>';
            for(j = 0; j < page; j++){
                html += ' <a class="paginate btn btn-primary" type="button" data-page="'+ (j+1) +'">' + (j+1) + '</a> ';
            }
        html += '<a class="paginate btn btn-primary" type="button">> </a></div>';

        return html;

    }

});
