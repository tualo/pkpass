<?php

namespace Tualo\Office\PKPass;

use Tualo\Office\Basic\TualoApplication;
use Ramsey\Uuid\Uuid;
use PKPass\PKPass AS Pass;

class PKPass
{

    private static $ENV = null;

    public static function env(string $key,mixed $default=false)
    {
        $env = self::getEnvironment();
        if (isset($env[$key])) {
            return $env[$key];
        }
        return $default;
    }

    public static function getEnvironment(): array
    {
        if (is_null(self::$ENV)) {
            $db = TualoApplication::get('session')->getDB();
            try {
                if (!is_null($db)) {
                    $data = $db->direct('select id,val from teams_environment');
                    foreach ($data as $d) {
                        self::$ENV[$d['id']] = $d['val'];
                    }
                }
            } catch (\Exception $e) {
            }
        }
        return self::$ENV;
    }

    public static function pass(
        string $id,
        string $balance,
        string $name
    ) : mixed {
        $pass = new Pass();
        $pass->setCertificatePath('../../../Certificate.p12'); // Set the path to your Pass Certificate (.p12 file)
        $pass->setCertificatePassword('test123'); // Set password for certificate
        $pass->setWwdrCertificatePath('../../../AppleWWDR.pem');
        $pass->setData('{
            "passTypeIdentifier": "pass.com.apple.test",
            "formatVersion": 1,
            "organizationName": "Starbucks",
            "teamIdentifier": "AGK5BZEN3E",
            "serialNumber": "' . $id . '",
            "backgroundColor": "rgb(240,240,240)",
            "logoText": "Starbucks",
            "description": "Demo pass",
            "storeCard": {
            "secondaryFields": [
                {
                    "key": "balance",
                    "label": "BALANCE",
                    "value": "' . $balance . '"
                },
                {
                    "key": "name",
                    "label": "NICKNAME",
                    "value": "' . $name . '"
                }

            ],
            "backFields": [
                {
                    "key": "id",
                    "label": "Card Number",
                    "value": "' . $id . '"
                }
            ]
        },
        "barcode": {
            "format": "PKBarcodeFormatPDF417",
            "message": "' . $id . '",
            "messageEncoding": "iso-8859-1",
            "altText": "' . $id . '"
        }
        }');

        // add files to the PKPass package
        $pass->addFile('icon.png');
        $pass->addFile('icon@2x.png');
        $pass->addFile('logo.png');
        $pass->addFile('background.png', 'strip.png');

        if ( !$pass->create(true)) { // Create and output the PKPass
            echo 'Error: ' . $pass->getError();
        }

    }
}

