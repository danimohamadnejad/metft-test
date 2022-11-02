<?php
return [
    'routes-prefix'=>'metft-auth',
    'routes-alias'=>'metft-auth.',
    'authentication-guards'=>[
        'metft'=>[
            'driver'=>'metft',
            'provider'=>'users',
        ],
    ],
    'default-login-method'=>'idpass',
    'login-methods'=>[
        'idpass'=>Metft\Auth\LoginMethods\LoginWithIdPass::class,
        'token'=>Metft\Auth\LoginMethods\LoginWithToken::class,
    ],
    'request-login-method-key'=>'login_method',
];