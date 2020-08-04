<?php

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;

require __DIR__ . '/../vendor/autoload.php';

function allowPolicy(string $methodArn)
{
    return [
        'principalId' => "apigateway.amazonaws.com",
        'policyDocument' => [
            "Version" => "2012-10-17",
            "Statement" => [
                [
                    "Action" => "execute-api:Invoke",
                    "Effect" => "Allow",
                    "Resource" => $methodArn,
                ]
            ]
        ]
    ];
}

function denyPolicy()
{
    return [
        "principalId" => "*",
        "policyDocument" => [
            "Version" => "2012-10-17",
            "Statement" => [
                [
                    "Action" => "*",
                    "Effect" => "Deny",
                    "Resource" => "*"
                ]
            ]
        ]
    ];
}

return function ($event) {
    $token = substr($event['authorizationToken'] ?? 'Bearer ', 7);
    $methodArn = $event['methodArn'];

    $signer = new Sha256();
    $publicKey = new Key('file://public_key.pem');

    $token = (new Parser())->parse($token);
    if ($token->verify($signer, $publicKey)) {
        return allowPolicy($methodArn);
    }

    return denyPolicy();
};

