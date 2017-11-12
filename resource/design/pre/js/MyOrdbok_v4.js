/*
 * MyOrdbok
 * http://www.myordbok.com
 * Copyright (c) 2008 - 2014 ZOTUNE.developer
 * Author: Khen Solomon Lethil
 * Version: 1.0.17
 * Date: Sept 14, 2014
 */
(function($){
$.fn.MyOrdbok=function(is){
  var z=z||{},q=q||{},zd=$(this);
  z={
	fn:{
		xhr:function(x){if(z.xhr)$.each(z.xhr,function(k,v){x.setRequestHeader(k,v);});}
	},
	click:function(){
		zd.on(is.Click,is.Action, function(event){
			q.x1=$(this); q.r1=zj.Ad(q.x1); q.c1=zj.Ac(q.x1); q.i1=zj.Ai(q.x1);
			//if(z[q.c1[0]] && $.isFunction(z[q.c1[0]][0])) z[q.c1[0]][0](); else if($.isFunction(z.A[q.c1[0]])) z.A[q.c1[0]](); 
			
			if(z[q.c1[0]] && $.isFunction(z[q.c1[0]][q.c1[1]])) z[q.c1[0]][q.c1[1]](); 
				else if(z[q.c1[0]] && $.isFunction(z[q.c1[0]][0])) z[q.c1[0]][0](); 
			 		else if($.isFunction(z.A[q.c1[0]])) z.A[q.c1[0]](); 
			event.preventDefault();
			event.stopPropagation();
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
			if($.fn.colorbox) $.colorbox({href:zj.Ah(q.x1),current:"Fonts {current} of {total}",width:"40%"});
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
	img:{
		set:function(){
			//?key=ABQIAAAAk0-qzrfhcMoXzVpLqNNZghQFSQtheH-ugMmNUC1exYiAINr_mhQm2LEy4BlTLh51QWPBB9ckI2M0pg
			if (window.google && window.google.load){
				if($(zj.input(gimg.q)).val()) google.load("search", "1", {"callback" : gimg.load});
			}
		},
		loads:function(){
			console.log('loaded');
		},
		result:function(){
			console.log('resulted');
		}
	},
	det:{
		is:{
			add:'add',edit:'edit', remove:'remove', loading:'loading', loaded:'loaded', editing:'editing', saving:'saving', done:'done', error:'error', editor:'editor', url:'det'
		},
		0:function(){			
			if($.isNumeric(q.i1[0])){
				x=q.x1.children('a');
				var CN= q.c1;
				CN.splice(1, 0, this.is.edit);
				if(!x.length) q.x1.append($(zj.tag.a, {id:q.i1[0],href:'#',class:CN.join(' '),text:this.is.edit}));
					else if(x.is(':hidden')) x.fadeIn(1); 
						else x.fadeOut(1);

			}
		},
		add:function(){
			this.editor('current',this.is.add);
		},
		edit:function(){
			this.editor(q.i1[0],this.is.edit);
		},
		editor:function(id,action){
			var x = zj.id(zozum);
			if(!$(x).length){
				$('body').append($(zj.tag.d, {id:zozum}).append(this.form(action)));
			}else if($(x).length && $(x).find('form').attr('name') !=action){
				$(x).html(this.form(action));
			}else if($(x).find(zj.id(id)).length){
				return $(x).find(zj.id(id)).effect("highlight");
			}
			return this.load({'id':id},$(x),action);
		},
		load:function(data,x,action){
			var y=z.det.is; q.x1.html(y.loading).addClass(y.loading);
			if(action==y.add)x.find('form').find(zj.input(y.remove)+','+zj.input(y.edit)).remove();
			$.ajax({url:zj.url([api,y.url]),type:'POST',dataType:'json',async: false,data:{action:y.editor,s:JSON.stringify(data)},
				success:function(j){
					x.children('form').prepend(zj.html($(zj.tag.p,{id:j.id}),j.zj));
					q.x1.html(y.loaded).addClass(y.loaded).removeClass(y.loading);
				}, error:function(req, status, error){
					q.x1.html(y.error).addClass(y.error).removeClass(y.loading);
				}
			});
		},
		form:function(name){
			return $(zj.tag.f,{method:'post',name:name}).append($(zj.tag.d).append($(zj.tag.i,{value:this.is.edit,name:this.is.edit,type:'submit'}),$(zj.tag.i,{value:this.is.add,name:this.is.add,type:'submit'}),$(zj.tag.i,{value:this.is.remove,name:this.is.remove,type:"submit"}))).on(is.Click,'input[type=submit]', function(event){
				var f=$(this.form),i=f.find('input,select,button,submit,textarea'),t=f.attr('name'),a=$(this).attr('name'),d=zj.serializeJSON(f);
				i.attr('disabled', 'disabled');
				$.ajax({url:zj.url([api,z.det.is.url]),type:'POST',dataType:'json',data:{action:a,r:d},
					success:function(j){
						if(a==z.det.is.remove && j.msg) f.remove(); else i.removeAttr('disabled');
					}, error:function(req, status, error){
						console.log('error');
					}
				});
				return false;
			});
		}
	},
	speech:{
		0:function(){
			this.audio({l:q.c1[1],q:q.x1.text()});
		},
		audio:function(file){
			var audio = document.createElement('audio');
			audio.src = zj.url([api,'speech','?',$.param(file)]);
			audio.load();
			audio.play();
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
	  this.img.set();
	}
  }; z[0]();
}})(jQuery);
$(function(){$(document).MyOrdbok({Click:'click',Action:'.zA'});});
//$(document).ready(function(){ $(document).MyOrdbok({Click:'click',Action:'.zA'}); });