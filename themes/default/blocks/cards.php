<div class="container py-3">
    <h2 editable="title">Qui sommes-nous ?</h2>
    <p editable="paragraph">Nous sommes une équipe passionnée par la création de solutions innovantes
        pour rendre la vie meilleure.</p>
    <div class="row" model-name="<?= ArticlesModel::TABLE_NAME ?>">
        <?php
        $articles = ArticlesModel::findAll('*');
        /** @var ArticlesModel $article */
        foreach (ArticlesModel::findAll('*') as $article) {
            ?>
            <div class="col-4">
                <div entity-id="<?= $article->getId() ?>" class="card shadow-sm">
                    <img src="<?= $article->getIllustrationResource() !== null ? $article->getIllustrationResource()->getSrc() : '' ?>"
                         class="object-fit-contain bd-placeholder-img card-img-top" width="100%" style="height: 225px;" alt="">
                    <div class="card-body bg-secondary">
                        <h5 editable-model="title"><?= $article->getTitle() ?></h5>
                        <p class="card-text" editable-model="subtitle"><?= $article->getSubtitle() ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>