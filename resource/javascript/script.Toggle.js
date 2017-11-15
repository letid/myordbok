menu:function(){
  // NOTE: font info toggle
  $('ul.menu li[data-toggle]').on(click, function() {
    var element=$(this); //core.x=element;
    var className = element.data('toggle');
    var container = element.parent().next();
    element.addClass('active').siblings().removeClass('active');
    if (container.is(":hidden"))container.fadeIn('fast');
    container.children(fn.Class(className)).fadeToggle('fast',function(){
      if ($(this).is(":hidden")) {
        container.fadeOut('fast');
        element.removeClass('active');
      }
    }).siblings().fadeOut('fast');
  });
},
panel:function(){
  var primary = $('body>div'), element=core.x;
  var closeElement = function(){
    element.removeClass('active').next().removeAttr('style').hide();
    primary.removeAttr( "style" );
  };
  if (element.hasClass('active')){
    closeElement();
  } else {
    element.next().show().animate({width: '250px',height:'100%'});
    if (element.next().hasClass('page')){
      primary.animate({left: '+=250px'});
    } else {
      primary.animate({right: '+=250px'});
    }
    primary.css({width:'100%',position: 'fixed'});
    element.addClass('active');
  }
  var openPrimary = function(evt){
    if (!$(evt.target).closest(element.next()).length) {
      closeElement();
      $(doc).off(click,openPrimary);
    }
  };
  $(doc).on(click,openPrimary);
}
