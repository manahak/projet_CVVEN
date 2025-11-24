<h3>Réserver la chambre <?= $chambre['ch_numero'] ?></h3>

<?php if(session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Banner for messages (will be filled by JS after AJAX) -->
<div id="reservation-message" style="display:none; margin-bottom:1rem;"></div>

<form id="reservation-form" action="<?= site_url('Reservation/submit') ?>" method="post">
    <input type="hidden" name="Id_Chambre" value="<?= $chambre['Id_Chambre'] ?>">
    <div class="mb-3">
        <label>Nombre de personnes</label>
        <input type="number" name="res_nb_personnes" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Date début</label>
        <input type="datetime-local" name="res_date_debut" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Date fin</label>
        <input type="datetime-local" name="res_date_fin" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Réserver</button>
</form>

<!-- Simple confirmation modal (no external libs) -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('reservation-form');
    var modal = document.getElementById('confirm-modal');
    var content = document.getElementById('confirm-content');
    var msg = document.getElementById('reservation-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Collect values
        var fd = new FormData(form);
        var chambreNum = <?= json_encode($chambre['ch_numero']) ?>;
        var nb = fd.get('res_nb_personnes');
        var dd = fd.get('res_date_debut');
        var df = fd.get('res_date_fin');

        // Build recap HTML
        content.innerHTML = '<p><strong>Chambre :</strong> ' + chambreNum + '</p>' +
                            '<p><strong>Nombre de personnes :</strong> ' + escapeHtml(nb) + '</p>' +
                            '<p><strong>Date début :</strong> ' + escapeHtml(dd) + '</p>' +
                            '<p><strong>Date fin :</strong> ' + escapeHtml(df) + '</p>';

        // Show modal
        modal.style.display = 'flex';

        // Handle cancel
        document.getElementById('confirm-cancel').onclick = function() {
            modal.style.display = 'none';
        };

        // Handle confirm -> send AJAX
        document.getElementById('confirm-ok').onclick = function() {
            // Send form data via fetch
            fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: fd
            }).then(function(resp) {
                if (resp.headers.get('content-type') && resp.headers.get('content-type').indexOf('application/json') !== -1) {
                    return resp.json();
                }
                // fallback: reload page
                window.location.reload();
            }).then(function(data) {
                modal.style.display = 'none';
                if (!data) return;
                if (data.status && data.status === 'success') {
                    // Show thank you banner
                    msg.style.display = 'block';
                    msg.className = 'alert alert-success';
                    msg.innerText = data.message || 'Merci de votre réservation';
                    // Optionally clear form
                    form.reset();
                } else {
                    msg.style.display = 'block';
                    msg.className = 'alert alert-danger';
                    msg.innerText = data.message || 'Une erreur est survenue';
                }
            }).catch(function(err) {
                modal.style.display = 'none';
                msg.style.display = 'block';
                msg.className = 'alert alert-danger';
                msg.innerText = 'Erreur réseau ou serveur';
            });
        };
    });

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>\"'`]/g, function (s) {
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;","`":"&#96;"}[s];
        });
    }
});
</script>
