<?php  require dirname(__FILE__) . DIRECTORY_SEPARATOR .'vendor/autoload.php';  

  use \PHPWineVanillaFlavour\Wine\System\Auth;

  new \PHPWineVanillaFlavour\Wine\Optimizer\Html;
  new \PHPWineVanillaFlavour\Wine\Optimizer\EnhancerElem; 

AUTH::USERAUTH('login');

echo " Welcome and Hello  :)) " . elem('a',[['href'],['logout.php']]);

/**
 * 
 * Would you like me to treat a cake and coffee ?
 * Become a donor, Because with you! We can build more...
 * Donate:
 * GCash : +639650332900
 * Paypal account: syncdevprojects@gmail.com
 * 
 **/



  