<?php
namespace DonCar\TallerBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class OrdenType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('numero');
        $builder->add('tiempo');
	$builder->add('mecanico', 'entity', array(
          'class' => 'DonCarTallerBundle:Mecanico',
          'property' => 'numero',
        ));

    }

    public function getName(){
        return 'orden';
    }
}

?>
