<?php
namespace DonCar\PreciosServiceBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class VehiculoType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('codigo', 'text', array('label'=> 'Codigo'))
          ->add('nombre', 'text', array('label'=> 'Nombre'))
      		->add('descripcion', 'text', array('label'=> 'Descripcion','required' => false));
	}

    public function getName(){
        return 'vehiculo';
    }
}

?>