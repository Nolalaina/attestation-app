<div class="page-head">
    <div>
        <p class="page-eyebrow">Guichet & Pilotage</p>
        <h1>Tableau de bord de la file d'attente</h1>
        <p class="page-sub">Vue d'ensemble de l'activité du bureau et gestion des flux d'attestation.</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="<?= APP_URL ?>/admin/ecranGuichet" target="_blank" class="btn btn-accent"><i class="bi bi-tv-fill"></i> Écran Guichet (Hall)</a>
        <a href="<?= APP_URL ?>/admin/registre" class="btn btn-primary"><i class="bi bi-journal-check"></i> Ouvrir le registre</a>
    </div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total des demandes</div>
        <div class="stat-value"><?= $total ?></div>
        <div class="stat-bar"><span style="width:100%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En attente</div>
        <div class="stat-value" style="color:var(--st-attente)"><?= $stats['en_attente'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['en_attente']/$total*100) : 0 ?>%;background:var(--st-attente)"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En cours de traitement</div>
        <div class="stat-value" style="color:var(--st-cours)"><?= $stats['en_cours'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['en_cours']/$total*100) : 0 ?>%;background:var(--st-cours)"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Prêtes pour retrait</div>
        <div class="stat-value" style="color:var(--st-traitee)"><?= $stats['traitee'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['traitee']/$total*100) : 0 ?>%;background:var(--st-traitee)"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Document Retirés</div>
        <div class="stat-value" style="color:var(--st-retiree)"><?= $stats['retiree'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['retiree']/$total*100) : 0 ?>%;background:var(--st-retiree)"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Refusées</div>
        <div class="stat-value" style="color:var(--st-refusee)"><?= $stats['refusee'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['refusee']/$total*100) : 0 ?>%;background:var(--st-refusee)"></span></div>
    </div>
</div>

<div class="section-title">
    <h2>Volume hebdomadaire des tickets</h2>
    <a href="<?= APP_URL ?>/admin/statistiques" class="btn btn-ghost btn-sm">Statistiques détaillées →</a>
</div>

<div class="card" style="margin-bottom:32px;">
    <?php if (empty($statsHebdo)): ?>
        <p style="color:var(--text-muted);margin:0;">Pas encore de données pour établir une tendance.</p>
    <?php else: ?>
        <div style="display:flex;align-items:flex-end;gap:20px;height:160px;padding-top:20px;">
            <?php
            $max = max(array_column($statsHebdo, 'total')) ?: 1;
            foreach ($statsHebdo as $s):
                $h = max(10, ($s['total'] / $max) * 120);
            ?>
            <div style="flex:1;text-align:center;">
                <div style="height:120px;display:flex;align-items:flex-end;justify-content:center;">
                    <div title="<?= $s['total'] ?> demande(s)" style="width:32px;height:<?= $h ?>px;background:var(--gradient-brand);border-radius:8px 8px 3px 3px;box-shadow:0 4px 12px rgba(6,182,212,0.3);"></div>
                </div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:8px;font-weight:600;"><?= date('d/m', strtotime($s['semaine_debut'])) ?></div>
                <div style="font-size:14px;font-weight:800;color:#fff;"><?= $s['total'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="section-title">
    <h2>Dernières demandes reçues à guichet</h2>
</div>

<?php if (empty($recentes)): ?>
    <div class="card empty-state"><div class="empty-ico"><i class="bi bi-inbox-fill"></i></div><p>Aucune demande n'a encore été soumise.</p></div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead><tr><th>N° Ticket</th><th>Étudiant</th><th>Type Attestation</th><th>Date</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($recentes as $d): ?>
                <tr>
                    <td class="mono"><?= htmlspecialchars($d['code_demande']) ?></td>
                    <td><strong><?= htmlspecialchars($d['etudiant_prenom'] . ' ' . $d['etudiant_nom']) ?></strong></td>
                    <td><?= htmlspecialchars($d['type_nom']) ?></td>
                    <td><?= date('d/m/Y', strtotime($d['date_demande'])) ?></td>
                    <td><span class="badge badge-<?= $d['statut'] ?>"><?= ucfirst(str_replace('_', ' ', $d['statut'])) ?></span></td>
                    <td>
                        <a href="<?= APP_URL ?>/admin/detail/<?= $d['id'] ?>" class="btn btn-ghost btn-sm">Traiter</a>
                        <a href="<?= APP_URL ?>/admin/ticket/<?= $d['id'] ?>" target="_blank" class="btn btn-ghost btn-sm" title="Imprimer le ticket"><i class="bi bi-printer"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
