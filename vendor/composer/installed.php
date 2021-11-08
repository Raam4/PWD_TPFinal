<?php return array(
    'root' => array(
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => NULL,
        'name' => '__root__',
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => NULL,
            'dev_requirement' => false,
        ),
        'almasaeed2010/adminlte' => array(
            'pretty_version' => 'v3.1.0',
            'version' => '3.1.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../almasaeed2010/adminlte',
            'aliases' => array(),
            'reference' => 'c641d7f5716ed47e76f70ab16e05ae41420120b8',
            'dev_requirement' => false,
        ),
        'twbs/bootstrap' => array(
            'pretty_version' => 'v5.1.3',
            'version' => '5.1.3.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../twbs/bootstrap',
            'aliases' => array(),
            'reference' => '1a6fdfae6be09b09eaced8f0e442ca6f7680a61e',
            'dev_requirement' => false,
        ),
        'twitter/bootstrap' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => 'v5.1.3',
            ),
        ),
    ),
);
