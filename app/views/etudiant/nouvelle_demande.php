<div class="page-head">
    <div>
        <p class="page-eyebrow">Formulaire Officiel</p>
        <h1>Nouvelle demande d'attestation</h1>
        <p class="page-sub">Générez votre ticket de file d'attente en sélectionnant le document souhaité.</p>
    </div>
    <a href="<?= APP_URL ?>/etudiant/mesDemandes" class="btn btn-ghost">← Annuler & Retour</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="error-list"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="two-col">
    <div class="card">
        <form method="POST" action="<?= APP_URL ?>/etudiant/nouvelleDemande">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

            <div class="form-group">
                <label for="type_id"><i class="bi bi-file-earmark-text-fill" style="color:var(--cyan)"></i> Type d'attestation demandée</label>
                <select id="type_id" name="type_id" required>
                    <option value="">— Sélectionner le type d'attestation —</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nom']) ?> (Délai moyen : <?= $t['delai_traitement_j'] ?> jours ouvrés)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="objet"><i class="bi bi-bullseye" style="color:var(--cyan)"></i> Motif ou Objet de la demande</label>
                <input type="text" id="objet" name="objet" placeholder="ex. Dossier de bourse, stage en entreprise, candidature Master..." required>
                <p class="form-hint">Précisez l'usage prévu pour votre attestation.</p>
            </div>

            <div class="form-group">
                <label for="observations"><i class="bi bi-chat-left-text-fill" style="color:var(--cyan)"></i> Observations ou remarques (Facultatif)</label>
                <textarea id="observations" name="observations" placeholder="Précisez toute information utile au bureau de la scolarité..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-send-fill"></i> Soumettre la demande & Obtenir mon ticket</button>
        </form>
    </div>

    <div class="card" style="border-color:var(--line-highlight);background:linear-gradient(135deg, rgba(15,23,42,0.9), rgba(30,41,59,0.7));">
        <h3 style="font-size:18px;margin-bottom:20px;"><i class="bi bi-signpost-split-fill" style="color:var(--cyan)"></i> Parcours du ticket en 4 étapes</h3>
        
        <div class="timeline" style="margin-top:10px;">
            <div class="timeline-item">
                <div class="timeline-date">Étape 1</div>
                <div class="timeline-label">Soumission du ticket</div>
                <div class="timeline-comment">Attribution instantanée d'un numéro unique (ex. ATT-2026-0001) au statut <strong>En attente</strong>.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-date">Étape 2</div>
                <div class="timeline-label">Prise en charge guichet</div>
                <div class="timeline-comment">L'agent vérifie votre dossier académique et passe le statut à <strong>En cours</strong>.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-date">Étape 3</div>
                <div class="timeline-label">Impression & Sceau</div>
                <div class="timeline-comment">Le document est signé et marqué comme <strong>Traitée</strong>, disponible pour retrait.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-date">Étape 4</div>
                <div class="timeline-label">Retrait physique</div>
                <div class="timeline-comment">Présentez votre reçu de ticket imprimé ou sur smartphone au guichet pour récupérer l'original.</div>
            </div>
        </div>
    </div>
</div>
