<?php
namespace Stadtradeln\Auth;

class AuthWebUntis
{
    private string $baseUrl;
    private string $school;
    private string $client;

    public function __construct()
    {
        $config = require 'webuntis_config.php';
        $this->baseUrl = rtrim($config['url'], '/') . '/';
        $this->school = $config['school'];
        $this->client = $config['client'] ?? 'Stadtradeln';
    }

    public function validateUser(?string $user, ?string $pass): bool
    {
        if (!$user || !$pass) return false;

        $url = $this->baseUrl . "jsonrpc.do?school=" . urlencode($this->school);

        $data = [
            'id' => 'ID',
            'method' => 'authenticate',
            'params' => [
                'user' => $user,
                'password' => $pass,
                'client' => $this->client
            ],
            'jsonrpc' => '2.0'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result === false || $http_code !== 200) {
            return false;
        }

        $json = json_decode($result, true);
        return isset($json['result']['sessionId']);
    }
}
