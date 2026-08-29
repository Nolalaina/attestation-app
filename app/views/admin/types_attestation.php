<div class="page-head">
    <div>
        <p class="page-eyebrow">Catalogue & Paramètres</p>
        <h1>Types d'attestation</h1>
        <p class="page-sub">Gérez la liste des documents délivrés par le bureau et leurs délais de traitement.</p>
    </div>
</div>

<div class="two-col">
    <div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nom du document</th><th>Délai Garanti</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($types as $t): ?>
                    <tr>
                        <td>
                            <strong style="font-size:15px;"><?= htmlspecialchars($t['nom']) ?></strong>
                            <?php if ($t['description']): ?><br><span style="color:var(--text-muted);font-size:13px;"><?= htmlspecialchars($t['description']) ?></span><?php endif; ?>
                        </td>
                        <td><span class="mono"><?= $t['delai_traitement_j'] ?> j. ouvrés</span></td>
                        <td><span class="badge <?= $t['actif'] ? 'badge-traitee' : 'badge-refusee' ?>"><?= $t['actif'] ? 'Actif' : 'Désactivé' ?></span></td>
                        <td><a href="<?= APP_URL ?>/admin/toggleType/<?= $t['id'] ?>" class="btn btn-ghost btn-sm"><?= $t['actif'] ? 'Désactiver' : 'Activer' ?></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h3 style="font-size:16px;margin-bottom:16px;"><i class="bi bi-plus-circle-fill" style="color:var(--cyan)"></i> Ajouter un type d'attestation</h3>
        <form method="POST" action="<?= APP_URL ?>/admin/typesAttestation">
            <div class="form-group">
                <label for="nom">Nom de l'attestation</label>
                <input type="text" id="nom" name="nom" placeholder="ex. Attestation de Réussite" required>
            </div>
            <div class="form-group">
                <label for="description">Description (facultatif)</label>
                <textarea id="description" name="description" placeholder="Description du document..."></textarea>
            </div>
            <div class="form-group">
                <label for="delai">Délai de traitement estimé (jours ouvrés)</label>
                <input type="number" id="delai" name="delai" value="3" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-check-lg"></i> Enregistrer le type</button>
        </form>
    </div>
</div>
