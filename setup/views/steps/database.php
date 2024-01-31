<div class="tw-mb-4 tw-w-full">
    <?php
    Text::create()
        ->template('/core/ui/views/admin/components/field/')
        ->value($hostname ?? '')
        ->label(__('setup.database.hostname'))
        ->name("hostname")
        ->required()
        ->validator(true)
        ->placeholder(__('setup.database.your_hostname'))
        ->required()
        ->render()
    ?>
</div>
<div class="tw-mb-4 tw-w-full">
    <?php
    Text::create()
        ->template('/core/ui/views/admin/components/field/')
        ->value($database ?? '')
        ->label(__('setup.database.database_name'))
        ->name("database")
        ->required()
        ->placeholder(__('setup.database.the_name_of_your_database'))
        ->required()
        ->validator(true)
        ->render()
    ?>
</div>
<div class="tw-mb-4 tw-w-full">
    <?php
    Text::create()
        ->value($username ?? '')
        ->template('/core/ui/views/admin/components/field/')
        ->label(__('setup.database.username'))
        ->name("username")
        ->required()
        ->placeholder(__('setup.database.your_username'))
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
        ->label(__('setup.database.password'))
        ->name("password")
        ->validator(true)
        ->required()
        ->placeholder(__('setup.database.your_password'))
        ->required()
        ->render()
    ?>
</div>