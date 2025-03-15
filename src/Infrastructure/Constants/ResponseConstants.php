<?php

namespace DevPM\Infrastructure\Constants;

class ResponseConstants
{
    public const string SUCCESS_HEADER_CODE = '200';

    public const string CREATED_HEADER_CODE = '201';

    public const string NO_CONTENT_HEADER_CODE = '204';

    public const string BAD_REQUEST_HEADER_CODE = '400';

    public const int FORBIDDEN_HEADER_CODE = 403;

    public const int NOT_FOUND_HEADER_CODE = 404;

    public const string UNPROCESSABLE_CONTENT_HEADER_CODE = '422';

    public const string MAINTENANCE_HEADER_CODE = '512';

    public const string BAD_REQUEST_MESSAGE = 'Bad Request';

    public const string CODE_KEY = 'code';

    public const string MESSAGE_KEY = 'message';

    public const string ITEMS_KEY = 'items';

    public const string PARAM_KEY = 'param';
    public const string ERRORS_KEY = 'errors';

    public const string DATA_KEY = 'data';

    public const string USER_KEY = 'user';

    public const string USER_COLLECTION_KEY = 'userCollection';
    public const string COMPANY_KEY = 'company';
    public const string COMPANY_COLLECTION_KEY = 'companyCollection';

    public const string PROJECT_KEY = 'project';

    public const string PROJECT_COLLECTION_KEY = 'projectCollection';

    public const string SORT_KEY = 'sort';
}
