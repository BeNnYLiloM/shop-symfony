<?php

namespace Shop\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\AppBundle\Entity\Product;
use Shop\AppBundle\Entity\Order;
use Shop\AppBundle\Entity\OrderTask;
use Shop\AppBundle\Entity\OrderProduct;
use Shop\AppBundle\Form\Type\ProductType;
use Shop\AppBundle\Form\Type\OrderType;

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

    public function addProductAction(Request $request)
    {
        $form = $this->createForm(new ProductType(), new Product());

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $product = $form->getData();

            $em->persist($product);
            $em->flush();

            $nameTask = 'Product';
            return $this->render('ShopAppBundle:Default:response.html.twig', array(
                'nameTask' => $nameTask,
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'amount' => $product->getAmount(),
            ));
        }

        return $this->render('ShopAppBundle:Default:addProduct.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function orderProductAction(Request $request)
    {
        $form = $this->createForm(new OrderType(), new OrderTask());

        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('Shop\AppBundle\Entity\Product');
        $products = $productRepository->findAll();

        $form->handleRequest($request);

        if($form->isValid()){
            $orderData = $form->getData();

            if($orderData->getOrderId()){
                $order = $em->find('Shop\AppBundle\Entity\Order', $orderData->getOrderId());
                if($order){
                    $product = $em->find('Shop\AppBundle\Entity\Product', $orderData->getProductId());
                    if(!$product) {
                        return $this->render('ShopAppBundle:Default:error.html.twig', array(
                            'name' => 'Product',
                            'id' => $orderData->getProductId(),
                        ));
                    }

                    $cart = new OrderProduct();
                    $cart->setOrder($order)
                        ->setProduct($product)
                        ->setCount($orderData->getCount());

                    $em->persist($cart);
                    $em->flush();
                } else {
                    return $this->render('ShopAppBundle:Default:error.html.twig', array(
                        'name' => 'Order',
                        'id' => $orderData->getOrderId(),
                    ));
                }
            } else {
                $product = $em->find('Shop\AppBundle\Entity\Product', $orderData->getProductId());
                if(!$product) {
                    return $this->render('ShopAppBundle:Default:error.html.twig', array(
                        'name' => 'Product',
                        'id' => $orderData->getProductId(),
                    ));
                }

                $newOrder = new Order();
                $newOrder->setCreated(new \DateTime('now'));

                $em->persist($newOrder);
                $em->flush();

                $cart = new OrderProduct();
                $cart->setOrder($newOrder)
                    ->setProduct($product)
                    ->setCount($orderData->getCount());

                $em->persist($cart);
                $em->flush();
            }

            return $this->render('ShopAppBundle:Default:productAddedInCart.html.twig');
        }

        return $this->render('ShopAppBundle:Default:orderProduct.html.twig', array(
            'products' => $products,
            'form' => $form->createView(),
        ));
    }
}
