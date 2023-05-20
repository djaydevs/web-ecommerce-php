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

document.querySelectorAll('input[type="number"]').forEach(numberInput => {numberInput.oninput = () =>{
  if(numberInput.value.length > numberInput.maxLength) numberInput.value = numberInput.value.slice(0, numberInput.maxLength);
  };
}); 

