<header class="sticky-top">
    <nav id="siteNavbar" class="navbar navbar-expand-lg bg-body border-bottom">
        <div class="container">
            <a href="/" class="navbar-brand d-flex align-items-center gap-3">
                <img
                        src="<?= Application::theme()->toURL('/assets/images/logo/logo-animated.png') ?>"
                        alt="logo"
                        width="48"
                        height="48"
                        class="rounded"
                />
                <span class="d-flex flex-column">
                    <span class="fw-bold">DodoCMS</span>
                    <small class="text-body-secondary"><?= DodoCMS::VERSION ?? 'version_not_found' ?></small>
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Basculer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">A propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Contenu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>

                <div class="d-flex gap-2 ms-lg-3">
                    <a href="/admin123" class="btn btn-outline-secondary">Administration</a>
                    <a href="#home" class="btn btn-primary">Demarrer</a>
                </div>
            </div>
        </div>
    </nav>
</header>
