<?php

declare(strict_types=1);

namespace App\Security\Voter\Paseka\Rasas;

use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Id;
use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
use App\Model\Paseka\Entity\Rasas\Kategor\Permission;
use App\Security\UserIdentity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RasaAccess 
//extends Voter
{
    // public const VIEW = 'view';
    // public const MANAGE_MEMBERS = 'manage_members';
    // public const EDIT = 'edit';

    // private $security;

    // public function __construct(AuthorizationCheckerInterface $security)
    // {
    //     $this->security = $security;
    // }

    // protected function supports($attribute, $subject): bool
    // {
    //     return in_array($attribute, [self::VIEW, self::MANAGE_MEMBERS, self::EDIT], true) && $subject instanceof Rasa;
    // }

    // protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    // {
    //     $user = $token->getUser();
    //     if (!$user instanceof UserIdentity) {
    //         return false;
    //     }

    //     if (!$subject instanceof Rasa) {
    //         return false;
    //     }

    //     switch ($attribute) {
    //         case self::VIEW:
    //             return
    //                 $this->security->isGranted('ROLE_WORK_MANAGE_PROJECTS') ||
    //                 $subject->hasPchelowod(new Id($user->getId()));
    //             break;
    //         case self::EDIT:
    //             return $this->security->isGranted('ROLE_WORK_MANAGE_PROJECTS');
    //             break;
    //         case self::MANAGE_MEMBERS:
    //             return
    //                 $this->security->isGranted('ROLE_WORK_MANAGE_PROJECTS') ||
    //                 $subject->isPchelowodGranted(new Id($user->getId()), Permission::MANAGE_PROJECT_MEMBERS);
    //             break;
    //     }

    //     return false;
    // }
}
