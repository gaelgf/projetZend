<?php
 // Filename: /module/Admin/src/Admin/Factory/WriteControllerFactory.php
 namespace Admin\Factory;

 use Admin\Controller\WriteController;
 use Zend\ServiceManager\FactoryInterface;
 use Zend\ServiceManager\ServiceLocatorInterface;

 class PostControllerFactory implements FactoryInterface
 {
     public function createService(ServiceLocatorInterface $serviceLocator)
     {
         $realServiceLocator = $serviceLocator->getServiceLocator();
         $postService        = $realServiceLocator->get('Admin\Service\PostServiceInterface');
         $postInsertForm     = $realServiceLocator->get('FormElementManager')->get('Admin\Form\PostForm');

         return new PostController(
             $postService,
             $postInsertForm
         );
     }
 }