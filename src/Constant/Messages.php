<?php


namespace App\Constant;


class Messages
{
    const INTERNAL_SERVER_ERROR = 'Seems as internal server error has occurred.';
    const NOT_ALLOWED = 'The action is not allowed on this resource.';
    const NOT_FOUND = 'Seems the % can\'t be found.';
    const ACCESS_DENIED = 'You don\'t have permission to the server. Seems the credentials is wrong';
    const TOKEN_EXPIRED = 'Seems the provided token has expired.';
    const INVALID_PARAM = 'Bad request - %s. Check and try again';
    const CREATED = '%s was created successfully.';
}