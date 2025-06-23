<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class CajaAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('fecha')
            ->add('concepto')
            ->add('tipo_movimiento')
            ->add('ingreso')
            ->add('egreso')
            ->add('saldo')
            ->add('metodo_pago')
            ->add('categoria')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('fecha')
            ->add('concepto')
            ->add('tipo_movimiento')
            ->add('ingreso')
            ->add('egreso')
            ->add('saldo')
            ->add('metodo_pago')
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
            ->add('id')
            ->add('fecha')
            ->add('concepto')
            ->add('tipo_movimiento')
            ->add('ingreso')
            ->add('egreso')
            ->add('saldo')
            ->add('metodo_pago')
            ->add('categoria')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('fecha')
            ->add('concepto')
            ->add('tipo_movimiento')
            ->add('ingreso')
            ->add('egreso')
            ->add('saldo')
            ->add('metodo_pago')
            ->add('categoria')
        ;
    }
}
