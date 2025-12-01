<?= view('templates/header') ?>

<h3>Réserver la chambre <?= $chambre['ch_numero'] ?></h3>

<?php if(session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Banner for messages -->
<div id="reservation-message" style="display:none; margin-bottom:1rem;"></div>

<form id="reservation-form" action="<?= site_url('Reservation/submit') ?>" method="post">
    <input type="hidden" name="Id_Chambre" value="<?= $chambre['Id_Chambre'] ?>">
    
    <div class="mb-3">
        <label>Nombre de personnes</label>
        <input type="number" name="res_nb_personnes" class="form-control" required min="1">
    </div>

    <!-- Date Selection with Calendar -->
    <div class="mb-3">
        <label>Sélectionner les dates</label>
        
        <!-- Toggle for Start/End date -->
        <div class="btn-group mb-2" role="group">
            <input type="radio" class="btn-check" name="date-mode" id="mode-start" value="start" checked>
            <label class="btn btn-outline-primary" for="mode-start">Date de début</label>
            
            <input type="radio" class="btn-check" name="date-mode" id="mode-end" value="end">
            <label class="btn btn-outline-primary" for="mode-end">Date de fin</label>
        </div>

        <!-- Calendar -->
        <div id="calendar-container" style="border:1px solid #ddd; padding:1rem; border-radius:4px; max-width:400px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <button type="button" id="prev-month" class="btn btn-sm btn-outline-secondary">← Précédent</button>
                <h5 id="month-year" style="margin:0;"></h5>
                <button type="button" id="next-month" class="btn btn-sm btn-outline-secondary">Suivant →</button>
            </div>
            <div id="calendar-grid" style="display:grid; grid-template-columns:repeat(7, 1fr); gap:4px;"></div>
        </div>

        <!-- Selected dates display and reset -->
        <div style="margin-top:1rem;">
            <p><strong>Date début :</strong> <span id="selected-start">Non sélectionnée</span></p>
            <p><strong>Date fin :</strong> <span id="selected-end">Non sélectionnée</span></p>
            <p><strong>Durée :</strong> <span id="selected-duration">-</span> nuit(s)</p>
            <p><strong>Prix par nuit :</strong> <?= number_format($chambre['ch_prix'], 2, ',', ' ') ?> €</p>
            <p><strong>Prix total :</strong> <span id="selected-price" style="font-size:1.2em; font-weight:bold; color:#28a745;">0,00 €</span></p>
            <button type="button" id="reset-dates" class="btn btn-sm btn-warning mt-2">Réinitialiser les dates</button>
        </div>
    </div>

    <!-- Hidden inputs for dates -->
    <input type="hidden" name="res_date_debut" id="input-start" required>
    <input type="hidden" name="res_date_fin" id="input-end" required>

    <button type="submit" class="btn btn-success">Réserver</button>
</form>

<!-- Confirmation Modal -->
<div id="confirm-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); align-items:center; justify-content:center; z-index:1000;">
    <div style="background:#fff; padding:1.25rem; max-width:520px; width:95%; border-radius:6px; box-shadow:0 6px 18px rgba(0,0,0,0.2);">
        <h4>Récapitulatif de la réservation</h4>
        <div id="confirm-content" style="margin:0.75rem 0;"></div>
        <div style="text-align:right;">
            <button id="confirm-cancel" class="btn btn-secondary" style="margin-right:0.5rem;">Annuler</button>
            <button id="confirm-ok" class="btn btn-primary">Confirmer</button>
        </div>
    </div>
</div>

<style>
    .calendar-day {
        padding: 8px 4px;
        text-align: center;
        border: 1px solid #eee;
        cursor: pointer;
        user-select: none;
        border-radius: 4px;
        font-size: 0.85rem;
    }
    .calendar-day:hover:not(.disabled):not(.weekend-header) {
        background-color: #e9ecef;
    }
    .calendar-day.disabled {
        background-color: #f0f0f0;
        color: #999;
        cursor: not-allowed;
    }
    .calendar-day.selected {
        background-color: #0d6efd;
        color: white;
    }
    .calendar-day.in-range {
        background-color: #cfe2ff;
    }
    .calendar-day.weekend-header {
        font-weight: bold;
        text-align: center;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chambreId = <?= json_encode($chambre['Id_Chambre']) ?>;
    const apiUrl = <?= json_encode(site_url('Reservation/getReservedDates/')) ?>;
    
    let currentDate = new Date();
    let selectedStart = null;
    let selectedEnd = null;
    let reservedDates = [];
    let dateMode = 'start'; // 'start' or 'end'

    // Fetch reserved dates
    fetch(apiUrl + chambreId)
        .then(r => r.json())
        .then(data => {
            reservedDates = data.reserved || [];
            renderCalendar();
        })
        .catch(() => {
            console.warn('Could not fetch reserved dates');
            renderCalendar();
        });

    // Toggle mode
    document.querySelectorAll('input[name="date-mode"]').forEach(el => {
        el.addEventListener('change', function(e) {
            dateMode = e.target.value;
            renderCalendar();
        });
    });

    // Reset dates button
    document.getElementById('reset-dates').addEventListener('click', function(e) {
        e.preventDefault();
        selectedStart = null;
        selectedEnd = null;
        updateDisplay();
        renderCalendar();
    });

    // Month navigation
    document.getElementById('prev-month').addEventListener('click', function(e) {
        e.preventDefault();
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('next-month').addEventListener('click', function(e) {
        e.preventDefault();
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Update header
        const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                           'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        document.getElementById('month-year').textContent = monthNames[month] + ' ' + year;

        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const grid = document.getElementById('calendar-grid');
        grid.innerHTML = '';

        // Weekday headers
        const weekdays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        weekdays.forEach(day => {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day weekend-header';
            dayEl.textContent = day;
            dayEl.style.fontWeight = 'bold';
            grid.appendChild(dayEl);
        });

        // Empty cells before month starts (adjust for Monday = 0)
        const adjustedFirstDay = (firstDay === 0 ? 6 : firstDay - 1);
        for (let i = 0; i < adjustedFirstDay; i++) {
            const emptyEl = document.createElement('div');
            grid.appendChild(emptyEl);
        }

        // Days of month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day';
            dayEl.textContent = day;

            const date = new Date(year, month, day);
            date.setHours(0, 0, 0, 0);
            const dateStr = formatDate(date);

            // Check if disabled (past or reserved)
            const isPast = date < today;
            const isReserved = reservedDates.includes(dateStr);
            const isDisabled = isPast || isReserved;

            // Check if selected or in range
            const isStart = selectedStart && formatDate(selectedStart) === dateStr;
            const isEnd = selectedEnd && formatDate(selectedEnd) === dateStr;
            const isInRange = selectedStart && selectedEnd && date > selectedStart && date < selectedEnd;

            if (isDisabled) {
                dayEl.classList.add('disabled');
            } else {
                dayEl.addEventListener('click', function() {
                    selectDate(date);
                });
            }

            if (isStart || isEnd) {
                dayEl.classList.add('selected');
            } else if (isInRange) {
                dayEl.classList.add('in-range');
            }

            grid.appendChild(dayEl);
        }
    }

    function selectDate(date) {
        if (dateMode === 'start') {
            selectedStart = new Date(date);
            // Reset end if before start
            if (selectedEnd && selectedStart > selectedEnd) {
                selectedEnd = null;
            }
        } else {
            if (!selectedStart) {
                alert('Veuillez d\'abord sélectionner une date de début');
                return;
            }
            if (date <= selectedStart) {
                alert('La date de fin doit être après la date de début');
                return;
            }
            selectedEnd = new Date(date);
        }

        updateDisplay();
        renderCalendar();
    }

    function updateDisplay() {
        document.getElementById('selected-start').textContent = selectedStart ? formatDate(selectedStart) : 'Non sélectionnée';
        document.getElementById('selected-end').textContent = selectedEnd ? formatDate(selectedEnd) : 'Non sélectionnée';
        
        // Calculate duration and price
        let duration = 0;
        let totalPrice = 0;
        const pricePerNight = <?= json_encode((float)$chambre['ch_prix']) ?>;
        
        if (selectedStart && selectedEnd) {
            const diffTime = Math.abs(selectedEnd - selectedStart);
            duration = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            totalPrice = duration * pricePerNight;
        }
        
        document.getElementById('selected-duration').textContent = duration;
        document.getElementById('selected-price').textContent = totalPrice.toFixed(2).replace('.', ',') + ' €';
        
        if (selectedStart) {
            document.getElementById('input-start').value = selectedStart.toISOString().split('T')[0] + 'T00:00:00';
        }
        if (selectedEnd) {
            document.getElementById('input-end').value = selectedEnd.toISOString().split('T')[0] + 'T23:59:59';
        }
    }

    function formatDate(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    // Handle form submission
    const form = document.getElementById('reservation-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!selectedStart || !selectedEnd) {
            alert('Veuillez sélectionner les dates de début et fin');
            return;
        }

        // Show confirmation modal
        const nb = form.querySelector('input[name="res_nb_personnes"]').value;
        const chambreNum = <?= json_encode($chambre['ch_numero']) ?>;
        const pricePerNight = <?= json_encode((float)$chambre['ch_prix']) ?>;
        const diffTime = Math.abs(selectedEnd - selectedStart);
        const duration = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const totalPrice = duration * pricePerNight;
        
        document.getElementById('confirm-content').innerHTML =
            '<p><strong>Chambre :</strong> ' + chambreNum + '</p>' +
            '<p><strong>Nombre de personnes :</strong> ' + escapeHtml(nb) + '</p>' +
            '<p><strong>Date début :</strong> ' + formatDate(selectedStart) + '</p>' +
            '<p><strong>Date fin :</strong> ' + formatDate(selectedEnd) + '</p>' +
            '<p><strong>Durée :</strong> ' + duration + ' nuit(s)</p>' +
            '<p style="font-size:1.1em;"><strong>Prix total :</strong> ' + totalPrice.toFixed(2).replace('.', ',') + ' €</p>';

        document.getElementById('confirm-modal').style.display = 'flex';

        document.getElementById('confirm-cancel').onclick = function() {
            document.getElementById('confirm-modal').style.display = 'none';
        };

        document.getElementById('confirm-ok').onclick = function() {
            const fd = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: fd
            }).then(r => {
                if (r.headers.get('content-type') && r.headers.get('content-type').indexOf('application/json') !== -1) {
                    return r.json();
                }
                return null;
            }).then(data => {
                document.getElementById('confirm-modal').style.display = 'none';
                if (!data) {
                    window.location.reload();
                    return;
                }
                if (data.status === 'success') {
                    // Scroll to top
                    window.scrollTo(0, 0);
                    
                    // Show thank you message at top
                    const msg = document.getElementById('reservation-message');
                    msg.style.display = 'block';
                    msg.className = 'alert alert-success';
                    msg.innerHTML = '<h4 style="margin:0;">✓ Merci de votre réservation !</h4><p style="margin:0.5rem 0 0 0;">Un récapitulatif a été envoyé à votre adresse email. Votre numéro de réservation est : <strong>' + escapeHtml(data.res_num || '') + '</strong></p>';
                    
                    // Refresh calendar to show new reservation as grayed out
                    setTimeout(() => {
                        fetch(apiUrl + chambreId)
                            .then(r => r.json())
                            .then(d => {
                                reservedDates = d.reserved || [];
                                renderCalendar();
                            });
                    }, 500);
                    
                    // Reset form
                    form.reset();
                    selectedStart = null;
                    selectedEnd = null;
                    updateDisplay();
                } else {
                    const msg = document.getElementById('reservation-message');
                    msg.style.display = 'block';
                    msg.className = 'alert alert-danger';
                    msg.innerHTML = '<strong>Erreur :</strong> ' + escapeHtml(data.message || 'Une erreur est survenue');
                }
            }).catch(err => {
                document.getElementById('confirm-modal').style.display = 'none';
                console.error(err);
                const msg = document.getElementById('reservation-message');
                msg.style.display = 'block';
                msg.className = 'alert alert-danger';
                msg.innerHTML = '<strong>Erreur réseau :</strong> Impossible de traiter la réservation';
            });
        };
    });

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>"'`]/g, s => ({
            '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;","`":"&#96;"
        }[s]));
    }
});
</script>
