<section id="experiences" class="background-color">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 80 1440 150">
        <path fill="var(--bs-dark)" fill-opacity="1"
              d="M0,224L288,160L576,128L864,224L1152,160L1440,160L1440,0L1152,0L864,0L576,0L288,0L0,0Z"></path>
    </svg>
    <div class="d-flex flex-column text-center py-5 container">
        <div animation="animate__fadeInUp" class="animate__animated">
            <h2 editable="name">Mes expériences</h2>
            <p editable="subtitle" class="text-center text-light text-uppercase">Suivez mon parcours professionnel</p>
        </div>
        <div class="separator mt-5"></div>
    </div>
    <div class="container pb-5">
        <div class="row justify-content-center my-5 g-5 g-md-0 mx-0 container"
             model-name="<?= ExperiencesModel::TABLE_NAME ?>">
            <?php
            /** @var ExperiencesModel $experience */
            foreach ($experiences ?? [] as $experience) {
                ?>
                <div class="col-12 col-md-4 experience-<?= $experience->getId() ?>" entity-id="<?= $experience->getId() ?>">
                    <div animation="animate__flipInX"
                         class="d-flex flex-column h-100 rounded-3 animate__animated">
                        <div class="mt-auto mb-auto">
                            <div class="text-center">
                                <img src="<?= $experience->getCompanyLogoResource()->getSrc() ?>" alt="<?= $experience->getCompanyLogoResource()->getAlternativeText() ?>" class="w-100 p-4">
                                <h3 editable-model="role" class="mt-3"><?= $experience->getRole() ?></h3>
                                <span editable-model="period"
                                      class="text-secondary"><?= $experience->getPeriod() ?></span></div>
                            <div class="mt-3 text-start mb-0" editable-model="tasks">
                                <?= $experience->getTasks() ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>