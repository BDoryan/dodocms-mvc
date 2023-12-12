<?= $header ?? '' ?>
<?= $content ?? '' ?>
<?= $footer ?? '' ?>
<div id="myModal" class="dodocms-modal show">
    <div class="dodocms-modal-content">
        <div class="dodocms-modal-header">
            <h2 class="dodocms-modal-title">Mon Modal</h2>
            <button type="button" class="dodocms-modal-close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                </svg>
            </button>
        </div>
        <div class="dodocms-modal-body">
            <p>Ceci est un modal simple.</p>
        </div>
        <div class="dodocms-modal-footer">
            <button type="button" class="dodocms-modal-close">Fermer</button>
        </div>
    </div>
</div>
