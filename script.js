$(function(){

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

});