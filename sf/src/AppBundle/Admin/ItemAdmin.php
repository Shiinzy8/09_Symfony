<?php
// src/AppBundle/Admin/CategoryAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ItemAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name','text');
        $formMapper->add('price');
        $formMapper->add('content','text');
        $formMapper->add('category', 'entity', array(
            'class' => 'AppBundle\Entity\Category',
            'choice_label' => 'getName',
        ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
        $datagridMapper->add('price');
        $datagridMapper->add('content');
        $datagridMapper->add('category.name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
        $listMapper->addIdentifier('price');
        $listMapper->addIdentifier('content');
        $listMapper->addIdentifier('category.name');
    }
}