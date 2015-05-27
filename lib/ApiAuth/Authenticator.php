<?php

namespace ApiAuth;

use Exception;

trait Authenticator
{
    private function getConfig($key, $required = true)
    {
        $value = $this->config->get($key);
        if (!$value && $required) {
            throw new Exception("Please set the '{$key}'' configuration value.");
        }
        return $value;
    }

    private function getApiResponse($username, $password)
    {
        $url = $this->getConfig('url');
        $method = $this->getConfig('method');
        $usernameField = $this->getConfig('username-field');
        $passwordField = $this->getConfig('password-field');
        $additionalParams = $this->getConfig('additionalParams', false);

        $post = $method === 'POST'; // otherwise GET

        // Build POST/GET parameters
        $params = array(
            $usernameField => $username,
            $passwordField => $password,
        );

        $params = http_build_query($params);

        if ($additionalParams) {
            $params .= $additionalParams;
        }

        $ch = curl_init();

        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        } else {
            $url .= '?' . $params;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $jsonResponse = @json_decode($response);

        $return = (object)array(
            'success' => false,
            'error' => null,
            'user' => null
        );

        if ($httpcode === 200) {
            $return->success = true;
            if (!empty($jsonResponse)) {
                if (isset($jsonResponse->user)) {
                    $return->user = $jsonResponse->user;
                }
            }
        } else {
            if (!empty($jsonResponse)) {
                if (isset($jsonResponse->error)) {
                    $return->error = $jsonResponse->error;
                }
            }
        }

        return $return;
    }
}
