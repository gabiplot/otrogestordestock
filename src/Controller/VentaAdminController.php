<?php
namespace App\Controller;

use App\Entity\DetalleVenta;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Controller\CRUDController;

use Symfony\Component\HttpFoundation\RedirectResponse;

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

    /**
     * @param $id
     */
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
