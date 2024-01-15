<section id="contact" class="bg-dark">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 80 1440 150">
        <path fill="var(--background-color)" fill-opacity="1"
              d="M0,224L288,160L576,128L864,224L1152,160L1440,160L1440,0L1152,0L864,0L576,0L288,0L0,0Z"></path>
    </svg>
    <div class="d-flex flex-column text-center py-5">
        <div animation="animate__fadeInUp" class="animate__animated"><h2>Me contacter</h2><span
                    class="text-light text-uppercase">Débuter notre première discussion</span></div>
        <div class="separator mt-5"></div>
    </div>
    <div class="container pb-5">
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast bg-dark" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
                <div class="toast-header bg-dark"><img src="/assets/imgs/pp.jpeg" class="logo-toast rounded-circle me-2"
                                                       alt="Développeur"><strong class="me-auto text-light">Doryan
                        BESSIERE</strong><span class="badge bg-primary">développeur</span>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">Votre message de contact a été reçu avec succès. Je vous remercie de l'intérêt
                    que vous me portez et j'y répondrais dans les meilleurs délais.
                </div>
            </div>
            <div class="toast bg-dark" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
                <div class="toast-header bg-dark"><img src="/assets/imgs/pp.jpeg" class="logo-toast rounded-circle me-2"
                                                       alt="Développeur"><strong class="me-auto text-light">Doryan
                        BESSIERE</strong><span class="badge bg-primary">développeur</span>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body"></div>
            </div>
        </div>
        <form animation="animate__bounceIn" id="contact" class="text-start col-10 mx-auto animate__animated">
            <div class="mb-3"><label for="email" class="form-label">Adresse e-mail :</label>
                <div class="background-color p-2 rounded-3"><input type="email"
                                                                   class="form-control background-color border-0 text-light"
                                                                   id="email" name="_replyto"
                                                                   placeholder="name@example.com">
                    <div data-lastpass-icon-root="true"
                         style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                </div>
            </div>
            <div class="mb-3"><label for="message" class="form-label">Message :</label>
                <div class="background-color p-2 rounded-3"><textarea required=""
                                                                      class="form-control background-color border-0 text-light"
                                                                      name="message" id="message" rows="8"
                                                                      placeholder="Entrez votre message de contact"></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" name="submit" class="btn btn-primary">Envoyer mon message</button>
            </div>
        </form>
    </div>
</section>