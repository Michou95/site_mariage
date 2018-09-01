$(function(){
    var rechercheOn = false;

    // -------- ECOUTEUR D'EVENEMENT ------------//

    $('.hover_section').click(function(){
        selectPhoto($(this));
    });

    $('#SearchForm').submit(function(e){
        e.preventDefault();
        selectPhoto($('#search'));
    });

    $('#submitForm').click(function(){
        selectPhoto($('#search'));
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
        $('.mute').html('');
        $('#what_the_funk').html('');
        $('.fillWidth').html('<source src="http://localhost/site_mariage/mariage/banniere_site_mariage.mp4" type="video/mp4"/>');
        $('.title').html('<h1>Mickael & Jennifer</h1><h2>28 Juillet 2018</h2>');
    })

    //------------- GESTION SCROLL ------------------------//

    $('.scroll_barre').click(function(){
    var scrollTo = ($(this).offset().top * 2);
        $('html, body').animate({ scrollTop: scrollTo }, 500);
    });

    //------------- AJAX IMAGE PAR CATEGORIES -------------//

    function selectPhoto(element){
        var page = $(element).attr('data-page');
        var mode = $(element).attr('data-mode');
        var id_invite = $(element).attr('data-id');
        var NomInvite = $(element).val();
        var scrollTo = ($('.scroll_barre').offset().top * 2);
        var titre = '';

        var request = $.ajax({
            url: "image_par_categorie.php",
            method: "POST",
            data: {
                    page : page,
                    mode : mode,
                    id_invite : id_invite,
                  }
        });

        request.done(function( data ) {
            //console.log(data);
            rechercheOn = true;
            $('html, body').animate({ scrollTop: scrollTo }, 500); // on scrolle la page sur les photos
            switch(mode){ //choix du titre a afficher
                case 'mairie' :
                    titre = 'Photos Mairie';
                    break;
                case 'vin_honneur' :
                    titre = 'Photos vin d\'honneur';
                    break;
                case 'salle' :
                    titre = 'Photos Salle Des Fêtes';
                    break;
                case 'personne' :
                    titre = 'Photo de '+ NomInvite;
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
          $('.mute').html('<i class="fas fa-ban fa-2x"></i><br><small>Stop</small>');
          $('.fillWidth').html("");
          $('#what_the_funk').html('<iframe style="top: 0px!important;" width="1500" height="500" src="https://www.youtube.com/embed/Io47l-upI5M?rel=0&amp;autoplay=1&controls=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
          $('.title').html('<h1>What The Funk !</h1>');
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
                $('#search').val($(this).text()).attr('data-id', $(this).val());
                $('#resultSearch').slideUp('fast').html('');
            });

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }

});
