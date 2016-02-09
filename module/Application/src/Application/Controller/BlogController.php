<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{

    public function indexAction()
    {
    	$userService = $this->getServiceLocator()->get('Application\Service\UserService');
		$user = $userService->getByEmail('john.doe@doe.fr');
        //return new ViewModel();
        return new ViewModel(array('user' => $user));
    }
}
