<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class StockAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('producto')
            ->add('cantidad')
            ->add('lote')
            ->add('fecha_vencimiento')
            ->add('fecha_actualizacion')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('producto')
            ->add('cantidad')
            ->add('lote')
            ->add('fecha_vencimiento')
            ->add('fecha_actualizacion')
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
            ->add('producto')
            //se puede agregar almacen ....
            ->add('cantidad')
            ->add('lote')
            ->add('fecha_vencimiento')
            ->add('fecha_actualizacion')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('producto')
            ->add('cantidad')
            ->add('lote')
            ->add('fecha_vencimiento')
            ->add('fecha_actualizacion')
        ;
    }
}
