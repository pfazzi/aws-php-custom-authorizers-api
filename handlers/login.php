<?php
declare(strict_types=1);

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;

require __DIR__ . '/../vendor/autoload.php';

$signer = new Sha256();
$privateKey = new Key('file://./../private_key.pem');

$time = time();
$token = (new Builder())
    ->issuedBy('http://example.com') // Configures the issuer (iss claim)
    ->permittedFor('http://example.org') // Configures the audience (aud claim)
    ->identifiedBy('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
    ->issuedAt($time) // Configures the time that the token was issue (iat claim)
    ->canOnlyBeUsedAfter($time + 60) // Configures the time that the token can be used (nbf claim)
    ->expiresAt($time + 3600) // Configures the expiration time of the token (exp claim)
    ->withClaim('uid', 1) // Configures a new claim, called "uid"
    ->getToken($signer, $privateKey); // Retrieves the generated token

header('Content-Type: application/json');

echo json_encode([
    'token' => (string)$token
]);