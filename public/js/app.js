$(document).ready(function () {
    // CONSTANTES ---- 
    const backToGame = document.querySelector('.back-to-game');
    const menuItems = document.querySelectorAll('.hud-items li[data-link]');

    document.querySelectorAll(".tab").forEach(tab => {

        tab.addEventListener("click", () => {

            document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"))
            document.querySelectorAll(".tab-content").forEach(c => c.classList.remove("active"))

            tab.classList.add("active")

            document.getElementById(tab.dataset.tab).classList.add("active")

        });
    })

    // redirect to game on click
    if(backToGame !== null) {
        backToGame.addEventListener('click', function () {
            window.location.href = CONFIG.domain + 'game';
        });
    }

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            const target = item.getAttribute('data-link');
            if(target) {
                window.location.href = CONFIG.domain + target.replace('link-', '');
            }
        });
    });
});