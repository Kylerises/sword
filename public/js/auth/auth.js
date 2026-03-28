import { showToast } from "../utils";
    
    const btnRegister = document.getElementById("btnRegister");
    const btnLogin = document.getElementById("btnLogin");

    // REGISTRATION AJX ----
    function register(username, password) {
        $.ajax({
            url: CONFIG.domain + 'register/register',
            type: 'POST',
            dataType: 'json',
            data: {
                username: username,
                password: password
            },
            success: function(data) {
                if(data.success) {
                    showToast(data.success, 'success');
                } else {
                    showToast(data.error, 'error');
                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX Error : ' + status + ' - ' + error);
                console.error('Response: ', xhr.responseText);
            }
        });
    }

    if(btnRegister !== null) {
        // call registration on click btn ----
        btnRegister.addEventListener('click', () => {
            const username = document.getElementById("nameRegister").value;
            const password = document.getElementById("passRegister").value;

            if(username == undefined || password == undefined) {
                showToast("Vous devez entrez un nom d'utilisateur et un mot de passse", 'error');
                return;
            }

            register(username, password);
        });
    }
    

    // LOGIN AJX ----
    function Login(username, password) {
        $.ajax({
            url: CONFIG.domain + 'login/login',
            type: 'POST',
            dataType: 'json',
            data: {
                username: username,
                password: password
            },
            success: function(data) {
                if(data.success) {
                    showToast(data.success, 'success');

                    setTimeout(() => {
                        window.location.href = CONFIG.domain + 'game';
                    }, 2000);
                } else {
                    showToast(data.error, 'error');
                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX Error : ' + status + ' - ' + error);
                console.error('Response: ', xhr.responseText);
            }
        });
    }

    if(btnLogin !== null) {
        // call Login on click btn ----
        btnLogin.addEventListener('click', () => {
            const username = document.getElementById("nameLogin").value;
            const password = document.getElementById("passLogin").value;

            if(username == undefined || password == undefined) {
                showToast("Vous devez entrez un nom d'utilisateur et un mot de passse", 'error');
                return;
            }

            Login(username, password);
        });
    }