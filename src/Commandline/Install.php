<?php
namespace Tualo\Office\PKPass\Commandline;
use Tualo\Office\Basic\ICommandline;
use Tualo\Office\Basic\CommandLineInstallSQL;

class Install extends CommandLineInstallSQL  implements ICommandline{
    public static function getDir():string {   return dirname(__DIR__,1); }
    public static $shortName  = 'pkpass';
    public static $files = [
        'install/pkpass_environment' => 'setup pkpass_environment  ',
        'install/pkpass_environment.ds' => 'setup pkpass_environment  ds ',

    ];
    
}