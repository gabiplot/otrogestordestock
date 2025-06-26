<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;

final class DetalleVentaAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        dump($this->isChild());
        if ($this->isChild()){
            $filter
            //->add('id')
            //->add('venta', )
            //->add('producto')
            //->add('cantidad')
            //->add('precio_unitario')
            //->add('descuento_item')
            //->add('subtotal')
            ;
        } else {
            $filter
            ->add('id')
            ->add('venta')
            ->add('producto')
            ->add('cantidad')
            ->add('precio_unitario')
            ->add('descuento_item')
            ->add('subtotal')
            ;
        }

    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('venta')
            ->add('producto')
            ->add('cantidad')
            ->add('precio_unitario')
            ->add('descuento_item')
            ->add('subtotal')
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
        if ($this->isCurrentRoute('create')) {
            $form
            ->add('venta')
            ->add('producto', ModelListType::class, ['btn_edit'=>false, 'btn_delete'=>false])
            ->add('cantidad')
            ->add('precio_unitario')
            ->add('descuento_item')
            ->add('subtotal')
            ;        
        } else {
            $form
            ->add('venta')
            ->add('producto')
            ->add('cantidad')
            ->add('precio_unitario')
            ->add('descuento_item')
            ->add('subtotal')
            ;
        }


    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('venta')
            ->add('producto')
            ->add('cantidad')
            ->add('precio_unitario')
            ->add('descuento_item')
            ->add('subtotal')
        ;
    }

	public function configureBatchActions($actions): array
	{
    	if (isset($actions['delete'])) {
        	unset($actions['delete']);
    	}

    	return $actions;
	}

}
