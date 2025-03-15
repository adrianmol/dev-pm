<?php

namespace DevPM\Infrastructure\Constants\Permission;

class PermissionConstant
{
    public const string VIEW = 'view';
    public const string CREATE = 'create';
    public const string EDIT = 'edit';
    public const string DELETE = 'delete';

    public const string COMPANIES_ENTITY = 'companies';

    public const string PROJECTS_ENTITY = 'projects';

    public const array PERMISSIONS_ARRAY = [
      self::VIEW . ' ' . self::COMPANIES_ENTITY,
      self::CREATE . ' ' . self::COMPANIES_ENTITY,
      self::EDIT . ' ' . self::COMPANIES_ENTITY,
      self::DELETE . ' ' . self::COMPANIES_ENTITY,
      self::VIEW . ' ' . self::PROJECTS_ENTITY,
      self::CREATE . ' ' . self::PROJECTS_ENTITY,
      self::EDIT . ' ' . self::PROJECTS_ENTITY,
      self::DELETE . ' ' . self::PROJECTS_ENTITY,
    ];

    public const array PERMISSIONS_VIEW = [
        self::COMPANIES_ENTITY => self::VIEW . ' ' . self::COMPANIES_ENTITY,
        self::PROJECTS_ENTITY => self::VIEW . ' ' . self::PROJECTS_ENTITY,
    ];
}
