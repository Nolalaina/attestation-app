<div class="page-head">
    <div>
        <p class="page-eyebrow">Registre Général</p>
        <h1>Registre des demandes & tickets</h1>
        <p class="page-sub"><?= $totalResultats ?> demande(s) correspondant à vos critères de recherche.</p>
    </div>
    <a href="<?= APP_URL ?>/admin/ecranGuichet" target="_blank" class="btn btn-accent"><i class="bi bi-tv-fill"></i> Écran Guichet (Hall)</a>
</div>

<form method="GET" action="<?= APP_URL ?>/admin/registre" class="filter-bar">
    <div class="form-group">
        <label for="q">Recherche rapide</label>
        <input type="text" id="q" name="q" placeholder="Nom, matricule, N° ticket..." value="<?= htmlspecialchars($filters['q']) ?>">
    </div>
    <div class="form-group">
        <label for="statut">Statut</label>
        <select id="statut" name="statut">
            <option value="">Tous les statuts</option>
            <?php foreach (['en_attente'=>'En attente','en_cours'=>'En cours','traitee'=>'Traitée','refusee'=>'Refusée','retiree'=>'Retirée'] as $k=>$v): ?>
                <option value="<?= $k ?>" <?= $filters['statut'] === $k ? 'selected' : '' ?>><?= $v ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="type_id">Type d'attestation</label>
        <select id="type_id" name="type_id">
            <option value="">Tous les types</option>
            <?php foreach ($types as $t): ?>
                <option value="<?= $t['id'] ?>" <?= (string)$filters['type_id'] === (string)$t['id'] ? 'selected' : '' ?>><?= htmlspecialchars($t['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="date_debut">Du</label>
        <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($filters['date_debut']) ?>">
    </div>
    <div class="form-group">
        <label for="date_fin">Au</label>
        <input type="date" id="date_fin" name="date_fin" value="<?= htmlspecialchars($filters['date_fin']) ?>">
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i> Filtrer</button>
    <a href="<?= APP_URL ?>/admin/registre" class="btn btn-ghost">Réinitialiser</a>
</form>

<?php if (empty($demandes)): ?>
    <div class="card empty-state"><div class="empty-ico"><i class="bi bi-search"></i></div><p>Aucune demande ne correspond à ces critères.</p></div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>N° Ticket</th><th>Étudiant</th><th>Matricule</th><th>Type</th><th>Date Dépôt</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $d): ?>
                <tr>
                    <td class="mono"><?= htmlspecialchars($d['code_demande']) ?></td>
                    <td><strong><?= htmlspecialchars($d['etudiant_prenom'] . ' ' . $d['etudiant_nom']) ?></strong></td>
                    <td class="mono"><?= htmlspecialchars($d['matricule']) ?></td>
                    <td><?= htmlspecialchars($d['type_nom']) ?></td>
                    <td><?= date('d/m/Y', strtotime($d['date_demande'])) ?></td>
                    <td><span class="badge badge-<?= $d['statut'] ?>"><?= ucfirst(str_replace('_', ' ', $d['statut'])) ?></span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="<?= APP_URL ?>/admin/detail/<?= $d['id'] ?>" class="btn btn-ghost btn-sm">Ouvrir</a>
                            <a href="<?= APP_URL ?>/admin/ticket/<?= $d['id'] ?>" target="_blank" class="btn btn-ghost btn-sm" title="Imprimer Ticket"><i class="bi bi-printer"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <?php $qs = array_merge($filters, ['page' => $p]); ?>
            <?php if ($p === $page): ?>
                <span class="current"><?= $p ?></span>
            <?php else: ?>
                <a href="?<?= http_build_query($qs) ?>"><?= $p ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
