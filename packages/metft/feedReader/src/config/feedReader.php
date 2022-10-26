<?php
return [
    'fillables'=>[
        'title',
        'link',
        'category',
        'description',
    ],

    'optional_fillables'=>[
        'cover_image'
    ],
    'slug-separator'=>'-',

    // Md5,Sha-256
    'hash-method'=>'md5',

    'to-watch-server'=>[
        'Cointelegraph',
        'Newsbtc',
        'Cryptoninjas'
    ],
    "feed-servers"=>[
        "cointelegraph"=>[
            "name"=>"Cointelegraph",
            "home_url"=>"https://cointelegraph.com",
            "feeds_url"=>"https://cointelegraph.com/rss"
        ],
        "newsbtc"=>[
            "name"=>"Newsbtc", 
            "home_url"=>"https://newsbtc.com",
            "feeds_url"=>"https://newsbtc/rss"
        ],
    ]
];