jZotune.d = {};
var URLFull, dClass='fZm', dEditor='detndad', dUrl='api/det', 
d_EM='denab7', d_EB='detable', d_EN='detor', d_AM='add-definition', d_AB='add-definition', d_AN='dador', 
is_edit='Edit?', is_loading='loading', is_loaded='loaded', is_editing='editing', is_saving='saving', is_done='done', is_error='error', is_msg=null, 
d_NA='add', d_NE='edit', d_NR='remove', d_NS='submit';
$(function(event){
	$(_isc(d_EM)).on("click", jZotune.d.xMa);
	$(_isc(d_EM)).on("click", _isc(d_EB),jZotune.d.xEd);
	
	$(_isc(d_AB)).on("click", jZotune.d.xAd);
	$(_isc(dEditor)).on("submit", 'form',false);
	$(document).on("click", _isc(dEditor)+' form input[type="submit"]', jZotune.d.xSm);
});
jZotune.d.xSm = function(event){
	var f=$(this.form),$i=f.find("input,select,button,submit,textarea"),t=f.attr('name'),a=$(this).attr('name'),d=f.serializeObject();
	$i.attr("disabled", "disabled");
	$.ajax({
		url:URLMain+dUrl,type:'POST',dataType:'json',data:{target:t,action:a,r:d},
		success:function(j){$i.removeAttr("disabled");$i.attr(j.status, j.status);},
		error:function(req, status, error){$msg = is_error;}
	});return false;
};
jZotune.d.xMa = function(event){
	var xC = $(this).attr('class').split(' '),xD = $(this).children(_isi(xC[0]));
	if ($.isNumeric(xC[0])){
		if (!xD.length) {
			$(this).append(jZotune.d.xSt(xC[0],d_EB,is_edit));
		} else {
			if(xD.is(':hidden')){
				xD.fadeIn();
			} else if ($(_isi(xC[0]), this).html() == is_edit ){
				xD.is(':visible')?xD.fadeOut(1):xD.fadeIn(1);
			} else {
				xD.fadeIn();
			}
		}
	}
}
jZotune.d.xAd = function(){
	var id = 'current', iZz=_isi(zozum),fAN=_isf(d_AN),q={'id':id};
	if(!$(iZz).length){jZotune.d.xHt('body',jZotune.d.xFo(d_AN),dEditor);} else if(!$(iZz).children(fAN).length){$(iZz).html(jZotune.d.xFo(d_AN));}
	if($(fAN).children(_isc(id)).length){
		if ($(this).attr('class').split(' ')[1] == id) {
			$tmp = $(fAN).children(_isc(id)).html();
			$(fAN).prepend($('<p>').append($tmp));
		} else {
			$(this).addClass(id);
		}
	} else {
		$(fAN).prepend($('<p>', {class:id,text:is_loading}));
		$(this).addClass(id);
		$(_isfin('edit'),fAN).remove();
		$(_isfin('remove'),fAN).remove();
		jZotune.d.xAj(q,d_AN,id);
	}return false;
}
jZotune.d.xEd = function(){
	var id=$(this).attr('id'), q={'id':id}, Ch=$(_isi(id), _isc(d_EM)), iZz=_isi(zozum), fEN=_isf(d_EN);
	if(!$(iZz).length){
		jZotune.d.xHt('body',jZotune.d.xFo(d_EN),dEditor);
	} else if(!$(iZz).children(fEN).length){
		$(iZz).html(jZotune.d.xFo(d_EN));
	}
	if($(fEN).children(_isc(id)).length){
		if(Ch.html() == is_editing){
			$(fEN).children(_isc(id)).remove();
			Ch.html(is_edit);
		} else {
			Ch.html(is_editing);
		}
	} else {
		Ch.html(is_loading);
		$(fEN).prepend($('<p>', {class:id,text:is_loading}));
		Ch.html(jZotune.d.xAj(q,d_EN,id));
	}return false;
}
jZotune.d.xSt = function(i,c,t){
	return $('<a>', {id:i,class:c,href:'#e?',text:t});
}
jZotune.d.xHt=function(where,t,mn){
	$('body').addClass(dClass);
	$(where).append($('<div>', {id:"zozum",class:mn}).append(t));
	jZotune.Actions.zoresize();
}
jZotune.d.xFo = function(n){
	return $('<form>',{action:"#",method:"post",name:n}).append($('<div>',{class:"action"}).append($('<input>',{value:d_NE,name:d_NE,type:"submit"}),$('<input>',{value:d_NA,name:d_NA,type:"submit"}),$('<input>',{value:d_NR,name:d_NR,type:"submit"})));
}
jZotune.d.xAj = function(q,fn,fi){
	$msg = is_loading;
	$dj = JSON.stringify(q);
	
	//{s:$dj}
	$.ajax({
		url: URLMain+dUrl,type:'POST',dataType:'json',async: false,data:{target:d_AN,action:d_NA,s:$dj},
		success: function(j){
			$(_isc(fi), _isf(fn)).empty();
			$.each(j.tag, function(n, f){$(_isc(fi), _isf(fn)).append($('<label>',{class:(n=='ID')?'none':n}).append($('<span>').append(n),$(f)))});
			$msg = is_loaded;
		},
		error: function(req, status, error){
			$(_isc(fi), _isf(fn)).html(error);
			$msg = is_error;
		}
	});
	return $msg;
}
$.fn.serializeObject = function()
{
  var o = {};
  var a = this.serializeArray();
  $.each(a, function() {
    if (o[this.name] !== undefined) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
    } else {
      o[this.name] = this.value || '';
    }
  });
  return o;
};