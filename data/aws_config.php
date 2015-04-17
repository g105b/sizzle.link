<?php return array(
    'includes' => array('_aws'),
    'services' => array(
        'default_settings' => array(
            'params' => array(
                'profile' => 'my_profile', // Looks up credentials in ~/.aws/credentials
                'region'  => 'us-west-2'
            )
        )
    )
);