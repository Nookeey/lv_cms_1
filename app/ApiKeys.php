<?php

namespace App;

class ApiKeys 
{
    /**
     * API KEYS -> url key generator api/randApiKey
     * 
     * main => a0c56fce502260c167d4d1d530a1c0b2094adad54c0a515733f773e31f05091ee492c5dcae9e009d0ecd5010c7c02bed
     */
    public function chcekApiKey($apiKey) {
        $apiKeys = array(
            "a0c56fce502260c167d4d1d530a1c0b2094adad54c0a515733f773e31f05091ee492c5dcae9e009d0ecd5010c7c02bed"
        );

        if (in_array($apiKey, $apiKeys)) {
            return true;
        }
        return false;
    }

    public function invalidApiKey() {
        $info = 'Invalid Api Key!';
        return $info;
    }
}
