$(document).ready(function(){
    $('#thread').click(function(){
        $('.create-thread').show()
        $('body').addClass('overflow-hidden');
    });
    $('#close-create').click(function(){
        $('.create-thread').hide()
        $('body').removeClass('overflow-hidden');
    });
});

