/*
 * MyOrdbok
 * http://www.myordbok.com
 * Copyright (c) 2008 - 2014 ZOTUNE.developer
 * Author: Khen Solomon Lethil
 * Version: 1.0.12
 * Date: Set 17, 2014
 */
(function($){
$.fn.MyOrdbok=function(is){
  var z=z||{},q=q||{},zd=$(this);
  z={
	fn:{
		xhr:function(x){if(z.xhr)$.each(z.xhr,function(k,v){x.setRequestHeader(k,v);});}
	},
	click:function(){
		zd.on(is.Click,is.Action, function(){
			q.x1=$(this); q.r1=zj.Ad(q.x1); q.c1=zj.Ac(q.x1); q.i1=zj.Ai(q.x1);
			if($.isFunction(z.A[q.c1[0]])) z.A[q.c1[0]](); else if(z[q.c1[0]] && $.isFunction(z[q.c1[0]][0])) z[q.c1[0]][0]();
			event.preventDefault();
		});
	},
	M:{
		0:function(q){
			/*
			ItemsMain=$('ol.items');
			ItemsAlbum=ItemsMain.children('li.album');
			ItemsMp3=ItemsMain.children('li.mp3');
			TaskMain=$('#task');
			TaskForm=TaskMain.children('form');
			q.Editor='#editor';
			q.Status='.status';
			q.Prefix='.prefix';
			if($.isFunction(this[q.c1[1]])){
				this[q.c1[1]](q);
			}
			*/
		},
		resetEditor:function(q){
			$(q.Editor).empty();
		},
		message:function(q,msg){
			$(q.Editor).append(z.h.paragraph({text:(msg||'No directory found in this page!')}));
		}
	},	
	A:{
		Attf:function(){
			console.log('ok',zj.Ah(q.x1));
			
			//q.x1.toggleClass(cur);
			//q.x1.parents('dl').children('dd').toggle();
		}
	},
	suggest:{
		form:'form[name=search]',field:'input[name=q]',button:'input[name=search]',classIn:'in',className:'selected',
		id:'suggest',listCurrent:-1,listTotal:0,delay:0,
		set:function(q){//form,field,id
			/*
			$.listCurrent=-1;
			$.listTotal=0;
			$.delay=0;
			*/

			$form=$(this.form);
			//$field=$(this.field);
			$input=$form.find(this.field).attr('autocomplete', 'off').focus();
			//$.input.attr('autocomplete', 'off').focus();
			$form.append($(zj.tag.d,{id:this.id}));
			$result=$(zj.id(this.id));
			
			/*
			$.field.focusin(function(){
				$.form.addClass('in');
				$.result.show();
			}).focusout(function(){
				$.form.removeClass();
				$.result.hide();
			});
			*/
			$input.focusin(function(){
				$form.addClass('in');
			}).focusout(function(){
				setTimeout(function(){z.suggest.clear();},200);
			});
			$input.keyup(function (evt) {
				var e = evt||window.event;
				var lastVal = $(this).val();
				if(z.suggest.arrows(e.keyCode,e.ctrlKey||e.metaKey)) return;
				setTimeout(function(){z.suggest.listener(lastVal);},z.suggest.delay);
			});
			$(this.button).click(function(){
				this.form.submit();
			});
			//$input.blur(function(){ setTimeout(function(){z.suggest.clear();},200); });
		},
		clear:function(){
			$form.removeClass();$result.removeAttr('style');
		},
		listener:function(lastValue){
			var q = $input.val();
			if(q == '') return;
			if(lastValue != q) return;
			$.getJSON(zj.url([api,'suggest']),{q:q}, function(j){
				z.suggest.listTotal = j.length;
				if(z.suggest.listTotal > 0){
					$result.empty().show();
					//for(var i=0; i < z.suggest.listTotal; i++) $(zj.tag.p,{text:j[i]}).appendTo($result).mouseover(function(){z.suggest.add(this)});
					$.each(j, function(i, v){
						$(zj.tag.p,{title:v,html:v.replace(new RegExp(q, "i"), "<b>$&</b>")}).appendTo($result).mouseover(function(){ z.suggest.add(this); });
					});
				} else {
					z.suggest.clear();
				}
			});
		},
		arrows:function(keyCode,ctrlDown){
			if($.inArray(keyCode,[40,38]) >= 0){
				if(keyCode == 38){
					if(this.listCurrent <= 0){ this.listCurrent = this.listTotal-1; }else{ this.listCurrent--; }
				} else {
					if(this.listCurrent >= this.listTotal-1){ this.listCurrent = 0; } else { this.listCurrent++; }
				}
				$result.children().each(function(i){
					if(i == z.suggest.listCurrent) z.suggest.add(this);
				}); return true;
			}else if($.inArray(keyCode,[13,37,39,16,17]) >= 0){ return true;
			}else if(ctrlDown && $.inArray(keyCode,[67]) >= 0){ return true; //c,v,x [67,86,88]
			}else if(keyCode == 27){ $input.val(''); return true;
				}else{ this.listCurrent = -1; return false; }
		},
		add:function(x){
			//$input.val(x.childNodes[0].nodeValue);
			$input.val(zj.At($(x)));
			$(x).addClass(z.suggest.className).siblings().removeClass();
			x.className = z.suggest.className;
			z.suggest.listCurrent =$(x).index();
			$(x).click(function(e){ $form.submit(); });
		}
	},
	com:{
		error:function(l){
			console.log('error found...');
		},
		load:function(q){
		},
		submit:function(q){
		}
	},
	0:function(){
	  this.suggest.set();
	  this.click();
	}
  }; z[0]();
}})(jQuery);
$(document).ready(function(){ $(document).MyOrdbok({Click:'click',Action:'.zA'}) });
