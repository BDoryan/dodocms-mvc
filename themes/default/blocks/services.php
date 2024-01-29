<section id="services" class="bg-dark">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 80 1440 150">
        <path fill="var(--background-color)" fill-opacity="1"
              d="M0,224L288,160L576,128L864,224L1152,160L1440,160L1440,0L1152,0L864,0L576,0L288,0L0,0Z"></path>
    </svg>
    <div class="d-flex flex-column text-center py-5 container">
        <div animation="animate__fadeInUp" class="animate__animated">
            <h2 editable="name">Mes services</h2>
            <p editable="subtitle" class="text-center text-light text-uppercase">Retrouvez ce que je vous propose</p>
        </div>
        <div class="separator mt-5"></div>
    </div>
    <div class="container pb-5">
        <div class="bg-dark">
            <div id="services" class="" model-name="<?= ServicesModel::TABLE_NAME ?>">
                <div class="row mb-5 my-md-1 g-5 g-md-3 mx-0">
                    <?php
                        /** @var ServicesModel $service */
                        foreach ($services ?? [] as $service) {
                    ?>
                        <div class="col-12 col-md-4" entity-id="<?= $service->getId() ?>">
                            <div animation="animate__fadeInLeft"
                                 class="d-flex flex-column h-100 background p-4 rounded-3 shadow position-relative animate__animated">
                                <div class="position-absolute top-0 start-50 translate-middle"><span
                                            class="badge bg-info fs-6 text-uppercase" editable="<?= 'services_'.$service->getId().'_badge' ?>">devis gratuit</span></div>
                                <h5 editable-model="title" class="pt-2 text-center mb-3"><?= $service->getTitle() ?></h5>
                                <div class="fs-2 d-flex gap-3 justify-content-center">
                                    <?php foreach ($service->getIconsList() as $icon){ ?>
                                        <i class="<?= $icon ?>"></i>
                                    <?php } ?>
                                </div>
                                <div class="separator my-3"></div>
                                <div  editable-model="content" class="mt-auto text-start">
                                    <?= $service->getContent() ?>
                                </div>
                                <a href="<?= $service->getHref() ?>" class="btn btn-primary">Demander un devis</a></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>