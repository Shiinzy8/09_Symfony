<?php
// src/AppBundle/Admin/CategoryAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('login','text');
        $formMapper->add('email','text');
        $formMapper->add('roles','collection');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('login');
        $datagridMapper->add('email');
        $datagridMapper->add('roles');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('login');
        $listMapper->addIdentifier('email');
//        $listMapper->addIdentifier('roles','collection');
    }
}