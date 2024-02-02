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
                P::pass('test','34.50','Beats','Beats Studio Wireless');
                exit();
            }catch(\Exception $e){
                App::result('msg', $e->getMessage());
            }
        },['get'],true);

    }
}