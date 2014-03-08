<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Functions\Controller\FunctionsController as Functions;

class IndexController extends AbstractActionController
{
    
    protected $functions;
    
    function __construct(){
        $this->functions = new Functions();
    }
    
    public function indexAction(){
           
        $user_profile = $this->functions->getWithAuthenticate("Facebook");
        
        /* 
         *  Se o usuario estiver autenticado pelo facebook ou pelo zfcuser,
         *  sera redirecionado para o module home
         */
        if ($user_profile || $this->zfcUserAuthentication()->hasIdentity()){
            
            return $this->redirect()->toRoute("album"); 
        }
        
        $vm = new ViewModel();
        // - Reseta o layout padrão da aplicação
        // $vm->setTerminal(true);
        
        return $vm;
    }
}
