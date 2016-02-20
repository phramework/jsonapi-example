<?php
declare(strict_types=1);

use Phramework\Testphase\Testphase;
use Phramework\Testphase\Globals;
use Phramework\Validate\ObjectValidator;
use Phramework\Validate\ArrayValidator;
use Phramework\Validate\StringValidator;

$settings = include __DIR__ . '/../../settings.php';

Testphase::setBase($settings['base']);

echo sprintf(
    'Base: "%s"',
    $settings['base']
) . PHP_EOL;

$responseBodyJsonapiCollection = new ObjectValidator(
    [
        'data' => new ArrayValidator(
            0,
            null,
            new ObjectValidator(
                (object) [
                    'id'   => new StringValidator(0, null, '/^[1-9][0-9]*$/'),
                    'type' => new StringValidator(2)
                ],
                ['id', 'type']
            )
        )
    ],
    ['data']
);

$responseBodyJsonapiResource = new ObjectValidator(
    [
        'data' => new  ObjectValidator(
            (object) [
                'id'   => new StringValidator(0, null),
                'type' => new StringValidator(2)
            ],
            ['id', 'type']
        )
    ],
    ['data']
);

Globals::set(
    'headerRequestContentType',
    'Content-Type: application/vnd.api+json'
);

Globals::set(
    'headerRequestAccept',
    'Accept: application/vnd.api+json'
);

Globals::set(
    'headerResponseContentType',
    'application/vnd.api+json;charset=utf-8'
);

Globals::set(
    'responseBodyJsonapiResource',
    $responseBodyJsonapiResource->toJSON()
);

Globals::set(
    'responseBodyJsonapiCollection',
    $responseBodyJsonapiCollection->toJSON()
);
