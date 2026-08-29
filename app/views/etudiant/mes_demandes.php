<div class="page-head">
    <div>
        <p class="page-eyebrow">Historique des Tickets</p>
        <h1>Mes demandes d'attestation</h1>
        <p class="page-sub">Suivez l'avancement de vos dossiers en temps réel et imprimez vos reçus de guichet.</p>
    </div>
    <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="btn btn-accent"><i class="bi bi-plus-lg"></i> Nouvelle demande</a>
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
                    <th>N° Ticket</th>
                    <th>Type d'Attestation</th>
                    <th>Objet</th>
                    <th>Date Dépôt</th>
                    <th>Retrait Prévu</th>
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
                        <div style="display:flex;gap:6px;">
                            <a href="<?= APP_URL ?>/etudiant/detail/<?= $d['id'] ?>" class="btn btn-ghost btn-sm" title="Voir les détails"><i class="bi bi-eye"></i> Détails</a>
                            <a href="<?= APP_URL ?>/etudiant/ticket/<?= $d['id'] ?>" target="_blank" class="btn btn-ghost btn-sm" title="Imprimer le reçu de ticket"><i class="bi bi-printer"></i> Ticket</a>
                            <?php if ($d['statut'] === 'en_attente'): ?>
                            <a href="<?= APP_URL ?>/etudiant/annuler/<?= $d['id'] ?>" class="btn btn-danger btn-sm" data-confirm="Annuler définitivement cette demande de ticket ?"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
