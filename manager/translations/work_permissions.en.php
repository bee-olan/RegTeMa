<?php

declare(strict_types=1);

use App\Model\Work\Entity\Projects\Role\Permission;

return [
    Permission::MANAGE_PROJECT_MEMBERS => 'Управлять Участниками Проекта',
    Permission::VIEW_TASKS => 'Просмотр задач',
    Permission::MANAGE_TASKS => 'Управление задачами',
];