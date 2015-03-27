<?php

namespace Shop\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\AppBundle\Entity\Task;
use Shop\AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

    public function addProductAction(Request $request)
    {
        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('Name', 'text')
            ->add('Price', 'text')
            ->add('Amount', 'text')
            ->add('save', 'submit', array('label' => 'Add product'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $name = $form->getData()->getName();
            $price = $form->getData()->getPrice();
            $amount = $form->getData()->getAmount();

            $product = new Product();
            $product->setName($name);
            $product->setPrice((float)$price);
            $product->setAmount((int)$amount);

            $em->persist($product);
            $em->flush();

            $name = 'Product';
            return $this->render('ShopAppBundle:Default:response.html.twig', array('name' => $name));
        }

        return $this->render('ShopAppBundle:Default:addProduct.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
