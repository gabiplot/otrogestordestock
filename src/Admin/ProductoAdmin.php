<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ->add('precio_de_compra')
            ->add('precio_venta')
            ->add('unidad_de_medida')
            ->add('stock_minimo')
            ->add('estado')
            ->add('categoria')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('nombre')
            ->add('precio_de_compra')
            ->add('precio_venta')
            ->add('unidad_de_medida')
            ->add('stock_minimo')
            ->add('estado')
            ->add('categoria')
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
            //->add('id')
            ->add('nombre')
            ->add('precio_de_compra')
            ->add('precio_venta')
            ->add('unidad_de_medida',ChoiceType::class, [
                'choices'  => [
                    'UNIDAD' => 'U',
                    'KILO' => 'K',
                    'LITRO' => 'L'
                ],
            ])
            ->add('stock_minimo')
            ->add('categoria')
            ->add('estado', ChoiceType::class, [
                'choices'  => [
                    'ACTIVO' => 'A',
                    'INACTIVO' => 'I',
                ],
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('nombre')
            ->add('precio_de_compra')
            ->add('precio_venta')
            ->add('unidad_de_medida')
            ->add('stock_minimo')
            ->add('estado')
            ->add('categoria')
        ;
    }
}
