menu:function(){
  // NOTE: font info toggle
  $('ul.menu li[data-toggle]').on('click', function() {
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
}
