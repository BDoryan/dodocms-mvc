<div class="tw-mb-4 tw-w-full">
    <?php
    Text::create()
        ->type('email')
        ->template('/core/ui/views/admin/components/field/')
        ->value($email ?? '')
        ->label(__('setup.user.root.email'))
        ->name("email")
        ->required()
        ->validator(true)
        ->placeholder(__('setup.user.root.your_email'))
        ->required()
        ->render()
    ?>
</div>
<div class="tw-mb-4 tw-w-full">
    <?php
    Text::create()
        ->value($username ?? '')
        ->template('/core/ui/views/admin/components/field/')
        ->label(__('setup.user.root.username'))
        ->name("username")
        ->required()
        ->placeholder(__('setup.user.root.your_username'))
        ->required()
        ->validator(true)
        ->render()
    ?>
</div>
<div class="tw-mb-4 tw-w-full">
    <?php
    Text::create()
        ->template('/core/ui/views/admin/components/field/')
        ->type('password')
        ->value($password ?? '')
        ->label(__('setup.user.root.password'))
        ->name("password")
        ->validator(true)
        ->required()
        ->placeholder(__('setup.user.root.your_password'))
        ->required()
        ->render()
    ?>
</div>