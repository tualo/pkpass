<?php

namespace Tualo\Office\PKPass;

use Tualo\Office\Basic\TualoApplication AS App; 
use Ramsey\Uuid\Uuid;
use PKPass\PKPass AS Pass;
use Tualo\Office\DS\DSFiles;
class PKPass
{

    private static $ENV = null;
    private static $params = null;

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

    public static function param(string $key,mixed $default=false)
    {
        $env = self::$params;
        if (isset($env[$key])) {
            return $env[$key];
        }
        return $default;
    }

    public static function binary(string $data):mixed
    {
        list($mime,$data) =  explode(',',$data);
        return base64_decode($data);
    }

    public static function pass(
        string $id,
        array $params
    ) : mixed {
        $pass = new Pass();
        self::$params = $params;

        $files=DSFiles::instance('tualocms_bilder');
        file_put_contents(App::get('tempPath').'/c.p12', self::binary($files->getBase64('titel',self::env('apple_certificate'))));
        file_put_contents(App::get('tempPath').'/AppleWWDR.cer', self::binary($files->getBase64('titel',self::env('apple_wwdr_certificate'))));
        $pass->setCertificatePath(App::get('tempPath').'/c.p12'); // Set the path to your Pass Certificate (.p12 file)
        $pass->setCertificatePassword(self::env('apple_cert_pass')); // Set password for certificate
        $pass->setWwdrCertificatePath(App::get('tempPath').'/AppleWWDR.cer');

        $object = [
            'passTypeIdentifier' => self::env('apple_passTypeIdentifier'),
            'formatVersion' => 1,
            'organizationName' => self::env('apple_organizationName'),
            'teamIdentifier' => self::env('apple_teamIdentifier'),
            'serialNumber' => $id,
            'backgroundColor' => self::param('apple_backgroundColor','rgb(240,240,240)'),
            'foregroundColor' => self::param('apple_foregroundColor','rgb(0,0,0)'),
            'labelColor' => self::param('apple_labelColor','rgb(0,0,0)'),
            'logoText' => self::param('apple_logoText'),
            'description' => self::param('description',''),
            'eventTicket' => [
                
                'backFields' => [
                    [
                        'key' => 'KEY_ADDITIONAL_ACCESSCODE',
                        'label' => self::param('KEY_ADDITIONAL_ACCESSCODE:LABEL',''),
                        'value' => self::param('KEY_ADDITIONAL_ACCESSCODE:VALUE','')
                    ],
                    [
                        'changeMessage' => 'restxt_chg_event',
                        'key' => 'KEY_EVENTLINE',
                        'label' => self::param('KEY_EVENTLINE:LABEL',''),
                        'value' => self::param('KEY_EVENTLINE:VALUE','')
                    ],
                    [
                        'changeMessage' => 'restxt_chg_venue',
                        'key' => 'KEY_LOCATION',
                        'label' => self::param('KEY_LOCATION:LABEL',''),
                        'value' => self::param('KEY_LOCATION:VALUE','')
                    ],
                    [
                        'key' => 'KEY_BACK_PRICE',
                        'label' => self::param('KEY_BACK_PRICE:LABEL',''),
                        'value' => self::param('KEY_BACK_PRICE:VALUE','')
                    ],
                    [
                        'changeMessage' => 'restxt_chg_additional',
                        'key' => 'KEY_BACK_DATA_Additional_Front1',
                        'label' => self::param('KEY_BACK_DATA_Additional_Front1:LABEL',' '),
                        'value' => self::param('KEY_BACK_DATA_Additional_Front1:VALUE',' ')
                    ],
                    [
                        'changeMessage' => 'restxt_chg_additional',
                        'key' => 'KEY_BACK_DATA_Additional_Front2',
                        'label' => self::param('KEY_BACK_DATA_Additional_Front2:LABEL',' '),
                        'value' => self::param('KEY_BACK_DATA_Additional_Front2:VALUE',' ')
                    ],
                    [
                        'changeMessage' => 'restxt_chg_additional',
                        'key' => 'KEY_BACK_DATA_Additional_Front3',
                        'label' => self::param('KEY_BACK_DATA_Additional_Front3:LABEL',' '),
                        'value' => self::param('KEY_BACK_DATA_Additional_Front3:VALUE',' ')
                    ],
                    [
                        'changeMessage' => 'restxt_chg_additional',
                        'key' => 'KEY_BACK_DATA_Additional_Front4',
                        'label' => self::param('KEY_BACK_DATA_Additional_Front4:LABEL',' '),
                        'value' => self::param('KEY_BACK_DATA_Additional_Front4:VALUE',' ')
                    ],
                    [
                        'changeMessage' => 'restxt_chg_additional',
                        'key' => 'KEY_BACK_DATA_Additional_Front5',
                        'label' => self::param('KEY_BACK_DATA_Additional_Front5:LABEL',' '),
                        'value' => self::param('KEY_BACK_DATA_Additional_Front5:VALUE',' ')
                    ],
                    [
                        'changeMessage' => 'restxt_chg_additional',
                        'key' => 'KEY_BACK_DATA_Additional_Front6',
                        'label' => self::param('KEY_BACK_DATA_Additional_Front6:LABEL',' '),
                        'value' => self::param('KEY_BACK_DATA_Additional_Front6:VALUE',' ')
                    ]
                ],
                'headerFields' => [
                    [
                        'changeMessage' => 'restxt_chg_date',
                        'key' => 'KEY_HEADER_LOCATION_DATE',
                        'label' => self::param('KEY_HEADER_LOCATION_DATE:LABEL',''),
                        'value' => self::param('KEY_HEADER_LOCATION_DATE:VALUE','')
                    ]
                ],
                'primaryFields' => [
                    [
                        'changeMessage' => 'restxt_chg_event',
                        'key' => 'KEY_PRIMERY',
                        'label' => self::param('KEY_PRIMERY:LABEL',''),
                        'value' => self::param('KEY_PRIMERY:VALUE','')
                    ]
                ],
                'auxiliaryFields' => [
                    [
                        'changeMessage' => 'restxt_chg_seat',
                        'key' => 'KEY_AUX_SEAT_1',
                        'label' => self::param('KEY_AUXILIARY:LABEL',''),
                        'value' => self::param('KEY_AUXILIARY:VALUE','')
                    ]
                ],
                
                'secondaryFields' => [
                    [
                        'key' => 'KEY_SECONDARY_TICKETTYPENAME',
                        'label' => self::param('KEY_SECONDARY_TICKETTYPENAME:LABEL',' '),
                        'value' => self::param('KEY_SECONDARY_TICKETTYPENAME:VALUE',' ')
                    ]
                ]
            ],
            'relevantDate' => self::param('utc_datetime',''),
            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => $id,
                'messageEncoding' => 'iso-8859-1',
                'altText' => $id
            ]
        ];
        $pass->setData(json_encode($object));


        file_put_contents(App::get('tempPath').'/'.self::env('apple_icon'), self::binary($files->getBase64('titel',self::env('apple_icon'))));
        file_put_contents(App::get('tempPath').'/'.self::env('apple_icon2x'), self::binary($files->getBase64('titel',self::env('apple_icon2x'))));
        file_put_contents(App::get('tempPath').'/'.self::env('apple_logo'), self::binary($files->getBase64('titel',self::env('apple_logo'))));

        // add files to the PKPass package
        $pass->addFile(App::get('tempPath').'/'.self::env('apple_icon'),'icon.png');
        $pass->addFile(App::get('tempPath').'/'.self::env('apple_icon2x'),'icon@2x.png');
        $pass->addFile(App::get('tempPath').'/'.self::env('apple_logo'),'logo.png');


        if (isset(self::$params['apple_strip'])){
            $params_files=DSFiles::instance(self::$params['apple_strip'][0]);
            file_put_contents(App::get('tempPath').'/'.self::$params['apple_strip'], self::binary($files->getBase64('titel',self::$params['apple_strip'][1])));
            $pass->addFile(App::get('tempPath').'/'.self::$params['apple_strip'], 'background.png');
        }else{
            if (self::env('apple_strip','')!=''){
                file_put_contents(App::get('tempPath').'/'.self::env('apple_strip'), self::binary($files->getBase64('titel',self::env('apple_strip'))));
                $pass->addFile(App::get('tempPath').'/'.self::env('apple_strip'), 'strip.png');
            }
        }

        if (isset(self::$params['apple_background'])){
            $params_files=DSFiles::instance(self::$params['apple_background'][0]);
            file_put_contents(App::get('tempPath').'/'.self::$params['apple_background'], self::binary($files->getBase64('titel',self::$params['apple_background'][1])));
            $pass->addFile(App::get('tempPath').'/'.self::$params['apple_background'], 'background.png');
        }else{
            if (self::env('apple_background','')!=''){
                file_put_contents(App::get('tempPath').'/'.self::env('apple_background'), self::binary($files->getBase64('titel',self::env('apple_background'))));
                $pass->addFile(App::get('tempPath').'/'.self::env('apple_background'), 'background.png');
            }
        }

        if ( !$pass->create(true)) { // Create and output the PKPass
            // echo 'Error: ' . $pass->getError();
        }
        return true;
    }
}

