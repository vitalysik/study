(function($) {
  $(document).ready(function() {
    var $form = $('#formreg');
    $form.find('input[name="submit"]').bind('click', function(e) {
      var is_error = false;
      $form.children().removeClass('error');
      $form.find('.error-msg').remove();

      var pass1 = $form.find('input[name="password"]');
      var pass2 = $form.find('input[name="password2"]');
      if (pass1.val() != pass2.val()) {
        is_error = true;
        pass1.after('<span class="error-msg">Password has mismatch</span>');
        pass1.addClass('error');
        pass2.addClass('error');
      }
      var login = $form.find('input[name="login"]');
      var elogin =  /^[a-zA-Zа-яА-Я]+$/;
      if (!elogin.test(login.val())) {
        is_error = true;
        login.after('<span class="error-msg">The username contains an illegal character</span>');
        login.addClass('error');
      };
      var mail = $form.find('input[name="email"]');
      var email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
      if (!email.test(mail.val())) {
        is_error = true;
        mail.after('<span class="error-msg">The e-mail address is not valid</span>');
        mail.addClass('error');
      };
      if (is_error) {
        e.preventDefault();
      }
    });
  });
})(jQuery);
