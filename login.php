<?php  require dirname(__FILE__) . DIRECTORY_SEPARATOR .'vendor/autoload.php';  

  use \PHPWineVanillaFlavour\Wine\System\Auth;
  use \PHPWineVanillaFlavour\Wine\System\Request;
  use \PHPWineVanillaFlavour\Wine\System\Validate;
  use \PHPWineVanillaFlavour\Plugins\PHPCrud\Crud\Vanilla;

  $portal = new class {
        
    /**
    * @var string 
    * @property string $err_username 
    * Defined return error username  
    * HTML field and error msg
    * @since PHPWine v1.4
    * @since 06.19.2022
    **/
    private ?string $err_username;

    /**
    * @var string 
    * @property string $err_password 
    * Defined return error err_password 
    * HTML field and error msg
    * @since PHPWine v1.4
    * @since 06.19.2022
    **/
    private ?string $err_password;

    /**
    * @var string 
    * @property string auth_err 
    * Defined return error auth_err 
    * HTML field and error msg
    * @since PHPWine v1.4
    * @since 06.19.2022
    **/
    private ?string $auth_err;

    /**
    * @var string 
    * @property string eCatch 
    * Defined return error eCatch 
    * HTML field and error msg
    * @since PHPWine v1.4
    * @since 06.19.2022
    **/
    private string $eCatch;

    /**
    * @var string 
    * @property string form_portal 
    * Defined return error form_portal 
    * HTML field and error msg
    * @since PHPWine v1.4
    * @since 06.19.2022
    **/    
    private string $form_portal;

    /**
      * Defined Installing dependecies __construct;
      * @since PHPWine v1.4
      * @since 06.19.2022
      **/ 
    public function __construct() {

     /**
      * Defined If the session is true or active then redirect to certain page!
      * @since 04.05.21
      * @since v1.0
      **/ 
     AUTH::USERAUTH('dashboard', true); 

     new \PHPWineVanillaFlavour\Wine\Optimizer\Html;
     new \PHPWineVanillaFlavour\Wine\Optimizer\EnhancerElem; 
     new \PHPWineVanillaFlavour\Wine\Optimizer\EnhancerDoIf; 
     new \PHPWineVanillaFlavour\Wine\Optimizer\EnhancerSetElemAttr; 
     new \PHPWineVanillaFlavour\Wine\Optimizer\HtmlH1;  
     new \PHPWineVanillaFlavour\Wine\Optimizer\HtmlDiv;
     new \PHPWineVanillaFlavour\Wine\Optimizer\HtmlUl;
     new \PHPWineVanillaFlavour\Wine\Optimizer\HtmlForm;
     
     // programm request
     $this->wine_portal();

     // do process
     print $this->wine_portal_error_messages()
                ->wine_portal_form()
                ->wine_portal_execute();
 
    }

  /**
   * Defined Make request for data formlogin when submit it !
   * @since 04.06.21
   * @since v1.0
   **/ 
  private function wine_portal()  {

    if($_SERVER["REQUEST_METHOD"] == "POST") :  

        /**
         * Defined Check if username has contains
         * @since 04.06.21
         * @since v1.0
         **/ 
         $un           = VALIDATE::$DATAFORM = ["username","Enter username or email or mobile"];
         $username     = VALIDATE::HASCONTAINS($un);  
         $this->err_username = VALIDATE::ERROR($username, $un);
        
        /**
         * Defined Check if password has contains
         * @since 04.06.21
         * @since v1.0
         **/ 
         $pw           = VALIDATE::$DATAFORM = ["password","Please enter valid associated password."];
         $password     = VALIDATE::HASCONTAINS($pw);  
         $this->err_password = VALIDATE::ERROR($password, $pw);
        
        /**
         * Defined Default|CaseSensitive = ["username","email","mobile","password"...etc...]
         * @since 04.06.21
         * @since v1.0
         **/ 
         $this->auth_err = AUTH::BIND( (new Vanilla)->wine_db() , 
         [   
            
             'QUERY_STATEMENT'         => AUTH::CHECKQUERY('users',['username','email','mobile','password','id','created_at'])
            ,'USERNAME_HASCONTAINS'    => $username 
            ,'USERNAME_ERROR'          => $this->err_username
            ,'PASSWORD_HASCONTAINS'    => $password
            ,'PASSWORD_ERROR'          => $this->err_password
            ,'NOTEXIST_CREDENTIAL'     => "USERNAME OR PASSWORD IS NOT ACCOSIATED WITH OUR SYSTEM" // email and password not exist to system
            ,'NOTASSOCIATED_CREDENTIAL'=> "INVALID CREDENTIALS ! NOT YET ACCOSIATED WITH OUR SYSTEM!" // either password/mobile/email/username is not assciated to system
            ,'USER_REDIRECT'           => "dashboard"
        
         ], REQUEST::SESSION_PORTAL_REQUEST ); 
        
      endif;  

    }

   /**
    * Defined error message handler reg form !
    * @since PHPWine v1.4
    * @since 06.19.2022
    **/ 
    private function wine_portal_error_messages() : self {

        if ( !empty( $this->eCatch = UL(function() { $print = [];
            
          foreach([ $this->err_username?? '', $this->err_password?? '', $this->auth_err?? ''] as $error) {
          
            $print[] = $error? ELEM('li' , $error , setElemAttr(['class'],['err_username_msg'])) : '';
          
          }

          return (implode("", $print));
        }
        , attr  : [ ]
        , id    : 'id-eCatch_err'
        , class : 'eCatch_error'
       
       ))) {

        return ($this);
      
      };

    }

   /**
    * Defined wine_portal_form!
    * @since PHPWine v1.4
    * @since 06.19.2022
    **/ 
    private function wine_portal_form() : self {

       $this->form_portal = form([ CHILD => [

            ['div', INNER => [
               
               ['label', ATTR => ['id'=>'id-username'], VALUE => ['Username/Email/Mobile: ']] ,
               ['input', ATTR => [
                   'type'  => 'text',
                   'id'    => 'id-username',
                   'class' => 'username',
                   'name'  => 'username',
                   'value' => ((isset($_COOKIE['username'])) ? $_COOKIE['username'] : ($username?? '') )
               ]]
        
            ]],
            ['div', INNER => [
               
                ['label', ATTR => ['id'=>'id-username'], VALUE => ['Password: ']] ,
                ['input', ATTR => [
                    'type'  => 'text',
                    'id'    => 'id-password',
                    'class' => 'password',
                    'name'  => 'password',
                    'value' => ((isset($_COOKIE['password'])) ? $_COOKIE['password'] : ($password?? '') )
                ]]
         
             ]],
             ['div', INNER => [
                
                 ['input', ATTR => [
                     'type'  => 'checkbox',
                     'id'    => 'id-remember',
                     'class' => 'remember',
                     'name'  => 'remember',
                     'value' => ((isset($_COOKIE["username"])) ? 'checked' : false)
                 ]],
                 ['label', ATTR => ['id'=>'id-remember'], VALUE => ['Remember me: ']] 
          
              ]],
              ['div', INNER => [
                
                ['input', ATTR => [
                    'type'  => 'submit', 'id'    => 'id-submit',
                    'class' => 'submit', 'name'  => 'submit',
                    'value' => 'Submit'
                ]]
         
             ]],
             ['div', INNER => [
                ['p', VALUE => [ ELEM('p','Don\'t have an account?'.ELEM('a','Sign up now',[['href'],['register.php']]) ) ]]
             ]]
        
         ]], attr : setElemAttr(['action','method'],[ htmlspecialchars($_SERVER["PHP_SELF"]), 'POST']) );

         return ($this);

    }

   /**
    * Defined execute chaining method!
    * @since PHPWine v1.4
    * @since 06.19.2022
    **/ 
    private function wine_portal_execute() {
        
        return $this->eCatch . $this->form_portal ;

    } 

  }; 
  
/**
 * 
 * Would you like me to treat a cake and coffee ?
 * Become a donor, Because with you! We can build more...
 * Donate:
 * GCash : +639650332900
 * Paypal account: syncdevprojects@gmail.com
 * 
 **/





