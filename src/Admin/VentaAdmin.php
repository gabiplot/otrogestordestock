<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;

use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

//use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use App\Entity\Movimiento;

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
            //->add('id')
            ->add('cliente',null,['header_class' =>'col-md-3 text-center'])
            ->add('fecha',null,['format' => 'd-m-Y', 'header_class' =>'col-md-1 text-center'])
            //->add('subtotal')
            //->add('descuento')
            //->add('impuestos')            
            ->add('estado',null, ['header_class' =>'col-md-2 text-center'])
            ->add('forma_pago',null, ['header_class' =>'col-md-2 text-center'])
            ->add('total',null, ['header_class' =>'col-md-2 text-center', 'row_align'=>'right'])
            //->add('observacion')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    //'edit' => [],
                    'delete' => [],
                ],
                ['header_class' =>'col-md-2 text-center']
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        //dd($this->getSubject());

        if ($this->isCurrentRoute('create')) {
            // CREATE
            $cliente = $this->getCliente(1);

            //dd($cliente);
            //dd();
            $this->getSubject()->setCliente($cliente);

            $form
            //->add('id')
            ->with('Datos del Cliente', ['class' => 'col-md-4'])
            ->add('cliente', ModelAutocompleteType::class, [
                        'property' => ['nombre','cuit'],
                        //'btn_add' => true,
                        // 'data' => $cliente,
                        'placeholder'=>'Seleccione el cliente',
                        'minimum_input_length' => 0,
                        //'row_attr'=>['class'=>'col-md-6'],
                    ])  
            /* 
            ->add('forma_pago', HiddenType::class,[
                'data' => '',
            ])
            */
            ->add('sub_total',HiddenType::class,['data' => '0.00'])
            ->add('descuento',HiddenType::class,['data' => '0.00'])
            ->add('impuestos',HiddenType::class,['data' => '0.00'])
            ->add('total',HiddenType::class,['data' => '0.00'])
            ->add('importe',HiddenType::class,['data' => '0.00'])
            ->add('cambio',HiddenType::class,['data' => '0.00'])           
            ->add('estado', HiddenType::class,[
                'data' => 'INICIADO',
            ])                       
            ->end()
            ->with('Fecha', ['class' => 'col-md-4'])
            ->add('fecha',null,[
                'widget'=>'single_text',
                'data'=>(new \DateTime('now')),
            ])
            ->end()
            ;      
        } else if ($this->isCurrentRoute('edit')) {
            if ($this->getSubject()->getEstado() == 'PENDIENTE'){
                $form->add('estado', HiddenType::class,[
                    'data' => 'FINALIZADO',
                ]); 
            } else {
                $form->add('estado', HiddenType::class,[
                    'data' => $this->getSubject()->getEstado(),
                ]);                
            }

            $form->add('total', HiddenType::class,[
                'data' => $this->getSubject()->getTotal(),
            ]);

            $form
            ->add('cliente',null, [
                    'row_attr'=>['class'=>'col-md-4'],
                    'help' => 'El cliente que efectua la compra'
                    ])
            ->add('fecha',null,[
                'widget'=>'single_text',
                'row_attr'=>['class'=>'col-md-4'],
                'help' => 'Fecha de Hoy'
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
                'required' => true,
                'row_attr'=>['class'=>'col-md-3']
            ])                    
            ->add('t', null, [
                'label' => 'Total',
                'disabled' => true,
                'mapped' => false,
                'data' => $this->getSubject()->getSubtotalVenta(),    
                'row_attr'=>['class'=>'col-md-3', ],
                'help' => 'Total a pagar por el cliente'
            ])
            ->add('importe',TextType::class, [
                'help' => 'Importe abonado por el cliente',
                'attr' => ['autofocus'=>'true'],
                'row_attr'=>['class'=>'col-md-3', 'autofocus'=>'true'],
            ])
            ->add('cambio',TextType::class, [
                'help' => 'El cambio que recibira el cliente',
                'disabled' => true,
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
                'placeholder'=>'Seleccione el cliente',
                'minimum_input_length' => 0,
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
            ->add('total')
            ->add('estado')
            ->add('forma_pago')
            ->add('observacion')
        ;
    }    

    /*
     * FUNCIONES PROPIAS 
     */
	public function getCliente($id)
	{ 	 

    	$ea = $this->getModelManager()
               	->getEntityManager('App\Entity\Cliente')
               	->getRepository('App\Entity\Cliente')
               	->find($id)
                ; 	 

    	return $ea;
	}
    
    public function preValidate(object $object): void
    {
        $object->setCambio($object->getCambioTotal());
    }

    public function preUpdate(object $object): void
    {
        if ($object->getEstado() == 'FINALIZAR')
        {
            
            //si existe movimiento en detalle actualizarlo
            //sino crearlo
        }
    }

    public function postUpdate(object $object): void
    {
        if ($object->getEstado() == 'FINALIZADO')
        {
            $em = $this->getModelManager()
                       ->getEntityManager('App\Entity\Movimiento');
            $movimiento = $em->getRepository('App\Entity\Movimiento')
                             ->findOneBy(['venta' => $object->getId()]);  

            //dd($movimiento);

            if ($movimiento) {
                $movimiento->setEntrada($object->getTotal());
                $movimiento->setSalida('0.00');
                $movimiento->setMotivo('VENTA');
                $movimiento->setTipo('ENTRADA');
                $movimiento->setFecha($object->getFecha());
                $em->persist($movimiento);
                $em->flush();
                //editar uno
            } else {
                $movimiento = new Movimiento;
                $movimiento->setEntrada($object->getTotal());
                $movimiento->setSalida('0.00');
                $movimiento->setMotivo('VENTA');
                $movimiento->setTipo('ENTRADA');
                $movimiento->setFecha($object->getFecha());
                $em->persist($movimiento);
                $em->flush();                
                //crear uno
            }

            //si existe movimiento en detalle actualizarlo
            //sino crearlo
        }
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
        $collection->add('finalizar', $this->getRouterIdParameter().'/finalizar');
    }

    protected function configureTabMenu(MenuItemInterface $menu, string $action, AdminInterface $childAdmin = null): void
    {
        //dump($this->getSubject());

        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        
        $id = $admin->getRequest()->get('id');
    
        
        if ($this->isGranted('LIST')) {
            $menu->addChild('Detalle Venta', $admin->generateMenuUrl('admin.detalle_venta.list', ['id' => $id]));
        }
        
    }

	public function configureBatchActions($actions): array
	{
    	if (isset($actions['delete'])) {
        	//unset($actions['delete']);
    	}

    	return $actions;
	}



}
