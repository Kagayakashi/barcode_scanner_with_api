$('#password_new, #password_new_confirm').on('keyup', function () {
  
  if($('#password_new').val() == $('#password_new_confirm').val()) {
    
    $('#message').html('').css('color', 'green');
    $('.password_change').prop('disabled', false);
  }
  else {
    
    $('#message').html('Новые пароли не совпадают').css('color', 'red');
    $('.password_change').prop('disabled', true);
  }
});