
$(document).ready(function(){
  $(".alien").hide();
  //$(".alienE1").show();
  //$(".alienE4").show();

  $(window).load(function(){
      getScore();
      loadStorageItems({"firstCall":true});
      showMessages(0, true);
      customScrollbars();
  });

  // Modules
  ButtonBar();


  /*
    @object ButtonBar user
  */
  function ButtonBar(){
    $(".buttonbar .form_wrap .topbar_button").click(function() {
      var clicked = $(this);
      $(".buttonbar .form_wrap").each(function(){
        if(clicked[0] !== $(this).find(".topbar_button")[0]) setButtonActive($(this).find(".topbar_button"), false);
      });
      //
      var active = $(this).parents(".form_wrap").hasClass("open") ? true : false;
      setButtonActive($(this), !active);
    });
    /*
      @setter buttonActive
    */
    function setButtonActive(btn, active){
      var props;
      if(active){
        $(btn).parents(".form_wrap").addClass("open");
        props = {"opacity":"1", "top": "75px"};
      }
      else{
        $(btn).parents(".form_wrap").removeClass("open");
        props = {"opacity":"0", "top": "25px"};
      }
      $(btn).parents(".form_wrap").find(".container").css("display","block");
      $(btn).parents(".form_wrap").find(".container").stop(0,1).animate({"top":props.top, "opacity":props.opacity}, 250, "easeOutSine", function(){
        if(!active) $(btn).parents(".form_wrap").find(".container").css("display", "none");
      });
    }
  }// end ButtonBar


  function customScrollbars(){
    $(".users").customScrollbar();
  }

  /* Feed click */
  $(".button.pick").click(function(e){
    updateScore();
  });

  /* Feed Button Ajax */
  function updateScore(){
    $(".button.pick").addClass("disabled");
    $.ajax({
      url: "php/updateScore.php",
      success: function(data){
        var parsedData = JSON.parse(data);
        if(data){
          $(".button.pick").removeClass("disabled");
          $(".barwrap h1 .score").text(parsedData.newScore);
          var points = $(".barwrap h1 .score").text();
          $(".barwrap h1 .score").stop(0,1).animateNumber({ number: points, numberStep: $.animateNumber.numberStepFactories.separator("'")}, 1000);
          $(".barwrap h1 .score").prop('number', points);
          var p = parsedData.feedItem;
          $(".feedItemOverlay").delay(300).fadeIn(500);
          $(".feedItemOverlay .title").text(p.name);
          $(".feedItemOverlay .title").css("color", p.color || "#5EACCC")
          $(".feedItemOverlay .val").css("color", p.color || "#5EACCC")
          loadSvg(".feedItemOverlay .img", "/monster"+p.img );
          //$(".feedItemOverlay .img").html("<img src='/monster"+p.img+"'/>");
          $(".feedItemOverlay .value .val").text(p.value);
          $(".feedItemOverlay .rarity .val").text(p.rarity);
          $(".feedItemOverlay .button").css("background",p.color || "#5EACCC");
          $(".feedItemOverlay .destroy.button, .feedItemOverlay .feed.button").click(function(){
            $(this).parents(".feedItemOverlay").fadeOut(300);
          });
          $(".feedItemOverlay .button.store").click(function(){
            $(".storageContainer").fadeIn("300");
            $(this).parents(".feedItemOverlay").fadeOut(300);
            loadSvg(".storageContainer .pickedItem", "/monster"+p.img );
          });
        }
        else {
          $(".button.pick").addClass("disabled");
        }
      }
    });
  }
  function showMessages(myTimestamp, polling){
    $.ajax({
      url:"php/showMessages.php",
      type:"POST",
      data: {
        "timestamp" : myTimestamp,
        "polling" : polling
      }
    }).done(function(data){
      var parsedData = JSON.parse(data);
      var messages = parsedData.messages;
      $(".chat .messages").html("");
      $(messages).each(function(i, elem){
        var color = elem.color || "#42AFDA";
        var message = "<p class='msg'>"+"<span class='user' style='color:"+color+";'>"+elem.name+"</span>"+": "+elem.message+"</p>";
        $(".chat .messages").append(message);
      });
      $(".chat .userinput .message").val("");
      $(".chat .messages").scrollTop(99999999);
      showMessages(parsedData.client_timestamp, false);
    });
  }

  function getScore(timestamp){
    var local_timestamp = {'timestamp' : timestamp};
    $.ajax({
      url: "php/getScore.php",
      type: 'GET',
      data: local_timestamp,
      async: true,
      cache: false,
      success: function(data){
        $(".barwrap h1 .score").text(data);
        var points = $(".barwrap h1 .score").text();
        $(".barwrap h1 .score").stop(0,1).animateNumber({ number: points, numberStep: $.animateNumber.numberStepFactories.separator("'")}, 1000);
        $(".barwrap h1 .score").prop('number', points);

        // @todo -> to function
        var ratio = points / 300000;
        var w = $(".bar").width() * ratio;
        $(".bar .fill").delay(50).animate({width:w+"px"}, 1000, "easeInOutCubic")
      }});
  }

  function loadSvg(selector, url) {
    var target = document.querySelector(selector);

    // If SVG is supported
    if (typeof SVGRect != "undefined") {
      // Request the SVG file
      var ajax = new XMLHttpRequest();
      ajax.open("GET", url +".svg", true);
      ajax.send();

      // Append the SVG to the target
      ajax.onload = function(e) {
        target.innerHTML = ajax.responseText;
      }
    } else {
      // Fallback to png
      target.innerHTML = "<img src='" + url + ".png' />";
    }
  }

  $(".users #showEmail").change(function(){
    var active = $(this).prop("checked");
    if(active) {
      $(".users").width("680px");
      $(".users .email").show();
    }
    else {
      $(".users").width("450px");
      $(".users .email").hide();
    }
    $(".users").customScrollbar("resize", true);

  });


  /* Ink Ripple */
  $(".button").mousedown(function(e){
    if($(this).hasClass("disabled")) return false;
    //ink
    $(this).data('x', e.pageX - $(this).offset().left);
    $(this).data('y', e.pageY - $(this).offset().top);
    var ink =$('<div class=\"inkdrop\"></div');
    $(this).prepend(ink);
    var color = $(this).attr("data-inkcolor");
    $(ink).css('left', $(this).data('x'));
    $(ink).css('top', $(this).data('y'));
    if(color) $(ink).css('background', color);
    var size = 600;
    $(ink).animate({width:size+"px", height:size+"px", left:'-='+size/2+"px", top:'-='+size/2+"px", opacity:'0'
  }, 800, "easeInOutCubic", function(){ $(this).remove(); });
  });


  /* Register Ajax*/
  $(".register_wrap .submit").click(function(){
    var submit_button;
    $.ajax({
      url: 'php/register.php',
      type: 'POST',
      data: {"register-email":$(this).parents(".form_wrap").find("#register-email").val(),
              "register-user":$(this).parents(".form_wrap").find("#register-user").val(),
              "register-pw":$(this).parents(".form_wrap").find("#register-pw").val()
            },
      success : function(data){
        var parsedData = JSON.parse(data);
        $(".register_wrap h2").html(parsedData.msg);
        formEffects();
        if(parsedData.registered) location.reload();
      }
    })
  });

  /* Login Ajax */
  $(".login_wrap .submit").click(function(){
    var submit_button;
    $.ajax({
      url: 'php/login.php',
      type: 'POST',
      data: { "login-user":$(this).parents(".form_wrap").find("#login-user").val(),
              "login-pw":$(this).parents(".form_wrap").find("#login-pw").val()
            },
      success : function(data){
        var parsedData = JSON.parse(data);
        $(".login_wrap h2").html(parsedData.msg);
        formEffects();
        if(parsedData.loggedIn) location.reload();
      }
    })
  });

  /* Click Storage Element */
  $(".storageContainer .elem").click(function(){
    var data = {
      "x":$(this).attr("x"),
      "y":$(this).attr("y")
    };
    loadStorageItems(data);
  });

  function loadStorageItems(postData){
      $.ajax({
        url:"php/storage.php",
        type :"POST",
        data : postData
      }).done(function(data){
        var parsedData = JSON.parse(data);
        console.log(parsedData);
        $("body").append(parsedData.storageTemplate);
        //
        var se = parsedData.storageEntries;
        $(se).each(function(i,elem){
        var selector = ".storageContainer .elem[x='"+elem.x+"'][y='"+elem.y+"']"
         loadSvg(selector+" .inner", '/monster'+elem.img );
         $(selector+" .username").html(elem.username+"<br>"+elem.feed_item_name);
         $(selector+" .username").css("color", elem.color);
        });
      });
  }


  /* Chat */
  $(".chat .sendButton").click(function(){
      sendMessage();
  });
  $(".chat .userinput .message").keyup(function(e){
      if(e.keyCode == 13){ sendMessage();}
  });



  function sendMessage(){
    if($(".chat .userinput .message").val() != ""){
      $.ajax({
        url: "php/sendMessage.php",
        type: "POST",
        data: {
          "message":$(".chat .userinput .message").val()
        }
      }).done(function(data){
        var parsedData = JSON.parse(data);
        if(parsedData.status == "no access"){
          $(".chat .notifications").html("<p class='warning'>No Access.</p>")
        }
      });
    }
  }



  /* Logout Ajax */
  $(".logout_wrap .submit").click(function(){
    var submit_button;
    $.ajax({
      url: 'php/logout.php',
      type: 'POST',
      success : function(data){
        location.reload();
      }
    });
  });

  function formEffects(){
    $(".form_wrap h2 .msg").click(function(){
      $(this).stop(0,1).fadeOut(400, function(){
        $(this).remove();
      });
    });
  }

  /* Text Input Active */
  $("input.text").each(function(){
    if($(this).val()) $(this).parents(".line").addClass("active");
  });
  $("input.text").focus(function(){
    $(this).parents(".line").addClass("active");
  });
  $("input.text").focusout(function(){
    if(!$(this).val()) $(this).parents(".line").removeClass ("active");
  });

  function hex2rgb(hex, opacity) {
    var rgb = hex.replace('#', '').match(/(.{2})/g);

    var i = 3;
    while (i--) {
      rgb[i] = parseInt(rgb[i], 16);
    }

    if (typeof opacity == 'undefined') {
      return 'rgb(' + rgb.join(', ') + ')';
    }

    return 'rgba(' + rgb.join(', ') + ', ' + opacity + ')';
  };

});
