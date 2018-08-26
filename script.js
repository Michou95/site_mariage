$(function(){


    $(".section").mouseleave(function(){
        $(this).children('.hover_section').slideUp('fast');
	});

    $('.section').mouseenter(function(){
        $(this).children('.hover_section').slideDown('fast');
    });

    $('.mute').click(function(){
      $('#audio').html("");
    })

});
