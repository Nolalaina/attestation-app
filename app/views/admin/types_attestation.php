<div class="page-head">
    <div>
        <p class="page-eyebrow">Catalogue et paramètres</p>
        <h1>Types d'attestation</h1>
        <p class="page-sub">Gérez la liste des documents délivrés par le bureau et leurs délais de traitement.</p>
    </div>
</div>

<div class="two-col">
    <div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nom du document</th><th>Délai garanti</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($types as $t): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($t['nom']) ?></strong>
                            <?php if ($t['description']): ?><br><span class="form-hint"><?= htmlspecialchars($t['description']) ?></span><?php endif; ?>
                        </td>
                        <td><span class="mono"><?= $t['delai_traitement_j'] ?> jours ouvrés</span></td>
                        <td><span class="badge <?= $t['actif'] ? 'badge-traitee' : 'badge-refusee' ?>"><?= $t['actif'] ? 'Actif' : 'Désactivé' ?></span></td>
                        <td><a href="<?= APP_URL ?>/admin/toggleType/<?= $t['id'] ?>" class="btn btn-ghost btn-sm"><?= $t['actif'] ? 'Désactiver' : 'Activer' ?></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h3>Ajouter un type d'attestation</h3>
        <form method="POST" action="<?= APP_URL ?>/admin/typesAttestation">
            <div class="form-group">
                <label for="nom">Nom de l'attestation</label>
                <input type="text" id="nom" name="nom" placeholder="ex. Attestation de réussite" required>
            </div>
            <div class="form-group">
                <label for="description">Description (facultatif)</label>
                <textarea id="description" name="description" placeholder="Description du document"></textarea>
            </div>
            <div class="form-group">
                <label for="delai">Délai de traitement estimé (jours ouvrés)</label>
                <input type="number" id="delai" name="delai" value="3" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Enregistrer le type</button>
        </form>
    </div>
</div>
