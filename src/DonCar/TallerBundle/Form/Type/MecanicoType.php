<?php
namespace DonCar\TallerBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class MecanicoType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('nombre');
        $builder->add('apellido');
        $builder->add('numero');
	}

    public function getName(){
        return 'mecanico';
    }
}

?>
