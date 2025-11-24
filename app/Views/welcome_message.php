<h2>Liste des réservations</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Réservation</th>
            <th>Client</th>
            <th>Email</th>
            <th>Chambre</th>
            <th>Capacité</th>
            <th>Prix</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($reservations as $res): ?>
        <tr>
            <td><?= $res['res_num'] ?></td>
            <td><?= $res['cl_nom'] . ' ' . $res['cl_prenom'] ?></td>
            <td><?= $res['cl_mail'] ?></td>
            <td><?= $res['ch_numero'] ?></td>
            <td><?= $res['ch_capacite'] ?></td>
            <td><?= $res['ch_prix'] ?></td>
            <td><?= $res['res_date_debut'] ?></td>
            <td><?= $res['res_date_fin'] ?></td>
            <td><?= $res['res_montant'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
