$(document).ready(function(){

    // for(let i = 1; i <= 7; i++){
    //     $('.show'+i).show();
    //     $('.hide'+i).hide();
    //     // if(i == 1){
    //     //     $('.topic-'+i).show();
    //     //     $('#topic-'+i).addClass("topics-active");
    //     // }else{
    //     //     $('.topic-'+i).hide();
    //     //     $('#topic-'+i).removeClass("topics-active");
    //     // }
    // }

    for(let i = 1; i <= 7; i++){
        $('#topic-'+i).click(function(){
            for(let j = 1; j <= 7; j++){
                if(i == j){
                    $('.topic-'+j).show();
                    $('#topic-'+j).addClass("topics-active");
                }else{
                    $('.topic-'+j).hide();
                    $('#topic-'+j).removeClass("topics-active");
                }
            }
        });
    }

    // for(let i = 1; i <= 26; i++){
    //     if(i == 1){
    //         $('.subtopic-'+i).show();
    //         $('#subtopic-'+i).addClass("topics-active");
    //     }else{
    //         $('.subtopic-'+i).hide();
    //         $('#subtopic-'+i).removeClass("topics-active");
    //     }
    // }

    for(let i = 1; i <= 26; i++){
        $('#subtopic-'+i).click(function(){
            for(let j = 1; j <= 26; j++){
                if(i == j){
                    $('.subtopic-'+j).show();
                    $('#subtopic-'+j).addClass("topics-active");
                }else{
                    $('.subtopic-'+j).hide();
                    $('#subtopic-'+j).removeClass("topics-active");
                }
            }
        });
    }

    
});

