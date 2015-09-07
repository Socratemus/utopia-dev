<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Mailer\Controller\Index'           =>      'Mailer\Controller\IndexController',
        )
    ),
    'service_manager' =>  array(
        'factories' => array (
            'Mailer' => 'Mail\Service\MailFactory',
          ),    
    )
);

?>

