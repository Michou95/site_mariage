$(function(){
    var rechercheOn = false;
    //ibitialisation recherche par saisie a false
    var saisieSearch = true;

    // -------- ECOUTEUR D'EVENEMENT ------------//
    eventListener();

    $('.hover_section').click(function(){
        selectPhoto($(this));
    });

    $('#SearchForm').submit(function(e){
        if(($('#search').attr('data-id') == '') || ($('#search').val() == '') || (saisieSearch == false)){
            if($('#search').val() == ''){
                var text = 'Veuillez entrer un prénom dans le champ ci-dessous';
                $('.popUp').fadeIn('fast').children('.textPopup').text();
            }else{
                var text = 'Veuillez sélectionner un prénom dans la liste ci-dessous';
            }

            $('.popUp').fadeIn('fast').children('.textPopup').text(text);
            return false;
        }
        e.preventDefault();
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
                var stateLike = $(this).children('.barre_miniature_hover').children('.btn-like').data('state-like');

                //Le clic s'est produit en dehors de l'élément btn-like
                $('#myModal .modal-content').load('modal_photo.php?urlPhoto='+$(this).prev('.photo').attr('data-url-photo')+'&photoClick='+$(this).prev('.photo').attr('id')+'&stateLike='+stateLike,function(){$('#myModal').modal('show');});
            }
        });

        // Ajout du bouton j'aime en gris ou rouge selon l'etat
        stateLike('TRUE');

        //Ajout de l'évenement sur le bouton pour like photo
        $('.like').click(function(){
            likePhoto($(this));
        });

        //GESTION AFFICHAGE HOVER PHOTO
        if (window.matchMedia("(min-width: 420px)").matches) {

            $(".hover_photo").mouseleave(function(){
                $(this).fadeOut('fast');
                if($(this).children('.barre_miniature_hover').is(':visible'))
                    $('.barre_miniature_hover').slideToggle(50);
            });

            $('.photo').mouseenter(function(){

                if($('.hover_photo') != $(this) && $('.hover_photo').is(':visible')){
                    $('.hover_photo').fadeOut('fast');
                }
                $(this).next('.hover_photo').fadeIn('fast');
                $('.barre_miniature_hover').slideToggle('fast');
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

          $('#apropos').click(function(){
            var titre = $('.photo_title');
            var container = $('.container');
            $('html, body').animate({ scrollTop: scrollTo }, 500);
            titre.fadeOut('fast');
            container.fadeOut('fast');
            setTimeout(function(){
              container.load('a_propos.php');
            }, 150);
            container.fadeIn();
          });

        }
    }

    // lancement autocomplétion a la modification du champ de saisie
    $('#search').keyup(function(e){
        //On remet a 0 la détéction de validation du nom par autocomplète
        if(saisieSearch == true)
            saisieSearch = false;

        if($('.popUp').is(':visible') && e.keyCode != 13){
            $('.popUp').hide().children('span').text('');
        }

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

    // -------------- GESTION SUBMIT RECHERCHE --------------------//

    $('#submitForm').click(function(){
        //Si l'utilisateur tente de faire une recherche sans passer par l'autocomplète on ne recherche rien
        if(($('#search').attr('data-id') == '') || ($('#search').val() == '') || (saisieSearch == false)){
            if($('#search').val() == ''){
                var text = 'Veuillez entrer un prénom dans le champ ci-dessous';
                $('.popUp').fadeIn('fast').children('.textPopup').text();
            }else{
                var text = 'Veuillez sélectionner un prénom dans la liste ci-dessous';
            }

            $('.popUp').fadeIn('fast').children('.textPopup').text(text);
            return false;
        }

        var path = window.location.pathname;

        // Si on est pas sur la page index on va chercher les photos
        if (path != '/site_mariage/' && path != '/site_mariage/index.php' && path != '/site_mariage/log.php') {
            selectPhoto($('#search'));
        } else { // si on est sur la page index
            // on remplis la session
            var password = $('input[name=passwordSave]').val();
            var username = $('#search').val();
            var id_invite = $('#search').attr('data-id');

            $.ajax({
                url: "verification_log.php",
                method: "POST",
                data: {
                        password : password,
                        username : username,
                        id_invite : id_invite
                      }
            });

            // et on redirige vers la home
            if (window.location.href.substr(-9) == 'index.php') {
                var link = window.location.href.replace("index.php", "site_mariage/home.php");
            } else if (window.location.href.substr(-7) == 'log.php') {
                var link = window.location.href.replace("log.php", "site_mariage/home.php");
            } else {
                var link = window.location.href = window.location.href+"site_mariage/home.php";
            }

            window.location.href = link;
        }
    });

    //------------ GESTION PASSWORD INDEX -------------------//

    $('#valider').click(function(e) {
        e.preventDefault();
        // on récupère le password saisi par l'utilisateur
        var password = $('input[name=password]').val();

        // on vérifie qu'il est correct
        if (password == 'Suce ma bite 2018!') {
            $('.erreur').html('');
            // on cache le premier formulaire
            $('.form-login').css('display', 'none');

            // on fait apparaitre le deuxième
            $('.form-inline').css('display', 'block');

            // on inscrit le password dans un champs caché pour la vérication PHP d'après
            $('input[name=passwordSave]').val(password);
        } else {
            $('.erreur').html('');
            $('.erreur').html('<p class="wrong">Mot de Passe Incorrect</p>');
        }
    })

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
        var path = window.location.pathname;
        var link = '';

        // Si on est PAS sur la page index
        if (path != '/site_mariage/' && path != '/site_mariage/index.php' && path != '/site_mariage/log.php') {
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

            link = "autocomplete.php";
        } else { // Sinon
            link = '/site_mariage/site_mariage/autocomplete.php';
        }

        var request = $.ajax({
            url: link,
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
                //Si l'utilisateur est passer par l'autocomplète, on autorise la recherche
                saisieSearch = true;
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
                  if (data == 'true') {
                    $(element).data('state-like', 'dislike');
                    stateLike('FALSE', element);
                  } else {
                    $(element).data('state-like', 'like');
                    stateLike('FALSE', element);
                  }
                });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }

    //------------ MISE A JOUR DU STATUS DU LIKE SUR LES PHOTOS -----------------//
    function stateLike(firstLoad = 'FALSE', element = 'NULL') {

        if (firstLoad == 'TRUE') {
            var countLike = $('.like');
            for (var i = 0; i < countLike.length; i++) {
                var like = $(countLike[i]).data('state-like');
                if (like == "like") {
                    $(countLike[i]).removeClass('dislike');
                    $(countLike[i]).addClass('addToLike');
                } else {
                    $(countLike[i]).removeClass('addToLike');
                    $(countLike[i]).addClass('dislike');
                }
            }
        } else {
            var self = element;
            var like = self.data('state-like');
            if (like == "like") {
                self.removeClass('dislike');
                self.addClass('addToLike');
            } else if (like == "dislike") {
                self.removeClass('addToLike');
                self.addClass('dislike');
            }
        }
    }

});
