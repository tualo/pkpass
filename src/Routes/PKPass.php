<?php
namespace Tualo\Office\PKPass\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route as BasicRoute;
use Tualo\Office\Basic\IRoute;
use Tualo\Office\PKPass\PKPass as P;

class PKPass implements IRoute{
    public static function register(){
        BasicRoute::add('/pkpass/test',function($matches){
            try{
                App::contenttype('application/json');

                $utc = new DateTimeImmutable('2038-12-25 17:30:00', new DateTimeZone('Europe/Berlin'));
                $utc->setTimezone(new DateTimeZone("UTC"));

                $param=[];
                
                $param['KEY_ADDITIONAL_ACCESSCODE:LABEL']='Zugriffscode';
                $param['KEY_ADDITIONAL_ACCESSCODE:VALUE']='123456';
                
                $param['KEY_PRIMERY:LABEL']='Ticket';
                $param['KEY_PRIMERY:VALUE']='Musterveranstaltung';



                $param['KEY_LOCATION:LABEL']='Ort';
                $param['KEY_LOCATION:VALUE']='Musterort';

                
                $param['KEY_BACK_PRICE:LABEL']='Kategorie';
                $param['KEY_BACK_PRICE:VALUE']='Muster';


                $param['KEY_BACK_DATA_Additional_Front1:LABEL']='Details';
                $param['KEY_BACK_DATA_Additional_Front1:VALUE']=''; // $event['description_md'];

                $param['KEY_BACK_DATA_Additional_Front2:LABEL']='Einschränkungen';
                $param['KEY_BACK_DATA_Additional_Front2:VALUE']='Zutritt ausschließlich ab 18 Jahre und nur mit gültigem Nachweis! Admission only from the age of 18 and only with valid proof!';

                $param['KEY_BACK_DATA_Additional_Front3:LABEL']='Einschränkungen';
                $param['KEY_BACK_DATA_Additional_Front3:VALUE']='Es gibt leider keinen Aufzug oder barrierefreien Zugang. Der Eingang und die Toiletten sind nur über Treppen zu erreichen.';

                $param['KEY_BACK_DATA_Additional_Front4:LABEL']='';
                $param['KEY_BACK_DATA_Additional_Front4:VALUE']='';

                $param['KEY_BACK_DATA_Additional_Front5:LABEL']='';
                $param['KEY_BACK_DATA_Additional_Front5:VALUE']='';
                
                // 2023-06-07T17:30+00:00
                $param['utc_datetime']=str_replace(' ','T',$utc->format("Y-m-d H:i+00:00"))              ;

                $param['KEY_SECONDARY_TICKETTYPENAME:LABEL']='Kategorie';
                $param['KEY_SECONDARY_TICKETTYPENAME:VALUE']=$ticket['cat'];
                
                $param['KEY_HEADER_LOCATION_DATE:LABEL']='Am';
                $param['KEY_HEADER_LOCATION_DATE:VALUE']=$utc->format("d.m.Y H:i");
                
                $param['KEY_SECONDARY_TICKETTYPENAME']=$ticket['cat'];

                $param['apple_logoText']='';
                $param['apple_backgroundColor']='rgb(0,0,0)';
                $param['apple_foregroundColor']='rgb(255,255,255)';
                $param['apple_labelColor']='rgb(240,240,240)';

                P::pass('test',$param);
                exit();
            }catch(\Exception $e){
                App::result('msg', $e->getMessage());
            }
        },['get'],true);

    }
}