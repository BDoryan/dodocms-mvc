<section id="competences" class="background-color">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 80 1440 150">
        <path fill="var(--bs-dark)" fill-opacity="1"
              d="M0,224L288,160L576,128L864,224L1152,160L1440,160L1440,0L1152,0L864,0L576,0L288,0L0,0Z"></path>
    </svg>
    <div class="d-flex flex-column text-center py-5">
        <div animation="animate__fadeInUp" class="animate__animated">
            <h2 editable="title">Mes compétences</h2>
            <span editable="subtitle"
                  class="text-light text-uppercase">Langages, outils, environnements maîtrisés</span>
        </div>
        <div class="separator mt-5"></div>
    </div>
    <div class="container pb-5">
        <div class="row g-4 justify-content-center" model-name="<?= SkillModel::TABLE_NAME ?>">
            <?php
            /** @var SkillModel $skill */
            foreach ($skills ?? [] as $skill) {
                ?>
                <div animation="animate__zoomInLeft" entity-id="<?= $skill->getId() ?>"
                     class="col-12 col-md-6 mb-3 animate__animated">
                    <h4 class="text-start mb-2"><i class="<?= $skill->getIcon() ?>"></i> <span
                                editable-model="name"><?= $skill->getName() ?></span></h4>
                    <div class="bg-white progress" role="progressbar" aria-valuenow="<?= $skill->getProgression() ?>"
                         aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: <?= $skill->getProgression() ?>%;"></div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="d-flex justify-content-center">
            <p editable="context" animation="animate__jackInTheBox"
               class="col-12 col-md-6 text-center text-light mt-5 animate__animated">
                Vous devez prendre en compte que ces estimations restent purement une opinion personnelle, il n'est pas
                possible de tout connaître dans un domaine spécifique.
            </p>
        </div>
    </div>
</section>