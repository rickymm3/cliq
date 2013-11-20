/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

/*When a user clicks on any Cliq Link
 * It changes 'active' 'content' and URL */
    $(document).on('click', '.cliq, .nav-item', function(e){
        e.preventDefault(); 
        $('.content').html('Loading');
        var cliq = $(this).data('cliq');
        var cliqid = $(this).data("cliqid");
        var request = $.ajax({
            type: "POST",
            url: "/cliqedit/ajax/ajax_change_cliq",
            dataType: 'json',
            data: {cliqid: cliqid, cliq:cliq}
        });
        request.done(function (response){
            var cliq = response['cliq'];
            var cliqid = response['cliqid'];
            var href = '/cliqedit/cliq/'+cliqid+'/'+cliq;
            History.pushState('', 'New URL: '+href, href);
            $('.active').html(response['active']);
            $('.content').html(response['threadlist']);
            $('.filters').html(response['filters']);
            $('.newthread').html(response['newthread']);
            
        }); 
    }); 
    
    
    //Waypoints Code
     
$(function() {
  // Do our DOM lookups beforehand
  // Do our DOM lookups beforehand
  var nav_wrapper = $(".cbwrapper");
  var nav_container = $(".cliqbar");
  var nav = $(".cliqbarinner");
  nav_wrapper.waypoint({
    handler: function(direction) {
        console.log(direction);
        if (direction == 'down') {
            nav_container.toggleClass('sticky', direction=='down');
            nav_wrapper.css({ 'height':nav.outerHeight() }); }
        else {
            nav_container.toggleClass('sticky', direction=='down');
            nav_wrapper.css({ 'height':'auto' }); }
    }
  });
});
    
       //subject jump to top of page
       $(document).on('click', '.subjectjump', function(e){
            e.preventDefault();
            $('body').animate({ scrollTop: 0 }, 'fast');
       });
    
    //End Waypoints Code
    
/*When a user clicks on New Thread
 * It changes 'content' and URL */

$(document).on('click', '.show-choose, .nt-choose', function(e){
      e.stopPropagation();
    $(".nt-choose").toggle();
});

$("html").click(function(){
    $(".nt-choose").hide();
});

   $(document).on('click', '.nt-cliq', function(e){
        e.preventDefault();
        $('.content').html('Loading');
        var request = $.ajax({
            type: "POST",
            url: "/cliqedit/ajax/ajax_newthread/",
            dataType: 'json',
            data: {}
        });
        request.done(function (response){
            if (response['isloggedin'] === false)
                {
                    var html = 'Please log in to post new thread';
                    $('.content').html(html);
                } else {
                    if (response['active'])
                        {
                            $('.active').html(response['active']); 
                       }
                    var cliqid = response['cliqid'];
                    var cliq = response['cliq'];
                    var href = '/cliqedit/create/'+cliqid+'/'+cliq;
                    History.pushState('', 'New URL: '+href, href);
                    $('.content').html(response['newthread']);
                }
        }); 
    });
    
    FB.Event.subscribe('auth.login', function() {
        window.location  = "/cliq2/auth_other/fb_signin/";
    });
    
    //Thread Content
    
     $(document).on('click', '.tl-subject a', function(e){
        e.preventDefault();
        var threadid = $(this).data('threadid');
        var slug = $(this).data('slug');
        var request = $.ajax({
            type: "POST",
            url: "/cliqedit/ajax/ajax_thread/",
            dataType: 'json',
            data: {threadid:threadid}
        });
        request.done(function (response){
            var href = '/cliqedit/thread/'+threadid+'/'+slug;
            History.pushState('', 'New URL: '+href, href);
            $('.active').html(response['active']);
            $('.content').html(response['content']);
            $('.newthread').html(response['reply']);
            $('.filters').html(response['filters']);
        }); 
    });
    
    //end thread content
    
 $(document).on('click', '.search_submit', function(e){
        e.preventDefault();
        var search = $('.search_input').val();
        var request = $.ajax({
            type: "POST",
            url: "/cliqedit/ajax/ajax_find/",
            dataType: 'json',
            data: {search:search}
        });
        request.done(function (response){
            var cliqidstring = '';
            var cliqid = response['cliqid'];
            if (cliqid === '') { cliqidstring = ""; } else { cliqidstring = cliqid + "/"; }
            var href = '/cliqedit/find/'+cliqidstring+'?q='+response['search'];
            History.pushState('', 'New URL: '+href, href);
            $('.content').html(response['search_results']);
        }); 
    });
    
     $(document).on('click', '.nt-submit', function(e){
         e.preventDefault();
         var body = editor.getValue();
         var subject = $('.nt-subject').val();
         $('.content').html('Loading');

         var request = $.ajax({
            type: "POST",
            url: "/cliqedit/ajax/ajax_createthread/",
            dataType: 'json',
            data: {body:body, subject:subject}
        });
        request.done(function (response){
            if (response['isloggedin'] === false)
                {
                    var html = 'Error: User not logged in';
                    $('.content').html(html);
                }else {
                    $('.active').html(response['active']);
                    $('.content').html(response['threadlist']);
                }
        }); 
    });
    /* == */
    
/* Auth scripts */
     $(document).on('click', '.authlogin', function(e){
         e.preventDefault();
         var request = $.ajax({
            type: "POST",
            url: "/cliqedit/ajax/authloginmodal/",
            dataType: 'json',
            data: {}
        });
        request.done(function (response){
            if (response['loggedin'] === true) {
                
            } else {
                $('.authloginmodal').html(response['authlogin']);
                $(function() {
                    $( ".authloginmodal" ).dialog({
                        height: 350,
                        width: 500,
                        modal: true
                    });
                }); 
            }
        }); 
    });
    
    $(document).on('click', '.authsubmit', function(e){
        e.preventDefault();
         var request = $.ajax({
            type: "POST",
            url: "/cliqedit/index.php/auth/login/",
            dataType: 'json',
            data: {}
        });
        request.done(function (response){
               
        });
        $('.authloginmodal').dialog('destroy');
    });
/* end Auth Scripts */

/* Slide out Menu hover code 
    var mnuTimeout = null;
    var hvrTimeout = null;

       $(document).on({ 
        mouseenter: function () {
           clearTimeout(mnuTimeout);
           hvrTimeout = setTimeout(function(){
               showSlideout_content();
           },300);
        },
        mouseleave : function() {
            mnuTimeout = setTimeout(hideSlideout_content,300);
            clearTimeout(hvrTimeout);
        }
       }, '.slideout');

        
       function showSlideout_content()
       {
           $('.slideout_content').show();
       }
       function hideSlideout_content()
       {
           $('.slideout_content').hide();
       }*/
       
/* end of Slide out Menu hover code */

/* Cliq hover */

    var CliqmnuTimeout = null;
    var CliqhvrTimeout = null;
    
       $(document).on({
        mouseenter: function () {
           if ($(this).hasClass('cliqhistory')) {
               return false;
           }
           var thiscliq = $(this);
           var hovcliqid = $(this).data('cliqid');
           clearTimeout(CliqmnuTimeout);
           CliqhvrTimeout = setTimeout(function(){
              showCliq_content(hovcliqid, thiscliq);
              hovcliqid = null;
              thiscliq = null;
           },500);
        },
        mouseleave : function() {
            var thiscliq = $(this);
            CliqmnuTimeout = setTimeout(function() {
                hideCliq_content(thiscliq); 
                thiscliq = null;
            },0);
            clearTimeout(CliqhvrTimeout);
        }
       }, '.cliq, .cliqinfo');
    
        
       function showCliq_content(hovcliqid, thiscliq)
       {
           if (thiscliq.hasClass('highlighted')) {
                    thiscliq.parent().children('.cliqinfo').show();
                } else {
                    var request = $.ajax({
                    type: "POST",
                    url: "/cliqedit/ajax/ajax_gethistory/",
                    dataType: 'json',
                    data: {hovcliqid:hovcliqid}
                });
                    request.done(function (response){
                        thiscliq.addClass('highlighted');
                        thiscliq.parent().append("<div class='cliqinfo highlighted'>"+response['history']+"</div>");                
                        thiscliq.parent().children('.cliqinfo').show();
                });
            }
       }
       
       function hideCliq_content(thiscliq)
       {
           thiscliq.parent().children('.cliqinfo').hide();
       }
       

//end Cliq Hover
// reply to thread
    //jump to reply area on reply click
       $(document).on('click', '.reply', function(e){
          $('.replyTo').toggle();
          if( $('.replyTo').is(':visible') ) {
                editor.focus();
                $(window).scrollTop($('.replyTo').position().top);
          }
           
       });
       
       $(document).on('click', '.reply-submit', function(e){
        e.preventDefault();
        var threadid = $(this).data('threadid');
        var postnum = $(this).data('postnum');
        var body = editor.getValue();
        var request = $.ajax({
            type: "POST",
            url: "/cliqedit/index.php/ajax/replyTo",
            dataType: 'json',
            data: {threadid:threadid, postnum:postnum, body:body}
        });
        request.done(function (response){
            //$('#wysihtml5-textarea').data("wysihtml5").editor.clear();
            $('.replyTo').hide();
             $('.replies').append(response['reply']);
        });
    });

    //css star color change on highlight:
     
    $(document).on('click', '.star', function(e){
        e.preventDefault();
        var clicked = $(this);
        if ($(this).hasClass('favstar')) {
            var isfaved = 'true';
        } else { isfaved = 'false';}
        var cliqid = $(this).data('cliqid');
         var request = $.ajax({
            type: "POST",
            url: "/cliqedit/index.php/ajax/ajax_changefav",
            dataType: 'json',
            data: {cliqid:cliqid, isfaved:isfaved}
        });
        request.done(function (response){
            if (clicked.hasClass('favstar'))
                {
                    clicked.removeClass('favstar');
                } else {
                    clicked.addClass('favstar');
                }
        });
    });
    
});