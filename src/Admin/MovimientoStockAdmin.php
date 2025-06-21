<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

final class MovimientoStockAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('tipo_movimiento')
            ->add('cantidad')
            ->add('stock_anterior')
            ->add('stock_actual')
            ->add('motivo')
            ->add('fecha_movimiento')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('tipo_movimiento')
            ->add('cantidad')
            ->add('stock_anterior')
            ->add('stock_actual')
            ->add('motivo')
            ->add('lote')
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
        /*
        $form
            //->add('id')            
            ->add('tipo_movimiento')
            ->add('cantidad')
            ->add('stock_anterior')
            ->add('stock_actual')
            ->add('motivo')
            ->add('fecha_movimiento')
        */
        $form
            ->add('fecha_movimiento')
            ->add('producto',null,['choice_label' => 'nombre',
                'label' => 'Producto'
            ])
            ->add('tipoMovimiento', ChoiceType::class, [
                'label' => 'Tipo de Movimiento',
                'choices' => [
                    'Entrada' => 'ENTRADA',
                    'Salida' => 'SALIDA',
                    'Ajuste' => 'AJUSTE',
                    'Transferencia' => 'TRANSFERENCIA'
                ]
            ])
            ->add('cantidad', NumberType::class, [
                'label' => 'Cantidad'
            ])
            ->add('stock_anterior', NumberType::class, [
                'label' => 'Stock Anterior'
            ])
            ->add('stock_actual', NumberType::class, [
                'label' => 'Stock Actual'
            ])
            ->add('motivo', TextType::class, [
                'label' => 'Motivo',
                'required' => false
            ])
            ->add('lote', null, [
                'label' => 'Lote',
                'required' => false
            ])
            /*
            ->add('documentoReferencia', TextType::class, [
                'label' => 'Documento de Referencia',
                'required' => false
            ])*/
            ;
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('tipo_movimiento')
            ->add('cantidad')
            ->add('stock_anterior')
            ->add('stock_actual')
            ->add('motivo')
            ->add('fecha_movimiento')
        ;
    }
}
