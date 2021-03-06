<?php

namespace Ulyssetour\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/admin/load/image',
        '/book_it/send_mail_message/tour',
        '/book_it/send_mail_message/helicopter',
        '/book_it/send_mail_message/create_tour'
    ];
}
