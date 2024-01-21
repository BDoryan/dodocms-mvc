<?php
//ControllerManager::synchronize('services');
var_dump($services);
//    $services = ServicesModel::findAll("*", ["active" => 1]);
?>
<section id="services" class="bg-dark">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 80 1440 150">
        <path fill="var(--background-color)" fill-opacity="1"
              d="M0,224L288,160L576,128L864,224L1152,160L1440,160L1440,0L1152,0L864,0L576,0L288,0L0,0Z"></path>
    </svg>
    <div class="d-flex flex-column text-center py-5 container">
        <div animation="animate__fadeInUp" class="animate__animated active animate__fadeInUp">
            <h2 editable="name">Mes services</h2>
            <p editable="subtitle" class="text-center text-light text-uppercase">Retrouvez ce que je vous propose</p>
        </div>
        <div class="separator mt-5"></div>
    </div>
    <div class="container pb-5">
        <div class="bg-dark">
            <div id="services" class="">
                <div class="row mb-5 my-md-1 g-5 g-md-3 mx-0">
                    <div class="col-12 col-md-4">
                        <div animation="animate__fadeInLeft"
                             class="d-flex flex-column h-100 background p-4 rounded-3 shadow position-relative animate__animated active animate__fadeInLeft">
                            <div class="position-absolute top-0 start-50 translate-middle"><span
                                        class="badge bg-info fs-6 text-uppercase">devis gratuit</span></div>
                            <h5 class="pt-2 text-center mb-3">Création de site vitrine, corporate &amp;
                                évènementiel</h5>
                            <div class="fs-2 d-flex gap-3 justify-content-center"><i class="fa-brands fa-html5"></i><i
                                        class="fa-brands fa-css3-alt"></i><i class="fa-brands fa-js"></i><i
                                        class="fa-brands fa-bootstrap"></i></div>
                            <div class="separator my-3"></div>
                            <div class="mt-auto text-start">
                                <ol>
                                    <li>Comprendre vos besoins et objectifs</li>
                                    <li>Création d'un plan de site</li>
                                    <li>Sélection des technologies</li>
                                    <li>Réalisation de la maquette</li>
                                    <li>Programmation du site</li>
                                    <li>Référencement</li>
                                    <li>Test et livraison</li>
                                </ol>
                            </div>
                            <a href="#contact" class="btn btn-primary">Demander un devis</a></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div animation="animate__fadeInLeft"
                             class="d-flex flex-column h-100 background p-4 rounded-3 shadow position-relative animate__animated active animate__fadeInLeft">
                            <div class="position-absolute top-0 start-50 translate-middle"><span
                                        class="badge bg-info fs-6 text-uppercase">devis gratuit</span></div>
                            <h5 class="pt-2 text-center mb-3">Création d'application sur mesure</h5>
                            <div class="fs-2 d-flex gap-3 justify-content-center"><i class="fa-brands fa-react"></i><i
                                        class="fa-brands fa-bootstrap"></i><i class="fa-brands fa-node"></i><i
                                        class="fa-brands fa-java"></i></div>
                            <div class="separator my-3"></div>
                            <div class="mt-auto text-start" editable="process">
                                <ol>
                                    <li>Comprendre vos besoins et objectifs</li>
                                    <li>Création d'un plan de navigation</li>
                                    <li>Sélection des technologies</li>
                                    <li>Réalisation de la maquette</li>
                                    <li>Programmation de l'application</li>
                                    <li>Test et livraison</li>
                                </ol>
                            </div>
                            <a href="#contact" class="btn btn-primary">Demander un devis</a></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div animation="animate__fadeInLeft"
                             class="d-flex flex-column h-100 background p-4 rounded-3 shadow position-relative animate__animated active animate__fadeInLeft">
                            <div class="position-absolute top-0 start-50 translate-middle"><span
                                        class="badge bg-info fs-6 text-uppercase">devis gratuit</span></div>
                            <h5 class="pt-2 text-center mb-2">Création de plugin minecraft</h5>
                            <div class="fs-2 d-flex gap-3 justify-content-center"><i class="fa-brands fa-java"></i>
                            </div>
                            <div class="separator my-3"></div>
                            <div class="mt-auto text-start">
                                <ol>
                                    <li>Comprendre vos besoins et objectifs</li>
                                    <li>Sélection des technologies</li>
                                    <li>Programmation du plugin</li>
                                    <li>Test et livraison</li>
                                </ol>
                            </div>
                            <a href="#contact" class="btn btn-primary">Demander un devis</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>