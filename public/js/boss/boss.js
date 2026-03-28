    import { formatNumber } from "../utils";
    import { showToast } from "../utils";
    import { saveStats } from "../save/save";
    
    let fightState = {
        active: false,
        start: 0
    };
    // AJX display boss ----
    export function displayBossPerZone() {
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

                                <div class="boss-power-recommended">
                                    recommended Power: ${formatNumber(boss.recommended_power)}
                                </div>

                                <div class="boss-power">
                                    HP: ${formatNumber(boss.boss_hp)}
                                </div>

                                <div class="boss-actions">
                                    <button class="attack-boss" data-boss-id="${boss.boss_id}">Attack</button>
                                    <button class="stop-boss" data-stop-id="${boss.boss_id}">Stop</button>
                                
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

    // AJX startFight ----
    export function startFight() {
        $.ajax({
            url: CONFIG.domain + 'boss/startFight',
            type: 'POST',
            dataType: 'json',

            success: function() {
                if(fightState.active) return;

                fightState.active = true;
                fightState.start = Date.now();

                showToast("Fight started");

                runTimer();
            }
        });
    }

    export function stopFight(stopId) {

        if(fightState.active === false) {
            showToast("Fight haven't start yet");
            return;
        }

        fightState.active = false;

        // AJX stopFight ----
        $.ajax({
            url: CONFIG.domain + 'boss/stopFight',
            type: 'POST',
            dataType: 'json',
            data: { id: stopId },

            success: function(data) {
                if (data.success) {
                    showToast("Fight done: boss kills: " + formatNumber(data.success.kills) + ' Wins: +' + formatNumber(data.success.wins), 'info');
                    saveStats();
                }
            }
        });
    }

    // timer ----
    function runTimer() {
        if (!fightState.active) return;
        if (!fightState.start) return;

        const now = Date.now();
        const elapsed = now - fightState.start;

        updateTimerUI(elapsed);

        requestAnimationFrame(runTimer);
    }

    // update timer ----
    function updateTimerUI(ms) {
        if (isNaN(ms)) return;

        const el = document.querySelector('#fight-timer');
        if (!el) return;

        const totalSeconds = Math.floor(ms / 1000);

        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;

        el.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    if(window.location.pathname.split('/').pop() == 'boss') {
        saveStats();
        displayBossPerZone();
    }

    // délégation btn dynamique -> atk
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.attack-boss[data-boss-id]');

        if (!btn) return;

        startFight(btn.dataset.bossId);
    });

    // délégation btn dynamique -> stop
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.stop-boss[data-stop-id]');

        if (!btn) return;

        stopFight(btn.dataset.stopId);
    });