<div class="tw-p-4">
    <h1 class="tw-text-2xl tw-font-bold">Tableau de bord</h1>
    <p class="tw-text-gray-600">Bienvenue sur le tableau de bord de l'administration.</p>

    <div class="tw-flex tw-wrap tw-gap-3">
        <div class="tw-m-auto tw-w-1/2 tw-mt-4 tw-shadow-sm tw-bg-white tw-rounded-lg tw-border-[1px] tw-border-gray-300 tw-flex tw-flex-col tw-gap-4 tw-justify-between tw-p-4">
            <div class="">
                <h2 class="tw-text-lg tw-font-bold">Informations</h2>
                <ul>
                    <li>Version de DodoCMS : <?= DodoCMS::VERSION ?> <?php if (Application::get()->hasUpdate()) { ?>(
                            <span
                                    class="tw-text-red-500 tw-font-bold tw-text-sm tw-italic tw-underline">Nouvelle version disponible</span>)<?php } ?>
                    </li>
                    <li>Version de PHP : <?= phpversion() ?></li>
                    <li>Version de MySQL : <?= Application::get()->getDatabase()->getVersion() ?></li>
                </ul>
            </div>
            <?php
            if (Application::get()->hasUpdate()) {
                ButtonHypertext::create()
                    ->text('Mettre à jour')
                    ->green()
                    ->href(NativeRoutes::getRoute(NativeRoutes::ADMIN_UPDATE))
                    ->render();
            }
            ?>
        </div>
        <div class="tw-w-1/2 tw-mt-4 tw-shadow-sm tw-bg-white tw-rounded-lg tw-border-[1px] tw-border-gray-300 tw-flex tw-flex-col tw-gap-4 tw-justify-between tw-p-4">
            <h2 class="tw-text-lg tw-font-bold">Modifications</h2>
            <div class="tw-mt-3">
                <?= MarkdownConverter::toHtml(file_get_contents(Application::get()->toRoot('changelog.md')) ?? '# 404 Not Found') ?>
            </div>
        </div>
    </div>
</div>