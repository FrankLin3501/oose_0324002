$(function() {
    //use many delay bacause of


    //getjasondata

    console.log('%c別試啦 (／‵Д′)／~ ╧╧有問題找組長啦', 'color: #f00; font-size: 40px;');//1l4m04m/42k7u62u/4ul4vu0 283

    smoothScroll(750);

  $(".work-container").hide(1);
      $(".work-wrap").hide(800);

});


//youtube暫停

var items = [];
var i_title=0;

function smoothScroll (duration) {
    $('a[href^="#"]').click('click', function(event) {

        var target = $( $(this).attr('href') );

        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, duration);
        }
    });
    $('.modal').click('click', function(event) {

        var target = $( $(this).attr('href') );

        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, duration);
        }
    });
}


// Get the modal login
var modal1 = document.getElementById('id01');

// When the user clicks anywhere outside of the modal1, close it
window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
    }


$(function(){

$(".work-wrap").hide(100);
  $(".work-container").show(1);
$(function(){
    var len = 18; //h3-text 超過25個字以"..."取代
    $(".h3-text").each(function(i){
        if($(this).text().length>len){
            $(this).attr("title",$(this).text());
            var text=$(this).text().substring(0,len-1)+"...";
            $(this).text(text);
        }
    });
});


$('input[type="submit"]').mousedown(function(){
    $(this).css('background', '#2ecc71');
});
$('input[type="submit"]').mouseup(function(){
    $(this).css('background', '#1abc9c');
});

$('#loginform').click(function(){
    $('.login').fadeToggle('slow');
    $(this).toggleClass('green');
});



$(document).mouseup(function (e)
{
    var container = $(".login");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
        $('#loginform').removeClass('green');
    }
});

// REQUIRED: "jQuery Query Parser" plugin.
// https://github.com/mattsnider/jquery-plugin-query-parser
// Minified version here:
(function($){var pl=/\+/g,searchStrict=/([^&=]+)=+([^&]*)/g,searchTolerant=/([^&=]+)=?([^&]*)/g,decode=function(s){return decodeURIComponent(s.replace(pl," "));};$.parseQuery=function(query,options){var match,o={},opts=options||{},search=opts.tolerant?searchTolerant:searchStrict;if('?'===query.substring(0,1)){query=query.substring(1);}while(match=search.exec(query)){o[decode(match[1])]=decode(match[2]);}return o;};$.getQuery=function(options){return $.parseQuery(window.location.search,options);};$.fn.parseQuery=function(options){return $.parseQuery($(this).serialize(),options);};}(jQuery));

// YOUTUBE VIDEO CODE
$(document).on('click', '.trigger-link', function (event) {
    event.preventDefault();
    $('#modal-demo').iziModal('open');
});

$(document).ready(function(){


    $('.comfirmbtn').click(function () {
        console.log($("input:checkbox:checked").length);
       // var data = $.getJSON("http://192.168.0.108/vote/js/event.php").responseJSON[0];
       // console.log(data);
        if($("input:checkbox:checked").length==0){
          $('#id02-text').append("你沒有選擇項目確定投票?");
          $('.id02form').append('<input style="display: none" type="hidden" value="" name="group[]">');
          $('.id02form').append('<input style="display: none" type="hidden" value='+0+' name="gLength">');

        }
        else{
            var length = $("input:checkbox:checked").length;
            $.getJSON( "http://163.18.22.15/vote/js/group.php", function( data ) {
                items=data;
                //console.log(items);
                var i = 0;
                var countticket=0;
                $('#id02-text').append('你選了:');
                $.each(items,function(){
                    //test
                    //console.log(items[i]);

                    for (j = 0; j < length; j++) {
                        if($("input:checkbox:checked")[j].value == items[i].G_ID){
                            countticket++;
                        $('#id02-text').append('<li name="group[]"value="'+items[i].G_ID+'">'+items[i].TITLE+'</li>');
                        $('.id02form').append('<input class="iteamss" style="display: none" type="hidden" value='+$("input:checkbox:checked")[j].value+' name="group[]">');
                        }
                    }
                    i++;

                });
                $('.id02form').append('<input  style="display: none" type="hidden" value='+countticket+' name="gLength">');
            });

        }

    });
    $('#id02-cancel').click(function () {
        $('#id02-text').html('');

        $('.id02form').html('');
    });



// BOOTSTRAP 3.0 - Open YouTube Video Dynamicaly in Modal Window
// Modal Window for dynamically opening videos
    setTimeout(function () {

    $('a[href^="https://www.youtube.com"]').on('click', function(e){
        // Store the query string variables and values
        // Uses "jQuery Query Parser" plugin, to allow for various URL formats (could have extra parameters)
        var queryString = $(this).attr('href').slice( $(this).attr('href').indexOf('?') + 1);
        var queryVars = $.parseQuery( queryString );

        // if GET variable "v" exists. This is the Youtube Video ID
        if ( 'v' in queryVars )
        {
            // Prevent opening of external page
            e.preventDefault();

            // Variables for iFrame code. Width and height from data attributes, else use default.
            var vidWidth = '100%'; // default
            var vidHeight = '80%'; // default
            if ( $(this).attr('data-width') ) { vidWidth = parseInt($(this).attr('data-width')); }
            if ( $(this).attr('data-height') ) { vidHeight =  parseInt($(this).attr('data-height')); }
            var iFrameCode = '<h2>'+$(this).parent().children().eq(0).text()+'</h2>'+
                '<iframe width="' + vidWidth + '" height="'+ vidHeight +'" scrolling="no" allowtransparency="true" allowfullscreen="true" src="http://www.youtube.com/embed/'+  queryVars['v'] +'?rel=0&wmode=transparent&showinfo=0" frameborder="0"></iframe>';

            // Replace Modal HTML with iFrame Embed
            $('#mediaModal .modal-body').html(iFrameCode);
            // Set new width of modal window, based on dynamic video content
            $('#mediaModal').on('show.bs.modal', function () {
                // Add video width to left and right padding, to get new width of modal window
                var modalBody = $(this).find('.modal-body');
                var modalDialog = $(this).find('.modal-dialog');
                var newModalWidth = vidWidth + parseInt(modalBody.css("padding-left")) + parseInt(modalBody.css("padding-right"));
                newModalWidth += parseInt(modalDialog.css("padding-left")) + parseInt(modalDialog.css("padding-right"));
                //newModalWidth += 'px';
                // Set width of modal (Bootstrap 3.0)
                $(this).find('.modal-dialog').css('width', '70%');
                $(this).find('.modal-dialog').css('height', '70%');
            });

            // Open Modal
            $('#mediaModal').modal();
        }
    });
    }, 1000);

// Clear modal contents on close.
// There was mention of videos that kept playing in the background.
    $('#mediaModal').on('hidden.bs.modal', function () {
        $('#mediaModal .modal-body').html('');
    });
    var selectedjadge = 0;
    setTimeout(function () {



//詳細資料區
        $('.details').click(function  () {


            var team = items[$(this).attr('key')];
            var student = items[$(this).attr('key')].STUDENT;
            var name= "";
            //console.log(team.G_ID);
            $.each( student, function(key2) {
                name= name+"   "+student[key2].S_NAME;
            });
            console.log(team.VIDEO_LINK);
            var video = '<iframe id="video" width="560" height="315" src="http://www.youtube.com/embed/'+team.VIDEO_LINK+'" frameborder="0" allowfullscreen></iframe>';
            // https://developers.google.com/youtube/iframe_api_reference

            // global variable for the player
            var player;



            if (team.VIDEO_LINK == '') {
              video = "";
            }
            $( ".project-title" ).html(team.TITLE+"<p><hr><p>組員:"+name+'<P class="p" style="text-align:center" >' + video + '<p>');
            $( ".project-load" ).html(team.ABSTRACT);

            $(".collections-row").hide(800);
            $(".work-container").show(800);
            $(".work-wrap").show(800);
           // $(".collections-row").append($(".work-container"));


        $('.work-return').click(function(event) {
            //$('.Collections').css('left','0%');
$(".p").html("");

           var backheitht= $("#work"+team.G_ID).attr("data-datil-back");
            //console.log(backheitht*153+600);
              $(".work-container").hide(1);
            $(".work-wrap").hide(800);

            $(".collections-row").show(800);

            setTimeout(function () {


            },1000);

        });
        });
        //inputbox and select color
        var checknam="";
        var s = 0;
        $('input').change(function () {
            var inputval = $(this).attr('value');
            $("#work"+inputval).toggleClass('select',800);


        $('.checkbox').change(function() {
            if($(this).is(":checked")) {

            }
        });
//limtevote

        $('.checkbox').change(function() {

            if($("input:checkbox:checked").length>6){
                if($(this).is(":checked")) {
                    $(this).prop('checked', false);
                    var inputval2 = $(this).attr('value');
                    $("#work"+inputval2).removeClass('select');
                }
            }

               $('.howmanyticket').html('<input type="number" name="gLength" class="checkbox" value="'+$("input:checkbox:checked").length+'">');

        });


});
    }, 1000);

});
});



$(document).ready(function(){

    $("body").transit();
});

$(document).on("click",".transit", function(){
    $("body").transit();
});

$(document).on("click", ".div1", function(){
    $(".transitDiv").transit();
});
