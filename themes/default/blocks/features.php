<!-- ====== Features Section Start -->
<section class="pb-8 pt-20 dark:bg-dark lg:pb-[70px] lg:pt-[120px]">
    <div class="container">
        <div class="-mx-4 flex flex-wrap">
            <div class="w-full px-4">
                <div class="mx-auto mb-12 max-w-[485px] text-center lg:mb-[70px]">
              <span editable="introduction" class="mb-2 block text-lg font-semibold text-primary">
                Features
              </span>
                    <h2 editable="title"
                        class="mb-3 text-3xl font-bold text-dark dark:text-white sm:text-4xl md:text-[40px] md:leading-[1.2]">
                        Nos fonctionnalités
                    </h2>
                    <p editable="description" class="text-base text-body-color dark:text-dark-6">
                        There are many variations of passages of Lorem Ipsum available
                        but the majority have suffered alteration in some form.
                    </p>
                </div>
            </div>
        </div>
        <div class="-mx-4 flex flex-wrap" model-name="<?= FeaturesModel::TABLE_NAME ?>">
            <?php foreach ($features ?? [] as $feature) { ?>
                <div class="w-full px-4 md:w-1/2 lg:w-1/4" entity-id="<?= $feature->getId() ?>">
                    <div class="wow fadeInUp group mb-12" data-wow-delay=".1s">
                        <div class="relative z-10 mb-10 flex h-[70px] w-[70px] items-center justify-center rounded-[14px] bg-primary">
                    <span class="absolute left-0 top-0 -z-[1] mb-8 flex h-[70px] w-[70px] rotate-[25deg] items-center justify-center rounded-[14px] bg-primary bg-opacity-20 duration-300 group-hover:rotate-45"
                    ></span>
                            <i class="text-2xl text-white <?php echo $feature->getIcon() ?>"></i>
                        </div>
                        <h4 editable-model="title" class="mb-3 text-xl font-bold text-dark dark:text-white">
                            <?= $feature->getTitle() ?>
                        </h4>
                        <p editable-model="description" class="mb-8 text-body-color dark:text-dark-6 lg:mb-9    ">
                            <?= $feature->getDescription() ?>
                        </p>
                        <a
                                href="<?= $feature->getLink() ?>"
                                class="text-base font-medium text-dark hover:text-primary dark:text-white dark:hover:text-primary"
                        >
                            En savoir plus
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- ====== Features Section End -->