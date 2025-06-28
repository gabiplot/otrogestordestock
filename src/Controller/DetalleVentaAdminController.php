<?php
namespace App\Controller;

//use App\Admin\DetalleVentaAdmin;
use App\Repository\ProductoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Request\AdminFetcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetalleVentaAdminController extends CRUDController
{
    private ProductoRepository $productoRepository;
    private AdminFetcherInterface $adminFetcher;

    public function __construct(AdminFetcherInterface $adminFetcher, ProductoRepository $productoRepository)
    {
        
        $this->productoRepository = $productoRepository;
        $this->adminFetcher = $adminFetcher;
    }

    /**
     * @param $id
     */
    public function agregarAction(request $request): Response
    {

        $admin = $this->adminFetcher->get($request);
        //dump($admin);
        //dd($admin->getSubject());
        //dump($request->get('cant_prod','0'));
        $cod_prod= $request->get('cod_prod','');

        //$em = $this->getModelManager();

        //dd($em);

        $producto = $this->productoRepository->findOneBy(['codigo_producto' => $cod_prod]);

        //dd($producto);

        if ($producto == null){
            //dump("finalizar y regresar con mensaje");
            //$request->getSession()->getFlashBag()->add
            $this->addFlash('sonata_flash_info', 'No Existe el producto');
            //dd();
            return new RedirectResponse($this->admin->generateUrl('list'));
        } else {
            $this->addFlash('sonata_flash_success', 'Producto existnte');
            dump($producto);
            return new RedirectResponse($this->admin->generateUrl('list'));

        }

        
        //dd();

    }
}