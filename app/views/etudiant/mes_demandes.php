<div class="page-head">
    <div>
        <p class="page-eyebrow">Historique des tickets</p>
        <h1>Mes demandes d'attestation</h1>
        <p class="page-sub">Suivez l'avancement de vos dossiers et imprimez vos reçus de guichet.</p>
    </div>
    <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="btn btn-accent">Nouvelle demande</a>
</div>

<?php if (empty($demandes)): ?>
    <div class="card empty-state">
        <div class="empty-ico"><i class="bi bi-ticket-detailed"></i></div>
        <p>Vous n'avez encore soumis aucune demande d'attestation.</p>
        <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="btn btn-accent">Faire ma première demande</a>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>N° ticket</th>
                    <th>Type d'attestation</th>
                    <th>Objet</th>
                    <th>Date de dépôt</th>
                    <th>Retrait prévu</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $d): ?>
                <tr>
                    <td class="mono"><?= htmlspecialchars($d['code_demande']) ?></td>
                    <td><strong><?= htmlspecialchars($d['type_nom']) ?></strong></td>
                    <td><?= htmlspecialchars($d['objet']) ?></td>
                    <td><?= date('d/m/Y', strtotime($d['date_demande'])) ?></td>
                    <td><?= $d['date_prevue_retrait'] ? date('d/m/Y', strtotime($d['date_prevue_retrait'])) : '—' ?></td>
                    <td><span class="badge badge-<?= $d['statut'] ?>"><?= ucfirst(str_replace('_', ' ', $d['statut'])) ?></span></td>
                    <td>
                        <div class="col-actions">
                            <a href="<?= APP_URL ?>/etudiant/detail/<?= $d['id'] ?>" class="btn btn-ghost btn-sm" title="Voir les détails">Détails</a>
                            <a href="<?= APP_URL ?>/etudiant/ticket/<?= $d['id'] ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-sm" title="Imprimer le reçu de ticket">Ticket</a>
                            <?php if ($d['statut'] === 'en_attente'): ?>
                            <a href="<?= APP_URL ?>/etudiant/annuler/<?= $d['id'] ?>" class="btn btn-danger btn-sm" data-confirm="Annuler définitivement cette demande ?">Annuler</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
