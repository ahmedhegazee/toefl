<?php

namespace App\Http;

use App\AllowedIP;
use App\Http\Middleware\allowedIpMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'available' => \App\Http\Middleware\isAvailableReservation::class,
        'check_roles' => \App\Http\Middleware\checkRoles::class,
        //Students Middleware
        'student_is_online' => \App\Http\Middleware\StudentMiddlewares\studentLastActivity::class,
        'check_student' => \App\Http\Middleware\StudentMiddlewares\checkStudent::class,
        'can_start_exam' => \App\Http\Middleware\StudentMiddlewares\canStartExam::class,
        //Admin Middleware
        'is-admin-professor' => \App\Http\Middleware\AdminMiddleware\isAdminOrProfessor::class,
        'super-admin' => \App\Http\Middleware\AdminMiddleware\isSuperAdmin::class,
        'manage-reading' => \App\Http\Middleware\AdminMiddleware\adminCanManageReadingSection::class,
        'manage-listening' => \App\Http\Middleware\AdminMiddleware\adminCanManageListeningSection::class,
        'manage-grammar' => \App\Http\Middleware\AdminMiddleware\adminCanManageGrammarSection::class,
        'manage-students-panel' => \App\Http\Middleware\AdminMiddleware\adminCanManageReservationsPanel::class,
        'manage-reservations-panel' => \App\Http\Middleware\AdminMiddleware\adminCanManageStudentsPanel::class,
        'manage-exams-panel' => \App\Http\Middleware\AdminMiddleware\adminCanManageExamsPanel::class,
        'edit-student-marks' => \App\Http\Middleware\AdminMiddleware\adminCanEditFailedStudentMarks::class,
        'print-certificates' => \App\Http\Middleware\AdminMiddleware\adminCanPrintCertificates::class,
        'allowed-ip' => \App\Http\Middleware\allowedIpMiddleware::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
