<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Transactional email notifications
    |--------------------------------------------------------------------------
    |
    | Sends order/review emails via Laravel Mail when enabled and mail.default
    | is not "log". Disable with CRAFTNEST_MAIL_NOTIFICATIONS=false in .env.
    |
    */

    'mail_notifications' => env('CRAFTNEST_MAIL_NOTIFICATIONS', true),

];
