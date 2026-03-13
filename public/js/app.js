$(document).ready(function () {
    // CONSTANTES ---- 
    const btnRegister = document.getElementById("btnRegister")
    const btnLogin = document.getElementById("btnLogin")

    document.querySelectorAll(".tab").forEach(tab => {

        tab.addEventListener("click", () => {

            document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"))
            document.querySelectorAll(".tab-content").forEach(c => c.classList.remove("active"))

            tab.classList.add("active")

            document.getElementById(tab.dataset.tab).classList.add("active")

        })
    })

    // TOAST ----
    let toastQueue = []

    function showToast(message, type = "info"){

        if(toastQueue.includes(message)) return
        toastQueue.push(message)

        const container = document.getElementById("toast-container")

        const toast = document.createElement("div")
        toast.classList.add("toast", type)
        toast.textContent = message

        container.appendChild(toast)

        setTimeout(() => {
            toast.remove()
            toastQueue = toastQueue.filter(t => t !== message)
        }, 3000)
    }
    
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
        // call Loginn on click btn ----
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
    

});