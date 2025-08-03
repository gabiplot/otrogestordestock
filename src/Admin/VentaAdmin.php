<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

final class VentaAdmin extends AbstractAdmin
{    

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('cliente')
            ->add('fecha')
            ->add('subtotal')
            //->add('descuento')
            //->add('impuestos')
            ->add('total')
            ->add('estado')
            ->add('forma_pago')
            ->add('observacion')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('cliente')
            ->add('fecha')
            ->add('subtotal')
            //->add('descuento')
            //->add('impuestos')
            ->add('total')
            ->add('estado')
            ->add('forma_pago')
            ->add('observacion')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    //'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        if ($this->isCurrentRoute('create')) {
            // CREATE
            $form
            //->add('id')
            ->with('Datos del Cliente', ['class' => 'col-md-4'])
            ->add('cliente', ModelAutocompleteType::class, [
                        'property' => ['nombre','cuit'],
                        //'btn_add' => true,
                        'placeholder'=>'Seleccione el cliente',
                        'minimum_input_length' => 0,
                        //'row_attr'=>['class'=>'col-md-6'],
                    ])     
            ->add('estado', HiddenType::class,[
                'data' => 'INICIADO',
            ])                       
            ->end()
            ->with('Fecha', ['class' => 'col-md-4'])
            ->add('fecha',null,[
                'widget'=>'single_text',
                'data'=>(new \DateTime('now')),
                //'row_attr'=>['class'=>'col-md-2'],
                //'required'=>true,
            ])
            ->end()
            ;      
        } else if ($this->isCurrentRoute('edit')) {
            // EDIT
            dump($this->getSubject());
            dump($this->getSubject()->getSubtotalVenta());
            $finalizar = $this->getRequest()->get('finalizar');

            if (!empty($finalizar)) {
                $form->add('estado', HiddenType::class,[
                    'data' => 'FINALIZAR',
                ]); 
                $form->add('total', HiddenType::class,[
                    'data' => $this->getSubject()->getSubtotalVenta(),
                ]); 
            } else {
                $form->add('estado', HiddenType::class,[
                    'data' => 'INICIADO',
                ]); 
                $form->add('total', HiddenType::class,[
                    'data' => $this->getSubject()->getSubtotalVenta(),
                ]); 
            }

            $form
            ->add('cliente',null, [
                    'row_attr'=>['class'=>'col-md-4'],
                    'help' => 'El cliente que efectua la compra'
                    ])
            ->add('fecha',null,[
                'widget'=>'single_text',
                //'data'=>(new \DateTime('now')),
                'row_attr'=>['class'=>'col-md-4'],
                'help' => 'Fecha de Hoy'
                //'required'=>true,
               ])
            ->add('e',null, [
                'disabled' => true,
                'mapped' => false,
                'label' => 'Estado',
                'data' => $this->getSubject()->getEstado(),
                'row_attr'=>['class'=>'col-md-4'],
                'help' => 'Estado de la Compra'
            ])    
            ->add('forma_pago',ChoiceFieldMaskType::class, [
                'choices' => [
                    'EFECTIVO' => 'EFECTIVO',
                    'CTA CTE' => 'CTA CTE',
                ],
                'map' => [
                    'EFECTIVO' => ['importe', 'cambio'],
                    'CTA CTE' => [''],
                ],
                'placeholder' => 'Seleccione el metodo de pago',
                'help' => 'El metodo de pago',
                'required' => false,
                'row_attr'=>['class'=>'col-md-3']
            ])                    
            ->add('t', null, [
                'label' => 'Total',
                //'readonly' => true,
                'disabled' => true,
                'mapped' => false,
               //'currency' => 'ARS',
                'data' => $this->getSubject()->getSubtotalVenta(),    
                'row_attr'=>['class'=>'col-md-3', ],
                'help' => 'Total a pagar por el cliente'
            ])
            ->add('importe',null, [
                'mapped' => false,
                'help' => 'Importe abonado por el cliente',
                //'currency' => 'ARS',
                'row_attr'=>['class'=>'col-md-3']
            ])
            ->add('cambio',null, [
                'help' => 'El cambio que recibira el cliente',
                'mapped' => false,
                'disabled' => true,
                //'currency' => 'ARS',
                'row_attr'=>['class'=>'col-md-3']
            ])            
            ->add('observacion',null, [
                'row_attr'=>['class'=>'col-md-12']
            ])
            ;            
        } else {
            //ESTO ES NECESARIO PARA EL AUTOCOMPLETE
            $form
            ->add('cliente', ModelAutocompleteType::class, [
                'property' => ['nombre','cuit'],
                //'btn_add' => true,
                'placeholder'=>'Seleccione el cliente',
                'minimum_input_length' => 0,
                //'row_attr'=>['class'=>'col-md-6'],
            ])  
            ;
        }

    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('cliente')
            ->add('fecha')
            ->add('subtotal')
            //->add('descuento')
            //->add('impuestos')
            ->add('total')
            ->add('estado')
            ->add('forma_pago')
            ->add('observacion')
        ;
    }    

    /*
     * FUNCIONES PROPIAS 
     */
    //ORDENAR POR DEFECTO
    public function preValidate(object $object): void
    {
        //dump($object);
        //dd();
    }


	protected function configureDefaultSortValues(array &$sortValues): void
	{
        
    	$sortValues['_sort_order'] = 'DESC';

    	$sortValues['_sort_by'] = 'id';
	}

    //RUTA POR DEFECTO PARA USAR EN EL CONTROLLER
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->add('detalle_venta', $this->getRouterIdParameter().'/detalleventa/list');
        $collection->add('agregar_producto', $this->getRouterIdParameter().'/detalleventa/agregar_producto');
        $collection->add('finalizar_venta', $this->getRouterIdParameter().'/detalleventa/finalizar_venta');
    }

    public function prePersist(object $object): void
    {
        //dd($object);
        $object->setSubTotal('0.00');
        $object->setDescuento('0.00');
        $object->setImpuestos('0.00');
        $object->setTotal('0.00');
        $object->setFormaPago('FORMA PAGO');

        //dd($object->getId());

        //dd($this->generateUrl('detalle_venta', ['id' => $object->getId()]));
    }

    protected function postPersist(object $object): void
    {
        parent::postPersist($object);
        
        //dd($this->generateUrl('detalle_venta', ['id' => $object->getId()]));

        // Redireccionar a la página de detalle después de crear
        $this->getRequest()->getSession()->set(
            'sonata_admin_redirect_url',
            $this->generateUrl('detalle_venta', ['id' => $object->getId()])
        );
    }

    /*
    protected function redirectTo(object $object): string
    {
        //dd("redirect");
        
        $request = $this->getRequest();
        
        // Si viene de crear o editar, redirigir a detalle
        if ($request->get('btn_create_and_edit') || $request->get('btn_update_and_edit')) {
            return 'detalle_venta';
        }
        
        // Mantener comportamiento por defecto para otros casos
        return parent::redirectTo($object);
        
    }
    */

    protected function configureTabMenu(MenuItemInterface $menu, string $action, AdminInterface $childAdmin = null): void
    {
        //dump($this->getSubject());

        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        
        $id = $admin->getRequest()->get('id');
        
        //if ($this->isGranted('EDIT')) {
            //$menu->addChild('Editar Venta', $admin->generateMenuUrl('edit', ['id' => $id]));
        //}

        //$menu->addChild('Ver Venta', $admin->generateMenuUrl('show', ['id' => $id]));
        
        if ($this->isGranted('LIST')) {
            //if ($this->getSubject()->getEstado()){
                $menu->addChild('Detalle Venta', $admin->generateMenuUrl('admin.detalle_venta.list', ['id' => $id]));
            //}        
        }
        
    }

	public function configureBatchActions($actions): array
	{
    	if (isset($actions['delete'])) {
        	unset($actions['delete']);
    	}

    	return $actions;
	}



}
