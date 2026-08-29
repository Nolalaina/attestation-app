// System JavaScript — AttestPro Queue & Certificate Portal

document.addEventListener('DOMContentLoaded', function () {
    // 1. Fermeture automatique des messages flash
    var flash = document.querySelector('.flash');
    if (flash) {
        setTimeout(function () {
            flash.style.transition = 'all .4s cubic-bezier(0.4, 0, 0.2, 1)';
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-8px)';
            setTimeout(function () { flash.remove(); }, 400);
        }, 4500);
    }

    // 2. Horloge en direct
    function updateClock() {
        var clockEl = document.getElementById('live-clock');
        if (clockEl) {
            var now = new Date();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var seconds = String(now.getSeconds()).padStart(2, '0');
            clockEl.textContent = hours + ':' + minutes + ':' + seconds;
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    // 3. Confirmation d'actions sensibles
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(el.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });

    // 4. Formulaire de statut : bascule du champ motif si "refusee"
    document.querySelectorAll('[data-statut-select]').forEach(function (select) {
        var motifBox = document.querySelector(select.getAttribute('data-statut-select'));
        if (!motifBox) return;
        var toggle = function () {
            if (select.value === 'refusee') {
                motifBox.style.display = 'block';
                motifBox.classList.add('animate-fade-in');
            } else {
                motifBox.style.display = 'none';
            }
        };
        select.addEventListener('change', toggle);
        toggle();
    });
});
