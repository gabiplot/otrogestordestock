<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;

final class CuentaCorrienteClienteAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('cliente')
            ->add('fecha')
            ->add('concepto')
            ->add('tipo_movimiento')
            ->add('tipo_referencia')
            ->add('debe')
            ->add('haber')
            ->add('saldo')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('cliente')
            ->add('fecha')
            ->add('concepto')
            ->add('tipo_movimiento')
            ->add('tipo_referencia')
            ->add('debe')
            ->add('haber')
            ->add('saldo')
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
            ->add('cliente')
            ->add('fecha')
            ->add('concepto')
            ->add('tipo_movimiento')
            ->add('tipo_referencia', ChoiceFieldMaskType::class, [
                'choices' => [
                    'cobro' => 'cobro',
                    'venta' => 'venta',
                ],
                'map' => [
                    'cobro' => ['cobro_cliente'],
                    'venta' => ['venta'],
                ],
                'placeholder' => 'Seleccione una opción',
                'required' => false
            ])
            ->add('venta')
            ->add('cobro_cliente')
            ->add('debe')
            ->add('haber')
            ->add('saldo')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('cliente')
            ->add('fecha')
            ->add('concepto')
            ->add('tipo_movimiento')
            ->add('tipo_referencia')
            ->add('debe')
            ->add('haber')
            ->add('saldo')
        ;
    }

    /*
    * VALIDACIONES 
    */

    public function preValidate(object $object): void
    {

        if ($object->getTipoReferencia() == null) {
            $object->setVenta(null);
            $object->setCobroCliente(null);
        } else {
            if ($object->getTipoReferencia() == 'cobro'){                
                $object->setVenta(null);
            } else if ($object->getTipoReferencia() == 'venta') {
                $object->setCobroCliente(null);
            }
        }           
    }
}
