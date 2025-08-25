<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use Sonata\AdminBundle\Filter\Model\FilterData;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQueryInterface;

final class ProductoAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('codigo_producto')
            ->add('nombre')
            //->add('precio_de_costo')
            //->add('precio_de_venta')            
            //->add('stock_actual')
            //->add('stock_minimo')
            //->add('unidad_de_medida')
            //->add('activo')
            ->add('stock', CallbackFilter::class, [
                'label' => 'Consultar Stock',
                //callback' => static function ($queryBuilder, $alias, $field, $value) {
                //    dd($value);

                //if (!$value || !isset($value['value'])) {
                //        return false;
                //    }
                'callback' => static function(ProxyQueryInterface $query, string $alias, string $field, FilterData $data): bool {
                    
                    if (!$data->hasValue()) {
                        return false;
                    }

                    //dd($data->getValue());
                    
                    switch ($data->getValue()) {
                        case 'menor': 
                            //dd($alias);                       
                            //$queryBuilder->andWhere($alias . '.stock_actual < ' . $alias . '.stock_minimo');
                            $query->andWhere($alias . '.stock_actual < ' . $alias . '.stock_minimo');
                            //dd($alias);
                            break;
                        case 'igual':
                            $query->andWhere($alias . '.stock_actual = ' . $alias . '.stock_minimo');
                            break;
                        case 'mayor':
                            $query->andWhere($alias . '.stock_actual > ' . $alias . '.stock_minimo');
                            break;
                        case 'critico':
                            // Stock actual es 0 o menor que la mitad del mínimo                            
                            $query->andWhere(
                                $query->expr()->orX(
                                    $alias . '.stock_actual = 0',
                                    $alias . '.stock_actual < (' . $alias . '.stock_minimo / 2)'
                                )
                            );                            
                            break;
                        default:
                            return false;
                    }                    
                    return true;
                },
                'field_type' => ChoiceType::class,
                'placeholder' => 'Seleccionar comparación',
                'field_options' => [
                    'choices' => [
                        'Stock menor que mínimo' => 'menor',
                        'Stock igual que mínimo' => 'igual',
                        'Stock mayor que mínimo' => 'mayor',
                        'Stock crítico' => 'critico',
                    ],
                    'required' => false,
                    'placeholder' => 'Seleccionar comparación',
                ],
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            //->add('id')
            ->add('codigo_producto',null, [
                            'header_class' =>'col-md-1 text-center',
        	                'row_align'=>'center']
                            )
            ->add('nombre',null, [
                'header_class' =>'col-md-1 text-center',
                'row_align'=>'center']
                )
            //->add('precio_de_costo')
            ->add('precio_de_venta',null, [
                'header_class' =>'col-md-1 text-center',
                'row_align'=>'right']
                )
            ->add('stock_actual',null, [
                'header_class' =>'col-md-1 text-center',
                'row_align'=>'right']
                )
            //->add('stock_minimo',null, [
            //    'header_class' =>'col-md-1 text-center',
            //    'row_align'=>'right']
            //    )
            //->add('unidad_de_medida')
            //->add('activo',null, [
            //    'header_class' =>'col-md-1 text-center',
            //    'row_align'=>'center']
            //    )
            ->add(ListMapper::NAME_ACTIONS, null, [
                'header_class' =>'col-md-1 text-center',
                'row_align'=>'center',
                'actions' => [
                    'show' => [],
                    //'edit' => [],
                    //'delete' => [],
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
                    ->add('codigo_producto')                    
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
                    ->add('stockActual', NumberType::class, [
                        'label' => 'Stock Actual',
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
            ->add('codigo_producto')
            ->add('nombre')
            ->add('precio_de_costo')
            ->add('precio_de_venta')
            ->add('unidad_de_medida')
            ->add('stock_minimo')            
        ;
    }

    //FUNCIONES PARTICULARES
    
    public function configureBatchActions($actions): array
	{
    	if (isset($actions['delete'])) {
        	unset($actions['delete']);
    	}

    	return $actions;
	}

}
