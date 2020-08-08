(function( $ ) {
  $( document ).ready(function() {

    $('.form-submit').on('click', function( event ) {
      event.preventDefault();
      let _this = $(this), json, error = false;
      let form  = _this.closest('form');
      let type  = form.attr('method');
      let url   = form.attr('action');
      let data  = new FormData(document.querySelector('form'));
      let emailField = form.find('input[type="email"]');

      if( ! isValidEmailAddress( emailField.val() ) ) {
        error = true;
        emailField.after('<span class="error" style="display: none; color: red; position: absolute; right: 5px; bottom: 2px;">The email address isn’t correct</span>');
        let message = form.find('.error');
        showError( message );
      }

      if( ! error ) {
        $.ajax({
          type        : type,
          url         : url,
          data        : data,
          contentType : false,
          cache       : false,
          processData : false,
          beforeSend: function() { /*preloader.show();*/ },
          success: function( data ) {
            json = JSON.parse( data );
            if( json.url ) {
              window.location.href = json.url;
            } else {
              emailField.after('<span class="error" style="display: none; color: red; position: absolute; right: 5px; bottom: 2px;">' + json.message + '</span>');
              let message = form.find('.error');
              showError( message );
            }
            // preloader.hide();
          }
        });
      }
    });

    $('.user_action').on('click', function( event ) {
      event.preventDefault();
      let _this  = $(this);
      let userId = _this.closest('tr').find('.user_id').html();
      let table  = _this.closest('table').data('table');
      $.ajax({
        type        : 'POST',
        url         : '/',
        data        : {
          action  : _this.data('action'),
          user_id : userId,
          table   : table
        },
        success: function( data ) {
          json = JSON.parse( data );
          if( json.url ) {
            window.location.href = json.url + '?userid=' + userId;
          } else {
            window.location.reload(true);
          }
        }
      });
    });

  });
})( jQuery );


// email validation
function isValidEmailAddress( emailAddress ) {
  var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
  return pattern.test(emailAddress);
}

// show error message
function showError( message ) {
  message.slideDown(400, function() {
    setTimeout(function() {
      message.slideUp(400, function() {
        message.remove();
      });
    }, 2000);
  });
}