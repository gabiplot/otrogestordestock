<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use App\Entity\Producto;
//use App\Entity\DetalleDebe;

class VentaAgregarProductoForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {        
        //$mm = $options['data']['mm'];

        $builder
            /*
            ->add('detalle_debe', EntityType::class, [
                        'class' => DetalleDebe::class,     
                        //'data' => $options['data']['det_deb'],
                        'choice_label' => 'nombre']
                )        
            */
            /*
            ->add('fecha', DateType::class, [
                        'widget'=>'single_text',
                        'data'=>(new \DateTime('now')),
                        'row_attr'=>['class'=>'col-md-2'],
                        'required'=>true,
            ])
            */            
            /*
            ->add('importe', TextType::class, [                   
                ])            
            */
            ->add('cantidad', TextType::class, [  
                'data' => '1'                 
                ])              
            
            ->add('producto_select', EntityType::class, [
                'class' => Producto::class,
                'placeholder'=>'Ingresa Codigo',
                'required' => false,
                'choice_label' => function (Producto $producto) {
                    return strval($producto->getCodigoProducto() . ' - ' . $producto->getNombre());
                }
                ]
            ) 
            ->add('producto', TextType::class, [
                //'class' => Producto::class,
                //'placeholder'=>'Ingresa Codigo',
                'required' => false,
                /*
                'choice_label' => function (Producto $producto) {
                    return strval($producto->getCodigoProducto() . ' - ' . $producto->getNombre());
                }
                */
                ]
            )             
            ->add('buscar_codigo_producto', HiddenType::class, [
                'required' => true,                
             ])
            /*
            ->add('producto',ModelAutocompleteType::class, [
                'class' => Producto::class,
                'placeholder'=>'Ingresa Codigo',
                'model_manager' => $mm,
                'required' => false,
                'property' => 'id'
            ])
            */               
			;
    }
}
