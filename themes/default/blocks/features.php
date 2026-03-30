<section id="about" class="py-5">
    <div class="container py-lg-4">
        <div class="row justify-content-center text-center mb-4">
            <div class="col-lg-8">
                <span editable="introduction" class="badge text-bg-primary-subtle text-primary mb-3">
                    Features
                </span>
                <h2 editable="title" class="display-6 fw-bold">Nos fonctionnalites</h2>
                <p editable="description" class="text-body-secondary mb-0">
                    There are many variations of passages of Lorem Ipsum available but the majority have suffered alteration in some form.
                </p>
            </div>
        </div>

        <div class="row g-4" model-name="<?= FeaturesModel::TABLE_NAME ?>">
            <?php foreach ($features ?? [] as $feature) { ?>
                <div class="col-md-6 col-xl-3" entity-id="<?= $feature->getId() ?>">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="icon-circle bg-primary text-white mb-3">
                                <i class="<?= $feature->getIcon() ?>"></i>
                            </div>
                            <h3 editable-model="title" class="h5 card-title"><?= $feature->getTitle() ?></h3>
                            <p editable-model="description" class="card-text text-body-secondary flex-grow-1">
                                <?= $feature->getDescription() ?>
                            </p>
                            <a href="<?= $feature->getLink() ?>" class="btn btn-outline-primary mt-2">En savoir plus</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
