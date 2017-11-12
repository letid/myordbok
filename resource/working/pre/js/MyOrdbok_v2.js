/*
 * MyOrdbok
 * http://www.myordbok.com
 * Copyright (c) 2008 - 2014 ZOTUNE.developer
 * Author: Khen Solomon Lethil
 * Version: 1.0.12
 * Date: Set 17, 2014
 */
(function($){
$.fn.MyOrdbok=function(e){
var z = z||{}, zd=$(this);
	z={
	album:{},
	fn:{
		xhr:function(x){if(z.xhr)$.each(z.xhr,function(k,v){x.setRequestHeader(k,v);});}
	},
	Click:function(){
		/*
		zd.on(e.c,e.A, function(){
			//var x=$(this); var q={}; q.x1=x; q.r1=zj.Ad(x); q.c1=zj.Ac(x); q.i1=zj.Ai(x);
			var q={}; q.x1=$(this); q.r1=zj.Ad(q.x1); q.c1=zj.Ac(q.x1); q.i1=zj.Ai(q.x1);
			if($.isFunction(z.A[q.c1[0]])){
				z.A[q.c1[0]](q);
			}else if(z[q.c1[0]] && $.isFunction(z[q.c1[0]][0])){
				z[q.c1[0]][0](q);
			}
			return false;
		});
		*/
	},
	Action:function(){
		/*
		$("input[type=search]").focus(function() {
		  //$( this ).blur();
		  console.log('vvv');
		});
		*/
		this.suggest.set();
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
		share:function(q){
			q.x1.toggleClass(cur);
			q.x1.parents('dl').children('dd').toggle();
		},
	},
	suggest:{
		//f:'<form>',p:'<p>',i:'<input>',l:'<label>',t:'<textarea>',d:'<div>',u:'<ul>',o:'<ol>',li:'<li>',a:'<a>',s:'<span>',
		form:'form[name=search]',field:'input[name=q]',button:'input[name=search]',classIn:'in',className:'selected',
		id:'suggest',listCurrent:-1,listTotal:0,delay:0,
		//name:{tk:"TK",al:"AL",pl:"PL",ar:"AR",fa:"FA"},
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
			$input.keyup(function (e) {
				var keyCode = e.keyCode || window.event.keyCode;
				var lastVal = $(this).val();
				if(z.suggest.arrows(keyCode)) return;
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
					//$.each(j, function(i, v){ $(zj.tag.p,{text:v}).appendTo($result).mouseover(function(){ z.suggest.add(this); }); });
					/*
					$(this).text().replace(new RegExp(z.data.q, "gi"), "<b>$&</b>");
					*/
					$.each(j, function(i, v){
						$(zj.tag.p,{title:v,html:v.replace(new RegExp(q, "i"), "<b>$&</b>")}).appendTo($result).mouseover(function(){ z.suggest.add(this); });
					});
				} else {
					z.suggest.clear();
				}
			});
		},
		arrows:function(keyCode){
			if(keyCode == 40 || keyCode == 38){
				if(keyCode == 38){
					if(this.listCurrent <= 0){ this.listCurrent = this.listTotal-1; }else{ this.listCurrent--; }
				} else {
					if(this.listCurrent >= this.listTotal-1){ this.listCurrent = 0; } else { this.listCurrent++; }
				}
				$result.children().each(function(i){
					if(i == z.suggest.listCurrent) z.suggest.add(this);
				});
				return true;
			}else if(keyCode == 27){
				z.suggest.clear();
			}
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
	}
};
z.Click();
z.Action();
}})(jQuery);
$(document).ready(function(){
	$(document).MyOrdbok({c:'click',z:'#jzmp',A:'.zA'});
	//zA
});