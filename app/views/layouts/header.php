<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> — Gestion des Attestations & File d'attente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body class="<?= Auth::isAdmin() ? 'is-admin' : 'is-etudiant' ?>">

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
                <span class="brand-tag">Queue & Attestations</span>
            </div>
        </div>

        <?php if (Auth::isAdmin()) { ?>
        <nav class="sidebar-nav">
            <div class="nav-section-title">PILOTAGE & GUICHET</div>
            <a href="<?= APP_URL ?>/admin/dashboard" class="nav-link <?= $isActive('/admin/dashboard') ?>">
                <i class="bi bi-grid-1x2-fill nav-ico"></i> <span>Tableau de bord</span>
            </a>
            <a href="<?= APP_URL ?>/admin/registre" class="nav-link <?= $isActive('/admin/registre') ?>">
                <i class="bi bi-card-checklist nav-ico"></i> <span>Registre des demandes</span>
            </a>
            <a href="<?= APP_URL ?>/admin/statistiques" class="nav-link <?= $isActive('/admin/statistiques') ?>">
                <i class="bi bi-bar-chart-line-fill nav-ico"></i> <span>Statistiques & Flux</span>
            </a>
            <a href="<?= APP_URL ?>/admin/ecranGuichet" target="_blank" class="nav-link">
                <i class="bi bi-tv-fill nav-ico" style="color:var(--cyan)"></i> <span>Écran Guichet Hall ↗</span>
            </a>
            <div class="nav-section-title">CONFIGURATIONS</div>
            <a href="<?= APP_URL ?>/admin/typesAttestation" class="nav-link <?= $isActive('/admin/typesAttestation') ?>">
                <i class="bi bi-folder-symlink-fill nav-ico"></i> <span>Catalogue Attestations</span>
            </a>
        </nav>
        <?php } else { ?>
        <nav class="sidebar-nav">
            <div class="nav-section-title">ESPACE ÉTUDIANT</div>
            <a href="<?= APP_URL ?>/etudiant/dashboard" class="nav-link <?= $isActive('/etudiant/dashboard') ?>">
                <i class="bi bi-speedometer2 nav-ico"></i> <span>Tableau de bord</span>
            </a>
            <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="nav-link <?= $isActive('/etudiant/nouvelleDemande') ?>">
                <i class="bi bi-plus-circle-fill nav-ico"></i> <span>Nouvelle demande</span>
            </a>
            <a href="<?= APP_URL ?>/etudiant/mesDemandes" class="nav-link <?= $isActive('/etudiant/mesDemandes') ?>">
                <i class="bi bi-journal-text nav-ico"></i> <span>Mes demandes</span>
            </a>
            <div class="nav-section-title">PROFIL</div>
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
                    <span class="user-role"><?= Auth::isAdmin() ? 'Agent Administratif' : 'Étudiant' ?></span>
                </div>
            </div>
            <a href="<?= APP_URL ?>/auth/logout" class="logout-link" title="Se déconnecter">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-title">
                <h1><?= Auth::isAdmin() ? 'Espace Administratif / Guichet' : 'Portail Étudiant' ?></h1>
                <p class="topbar-sub">Suivi en temps réel des tickets et demandes d'attestations</p>
            </div>
            <div class="topbar-actions">
                <div class="status-indicator">
                    <span class="pulse-dot"></span> Guichet En Ligne
                </div>
                <span class="time-badge" id="live-clock"><?= date('H:i:s') ?></span>
            </div>
        </header>

        <?php if (!empty($_SESSION['flash'])) { ?>
            <div class="flash flash-<?= $_SESSION['flash']['type'] ?>">
                <i class="bi bi-info-circle-fill"></i>
                <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php } ?>
<?php } ?>
