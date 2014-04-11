<?php
namespace DonCar\PreciosServiceBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class TrabajoType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('tipo_mano_de_obra', 'entity', array('class'=>'DonCarPreciosServiceBundle:TipoManoDeObra', 'property'=>'nombre', 'label'=>'Tipo mano de obra'))
        	->add('nombre', 'text', array('label'=> 'Nombre'))
      		->add('descripcion', 'text', array('label'=> 'Descripcion','required' => false))
      		->add('precio', 'number', array('label'=> 'Precio'))
      		->add('tiempo', 'number', array('label'=> 'Tiempo'))
      		->add('costo_por_uso', 'checkbox', array('label'=> 'Costo por uso','required' => false));
	}

    public function getName(){
        return 'trabajo';
    }
}

?>