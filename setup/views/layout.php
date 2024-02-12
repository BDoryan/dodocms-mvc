<div class="tw-min-h-screen tw-flex tw-flex-col tw-items-center tw-justify-center tw-p-4 tw-bg-gradient-to-br tw-from-violet-300 tw-via-violet-200 tw-to-violet-200">
    <div class="tw-backdrop-filter tw-backdrop-blur-lg tw-bg-opacity-50 tw-border tw-border-black tw-border-opacity-20 tw-bg-white tw-p-8 tw-rounded-3xl tw-shadow-lg tw-w-full md:tw-w-4/5 lg:tw-w-4/5 xl:tw-w-2/6">
        <div class="tw-text-center">
            <img class="tw-mx-auto tw-mb-5" width="110" height="110"
                 src="<?= Application::get()->toURL("/core/assets/imgs/logo-animated.png") ?>">
            <h1 class="tw-text-3xl tw-font-semibold tw-text-center tw-mt-3 tw-mb-0">DodoCMS
                - <?= __('dodocms.setup') ?></h1>

            <form id="setup" class="tw-text-start tw-flex tw-flex-wrap tw-mt-1" action="<?= Tools::getCurrentURI(); ?>"
                  method="POST" novalidate>
                <input type="hidden" name="step">

                <h2 class="tw-px-2 tw-mb-[40px] tw-text-center tw-text-base tw-italic tw-mx-auto"><?= $title ?? 'untitled' ?></h2>
                <?php
                if (!empty($alerts)) { ?>
                    <div class="alert-container tw-my-3 tw-w-full tw-text-white">
                        <?php
                        array_map(function ($alert) {
                            echo $alert->render();
                        }, $alerts);
                        ?>
                    </div>
                <?php } ?>
                <?= $content ?? 'No content' ?>

                <div class="tw-w-full tw-flex tw-justify-between tw-items-center tw-mt-10 tw-relative">
                    <?=
                    ButtonHypertext::create()
                        ->href('?step=' . (($step ?? 2) - 1))
                        ->gray()
                        ->disabled(!($can_previous ?? false))
                        ->text('<i class="fa-solid fa-arrow-left tw-me-2"></i>' . __('setup.previous'))
                        ->html()
                    ?>
                    <span class="tw-absolute tw-top-1/2 tw-left-1/2 tw-transform -tw-translate-x-1/2 -tw-translate-y-1/2 tw-text-gray-700 tw-text-lg"><?= $step ?? '' ?> / <?= $total_steps ?? '' ?></span>
                    <?php
                    Button::create()
                        ->type('submit')
                        ->style($total_steps == $step ? ButtonComponent::BUTTON_GREEN : ButtonComponent::BUTTON_GRAY)
                        ->disabled(!($can_next ?? false))
                        ->text(($total_steps == $step ? __('setup.finish') : __('setup.next')) . '<i class="fa-solid fa-arrow-right tw-ps-2" ></i>')
                        ->render()
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>