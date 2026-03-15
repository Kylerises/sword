$(document).ready(function () {
    // CONSTANTES ---- 
    const btnRegister = document.getElementById("btnRegister")
    const btnLogin = document.getElementById("btnLogin")
    const rssBar = document.querySelector('.rss-bar')
    const backToGame = document.querySelector('.back-to-game')

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

    // redirect to game on click
    if(backToGame !== null) {
        backToGame.addEventListener('click', function () {
            window.location.href = CONFIG.domain + 'game';
        });
    }

    const menuItems = document.querySelectorAll('.hud-items li[data-link]');

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            const target = item.getAttribute('data-link');
            if(target) {
                window.location.href = CONFIG.domain + target.replace('link-', '');
            }
        });
    });
    
    
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

    // AJX display sword ----
    function displayAllSword() {
        $.ajax({
            url: CONFIG.domain + 'sword/displayAllSword',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                if (data.success && Array.isArray(data.success)) {
                    let el = document.getElementById('sword-items');
                    let html = '';

                    data.success.forEach(sword => {
                        html += `
                            <li>
                                <div class="sword-name">${sword.sword_name}</div>
                                <div class="sword-img">
                                    <img src="${CONFIG.domain}${sword.images}" alt="${sword.sword_name}">
                                </div>
                                <div class="sword-power">
                                    Puissance: +${formatNumber(sword.sword_power)}
                                </div>
                                <div class="sword-power-required">
                                    Requis: ${formatNumber(sword.sword_power_required)} Puissance
                                </div>
                            </li>
                        `;
                    });

                    el.innerHTML = html;
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }

    // AJX display boss ----
    function displayBossPerZone() {
        $.ajax({
            url: CONFIG.domain + 'boss/displayBossPerZone',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                if (data.success && Array.isArray(data.success)) {
                    let el = document.getElementById('boss-items');
                    let html = '';

                    data.success.forEach(boss => {
                        html += `
                            <li class="boss-card">
                                <div class="boss-name">${boss.boss_name}</div>

                                <div class="boss-img">
                                    <img src="${CONFIG.domain}${boss.images}" alt="${boss.boss_name}">
                                </div>

                                <div class="boss-health">
                                    <div class="boss-health-bar"></div>
                                </div>

                                <div class="boss-power-recommended">
                                    Puissance recommandée: ${formatNumber(boss.recommended_power)}
                                </div>

                                <div class="boss-power">
                                    HP: ${formatNumber(boss.boss_hp)}
                                </div>

                                <div class="boss-actions">
                                    <button class="attack-boss">Attaquer</button>
                                    <button class="stop-boss">Arrêter</button>
                                </div>
                            </li>
                        `;
                    });

                    el.innerHTML = html;
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }

    // AJX load power ----
    function loadPower() {
        $.ajax({
            url: CONFIG.domain + 'ressources/sendPowerAndPowerPerSec',
            type: 'POST',
            dataType: 'json',

            success: function(data) {

                if(data.success) {

                    actualPower = Number(data.success.power);
                    pps = Number(data.success.pps);

                    startPowerLoop();
                }

            }
        });
    }

    // start a loop increasing power each 1 second (dynamic)
    let powerLoopStarted = false;

    function startPowerLoop() {
        if (powerLoopStarted) return; // bloque les doublons
        powerLoopStarted = true;

        setInterval(() => {
            actualPower += pps;
            document.getElementById('power').textContent = 'Puissance: ' + formatNumber(actualPower);
        }, 1000);
    }

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

    // call function display once ----
    if(rssBar !== null) {
      displayPower();
      displayPowerPerSecond();
      displayWin();
      // call loadPower and start loop
      loadPower();
    }

    if(window.location.pathname.split('/').pop() == 'sword') {
        displayAllSword();
    }

    if(window.location.pathname.split('/').pop() == 'boss') {
        displayBossPerZone();
    }

    //saveStats();

    function updateBossHealth(bar, percent) {
        bar.style.width = percent + "%";
    }

});