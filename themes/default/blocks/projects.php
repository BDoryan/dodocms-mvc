<section id="projects" class="bg-dark">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 80 1440 150">
        <path fill="var(--background-color)" fill-opacity="1"
              d="M0,224L288,160L576,128L864,224L1152,160L1440,160L1440,0L1152,0L864,0L576,0L288,0L0,0Z"></path>
    </svg>
    <div class="d-flex flex-column text-center py-5">
        <div animation="animate__fadeInUp" class="animate__animated">
            <h2 editable="title">Mes projets</h2>
            <span editable="subtitle" class="text-light text-uppercase">Projets réalisés durant mon apprentissage</span>
        </div>
        <div class="separator mt-5"></div>
    </div>
    <div class="container pb-5">
        <div class="row my-0 my-md-3 g-5 g-md-4 mx-0" model-name="<?= ProjectsModel::TABLE_NAME ?>">
            <?php
            /** @var ProjectsModel $project */
            foreach ($projects ?? [] as $project) {
                ?>
                <div class="col-12 col-md-4" entity-id="<?= $project->getId() ?>">
                    <div animation="animate__zoomInDown"
                         class="project background-color rounded shadow animate__animated h-100">
                        <div class="d-flex flex-column h-100">
                            <div class="rounded-top project-image">
                                <img src="<?= $project->getProjectIllustrationResource()->getSrc() ?>"
                                     alt="<?= $project->getProjectIllustrationResource()->getAlternativeText() ?>"
                                     class="w-100 rounded-top">
                            </div>
                            <div class="p-3 project-content my-auto">
                                <h4 editable-model="name"><?= $project->getName() ?></h4>
                                <div class="mt-2 text-center gap-2">
                                    <span editable-model="type"
                                          class="badge bg-primary"><?= $project->getType() ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="hover">
                            <button type="button" class="text-white fs-2 view-button" data-bs-toggle="modal"
                                    data-bs-target="#project-<?= $project->getId() ?>"><i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal fade" id="project-<?= $project->getId() ?>" data-bs-backdrop="static"
                         data-bs-keyboard="false"
                         tabindex="-1"
                         aria-labelledby="project-22Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-border rounded-3">
                                <div class="modal-content">
                                    <div class="modal-header pb-0">
                                        <h1 editable-model="name" class="modal-title fs-5"
                                            id="staticBackdropLabel"><?= $project->getName() ?></h1>
                                        <button type="button" class=" btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="categories d-flex gap-2 text-start pt-2 pb-3 mb-3 border-bottom">
                                        <div class="me-auto fs-4 d-flex gap-3">
                                            <?php foreach ($project->getIconsList() as $icon) { ?>
                                                <i class="<?= $icon ?>"></i>
                                            <?php } ?>
                                        </div>
                                        <span class="badge bg-primary"
                                              editable-model="type"><?= $project->getType() ?></span>
                                    </div>
                                    <div class="modal-body text-start pe-3">
                                        <h3 editable-model="title"
                                            class="text-start text-secondary mb-3"><?= $project->getTitle() ?></h3>
                                        <div editable-model="content">
                                            <?= $project->getContent() ?>
                                        </div>
                                        <div class="row justify-content-center mt-5 d-flex flex-column gap-4">
                                            <?php
                                            /** @var ResourceModel $image */
                                            foreach ($project->getImages() as $image) {
                                                ?>
                                                <img src="<?= $image->getSrc() ?>"
                                                     alt="<?= $image->getAlternativeText() ?>" class="col">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <a href="<?= $project->getLink() ?>" class="mt-3 btn btn-primary w-100">visiter le
                                        projet</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="d-flex justify-content-center">
            <p animation="animate__jackInTheBox"
               class="col-12 col-md-6 text-center text-light mt-5 animate__animated">
                J'ai accompli de nombreux projets au fil des années, mais j'ai sélectionné les plus pertinents pour les
                afficher sur ma
                page. Cela donne une image plutôt claire de mes compétences et de mes réalisations les plus
                marquantes.</p>
        </div>
    </div>
</section>