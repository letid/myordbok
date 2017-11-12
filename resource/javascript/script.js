/*
 * MyOrdbok
 */
(function($,doc){
	$.fn.MyOrdbok=function(is){
		// =require ../../../../public/script.Common.js
		fn.data.link(['api']);
		// fn.data.meta(['uid','unm']);
		var core={
			suggest:{
	      // =require script.Suggestion.js
	    },
			toggle:{
	      // =require script.Toggle.js
	    },
			word:{
	      // =require script.Word.js
	    },
			speech:function(){
				var audio = doc.createElement('audio');
				audio.src = fn.Url([fn.api,'speech',{q:core.x.parent().text(),l:core.c[1]}]);
				core.x.addClass('playing');
				audio.load();
				audio.play();
				audio.addEventListener("ended", function(){
				    //  myAudio.currentTime = 0;
				    //  console.log("ended");
						 core.x.removeClass('playing');
				});
			},
	    click:function(){
				$(doc).on('click',fn.Class('zA'), function(event){
					var x=$(this); core.x=x;
					// core.r=zj.Ad(x);
					core.c=x.attr('class').split(' ');
					// core.i=zj.Ai(x);
					coreInitiate(core.c);
					event.preventDefault();
					event.stopPropagation();
				});
	    },
	    auto:function(){
				// console.log(fn.Class('zO'));
				$(fn.Class('zO')).each(function() {
					var x=$(this); core.x=x;
					core.c=x.attr('class').split(' ');
					coreInitiate(core.c);
				});
	    },
	    img:{
	      set:function(){
	        // console.log('img set');
	      }
	    }
		};
    function coreInitiate(x) {
      if(core[x[0]] && $.isFunction(core[x[0]])) core[x[0]]();
        else if(core[x[0]] && $.isFunction(core[x[0]][x[1]])) core[x[0]][x[1]]();
					else if(core[x[0]] && $.isFunction(core[x[0]][0])) core[x[0]][0]();
    };
    $.each(is,function(i,x){coreInitiate(x.split(' '))});
	};
})(jQuery,document);
/*
(function(win,doc) {
  'use strict';
	console.log('test');
}(window,document));
*/
// $(function(){
//   $(document).MyOrdbok(['suggest ready','click','img set']);
// });
/*
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-18578545-1','auto');
ga('require', 'linkid', 'linkid.js');
ga('require', 'displayfeatures');
ga('send', 'pageview');
$(function(){
  $(document).MyOrdbok({
    Click:'click',Action:'.zA',Q:['suggest set','click','img set'],extended:'MyOrdbok'
  });
});
</script>
*/
