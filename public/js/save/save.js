        import { showToast } from "../utils";
        import { savePpsAfterNewSword } from "../rssBar/rss";
        import { displayPowerPerSecond } from "../rssBar/rss";
        import { displayPower } from "../rssBar/rss";
        import { displayWin } from "../rssBar/rss";
        import { loadPower } from "../rssBar/rss";
        
        export function saveStats() {
        $.ajax({
            url: CONFIG.domain + 'ressources/saveStats',
            type: 'POST',
            dataType: 'json',

            success: function(data) {
                if(data.success) {
                   showToast(data.success, "success");
                   savePpsAfterNewSword();
                   loadPower();
                   displayPowerPerSecond();
                   displayPower();
                   displayWin();
                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX Error : ' + status + ' - ' + error);
                console.error('Response: ', xhr.responseText);
            }
        });
    }

        async function loop() {
        while (true) {
            await saveStats();
            await new Promise(resolve => setTimeout(resolve, 10000));
        }
    }

        loop();