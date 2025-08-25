<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;

final class MovimientoAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            //->add('id')
            ->add('fecha')
            ->add('entrada')
            ->add('salida')
            ->add('motivo')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            //->add('id')
            ->add('usuario')
            ->add('tipo')
            ->add('fecha',null,['format' => 'd-m-Y'])
            ->add('entrada')
            ->add('salida')
            ->add('motivo')
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
            ->add('tipo',ChoiceFieldMaskType::class,[
                'choices' => [
                    'ENTRADA' => 'ENTRADA',
                    'SALIDA' => 'SALIDA',
                ],
                'map' => [
                    'ENTRADA' => ['venta', 'entrada'],
                    'SALIDA' => ['salida'],
                ],
                'placeholder' => 'Choose an option',
                'required' => true
            ])
            ->add('fecha',null,[
                 'widget'=>'single_text',
                 'required'=>true,
               ])
            ->add('venta')            
            ->add('entrada')
            ->add('salida')
            ->add('motivo')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //->add('id')
            ->add('fecha')
            ->add('entrada')
            ->add('salida')
            ->add('motivo')
        ;
    }

    //CUSTOM FUNCTIONS
	protected function configureDefaultSortValues(array &$sortValues): void
	{
        
    	$sortValues['_sort_order'] = 'DESC';

    	$sortValues['_sort_by'] = 'id';
	}



}
