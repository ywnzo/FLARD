var loginBtns = document.querySelectorAll('.login-btn');
var registerBtns = document.querySelectorAll('.register-btn');

var authBtnWrapper = document.getElementById('auth-btn-wrapper');

var loginForm = document.getElementById('login-form');
var registerForm = document.getElementById('register-form');

function main() {
  loginBtns.forEach(function(loginBtn) {
    loginBtn.addEventListener('click', function() {
      loginForm.style.display = 'flex';
      registerForm.style.display = 'none';
      authBtnWrapper.style.display = 'none';
    });
  });

  registerBtns.forEach(function(registerBtn) {
    registerBtn.addEventListener('click', function() {
      loginForm.style.display = 'none';
      registerForm.style.display = 'flex';
      authBtnWrapper.style.display = 'none';
    });
  });
}

main();
