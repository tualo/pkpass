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

    public static function binary(string $data):mixed
    {
        list($mime,$data) =  explode(',',$data);
        return base64_decode($data);
    }

    public static function pass(
        string $id,
        string $balance,
        string $name,
        string $description
    ) : mixed {
        $pass = new Pass();
        $files=DSFiles::instance('tualocms_bilder');
        file_put_contents(App::get('tempPath').'/c.p12', base64_decode(str_replace('data:application/x-pkcs12;base64,','',$files->getBase64('titel',self::env('apple_certificate')))));
        file_put_contents(App::get('tempPath').'/AppleWWDR.cer', base64_decode(str_replace('data:application/x-x509-ca-cert;base64,','',$files->getBase64('titel',self::env('apple_wwdr_certificate')))));

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
            "eventTicket": {
                "auxiliaryFields": [
                    {
                        "changeMessage": "restxt_chg_seat",
                        "key": "KEY_AUX_SEAT_1",
                        "label": "Eingang",
                        "value": "Parkett links"
                    },
                    {
                        "changeMessage": "restxt_chg_seat",
                        "key": "KEY_AUX_SEAT_2",
                        "label": "Block",
                        "value": "Parkett links"
                    },
                    {
                        "changeMessage": "restxt_chg_seat",
                        "key": "KEY_AUX_SEAT_3",
                        "label": "Reihe",
                        "value": "17"
                    },
                    {
                        "changeMessage": "restxt_chg_seat",
                        "key": "KEY_AUX_SEAT_4",
                        "label": "Platz",
                        "value": "6"
                    }
                ],
                "backFields": [
                    {
                        "key": "KEY_ADDITIONAL_ACCESSCODE",
                        "label": "restxt_additional_accesscode",
                        "value": "28FW44SB"
                    },
                    {
                        "changeMessage": "restxt_chg_event",
                        "key": "KEY_EVENTLINE",
                        "label": "restxt_event",
                        "value": "'.$name.'"
                    },
                    {
                        "changeMessage": "restxt_chg_venue",
                        "key": "KEY_LOCATION",
                        "label": "restxt_venue",
                        "value": "Stage Theater des Westens\nKantstraße 12 , 10623 BERLIN, DE"
                    },
                    {
                        "key": "KEY_BACK_SEATLINE",
                        "label": "restxt_seat",
                        "value": "Eingang: Parkett links, Block: Parkett links, Reihe: 17, Platz: 6"
                    },
                    {
                        "key": "KEY_BACK_PRICE",
                        "label": "restxt_price",
                        "value": "Kategorie 2\nNormalpreis"
                    },
                    {
                        "changeMessage": "restxt_chg_additional",
                        "key": "KEY_BACK_DATA_Additional_Front1",
                        "label": "Hinweise:",
                        "value": "Foyeröffnung ab 1 Std. vor Vorstellungsbeginn. Nach Vorstellungsbeginn kein Einlass.\n"
                    },
                    {
                        "changeMessage": "restxt_chg_additional",
                        "key": "KEY_BACK_DATA_Additional_Front2",
                        "label": "",
                        "value": "Ermäßigungsnachweise bitte beim Einlass vorzeigen."
                    },
                    {
                        "changeMessage": "restxt_chg_additional",
                        "key": "KEY_BACK_DATA_Additional_Front3",
                        "label": "",
                        "value": "Umtausch und Rückgabe von Tickets ist ausgeschlossen."
                    },
                    {
                        "changeMessage": "restxt_chg_additional",
                        "key": "KEY_BACK_DATA_Additional_Front4",
                        "label": "",
                        "value": "Kein Einlass für Kinder unter 3 Jahren."
                    },
                    {
                        "changeMessage": "restxt_chg_additional",
                        "key": "KEY_BACK_DATA_Additional_Front5",
                        "label": "",
                        "value": "Aus urheberrechtlichen Gründen sind Bild- und Tonaufnahmen nicht gestattet."
                    },
                    {
                        "changeMessage": "restxt_chg_additional",
                        "key": "KEY_BACK_DATA_Additional_Front6",
                        "label": "",
                        "value": "Bitte beachten Sie, dass am Einlass Sicherheitskontrollen stattfinden. Planen Sie daher ein, ca. eine Stunde vor Vorstellungsbeginn im Theater zu sein. Bitte verzichten Sie auf das Mitführen von großen Gepäckstücken oder Rucksäcken sowie Laptops, professionelle Fotografie-, Video- oder Audio-Geräte o. Ä. Wir danken für Ihr Verständnis."
                    }
                    
                ],
                "headerFields": [
                    {
                        "changeMessage": "restxt_chg_date",
                        "key": "KEY_HEADER_LOCATION_DATE",
                        "label": "Stage The...",
                        "value": "07.06.2023 19:30"
                    }
                ],
                "primaryFields": [
                    {
                        "changeMessage": "restxt_chg_event",
                        "key": "KEY_PRIMERY",
                        "label": "",
                        "value": "ROMEO & JULIA  Liebe ist alles -..."
                    }
                ],
                "secondaryFields": [
                    {
                        "key": "KEY_SECONDARY_TICKETTYPENAME",
                        "label": "",
                        "value": "Normalpreis"
                    }
                ]
            },
            "barcode": {
                "format": "PKBarcodeFormatQR",
                "message": "' . $id . '",
                "messageEncoding": "iso-8859-1",
                "altText": "' . $id . '"
            }
        }');

        file_put_contents(App::get('tempPath').'/'.self::env('apple_icon'), self::binary($files->getBase64('titel',self::env('apple_icon'))));
        file_put_contents(App::get('tempPath').'/'.self::env('apple_icon2x'), self::binary($files->getBase64('titel',self::env('apple_icon2x'))));
        file_put_contents(App::get('tempPath').'/'.self::env('apple_logo'), self::binary($files->getBase64('titel',self::env('apple_logo'))));
        file_put_contents(App::get('tempPath').'/'.self::env('apple_strip'), self::binary($files->getBase64('titel',self::env('apple_strip'))));

        // add files to the PKPass package
        $pass->addFile(App::get('tempPath').'/'.self::env('apple_icon'),'icon.png');
        $pass->addFile(App::get('tempPath').'/'.self::env('apple_icon2x'),'icon@2x.png');
        $pass->addFile(App::get('tempPath').'/'.self::env('apple_logo'),'logo.png');
        $pass->addFile(App::get('tempPath').'/'.self::env('apple_strip'), 'strip.png');

        if ( !$pass->create(true)) { // Create and output the PKPass
            echo 'Error: ' . $pass->getError();
        }

    }
}

