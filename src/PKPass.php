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
        file_put_contents(App::get('tempPath').'/c.p12', base64_decode($files->getBase64('titel',self::env('apple_certificate'))));
        file_put_contents(App::get('tempPath').'/AppleWWDR.cer', base64_decode($files->getBase64('titel',self::env('apple_wwdr_certificate'))));

        $pass->setCertificatePath(App::get('tempPath').'/c.p12'); // Set the path to your Pass Certificate (.p12 file)
        $pass->setCertificatePassword(self::env('apple_cert_pass')); // Set password for certificate
        $pass->setWwdrCertificatePath(App::get('tempPath').'/AppleWWDR.cer');
        $pass->setData('{
            "passTypeIdentifier": "'.self::env('apple_passTypeIdentifier').'",
            "formatVersion": 1,
            "organizationName": "'.self::env('apple_organizationName').'",
            "teamIdentifier": "'.self::env('apple_teamIdentifier').'",
            "serialNumber": "' . $id . '",
            "backgroundColor": "rgb(240,240,240)",
            "logoText": "'.self::env('apple_logoText').'",
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
                    "label": "'.self::env('apple_backFieldsLabel').'",
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

        file_put_contents(App::get('tempPath').'/'.self::env('apple_icon'), base64_decode($files->getBase64('titel',self::env('apple_icon'))));
        file_put_contents(App::get('tempPath').'/'.self::env('apple_icon2x'), base64_decode($files->getBase64('titel',self::env('apple_icon2x'))));
        file_put_contents(App::get('tempPath').'/'.self::env('apple_logo'), base64_decode($files->getBase64('titel',self::env('apple_logo'))));
        file_put_contents(App::get('tempPath').'/'.self::env('apple_strip'), base64_decode($files->getBase64('titel',self::env('apple_strip'))));

        // add files to the PKPass package
        $pass->addFile(self::env('apple_icon'),'icon.png');
        $pass->addFile(self::env('apple_icon2x'),'icon@2x.png');
        $pass->addFile(self::env('apple_logo'),'logo.png');
        $pass->addFile(self::env('apple_strip'), 'strip.png');

        if ( !$pass->create(true)) { // Create and output the PKPass
            echo 'Error: ' . $pass->getError();
        }

    }
}

