<?php if($driver_need_install ?? false) { ?>
    <div class="tw-w-full tw-bg-red-700 tw-text-white tw-text-lg tw-p-2 tw-rounded-lg">
        <p class="tw-text-center">The PDO MySQL driver is not installed on your server. Please install it before proceeding.</p>
        <p class="tw-text-center">CURL, XML, ZIP are required to use the system.</p>
    </div>
    <a class="tw-mt-2 tw-text-blue-800 tw-underline tw-italic" href="http://blog.gabrielsaldana.org/how-to-install-php-pdo-on-debian-lenny/" target="_blank">How to install PHP PDO extensions on Debian</a>
<?php } ?>
