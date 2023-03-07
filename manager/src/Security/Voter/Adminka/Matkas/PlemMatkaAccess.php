<?php

declare(strict_types=1);

namespace App\Security\Voter\Adminka\Matkas;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\Matkas\Role\Permission;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Security\UserIdentity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PlemMatkaAccess extends Voter
{

    public const VIEW = 'view';
    public const MANAGE_UCHASTIES = 'manage_uchasties';
    public const EDIT = 'edit';
    public const CREATE = 'create';

    private $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::MANAGE_UCHASTIES, self::EDIT], true) && $subject instanceof PlemMatka;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        // достаем текущего пользователя
        $user = $token->getUser();
        if (!$user instanceof UserIdentity) {
            return false;
        }
// instanceof - проверяет является ли текущий объект экземпляром указанного класса
        if (!$subject instanceof PlemMatka) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return
                    $this->security->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS') ||
                    $subject->hasUchastie(new Id($user->getId()));
                break;
            case self::CREATE:
                return $this->security->isGranted('ROLE_MANAGE_PLEMMATKAS');
                break;
            case self::EDIT:
                return $this->security->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS');
                break;
            case self::MANAGE_UCHASTIES:
                return
                    $this->security->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS') ||
                    $subject->isUchastieGranted(new Id($user->getId()), Permission::MANAGE_PLEMMATKA_UCHASTIES);
                break;
        }

        return false;
    }
}
