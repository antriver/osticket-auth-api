<?php

return array(
    'id' => 'auth:api', // notrans
    'version' => '1.0.1',
    'name' => /* trans */ 'External API Authentication',
    'author' => 'Anthony Kuske',
    'description' => /* trans */ 'Allows staff to login with credentials for an external REST API.',
    'url' => 'https://www.github.com/antriver/osticket-auth-api',
    'plugin' => 'bootstrap.php:ApiAuth\Plugin'
);
