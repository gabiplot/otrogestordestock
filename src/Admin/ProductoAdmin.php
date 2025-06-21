<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class ProductoAdmin extends AbstractAdmin
{

    //remove batch delete
    public function configureBatchActions($actions): array
	{
    	if (isset($actions['delete'])) {
        	unset($actions['delete']);
    	}

    	return $actions;
	}

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('nombre')
            ->add('precio_de_costo')
            ->add('precio_de_venta')
            ->add('unidad_de_medida')
            ->add('stock_minimo')
            ->add('activo')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('nombre')
            ->add('precio_de_costo')
            ->add('precio_de_venta')
            ->add('unidad_de_medida')
            ->add('stock_minimo')
            ->add('activo')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('Información Básica')
                ->with('Datos del Producto', ['class' => 'col-md-8'])
                    ->add('nombre', TextType::class, [
                        'label' => 'Nombre del Producto'
                    ])
                    ->add('descripcion', TextareaType::class, [
                        'label' => 'Descripción',
                        'required' => false,
                        'attr' => ['rows' => 3]
                    ])
                ->end()
                ->with('Activo', ['class' => 'col-md-4'])
                    ->add('activo', CheckboxType::class, [
                        'label' => 'Producto Activo',
                        'required' => false
                    ])
                ->end()
            ->end()
            ->tab('Precios y Stock')
                ->with('Precios', ['class' => 'col-md-6'])
                    ->add('precio_de_costo', MoneyType::class, [
                        'label' => 'Precio de Costo',
                        'currency' => 'ARS',
                        'required' => true
                    ])
                    ->add('precio_de_venta', MoneyType::class, [
                        'label' => 'Precio de Venta',
                        'currency' => 'ARS',
                        'required' => true
                    ])
                ->end()
                ->with('Stock', ['class' => 'col-md-6'])            
                    ->add('stockMinimo', NumberType::class, [
                        'label' => 'Stock Mínimo',
                        'required' => true
                    ])                    
                    ->add('unidad_de_medida', ChoiceType::class, [
                        'label' => 'Unidad de Medida',
                        'choices' => [
                            'Unidad' => 'UNIDAD',
                            'Kilogramo' => 'KG',
                            'Gramo' => 'GR',
                            'Litro' => 'LT',
                            'Metro' => 'MT',
                            'Caja' => 'CAJA',
                            'Docena' => 'DOCENA'
                        ]
                    ])
                ->end()
            ->end();
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('nombre')
            ->add('precio_de_costo')
            ->add('precio_de_venta')
            ->add('unidad_de_medida')
            ->add('stock_minimo')            
        ;
    }
}
