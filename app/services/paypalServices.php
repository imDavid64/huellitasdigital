<?php
class PaypalService {
    private $config;

    public function __construct() {
        $this->config = include __DIR__ . '/../../config/paypal_config.php';
    }

    public function createOrder($amount) {
        $url = "https://api-m.sandbox.paypal.com/v2/checkout/orders";
        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[ 'amount' => ['currency_code' => 'USD', 'value' => $amount] ]]
        ];
        return $this->sendRequest($url, $data);
    }

    private function sendRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->getAccessToken()
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    private function getAccessToken() {
        $url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $this->config['client_id'] . ':' . $this->config['client_secret'],
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials'
        ]);
        $response = curl_exec($ch);
        $json = json_decode($response, true);
        curl_close($ch);
        return $json['access_token'];
    }
}
