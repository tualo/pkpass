<?php
namespace Tualo\Office\PKPass\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route as BasicRoute;
use Tualo\Office\Basic\IRoute;
use Tualo\Office\PKPass\PKPass as P;

class PKPass implements IRoute{
    public static function register(){
        BasicRoute::add('/pkpass/(?P<channel>[\w.\/\-]+)',function($matches){
            try{
                App::contenttype('application/json');
                if (!isset($_POST['message'])) throw new \Exception('message is missing!');
                App::result('r',T::sendMessage($matches['channel'],$_POST['messgae']));

                App::result('success',true);
            }catch(\Exception $e){
                App::result('msg', $e->getMessage());
            }
        },['post'],true);

    }
}