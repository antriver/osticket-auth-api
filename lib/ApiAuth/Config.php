<?php

namespace ApiAuth;

use ChoiceField;
use SectionBreakField;
use TextboxField;
use Plugin;
use PluginConfig;

class Config extends PluginConfig
{
    /**
     * Provide compatibility function for versions of osTicket prior to translation support (v1.9.4)
     */
    public function translate()
    {
        if (!method_exists('Plugin', 'translate')) {
            return array(
                function ($x) {
                    return $x;
                },
                function ($x, $y, $n) {
                    return $n != 1 ? $y : $x;
                },
            );
        }
        return Plugin::translate('auth-url');
    }

    public function getOptions()
    {
        list($trans) = $this->translate();

        return array(

            'plugin-header' => new SectionBreakField(
                array(
                    'label' => $trans('Plugin Settings'),
                )
            ),

            'enabled-for' => new ChoiceField(
                array(
                    'label' => $trans('Authentication'),
                    'choices' => array(
                        '0' => $trans('Disabled'),
                        'staff' => $trans('Agents (Staff) Only'),
                        //'client' => $trans('Clients Only'),
                        //'all' => $trans('Agents and Clients'),
                    ),
                )
            ),

            'api-header' => new SectionBreakField(
                array(
                    'label' => $trans('API Settings'),
                )
            ),

            'url' => new TextboxField(
                array(
                    'label' => $trans('API URL'),
                    'configuration' => array(
                        'size' => 60,
                        'length' => 200
                    ),
                )
            ),

            'method' => new ChoiceField(
                array(
                    'label' => $trans('Method'),
                    'choices' => array(
                        'POST' => 'POST',
                        'GET' => 'GET',
                    ),
                )
            ),

            'username-field' => new TextboxField(
                array(
                    'label' => $trans('Username Field'),
                    'configuration' => array(
                        'size' => 60,
                        'length' => 100
                    ),
                )
            ),

            'password-field' => new TextboxField(
                array(
                    'label' => $trans('Password Field'),
                    'configuration' => array(
                        'size' => 60,
                        'length' => 100
                    ),
                )
            ),

            'additional-params' => new TextboxField(
                array(
                    'label' => $trans('Additional Parameters'),
                    'configuration' => array(
                        'size' => 60,
                        'length' => 100
                    ),
                )
            ),

        );

    }
}
