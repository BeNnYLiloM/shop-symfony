<?php

namespace Shop\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\AppBundle\Entity\Product;
use Shop\AppBundle\Entity\Order;
use Shop\AppBundle\Entity\OrderProduct;
use Shop\AppBundle\Entity\ShowTask;
use Shop\AppBundle\Form\Type\ProductType;
use Shop\AppBundle\Form\Type\OrderProductType;
use Shop\AppBundle\Form\Type\ShowType;
use Shop\AppBundle\Form\Type\EditType;

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
        $form = $this->createForm(new OrderProductType(), new OrderProduct(), array(
            'em' => $this->getDoctrine()->getManager(),
        ));

        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('Shop\AppBundle\Entity\Product');
        $products = $productRepository->findAll();

        $form->handleRequest($request);

        if($form->isValid()){
            $orderData = $form->getData();

            if($orderData->getOrder()){
                $em->persist($orderData);
                $em->flush();
            } else {
                $newOrder = new Order();
                $newOrder->setCreated(new \DateTime('now'));

                $em->persist($newOrder);
                $em->flush();

                $cart = new OrderProduct();
                $cart->setOrder($newOrder)
                    ->setProduct($orderData->getProduct())
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

    public function showAction(Request $request)
    {
        if($_SERVER['REQUEST_URI'] == '/show-order'){
            $form = $this->createForm(new ShowType(), new ShowTask());

            $form->handleRequest($request);

            if($form->isValid()){
                $data = $form->getData();

                $em = $this->getDoctrine()->getManager();

                $order = $em->find('ShopAppBundle:Order', $data->getId());
                if(!$order){
                    return $this->render('ShopAppBundle:Default:error.html.twig', array(
                        'name' => 'Order',
                        'id' => $data->getOrderId(),
                    ));
                } else {
                    return $this->render('ShopAppBundle:Default:show.html.twig', array(
                        'id' => $order->getId(),
                        'total' => $order->getTotal(),
                        'created' => date('Y-m-d h:m',$order->getCreated()->getTimestamp()),
                    ));
                }
            }

            return $this->render('ShopAppBundle:Default:poleId.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    public function editAction(Request $request)
    {
        if($_SERVER['REQUEST_URI'] == '/edit-order'){
            $form = $this->createForm(new EditType(), new OrderProduct());
        } elseif($_SERVER['REQUEST_URI'] == '/edit-product') {
            $form = $this->createForm(new EditType(), new OrderProduct());

            $form->handleRequest($request);

            if($form->isValid()){
                $data = $form->getData();

                $em = $this->getDoctrine()->getManager();

                $product = $data->getProduct();

                for($i = 0; $i <= (count($product) - 1); $i++){
                    $productArray = $product->get($i);
                    $editProduct = $em->find('ShopAppBundle:Product', $productArray['id']);

                    if(!$productArray['name'] == null){
                        $editProduct->setName($productArray['name']);
                    }
                    if(!$productArray['price'] == null){
                        $editProduct->setPrice($productArray['price']);
                    }
                    if(!$productArray['amount'] == null){
                        $editProduct->setAmount($productArray['amount']);
                    }

                    $em->persist($editProduct);
                    $em->flush();
                }

                return $this->render('ShopAppBundle:Default:edit.html.twig');
            }

            return $this->render('ShopAppBundle:Default:editProduct.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
}
