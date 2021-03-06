<?php
namespace RbComment;

use RbComment\Factory;
use RbComment\Model\CommentTable;
use Zend\Mail\Transport\Sendmail;

return [
    'router' => [
        'routes' => [
            'rbcomment' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/rbcomment/:action',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => 'RbComment\Controller\Comment',
                    ],
                ],
            ],
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'delete-spam' => [
                    'options' => [
                        'route' => 'delete spam',
                        'defaults' => [
                            'controller' => 'RbComment\Controller\Console',
                            'action'     => 'delete-spam',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'RbComment\Controller\Comment' => Factory\Controller\CommentControllerFactory::class,
            'RbComment\Controller\Console' => Factory\Controller\ConsoleControllerFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'rbMailer' => Factory\Mvc\Controller\Plugin\MailerFactory::class,
        ]
    ],
    'service_manager' => [
        'factories' => [
            CommentTable::class     => Factory\Model\CommentTableFactory::class,
            'RbCommentTableGateway' => Factory\Model\RbCommentTableGatewayFactory::class,
            'RbComment\Akismet'     => Factory\Service\AkismetServiceFactory::class,
        ],
        'invokables' => [
            /**
             * Placeholder transport config. Do not use this in production.
             * Replace with SMTP.
             */
            'RbComment\Mailer' => Sendmail::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'rbComment' => Factory\View\Helper\CommentFactory::class,
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'rbcomment/theme/uikit'      => __DIR__ . '/../view/theme/uikit.phtml',
            'rbcomment/theme/bootstrap3' => __DIR__ . '/../view/theme/bootstrap3.phtml',
            'rbcomment/theme/default'    => __DIR__ . '/../view/theme/default.phtml',
        ],
    ],
    'rb_comment' => [
        /**
         * Default visibility of the comments.
         */
        'default_visibility' => 1,
        'strings' => [
            'author'      => 'Author',
            'contact'     => 'Email',
            'content'     => 'Comment',
            'submit'      => 'Post',
            'comments'    => 'Comments',
            'required'    => 'All fields are required. Contact info will not be published.',
            'signout'     => 'Sign Out',
            'signin'      => 'Sign In',
            'signedinas'  => 'You are signed in as',
            'notsignedin' => 'You are not signed in. To be able to comment, please ',
        ],
        'email' => [
            /**
             * Send email notifications.
             */
            'notify' => false,
            /**
             * Email addresses where to send the notification.
             */
            'to' => [],
            /**
             * From header. Usually something like noreply@myserver.com
             */
            'from' => '',
            /**
             * Subject of the notification email.
             */
            'subject' => 'New Comment',
            /**
             * Text of the comment link.
             */
            'context_link_text' => 'See this comment in context',
        ],
        'akismet' => [
            /**
             * If this is true, the comment will be checked for spam.
             */
            'enabled' => false,
            /**
             * Your Akismet api key.
             */
            'api_key' => '',
            /**
             * Akismet uses IP addresses. If you are behind a proxy this SHOULD
             * be configured to avoid false positives.
             * Uses the class \Zend\Http\PhpEnvironment\RemoteAddress
             */
            'proxy' => [
                /**
                 * Use proxy addresses or not.
                 */
                'use' => false,
                /**
                 * List of trusted proxy IP addresses.
                 */
                'trusted' => [
                ],
                /**
                 * HTTP header to introspect for proxies.
                 */
                'header' => 'X-Forwarded-For',
            ],
        ],
        'zfc_user' => [
            /**
             * This enables the ZfcUser integration.
             */
            'enabled' => false,
        ],
        'gravatar' => [
            /**
             * This enables the Gravatar integration.
             */
            'enabled' => false,
        ],
    ],
];
