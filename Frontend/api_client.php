<?php
if (session_status() === PHP_SESSION_NONE) session_start();

const API_BASE = 'http://localhost:5090/api';

function api_request($method, $endpoint, $data = null, $isMultipart = false) {
    $ch = curl_init(API_BASE . $endpoint);
    $headers = [];

    if (!empty($_SESSION['token'])) {
        $headers[] = 'Authorization: Bearer ' . $_SESSION['token'];
    }

    if (!$isMultipart) {
        $headers[] = 'Content-Type: application/json';
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if ($data !== null) {
        if ($isMultipart) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['status' => $status, 'data' => json_decode($response, true), 'raw' => $response];
}

function require_login() {
    if (empty($_SESSION['token'])) {
        header('Location: login.php');
        exit;
    }
}

function require_role($roles) {
    require_login();
    if (!in_array($_SESSION['role'] ?? '', (array)$roles, true)) {
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}
