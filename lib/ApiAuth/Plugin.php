<?php

namespace ApiAuth;

class Plugin extends \Plugin
{
    public $config_class = "ApiAuth\Config";

    public function bootstrap()
    {
        $config = $this->getConfig();
        $enabledFor = $config->get('enabled-for');

        if ($enabledFor === 'all' || $enabledFor === 'staff') {
            \StaffAuthenticationBackend::register(
                new StaffAuthBackend($this->getConfig())
            );
        }

        // TODO
        /*if ($enabledFor === 'all' || $enabledFor === 'client') {
            \UserAuthenticationBackend::register(
                new ClientAuthBackend($this->getConfig())
            );
        }*/
    }
}
