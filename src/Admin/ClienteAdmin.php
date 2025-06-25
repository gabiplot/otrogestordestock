<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ClienteAdmin extends AbstractAdmin
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
            ->add('cuit')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('nombre')                                    
            ->add('cuit')
            ->add('email')
            ->add('tipo_cliente')
            //->add('fecha_registro')
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
            //->add('id')
            ->add('nombre')
            ->add('cuit')
            ->add('email')
            ->add('tipo_cliente')
            ->add('fecha_registro')
            ->add('activo')            
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //->add('id')
            ->add('nombre')
            ->add('cuit')
            ->add('email')
            ->add('tipo_cliente')
            ->add('fecha_registro')
            ->add('activo')            
        ;
    }
}
