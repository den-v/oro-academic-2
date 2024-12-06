<?php

namespace Training\Bundle\UserNamingBundle\Controller;

use Oro\Bundle\SecurityBundle\Attribute\Acl;
use Oro\Bundle\SecurityBundle\Attribute\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Attribute\Route;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingTypeController
{
    #[Route(path:'/', name:'training_user_naming_type_index')]
    #[Template]
    #[AclAncestor('training_user_naming_type_view')]
    public function indexAction(): array
    {
        return [
            'entity_class' => UserNamingType::class,
        ];
    }

     #[Route(path:'/view/{id}', name:'training_user_naming_type_view', requirements:['id' => '\d+'])]
     #[Template]
     #[Acl(id: 'training_user_naming_type_view', type: 'entity', class: UserNamingType::class, permission: 'VIEW')]
    public function viewAction(UserNamingType $type)
    {
        return [
            'entity' => $type
        ];
    }
}
