<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AttestPro, demande et suivi des attestations administratives pour les étudiants.">
    <title><?= APP_NAME ?> | Gestion des attestations et file d'attente</title>
    <link rel="preconnect" href="https://api.fontshare.com">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@400,500,600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body class="<?= Auth::isAdmin() ? 'is-admin' : 'is-etudiant' ?>">
<a class="visually-hidden" href="#contenu">Aller au contenu</a>
<?php if (Auth::check()) {
    $currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $isActive = function($route) use ($currentUri) {
        $path = '/' . ltrim($route, '/');
        return ($currentUri === $path || str_starts_with($currentUri, $path . '/')) ? 'active' : '';
    };
?>
<div class="app-shell">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
            <div class="brand-info">
                <span class="brand-name"><?= APP_NAME ?></span>
                <span class="brand-tag">File d'attente et attestations</span>
            </div>
        </div>

        <?php if (Auth::isAdmin()) { ?>
        <nav class="sidebar-nav" aria-label="Administration">
            <div class="nav-section-title">Pilotage et guichet</div>
            <a href="<?= APP_URL ?>/admin/dashboard" class="nav-link <?= $isActive('/admin/dashboard') ?>">
                <i class="bi bi-grid-1x2-fill nav-ico"></i> <span>Tableau de bord</span>
            </a>
            <a href="<?= APP_URL ?>/admin/registre" class="nav-link <?= $isActive('/admin/registre') ?>">
                <i class="bi bi-card-checklist nav-ico"></i> <span>Registre des demandes</span>
            </a>
            <a href="<?= APP_URL ?>/admin/statistiques" class="nav-link <?= $isActive('/admin/statistiques') ?>">
                <i class="bi bi-bar-chart-line-fill nav-ico"></i> <span>Statistiques</span>
            </a>
            <a href="<?= APP_URL ?>/admin/ecranGuichet" target="_blank" rel="noopener" class="nav-link">
                <i class="bi bi-tv-fill nav-ico"></i> <span>Écran guichet</span>
            </a>
            <div class="nav-section-title">Catalogue</div>
            <a href="<?= APP_URL ?>/admin/typesAttestation" class="nav-link <?= $isActive('/admin/typesAttestation') ?>">
                <i class="bi bi-folder-symlink-fill nav-ico"></i> <span>Types d'attestation</span>
            </a>
        </nav>
        <?php } else { ?>
        <nav class="sidebar-nav" aria-label="Étudiant">
            <div class="nav-section-title">Espace étudiant</div>
            <a href="<?= APP_URL ?>/etudiant/dashboard" class="nav-link <?= $isActive('/etudiant/dashboard') ?>">
                <i class="bi bi-speedometer2 nav-ico"></i> <span>Tableau de bord</span>
            </a>
            <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="nav-link <?= $isActive('/etudiant/nouvelleDemande') ?>">
                <i class="bi bi-plus-circle-fill nav-ico"></i> <span>Nouvelle demande</span>
            </a>
            <a href="<?= APP_URL ?>/etudiant/mesDemandes" class="nav-link <?= $isActive('/etudiant/mesDemandes') ?>">
                <i class="bi bi-journal-text nav-ico"></i> <span>Mes demandes</span>
            </a>
            <div class="nav-section-title">Profil</div>
            <a href="<?= APP_URL ?>/etudiant/profil" class="nav-link <?= $isActive('/etudiant/profil') ?>">
                <i class="bi bi-person-badge-fill nav-ico"></i> <span>Mon profil</span>
            </a>
        </nav>
        <?php } ?>

        <div class="sidebar-footer">
            <div class="user-chip">
                <div class="user-avatar"><?= strtoupper(substr(Auth::fullName(), 0, 1)) ?></div>
                <div class="user-meta">
                    <span class="user-name"><?= htmlspecialchars(Auth::fullName()) ?></span>
                    <span class="user-role"><?= Auth::isAdmin() ? 'Agent administratif' : 'Étudiant' ?></span>
                </div>
            </div>
            <a href="<?= APP_URL ?>/auth/logout" class="logout-link" title="Se déconnecter" aria-label="Se déconnecter">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </aside>

    <main class="main-content" id="contenu">
        <header class="topbar">
            <div class="topbar-title">
                <h1><?= Auth::isAdmin() ? 'Espace administratif' : 'Portail étudiant' ?></h1>
                <p class="topbar-sub">Suivi en temps réel des demandes d'attestations</p>
            </div>
            <div class="topbar-actions">
                <span class="status-indicator">Guichet en ligne</span>
                <span class="time-badge" id="live-clock"><?= date('H:i:s') ?></span>
            </div>
        </header>

        <?php if (!empty($_SESSION['flash'])) { ?>
            <div class="flash flash-<?= $_SESSION['flash']['type'] ?>" role="status">
                <i class="bi bi-info-circle-fill"></i>
                <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php } ?>
<?php } ?>
