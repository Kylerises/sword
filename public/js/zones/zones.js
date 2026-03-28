    import { showToast } from "../utils";
    import { formatNumber } from "../utils";
    import { displayWin } from "../rssBar/rss";
    import { ressource } from "../rssBar/rss";
    import { saveStats } from "../save/save";

    // AJX display actual zone ----
    export function displayActualZone() {
        $.ajax({
            url: CONFIG.domain + 'zones/displayActualZone',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    
                    let zone = document.getElementById('actual-zone')
                    zone.textContent = 'Zone actuelle: ' + data.success;

                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX Error : ' + status + ' - ' + error);
                console.error('Response: ', xhr.responseText);
            }
        });
    }

    // AJX displayAllZones ----
     export function displayAllZones() {

        $.ajax({
            url: CONFIG.domain + 'zones/displayAllZones',
            type: 'POST',
            dataType: 'json',

            success: function(data) {

                if(data.success) {

                    ressource().then(function(rss){

                        const power = Number(rss.success.power);
                        const win = Number(rss.success.win);

                        let el = document.querySelector('.zone-items');
                        let html = '';

                        data.success.forEach(zone => {

                            let locked = '';
                            let nameColor = 'red';
                            let powerColor = 'red';
                            let bossColor = 'red';
                            let winColor = 'red';
                            let unlockBtn = '';
                            let teleportBtn = '';

                            if(zone.is_unlocked === 0){
                                locked = 'zone-locked';
                            }

                            if(power >= Number(zone.power_required) || zone.is_unlocked === 1) {
                                powerColor = 'green';
                            }

                            if(zone.boss_kill >= zone.boss_zone_kill || zone.is_unlocked === 1) {
                                bossColor = 'green';
                            }

                            if(win >= Number(zone.win_required) || zone.is_unlocked === 1) {
                                winColor = 'green';
                            }

                            if(winColor === 'green' && powerColor === 'green' && bossColor === 'green') {
                                nameColor = 'green';
                            }

                            if(zone.is_unlocked === 0 && nameColor === 'green') {
                                unlockBtn = `
                                <button class="unlock-zone" data-id="${zone.zone_id}">Unlock</button>`
                            }

                            if(zone.actual_zone !== zone.zone_id && zone.is_unlocked === 1) {
                                teleportBtn = `<button class="teleport-zone" data-id="${zone.zone_id}">Teleportation</button>`
                            }

                            html += `
                            <li class="zone-card">
                                <div class="${locked}">
                                
                                    <div class="zone-img">
                                        <img src="${CONFIG.domain}${zone.images}">
                                    </div>
                                    
                                    <div class="zone-name ${nameColor}">
                                        ${zone.name}
                                    </div>
                                </div>

                                <div class="zone-requirements">

                                    <div class="zone-req">
                                        <span class="${powerColor}">Power required: ${formatNumber(zone.power_required)}</span>
                                    </div>

                                    <div class="zone-req">
                                        <span class="${bossColor}">${zone.boss_name}: ${zone.boss_kill} / ${zone.boss_zone_kill}</span>
                                    </div>

                                    <div class="zone-req">
                                        <span class="${winColor}">Win required: ${formatNumber(zone.win_required)}</span>
                                    </div>

                                    ${teleportBtn} ${unlockBtn}

                                </div>
                            </li>`;
                        });

                        el.innerHTML = html;

                    });

                }

            }

        });

    }

    // AJX unlockZone
     export function unlockZone(zone_id) {
        $.ajax({
            url: CONFIG.domain + 'zones/unlockZone',
            type: 'POST',
            dataType: 'json',
            data: {id: zone_id},

            success: function(data) {
                if(data.success) {
                    showToast(data.success, "success");
                    displayWin();
                    displayAllZones();
                    saveStats();
                } else {
                    showToast(data.error, "error");
                }
            }
        });
    }

    // AJX teleport ----
    export function tp(zone_id) {
        $.ajax({
            url: CONFIG.domain + 'zones/tp',
            type: 'POST',
            dataType: 'json',
            data: {id: zone_id},

            success: function (data) {
                if(data.success) {
                    showToast(data.success);

                    displayAllZones();
                }
            }
        });
    }

        if(window.location.pathname.split('/').pop() == 'zones') {
        saveStats();
        displayAllZones();
    }

    if(window.location.pathname.split('/').pop() == 'game') {
        saveStats();
        displayActualZone();
    }

    // délégation btn dynamique -> unlockZone
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.unlock-zone[data-id]');
        
        if (!btn) return;

        unlockZone(btn.dataset.id);
    });

    // délégation btn dynamique -> teleport
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.teleport-zone[data-id]');
        
        if (!btn) return;

        tp(btn.dataset.id);
    });