<?php

namespace Shop\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\AppBundle\Entity\Product;
use Shop\AppBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('Shop\AppBundle\Entity\Product');
        $products = $productRepository->findAll();

        return $this->render('ShopAppBundle:Default:index.html.twig', array(
            'products' => $products,
        ));
    }

    public function newAction(Request $request)
    {
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', 'text')
            ->add('dueDate', 'date')
            ->add('save', 'submit', array('label' => 'Create Task'))
            ->getForm();

        return $this->render('ShopAppBundle:Default:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
