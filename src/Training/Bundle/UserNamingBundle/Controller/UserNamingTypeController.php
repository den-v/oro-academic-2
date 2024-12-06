<?php

namespace Training\Bundle\UserNamingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Attribute\Route;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingTypeController
{
    #[Route(path:'/', name:'training_user_naming_type_index')]
    #[Template]
    public function indexAction(): array
    {
        return [
            'entity_class' => UserNamingType::class,
        ];
    }

     #[Route(path:'/view/{id}', name:'training_user_naming_type_view', requirements:['id' => '\d+'])]
     #[Template]
    public function viewAction(UserNamingType $type)
    {
        return [
            'entity' => $type
        ];
    }
}
