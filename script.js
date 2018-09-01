$(function(){
    var rechercheOn = false;

    // -------- ECOUTEUR D'EVENEMENT ------------//

    $('.hover_section').click(function(){
        selectPhoto($(this));
    });

    function eventListener(){
        $('.paginate_link').click(function(){
            selectPhoto($(this));
        });
    }

    // lancement autocomplétion a la modification du champ de saisie
    $('#search').keyup(function(){
        if($(this).val().length > 0)//Lancement si la valeur est supérieur a 0
            autocomplete($(this));
        else //Sionon on cache l'autocomplète car vide
            $('#resultSearch').slideUp('fast');
    });

    // lancement autocomplétion au click dans le champ de saisie
    $('html').click(function(e){
        //console.log(e.target.id);
        if(e.target.id == 'search'){ //Si le clic est dans la champ de recherche on remet l'autocomplete
            if($('#search').val().length > 0) //A condition que ça valeur ne soit pas null
                autocomplete($('#search'));
        }else{ //Si on click en dehors, on masque l'autocomplete
            $('#resultSearch').slideUp('fast'); 
        }
            
    });


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
        $('.mute').html('');
    })

    //------------- GESTION SCROLL ------------------------//

    $('.scroll_barre').click(function(){
    var scrollTo = ($(this).offset().top * 2);
        $('html, body').animate({ scrollTop: scrollTo }, 500);
    });

    //------------- AJAX IMAGE PAR CATEGORIES -------------//

    function selectPhoto(element){
        var categorie = $(element).attr('data-categorie');
        var page = $(element).attr('data-page');
        var mode = $(element).attr('data-mode');
        //console.log(categorie);
        var scrollTo = ($('.scroll_barre').offset().top * 2);
        var titre = '';

        var request = $.ajax({
            url: "image_par_categorie.php",
            method: "POST",
            data: {
                    categorie : categorie,
                    page : page,
                    mode : mode,
                  }
        });

        request.done(function( data ) {
            //console.log(data);
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
                $('.container').html(data);
                $('.container').fadeIn('slow');
                eventListener(); // /!\IMPORTANT/!\ permet de relancer l'event listener pour les bouton de pagination
            });
            //$( ".container" ).html( data );
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }

    //------------------ AJAX AUTOCOMPLETE -------------------//

    function autocomplete(element){
        var element = $(element);
        var saisie = $(element).val();

        if(saisie == "what the funk"){
          $('#audio').html("<audio autoplay src='mariage/what_the_funk.mp3'></audio>");
          $('.mute').html('<i class="fas fa-volume-off fa-3x"></i><br><small>mute</small>');
          return false;
        }

        var request = $.ajax({
            url: "autocomplete.php",
            method: "POST",
            data: {
                    saisie : saisie,
                  }
        });

        request.done(function( data ) {
            var result = JSON.parse(data);
            var li = '';
                $(result).each(function(key, value){
                    var prenom = value.prenom.charAt(0).toUpperCase() + value.prenom.slice(1);
                    var nom = value.nom.charAt(0).toUpperCase() + value.nom.slice(1);

                    li += '<li class="searchPerson" value="'+value.id_invite+'">'+prenom+' '+nom+'</li>';
                });

                if(li.length == '0')
                    li = '<li>Aucun résultat !</li>'

            $('#resultSearch').html(li).slideDown('fast');

            $('.searchPerson').click(function(){
                $('#search').val($(this).text()).attr('value', $(this).val());
                $('#resultSearch').slideUp('fast').html('');
            });

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }

});
