help:function(){
  this.form(core.x.data('word')).appendTo(core.x);
  // console.log(core.x.data('word'));
},
suggest:function(){
  // this.form().appendTo(core.x.parent().parent());
  core.x.parent().replaceWith(this.form(core.x.data('word')));
},
form:function(word){
  return $('<form>',{method:'POST'}).append(
    $('<div>').append(
      $('<input>',{type:'text',name:'word',value:word})
    ),
    $('<div>').append(
      $('<span>').html('Meaning'),
      $('<textarea>',{name:'mean'})
    ),
    $('<div>').append(
      $('<span>').html('Example'),
      $('<textarea>',{name:'exam'})
    ),
    $('<p>').html(''),
    $('<div>',{class:'submit'}).append(
      $('<input>',{type:'submit',name:'submit',value:'Post'}),
      $('<input>',{type:'reset',value:'Reset'})
    )
    // $('<div>',{class:'cancel'}).append(
    //   $('<input>',{type:'reset',value:'Cancel'})
    // ),
  ).on('submit',this.submit);
},
// word, mean,exam, wo, wm, we,
submit:function(event){
  event.preventDefault();
  var form = $(this);
  var msgContainer = form.children('p');
  msgContainer.html('...a moment please').removeClass();
  // var msgContainer = form.parent();
  // msgContainer.html('Thank you').addClass('done');
  // msgContainer.html('fail').addClass('fail');
  // form.children('div').hide();


  var jqxhr = $.post(fn.Url([fn.api,'post']),fn.serializeObject($(this)), function() {
    // console.log( "success" );
  }).done(function(response) {
    msgContainer.html(response.msg).addClass(response.status);
    if (response.status == 'done') {
      form.children('div').hide();
    }
  }).fail(function(xhr, textStatus, error) {
    msgContainer.html(error).addClass('fail');
  }).always(function() {
  });
}
/*
var jqxhr = $.post( "example.php", function() {
  // alert( "success" );
}).done(function() {
  // alert( "second success" );
}).fail(function() {
  // alert( "error" );
}).always(function() {
  // alert( "finished" );
}).always(function() {
  // alert( "second finished" );
});
*/
