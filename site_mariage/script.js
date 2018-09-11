$(function(){
    var rechercheOn = false;

    // -------- ECOUTEUR D'EVENEMENT ------------//
    eventListener();

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

    $('#best_picture').click(function(){
      selectPhoto($(this));
    });

    //Evenement a lancer apres requetes ajax
    function eventListener(){
        //Ajout de l'évènement de recherche de photo sur la pagination
        $('.paginate_link').click(function(){
            selectPhoto($(this));
        });

        //Ajout de l'évènement pour affichage de la modal sur les résultat de recherche
        $('.hover_photo').click(function(){
            if(!$(event.target).closest('.btn-like, .btn-download').length) {
            //Le clic s'est produit en dehors de l'élément btn-like
            $('#myModal .modal-content').load('modal_photo.php?urlPhoto='+$(this).prev('.photo').attr('data-url-photo')+'&photoClick='+$(this).prev('.photo').attr('id'),function(){$('#myModal').modal('show');});
            }
        });

        //Ajout de l'évenement sur le bouton pour like photo
        $('.like').click(function(){
            likePhoto($(this));
        });

        //GESTION AFFICHAGE HOVER PHOTO
        $(".hover_photo").mouseleave(function(){
            $(this).fadeOut('fast');
            if($(this).children('.barre_miniature_hover').is(':visible'))
                $('.barre_miniature_hover').slideToggle(50);
        });

        $('.photo').mouseenter(function(){
            $('.barre_miniature_hover').slideToggle('fast');
            $(this).next('.hover_photo').fadeIn('fast');
        });

        $('.btn-custom').mouseenter(function(){
            if($(this).hasClass('btn-like'))
                $(this).next().toggle("slide", { direction: "left" }, 150);

            if($(this).hasClass('btn-download'))
                $(this).prev().toggle("slide", { direction: "right" }, 150);
        });

        $('.btn-custom').mouseleave(function(){
            if($(this).hasClass('btn-like'))
                $(this).next().hide();

            if($(this).hasClass('btn-download'))
                $(this).prev().hide();
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

    $('.section').mouseenter(function(){
        $(this).children('.photo_section').slideDown('fast');
    });

    $(".section").mouseleave(function(){
        $(this).children('.photo_section').slideUp('fast');
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
    var scrollTo = ($(this).offset().top);
        $('html, body').animate({ scrollTop: scrollTo }, 500);
    });

    //------------- AJAX IMAGE PAR CATEGORIES -------------//

    function selectPhoto(element){
        var page = $(element).attr('data-page');
        var mode = $(element).attr('data-mode');
        var id_invite = $(element).attr('data-id');
        var NomInvite = ($(element).attr('data-nom-invite') != undefined) ? $(element).attr('data-nom-invite') : $(element).val();
        var scrollTo = ($('.scroll_barre').offset().top + 30);
        var titre = '';

        var request = $.ajax({
            url: "image_par_categorie.php",
            method: "POST",
            data: {
                    page : page,
                    mode : mode,
                    id_invite : id_invite,
                    nom_invite : NomInvite,
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
                case 'photobooth' :
                    titre = 'Photobooth';
                    break;
                case 'personne' :
                    titre = 'Photo de '+ NomInvite;
                    break;
                case 'best_photos' :
                    titre = 'Vos photos favorites';
                    break;
            }
            $('.photo_title').fadeOut('fast',function(){ //modification du titre
                $('.photo_title').html('<h2>' + titre + '</h2>');
                $('.photo_title').fadeIn('slow');
            });
            $('.container').fadeOut('fast',function(){ //Chargement et affichage des photo
                if(mode == 'best_photos'){
                  var best = '<div class="col-xs-12"><p class="text-center alert-success" style="font-family: \'allura\', verdana, arial, sans-serif;">Ici son regroupées les photos ayant reçu le + de "J\'aime". N\'hésitez pas à clicker sur le bouton "J\'aime" lorsqu\'une photo vous plait! Le classement changera en fonction des "J\'aime" obtenus par les photos.</p></div>' + data;
                  $('.container').html(best);
                  $('.container').fadeIn('slow');
                }
                else{
                  $('.container').html(data);
                  $('.container').fadeIn('slow');
                }
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

        if(saisie == "vincent" || saisie == "vincent joly" || saisie == 'vincent Joly' || saisie == 'Vincent joly' || saisie == 'Vincent'){
          $('.title').html('<h1>Vinz Suce Batard !</h1>');
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
                if($(this).val() == 56){
                  $('.title').html('<h1>Vinz Suce Batard !</h1>');
                }
            });

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }

    //------------ GESTION AFFICHAGE PAGE VIDEOS ----------------//

    $('#videos').click(function(){
      var scrollTo = ($('.scroll_barre').offset().top + 30);
      $('html, body').animate({ scrollTop: scrollTo }, 500);
      $('.photo_title').fadeOut('fast');
      $('.container').fadeOut('fast');
      setTimeout(function(){
        $('.container').load("videos.php");
      }, 150);
      $('.container').fadeIn();
    });

    //------------ AJOUT DE LIKE SUR LES PHOTOS -----------------//

    function likePhoto(element){
        //----- Recuperation valeur dans data-id-photo
        var id_photo = $(element).attr('data-id-photo');
  
        var request = $.ajax({
            url: "vote_photo.php",
            method: "POST",
            data: {
                    id_photo : id_photo,
                  }
        });
  
        request.done(function( data ) {
                  console.log(data);
                });
  
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }

});
