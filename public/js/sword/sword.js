    import { formatNumber } from "../utils";
    import { saveStats } from "../save/save";
    
    // AJX display sword ----
    export function displayAllSword() {
        $.ajax({
            url: CONFIG.domain + 'sword/displayAllSword',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                if (data.success && Array.isArray(data.success)) {
                    let el = document.getElementById('sword-items');
                    let html = '';

                    data.success.forEach(sword => {

                        let isGreen = '';
                        let isActive = '';
                        let showIsActive = '';

                        let power = Number(sword.power);
                        let power_required = Number(sword.sword_power_required);

                        if(power > power_required) {
                            isGreen = 'green';
                        } else {
                            isGreen = 'red';
                        }

                        if(sword.actual_sword === sword.id) {
                            isActive = 'id="active-sword';
                            showIsActive = `<div class="equiped">Épée active</div>`;
                        } else {
                            isActive = '';
                            showIsActive = '';
                        }

                        html += `
                            <li ${isActive}>
                                <div class="sword-name">${sword.sword_name}</div>
                                <div class="sword-img">
                                    <img src="${CONFIG.domain}${sword.images}" alt="${sword.sword_name}">
                                </div>
                                <div class="sword-power">
                                    Power: +${formatNumber(sword.sword_power)}
                                </div>
                                <div class="sword-power-required ${isGreen}">
                                    Required: ${formatNumber(sword.power)} / ${formatNumber(sword.sword_power_required)} Puissance
                                </div>
                                ${showIsActive}
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

    if(window.location.pathname.split('/').pop() == 'sword') {
        saveStats();
        displayAllSword();
    }