//var imageSearch;
//var q ='love';
var gimg={
	gimg:'gimg',gimgbranding:'branding',id:'wrap',gimgnav:'nav',loading:'Loading...',gimgwrap:'wrap',q:'q',search:'',
	d:zj.tag.d,im:zj.tag.img,p:zj.tag.p,a:zj.tag.a,h4:zj.tag.h4,
	load:function(){
		gimg.containar = zj.class(gimg.gimgwrap);
		gimg.navigator = zj.class(gimg.gimgnav);
		gimg.main = zj.class(gimg.gimg);
		gimg.search = $(zj.input(gimg.q)).val();
		gimg.content();
		x=new google.search.ImageSearch();
		x.setSearchCompleteCallback(this, gimg.done, null);
		//x.setRestriction(google.search.ImageSearch.RESTRICT_IMAGESIZE,google.search.ImageSearch.IMAGESIZE_SMALL);
		//x.setRestriction(google.search.ImageSearch.RESTRICT_FILETYPE,google.search.ImageSearch.FILETYPE_PNG);
		//x.setRestriction(google.search.ImageSearch.RESTRICT_IMAGETYPE,google.search.ImageSearch.IMAGETYPE_CLIPART);
		
		x.execute(gimg.search);
		google.search.ImageSearch.RESULT_CLASS;
		google.search.Search.getBranding(gimg.gimgbranding);
	},
	content:function()
	{
		$zolai = $('#content .resize .wrapper .main');
		$HTML = $(gimg.d, {class:gimg.gimg}).append(
			//$(gimg.d, {class:gimg.gimgbranding}),
			$(gimg.d, {class:gimg.gimgwrap,text:gimg.loading}),
			$(gimg.d, {class:gimg.gimgnav,text:gimg.loading}),
			$(gimg.d, {id:gimg.gimgbranding})
			);
		$zolai.append($HTML);
		//if($.fn.colorbox) $.colorbox({href:zj.Ah(q.x1),current:"Fonts {current} of {total}",width:"40%"});
		//if($.fn.colorbox) $.colorbox({rel:'gimg', transition:'none', retinaImage:true, retinaUrl:true});
	},
	done:function(){
		if (x.results && x.results.length > 0){
			var main = $(gimg.containar).empty();
			for(var i=0; i < x.results.length; i++){
				var r=x.results[i];
				console.log(r);
				$(gimg.d).append(
					$(gimg.h4, {text:r.titleNoFormatting}),
					$(gimg.a,{href:r.url,rel:'gimg',title:r.contentNoFormatting}).append(
						$(gimg.im, {src:r.tbUrl,alt:r.titleNoFormatting})
					),
					$(gimg.p, {text:r.contentNoFormatting || r.visibleUrl})
				).appendTo(main);
				//rel="prettyPhoto[gallery1]"
			}
		gimg.nav();
		//theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook
		//$("[rel^='gimg']").prettyPhoto({social_tools:false,theme:'light_square'});
		//if($.fn.colorbox) $.colorbox({href:zj.Ah(q.x1),current:"Fonts {current} of {total}",width:"40%"});
		$("[rel^='gimg']").colorbox({rel:'gimg', width:"80%",transition:'none',next:'&#8658;',previous:'&#8656;',close:'&#215;',current:'{current}/{total}'});
		}
	},
	nav:function(){
		var main = $(gimg.navigator).empty();
		for (var i = 0; i < x.cursor.pages.length; i++) {
			var page = x.cursor.pages[i];
			var pageclass= (x.cursor.currentPageIndex == i)?'cur':'';
			var pagehref = "javascript:x.gotoPage("+i+");";
			$(gimg.a,{html:page.label,class:pageclass,href:pagehref}).appendTo(main);
		}
	}
};
/*
google.load('search', '1');
google.setOnLoadCallback(gimg.load);
*/