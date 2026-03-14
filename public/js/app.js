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

    // Function for formatted number into human readable format ----
    function formatNumber(number) {

        number = Number(number)

        const suffixes = ['', 'K', 'M', 'B', 'T', 'Qa', 'Qi', 'Sx', 'Sp', 'Oc', 'No'];

        let i = 0;

        while (number >= 1000 && i < suffixes.length - 1) {
            number = number / 1000;
            i++;
        }

        return number.toFixed(2).replace(/\.00$/, '') + suffixes[i];
    }

    // AJX display power per second ----
    function displayPowerPerSecond() {
        $.ajax({
            url: CONFIG.domain + 'ressources/displayPowerPerSecond',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    let powerPerSecond = document.getElementById('power_per_second')
                    powerPerSecond.textContent = 'Puissance par seconde: ' + formatNumber(data.success);

                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX Error : ' + status + ' - ' + error);
                console.error('Response: ', xhr.responseText);
            }
        });
    }

    // AJX display power ----
    function displayPower() {
        $.ajax({
            url: CONFIG.domain + 'ressources/displayPower',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    let power = document.getElementById('power')
                    power.textContent = 'Puissance: ' + formatNumber(data.success);

                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX Error : ' + status + ' - ' + error);
                console.error('Response: ', xhr.responseText);
            }
        });
    }

    // AJX display win ----
    function displayWin() {
        $.ajax({
            url: CONFIG.domain + 'ressources/displayWin',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    let win = document.getElementById('win')
                    win.textContent = 'Victoires: ' + formatNumber(data.success);

                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX Error : ' + status + ' - ' + error);
                console.error('Response: ', xhr.responseText);
            }
        });
    }

    // call function display once ----
    displayPower();
    displayPowerPerSecond()
    displayWin()

    // AJX load power ----
    function loadPower() {
        $.ajax({
            url: CONFIG.domain + 'ressources/sendPowerAndPowerPerSec',
            type: 'POST',
            dataType: 'json',

            success: function(data) {

                if(data.success) {

                    actualPower = parseInt(data.success.power);
                    pps = parseInt(data.success.pps);

                    startPowerLoop();
                }

            }
        });
    }

    // start a loop increasing power each 1 second (dynamic)
    function startPowerLoop() {

        setInterval(() => {

            actualPower += pps;

            document.getElementById('power').textContent =
                'Puissance: ' + formatNumber(actualPower);

        }, 1000);

    }

    // call loadPower and start loop
    loadPower();

    function saveStats() {
        $.ajax({
            url: CONFIG.domain + 'ressources/saveStats',
            type: 'POST',
            dataType: 'json',

            success: function(data) {
                if(data.success) {
                   showToast(data.success, "success");
                   displayPower();
                   loadPower();
                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX Error : ' + status + ' - ' + error);
                console.error('Response: ', xhr.responseText);
            }
        });
    }

    // call save for test REMOVE AFTER
    saveStats();
});