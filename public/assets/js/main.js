// System JavaScript — AttestPro queue & certificate portal
document.addEventListener('DOMContentLoaded', function () {
    var flash = document.querySelector('.flash');
    if (flash) {
        setTimeout(function () {
            flash.style.transition = 'opacity .4s ease, transform .4s ease';
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-8px)';
            setTimeout(function () { flash.remove(); }, 400);
        }, 4500);
    }

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

    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(el.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });

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
