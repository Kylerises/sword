    import { formatNumber } from "../utils";
    import { showToast } from "../utils";
    
    const rssBar = document.querySelector('.rss-bar');

    // AJX display power per second
    export function displayPowerPerSecond() {
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
    export function displayPower() {
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

    // AJX display win
    export function displayWin() {
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

        // AJX update PPS after new Sword
    export function savePpsAfterNewSword(){
        $.ajax({
            url: CONFIG.domain + 'ressources/savePpsAfterNewSword',
            type: 'POST',
            dataType: 'json',

            success: function(data) {
                if(data.success) {
                    showToast(data.success);
                    displayPowerPerSecond();
                }
            }
        })
    }

    // AJX resource Promise to simplify
    export function ressource() {
        return $.ajax({
            url: CONFIG.domain + 'ressources/ressource',
            type: 'POST',
            dataType: 'json'
        });
    }

        // AJX load power
    export function loadPower() {
        $.ajax({
            url: CONFIG.domain + 'ressources/sendPowerAndPowerPerSec',
            type: 'POST',
            dataType: 'json',

            success: function(data) {

                if(data.success) {

                    let actualPower = Number(data.success.power);
                    let pps = Number(data.success.pps);
                    
                    startPowerLoop(actualPower, pps);
                }

            }
        });
    }

        // start a loop increasing power each 1 second (dynamic)
    let powerLoopStarted = false;

    function startPowerLoop(actualPower, pps) {
        if (powerLoopStarted) return;
        powerLoopStarted = true;

        setInterval(() => {
            actualPower += pps;
            document.getElementById('power').textContent = 'Puissance: ' + formatNumber(actualPower);
        }, 1000);
    }

    // call function display once ----
    if(rssBar !== null) {
      displayPower();
      displayPowerPerSecond();
      displayWin();
      // call loadPower and start loop
      loadPower();
    }