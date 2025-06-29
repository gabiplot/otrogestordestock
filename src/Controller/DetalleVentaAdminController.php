<?php
namespace App\Controller;

//use App\Admin\DetalleVentaAdmin;
use App\Repository\ProductoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetalleVentaAdminController extends CRUDController
{
    private ProductoRepository $productoRepository;

    public function __construct( ProductoRepository $productoRepository)
    {
        
        $this->productoRepository = $productoRepository;
        //$this->adminFetcher = $adminFetcher;
    }
}