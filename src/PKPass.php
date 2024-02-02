<?php

namespace Tualo\Office\PKPass;

use Tualo\Office\Basic\TualoApplication AS App; 
use Ramsey\Uuid\Uuid;
use PKPass\PKPass AS Pass;
use Tualo\Office\DS\DSFiles;
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
            $db = App::get('session')->getDB();
            try {
                if (!is_null($db)) {
                    $data = $db->direct('select id,val from pkpass_environment');
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
        string $name,
        string $description
    ) : mixed {
        $pass = new Pass();
        $files=DSFiles::instance('tualocms_bilder');
        file_put_contents(App::get('tempPath').'/c.p12', base64_decode($files->getBase64('titel',self::env('certificate'))));
        file_put_contents(App::get('tempPath').'/AppleWWDR.cer', base64_decode($files->getBase64('titel',self::env('wwdr_certificate'))));

        $pass->setCertificatePath(App::get('tempPath').'/c.p12'); // Set the path to your Pass Certificate (.p12 file)
        $pass->setCertificatePassword(self::env('cert_pass')); // Set password for certificate
        $pass->setWwdrCertificatePath(App::get('tempPath').'/AppleWWDR.cer');
        $pass->setData('{
            "passTypeIdentifier": "'.self::env('passTypeIdentifier').'",
            "formatVersion": 1,
            "organizationName": "'.self::env('organizationName').'",
            "teamIdentifier": "'.self::env('teamIdentifier').'",
            "serialNumber": "' . $id . '",
            "backgroundColor": "rgb(240,240,240)",
            "logoText": "'.self::env('logoText').'",
            "description": "' . $description . '",
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
                    "label": "'.self::env('backFieldsLabel').'",
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

