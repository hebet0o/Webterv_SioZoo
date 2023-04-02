<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

if (!isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['email'])) {
    echo "Minden mező kitöltése kötelező!";
    exit;
}

$to = "SioZoo@webtervezes.hu";

$subject = "SioZoo - Új kérdés érkezett!";

$name = $_POST['vnev'] . $_POST['knev'];
$email = $_POST['phone'];
$phone = $_POST['email'];
$body = $_POST['body'];

$headers = "From: {$email}" . PHP_EOL;

if (mail($to, $subject, $body, $headers)) {
    echo "Kérdése! Igykeszünk minnél előbb válaszolni!";
} else {
    echo "Valami hiba történt az elküldés során!";
}
