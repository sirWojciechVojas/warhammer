$(document).ready(function()
{
    $('body').on('mousedown',function(){
        $(this).addClass('clickDown');
    });
    $('body').on('mouseup',function(){
        $(this).removeClass('clickDown');
    });

    $("*").each(function() {
        var cur = $(this);
        if(cur.css("cursor") == "pointer") {
            //console.log(cur.css("cursor"));
           cur.addClass('myPointer');
        }
    });
});