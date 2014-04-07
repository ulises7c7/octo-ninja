<?php
namespace DonCar\PreciosServiceBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class ManoDeObraType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('codigo', 'text', array('label'=> 'Codigo'))
        	->add('nombre', 'text', array('label'=> 'Nombre'))
      		->add('descripcion', 'text', array('label'=> 'Descripcion'))
      		->add('precio', 'number', array('label'=> 'Precio'));
	}

    public function getName(){
        return 'manodeobra';
    }
}

?>