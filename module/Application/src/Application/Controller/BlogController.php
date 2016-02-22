<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\EntityUsingController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Post;
use Admin\Form\PostForm;

class BlogController extends EntityUsingController
{

    public function indexAction()
    {
    	$em = $this->getEntityManager();
        $posts = $em->getRepository('Admin\Entity\Post')->findBy(array(), array('titre' => 'ASC'));
        
        return new ViewModel(array('posts' => $posts,));
    }
}
