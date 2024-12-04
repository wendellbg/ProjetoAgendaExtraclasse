const form = document.querySelector('.login-form').addEventListener('submit', (e) =>{
    e.preventDefault();
    const login = document.querySelector('#login').value;
    const password = document.querySelector('#password').value
    if(login === 'weu' && password === '123'){
        window.location.href = '/home'
    }
    else{
        alert('login invalido!!!')
    }
})