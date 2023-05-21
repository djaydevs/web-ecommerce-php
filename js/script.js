const toggleBtnProfile = document.querySelector('#btn-account');
const divProfile = document.querySelector('#profile');
const btnLogin = document.querySelector('#login');
const btnSignup = document.querySelector('#signup');

// Add a click event listener to the button
toggleBtnProfile.addEventListener('click', () => {
  // Toggle the visibility of the div
  if (divProfile.style.display === "none") {
    divProfile.style.display = "block";
  } else {
    divProfile.style.display = "none";
  }
});

btnLogin.addEventListener('click', () => {
  window.location.href = 'login.php';
});

btnSignup.addEventListener('click', () => {
  window.location.href = 'register.php';
});

document.querySelectorAll('input[type="number"]').forEach(numberInput => {numberInput.oninput = () =>{
  if(numberInput.value.length > numberInput.maxLength) numberInput.value = numberInput.value.slice(0, numberInput.maxLength);
  };
}); 

