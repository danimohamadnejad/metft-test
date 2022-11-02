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
    'login-methods'=>[
        'idpass'=>Metft\Auth\LoginMethods\LoginWithIdPass::class,
        'token'=>Metft\Auth\LoginMethods\LoginWithToken::class,
    ],
    'query-string-login-method-key'=>'login_method',
];