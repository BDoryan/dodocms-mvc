<section id="home" class="hero-section text-white py-5 py-lg-6">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span editable="build_with" class="badge text-bg-light text-primary mb-3">
                    CMS PHP modulaire
                </span>
                <h1 editable="title" class="display-5 fw-bold mb-3">
                    Open-Source Web Template for SaaS, Startup, Apps, and More
                </h1>
                <p editable="subtitle" class="lead text-body-secondary mb-4">
                    Multidisciplinary Web Template Built with Your Favourite Technology - HTML Bootstrap, Tailwind and React NextJS.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="https://links.tailgrids.com/play-download" class="btn btn-light btn-lg" editable="main_button">
                        Demarrez maintenant
                    </a>
                    <a href="https://github.com/tailgrids/play-tailwind" target="_blank" class="btn btn-outline-light btn-lg">
                        <span editable="secondary_button">En savoir plus</span>
                    </a>
                </div>
                <div class="row row-cols-1 row-cols-sm-3 g-3">
                    <div class="col">
                        <div class="card h-100 border-0 bg-white bg-opacity-10 text-white">
                            <div class="card-body">
                                <div class="h4 mb-1">100%</div>
                                <p class="mb-0 small text-white-50">Editable</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 border-0 bg-white bg-opacity-10 text-white">
                            <div class="card-body">
                                <div class="h4 mb-1">Bootstrap</div>
                                <p class="mb-0 small text-white-50">Composants de base</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 border-0 bg-white bg-opacity-10 text-white">
                            <div class="card-body">
                                <div class="h4 mb-1">CMS</div>
                                <p class="mb-0 small text-white-50">Edition visuelle</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-lg border-0 overflow-hidden">
                    <img
                            editable="illustration"
                            src="<?= Application::get()->getTheme()->toURL('assets/images/hero/hero-image.jpg') ?>"
                            alt="hero"
                            class="img-fluid"
                    />
                </div>
            </div>
        </div>
    </div>
</section>
