let profile = document.querySelector('.header .profile');

document.querySelector('#user-btn').onclick = () =>{
    profile.classList.toggle('active');
}

document.querySelector('#login').onclick = () => {
    window.location.href = 'login.php';
  };

  document.querySelector('#signup').onclick = () => {
    window.location.href = 'register.php';
  };


