<?php
namespace App\Controller;

use App\Entity\DetalleVenta;
use App\Form\VentaAgregarProductoForm;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Entity\Producto;

class VentaAdminController extends CRUDController
{

    /**
     * Redirijo al detalle_venta, sino continuo.
     *
     */
    protected function redirectTo(Request $request, object $object): RedirectResponse
    {

        if (null !== $request->get('btn_create_and_edit')) {
            return new RedirectResponse($this->admin->generateUrl('detalle_venta', ['id' => $object->getId()]));
        }

        return parent::redirectTo($request, $object);
    }

    public function agregarProductoAction(request $request): Response   
    {

        //venta actual;
        $venta = $this->admin->getSubject();

        $formulario = $request->request->get('venta_agrega_producto_form');

        $form = $this->createForm(VentaAgregarProductoForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {            

            /*
            $token = new CsrfToken('venta_agregar_producto_form', $request->request->get('venta_agregar_producto_form')['_token']);            

            if (!$csrfTokenManager->isTokenValid($token)) {
                throw new AccessDeniedHttpException('CSRF token inválido.');
            } 
            */           

            $form_data = $form->getData();

            $buscar_codigo_producto = strip_tags($form_data['buscar_codigo_producto'],'');

            $cantidad = strip_tags($form_data['cantidad'],'');

            $producto = strip_tags($form_data['producto'],'');
            
            $producto_select = $form_data['producto_select'];

            //dump($producto_select instanceof Producto);

            //dd($form->getData());            

            if (!is_numeric($cantidad)){
                $this->addFlash('sonata_flash_error', 'La cantidad debe ser un numero ! ' );
                return new RedirectResponse($this->admin->generateUrl('detalle_venta', ['id' => $venta->getId()]));
            }

            if ($buscar_codigo_producto == "true")
                {
                    //busca por codigo de producto
                    $producto = $this->admin
                                        ->getModelManager()
                                        ->getEntityManager('App\Entity\Producto')
                                        ->getRepository('App\Entity\Producto')
                                        ->findOneBy(['codigo_producto' => $producto]);
                    if ($producto == null)
                    {
                        $this->addFlash('sonata_flash_error', 'No Existe el producto con codigo: ' . $producto );
                        return new RedirectResponse($this->admin->generateUrl('detalle_venta', ['id' => $venta->getId()]));
                    }                                     
                } 
            else 
                {

                    if (!($producto_select instanceof Producto)) {
                        $this->addFlash("error", "No selecciono ningun producto !");
                        return new RedirectResponse($this->admin->generateUrl('detalle_venta', ['id' => $venta->getId()]));
                    } 
                    
                    $producto = $producto_select;
                }
        
                    $detalle_venta = new DetalleVenta;                                 
        
                    $subtotal = $cantidad * $producto->getPrecioDeVenta();
            
                    $detalle_venta->setProducto($producto);
                    $detalle_venta->setCantidad($cantidad);
                    $detalle_venta->setPrecioUnitario($producto->getPrecioDeVenta());
                    $detalle_venta->setDescuentoItem(0.0);
                    $detalle_venta->setSubtotal($subtotal);
                    $detalle_venta->setVenta($venta);
                    
                    $entityManager =  $this->admin
                                            ->getModelManager()
                                            ->getEntityManager('App\Entity\Venta');
        
                    $entityManager->persist($detalle_venta);
        
                    $entityManager->flush();
        
                    return new RedirectResponse($this->admin->generateUrl('detalle_venta', ['id' => $venta->getId()]));

        }                                  
                

        return $this->render('VentaAdmin/agregar_producto.html.twig', [
            'form' => $form->createView(),
            'error' => "",
        ]);
    }

    /**
     * @param $id
     */
    /*
    public function agregarProductoAction(request $request): RedirectResponse
    {
        //dd($request);

        $venta = $this->admin->getSubject();

        $cod_prod = strip_tags($request->get('cod_prod',''));

        $cant_prod = strip_tags($request->get('cant_prod',''));

        $producto = $this->admin
                         ->getModelManager()
                         ->getEntityManager('App\Entity\Producto')
                         ->getRepository('App\Entity\Producto')
                         ->findOneBy(['codigo_producto' => $cod_prod]);


        //dd($detalle_venta);

        if ($producto == null){
            $this->addFlash('sonata_flash_error', 'No Existe el producto con codigo: ' . $cod_prod );
            return new RedirectResponse($this->admin->generateUrl('detalle_venta', ['id' => $venta->getId()]));
        } else {
            //$this->addFlash('sonata_flash_success', 'Producto existente');

            //dd($producto);

            $detalle_venta = new DetalleVenta;                                 

            $subtotal = $cant_prod * $producto->getPrecioDeVenta();
    
            $detalle_venta->setProducto($producto);
            $detalle_venta->setCantidad($cant_prod);
            $detalle_venta->setPrecioUnitario($producto->getPrecioDeVenta());
            $detalle_venta->setDescuentoItem(0.0);
            $detalle_venta->setSubtotal($subtotal);
            $detalle_venta->setVenta($venta);
            //$venta->addDetalleVenta($detalle_venta);
            
            $entityManager =  $this->admin
                                   ->getModelManager()
                                   ->getEntityManager('App\Entity\Venta');

            $entityManager->persist($detalle_venta);

            $entityManager->flush();

            return new RedirectResponse($this->admin->generateUrl('detalle_venta', ['id' => $venta->getId()]));
        }

        
        //dd();

    }
    */
    
    public function finalizarVentaAction(request $request): RedirectResponse
    {        
        $venta = $this->admin->getSubject();
        $detalle_ventas = $venta->getDetalleVentas();

        //dump($venta);

        //dump($venta->getSubtotalVenta());

        /*
        foreach($detalle_ventas as $detalle_venta)
        {
            dump($detalle_venta);
        }
        */
        $venta->setSubTotal($venta->getSubtotalVenta());
        $venta->setFormaPago("EFECTIVO");
        $venta->setTotal($venta->getSubtotalVenta());

        $entityManager =  $this->admin
                               ->getModelManager()
                               ->getEntityManager('App\Entity\Venta');

        $entityManager->persist($venta);
        $entityManager->flush();

        //dd($request);
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
