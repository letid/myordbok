edit:function(){
  if (core.x.children().length){
    core.x.children().toggle();
  } else {
    core.x.append(
      $('<span>',{class:'icon-tag'}).on(click,function(event){
        core.admin.Id = $(this).parent().attr('id');
        if (core.admin.Id) {
          core.admin.editPanel();
        }
        event.preventDefault();
        event.stopPropagation()
      })
    );
  }
},
add:function(){
  this.Id=core.x.attr('id');
  this.editPanel();
  console.log(this.Id);
},
editContainer:function(){
  var container = $('body').children('div.editor');
  // if (container.is(":hidden"))container.fadeIn('fast');
  if (!container.length){
    container = $('<div>',{class:'editor'});
    $('body').append(container.append($('<p>',{class:'animate-spin icon-loading'})));
  }
  // return this.elementEontainer=container;
  return container;
},
editPanel:function(){
  var primary = $('body').children('div.primary'), element=this.editContainer();
  var hideElement = function(){
    element.removeAttr('style').hide();
    primary.removeAttr('style');
  };
  var showElement = function(){
    element.fadeIn('fast');
    if ($(doc).width() <= 736){
      primary.css({width:'100%',position: 'fixed'}).animate({right:'+=300px'});
      var openPrimary = function(evt){
        if (!$(evt.target).closest(element).length) {
          hideElement();
          $(doc).off(click,openPrimary);
        }
      };
      $(doc).on(click,openPrimary);
    } else {
      primary.css('margin-right','300px');
    }
  };
  if (element.find(fn.Form(this.Id)).length){
    if (element.is(':visible')){
      hideElement();
    } else {
      showElement();
    }
  } else {
    element.addClass('wait');
    $.ajax({type: "POST", url: fn.Url([fn.api,'editor']), data: {q:this.Id},dataType: 'json'}).done(function(response) {
      element.append(core.admin.editForm(response));
    }).fail(function(xhr, textStatus, error) {
      console.log(textStatus);
    }).always(function(xhr, textStatus, error) {
      element.removeClass('wait');
    });
    showElement();
  }
},
editForm:function(r){
  return $('<form>',{method:'POST',name:r.rows.id,id:'update'}).append(
    $('<div>').append(
      $('<input>',{type:'text',name:'word',value:r.rows.word})
    ),
    $('<div>').append(
      $('<span>').html('Meaning'),
      $('<textarea>',{name:'sense'}).html(r.rows.sense)
    ),
    $('<div>').append(
      $('<span>').html('Example'),
      $('<textarea>',{name:'exam'}).html(r.rows.exam)
    ),
    $('<div>').append(
      $('<span>').html('seq'),
      $('<input>',{type:'text',name:'seq',value:r.rows.seq})
    ),
    $('<div>').append(
      $('<select>',{name:'tid'}).html(this.editFormSelect(r.grammar,r.rows.tid))
    ),
    $('<p>').html(''),
    $('<div>',{class:'submit'}).append(
      $('<input>',{type:'hidden',name:'id',value:r.rows.id}),
      $('<button>',{type:'submit',id:'update',text:'Update'}),
      $('<button>',{type:'submit',id:'insert',text:'Insert'}),
      $('<button>',{type:'submit',id:'delete',text:'Delete'})
    )
  ).on('submit',this.editPost);

},
editFormSelect:function(row,tid){
  return $.map( row, function( v, k ) {
    var attr = {value:k,text:v};
    if (k == tid) {
      attr['selected']='selected';
    }
    return $('<option>',attr);
  });
},
editPost:function(event){
  event.preventDefault();
  var element = $('body').children('div.editor').addClass('wait');
  var form = $(this);
  var msgContainer = form.children('p');
  var task = $(doc.activeElement).attr('id') || form.attr('id');
  $.ajax({type: "POST", url: fn.Url([fn.api,'editor',task]), data: fn.serializeObject(form),dataType: 'json'}).done(function(response) {
    // element.append(core.admin.editForm(response));
    console.log(response);
    if (response.error){
      msgContainer.html(response.msg);
    } else {
      msgContainer.html('done');
    }
  }).fail(function(xhr, textStatus, error) {
    console.log(textStatus);
  }).always(function() {
    element.removeClass('wait');
    // console.log('wait');
  });
},
importMsgRset:function(){
  core.x.parents().parents().children().find('.msg').empty();
},
import:function(){
  this.msgContainer = core.x.parents().parents().children().find('.msg');
  if (core.x.data('task')) {
    this.importPost(core.x.removeClass('done error'));
  } else {
    core.x.html('Wait');
    this.importNext(core.x.parent().children().removeClass('done working error'),0);
  }
},
importNext: function(task,id){
  if ($(task[id]).data('task')) {
    this.importPost($(task[id])).promise().then(function() {
      if (task.length >= id) {
        core.admin.importNext(task,id+1);
      } else {
        core.x.html('Done');
      }
    });
  } else if (task.length >= id) {
    core.admin.importNext(task,id+1);
  } else {
    core.x.html('Done');
  }
},
importPost:function(i){
  return $.ajax({
    type: "GET", url: fn.Url([fn.api,'import']), data: {q:i.data('task')},dataType: 'json',
    beforeSend: function(xhr) {
      i.addClass('working');
    }
  }).done(function(response) {
    if (response.error) {
      i.addClass('error');
      core.admin.msgContainer.append($('<p>',{class:i.data('task'),text:response.msg}));
    } else {
      i.addClass('done');
    }
  }).fail(function(xhr, textStatus, error) {
    i.addClass('error');
  }).always(function(xhr, textStatus, error) {
    i.removeClass('working');
  });
}
