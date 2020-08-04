<?php

require __DIR__ . '/vendor/autoload.php';

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
    $token = $event['authorizationToken'] ?? '';
    $methodArn = $event['methodArn'];

    if ($token === 'OK') {
        return allowPolicy($methodArn);
    }

    return denyPolicy();
};

