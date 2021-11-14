<?php

use Rootsoft\Algorand\Clients\PureStake;

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'gerencianet' => [
        'pixkey' => env('GERENCIANET_PIX_KEY'),
        'env' => env('GERENCIANET_ENV', 'dev'),
        'dev' => [
            'key' => env('GERENCIANET_H_PIX_KEY'),
            'client_id' => env('GERENCIANET_H_CLIENT_ID'),
            'client_secret' => env('GERENCIANET_H_CLIENT_SECRET'),
            'certificate' => env('GERENCIANET_H_CERTPATH', storage_path('app/certs/pix/gerencianet.pem')),
            'certificate_password' => env('GERENCIANET_H_CERT_PASS', ''),
            'base_url' => 'https://api-pix-h.gerencianet.com.br',
        ],
        'default' => [
            'key' => env('GERENCIANET_PIX_KEY'),
            'client_id' => env('GERENCIANET_CLIENT_ID'),
            'client_secret' => env('GERENCIANET_CLIENT_SECRET'),
            'certificate' => env('GERENCIANET_CERT', storage_path('app/certs/pix/gerencianet-prod.pem')),
            'certificate_password' => env('GERENCIANET_CERT_PASS', ''),
            'base_url' => 'https://api-pix.gerencianet.com.br',
        ],
        'bankCode' => 455,
        'routingNumber' => '4434',
        'accountNumber' => '1233-3',
        'holderDocumentNumber' => '33.241.170/0001-17',
        'holderDocumentType' => 'CNPJ',
        'holderName' => 'R DE A V VERDE (Autum)'
    ],

    'algorand' => [
        'wallet' => env('MASTER_WALLET_ADDRESS'),
        'asset_id' => env('MASTER_COIN_ID'),
        'seed' => env('MASTER_WALLET_SEED'),
    ],

    'purestake' => [
        'default' => env('ALGORAND_NET', 'testnet'),
        'mainnet' => [
            'indexer_url' => 'https://mainnet-algorand.api.purestake.io/idx2',
            'algod_url' => 'https://mainnet-algorand.api.purestake.io/ps2',
            'api_token_header' => 'X-API-Key',
            'api_key' => env('PURESTAKE_API_KEY'),
        ],
        'testnet' => [
            'indexer_url' => 'https://testnet-algorand.api.purestake.io/idx2',
            'algod_url' => 'https://testnet-algorand.api.purestake.io/ps2',
            'api_token_header' => 'X-API-Key',
            'api_key' => env('PURESTAKE_API_KEY'),
        ],
        'betanet' => [
            'indexer_url' => 'https://betanet-algorand.api.purestake.io/idx2',
            'algod_url' => 'https://betanet-algorand.api.purestake.io/ps2',
            'api_token_header' => 'X-API-Key',
            'api_key' => env('PURESTAKE_API_KEY'),
        ],
    ],

];
