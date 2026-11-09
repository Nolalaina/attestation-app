<div class="page-head">
    <div>
        <p class="page-eyebrow">Formulaire officiel</p>
        <h1>Nouvelle demande d'attestation</h1>
        <p class="page-sub">Générez votre ticket en sélectionnant le document souhaité.</p>
    </div>
    <a href="<?= APP_URL ?>/etudiant/mesDemandes" class="btn btn-ghost">Annuler et retourner</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="error-list"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="two-col">
    <div class="card">
        <form method="POST" action="<?= APP_URL ?>/etudiant/nouvelleDemande">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

            <div class="form-group">
                <label for="type_id">Type d'attestation demandée</label>
                <select id="type_id" name="type_id" required>
                    <option value="">Sélectionner le type d'attestation</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nom']) ?> (délai moyen : <?= $t['delai_traitement_j'] ?> jours ouvrés)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="objet">Motif ou objet de la demande</label>
                <input type="text" id="objet" name="objet" placeholder="ex. Dossier de bourse, stage en entreprise, candidature master" required>
                <p class="form-hint">Précisez l'usage prévu pour votre attestation.</p>
            </div>

            <div class="form-group">
                <label for="observations">Observations ou remarques (facultatif)</label>
                <textarea id="observations" name="observations" placeholder="Précisez toute information utile pour le bureau de la scolarité"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Soumettre la demande et obtenir mon ticket</button>
        </form>
    </div>

    <div class="card">
        <h3>Parcours du ticket en 4 étapes</h3>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-date">Étape 1</div>
                <div class="timeline-label">Soumission du ticket</div>
                <div class="timeline-comment">Attribution instantanée d'un numéro unique, par exemple ATT-2026-0001, au statut en attente.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-date">Étape 2</div>
                <div class="timeline-label">Prise en charge au guichet</div>
                <div class="timeline-comment">L'agent vérifie votre dossier et passe le statut à en cours.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-date">Étape 3</div>
                <div class="timeline-label">Impression et visa</div>
                <div class="timeline-comment">Le document est signé et marqué comme traitée, disponible pour retrait.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-date">Étape 4</div>
                <div class="timeline-label">Retrait physique</div>
                <div class="timeline-comment">Présentez votre reçu imprimé ou sur smartphone au guichet pour récupérer l'original.</div>
            </div>
        </div>
    </div>
</div>
