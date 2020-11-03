<?php

return [
    '__name' => 'api-profile-setting',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/api-profile-setting.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/api-profile-setting' => ['install','update','remove'],
        'app/api-profile-setting' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'profile' => NULL
            ],
            [
                'profile-auth' => NULL
            ],
            [
                'lib-form' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'ApiProfileSetting\\Controller' => [
                'type' => 'file',
                'base' => 'app/api-profile-setting/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'api' => [
            'apiProfileSetting' => [
                'path' => [
                    'value' => '/pme/setting/(:type)',
                    'params' => [
                        'type' => 'slug'
                    ]
                ],
                'handler' => 'ApiProfileSetting\\Controller\\Setting::edit',
                'method' => 'PUT'
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'api.profile.account' => [
                'name' => [
                    'label' => 'Username',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                        'unique' => [
                            'model' => 'Profile\\Model\\Profile',
                            'field' => 'name',
                            'self' => [
                                'service' => 'profile.id',
                                'field' => 'id'
                            ]
                        ]
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                        'email' => TRUE,
                        'unique' => [
                            'model' => 'Profile\\Model\\Profile',
                            'field' => 'email',
                            'self' => [
                                'service' => 'profile.id',
                                'field' => 'id'
                            ]
                        ]
                    ]
                ],
                'phone' => [
                    'label' => 'Phone',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                        'unique' => [
                            'model' => 'Profile\\Model\\Profile',
                            'field' => 'phone',
                            'self' => [
                                'service' => 'profile.id',
                                'field' => 'id'
                            ]
                        ]
                    ]
                ]
            ],
            'api.profile.contact' => [
                'contact-email' => [
                    'label' => 'Public Email',
                    'rules' => [
                        'email' => TRUE
                    ]
                ],
                'contact-phone' => [
                    'label' => 'Public Phone',
                    'rules' => []
                ],
                'contact-manager' => [
                    'label' => 'Manager Phone',
                    'rules' => []
                ],
                'addr_country' => [
                    'label' => 'Country',
                    'rules' => []
                ],
                'addr_state' => [
                    'label' => 'State',
                    'rules' => []
                ],
                'addr_city' => [
                    'label' => 'City',
                    'rules' => []
                ],
                'addr_street' => [
                    'label' => 'Street',
                    'rules' => []
                ]
            ],
            'api.profile.education' => [
                'educations' => [
                    'label' => 'Educations',
                    'rules' => [
                        'array' => TRUE
                    ],
                    'children' => [
                        '*' => [
                            'rules' => [
                                'object' => true
                            ],
                            'children' => [
                                'level' => [
                                    'rules' => [
                                        'required' => true,
                                        'in' => [
                                            'TK','SD','SMP','SMA','Sarjana','Magister','Doktor'
                                        ]
                                    ]
                                ],
                                'year' => [
                                    'rules' => [
                                        'required' => true,
                                        'regex' => '![0-9]{4}-[0-9]{2}!'
                                    ]
                                ],
                                'place' => [
                                    'rules' => [
                                        'required' => true 
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'api.profile.password' => [
                'old-password' => [
                    'label' => 'Currect Password',
                    'rules' => [
                        'required' => true
                    ]
                ],
                'password' => [
                    'label' => 'New Password',
                    'rules' => [
                        'required' => true,
                        'length' => [
                            'min' => 6
                        ]
                    ]
                ],
                'retype-password' => [
                    'label' => 'Retype New Password',
                    'rules' => [
                        'required' => true,
                        'length' => [
                            'min' => 6
                        ]
                    ]
                ]
            ],
            'api.profile.profession' => [
                'profession' => [
                    'label' => 'Professions',
                    'type' => 'textarea',
                    'rules' => [
                        'array' => TRUE
                    ],
                    'children' => [
                        '*' => [
                            'rules' => [
                                'object' => true 
                            ],
                            'children' => [
                                'type' => [
                                    'rules' => [
                                        'required' => true,
                                        'empty' => FALSE
                                    ]
                                ],
                                'since' => [
                                    'rules' => [
                                        'required' => true,
                                        'regex' => '!^[0-9]{4}-[0-9]{2}$!'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'api.profile.general' => [
                'fullname' => [
                    'label' => 'Fullname',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE
                    ]
                ],
                'avatar' => [
                    'label' => 'Avatar',
                    'type' => 'image',
                    'form' => 'std-image',
                    'rules' => [
                        'required' => TRUE,
                        'upload' => TRUE
                    ]
                ],
                'bdate' => [
                    'label' => 'Birth Date',
                    'type' => 'date',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                        'date' => [
                            'format' => 'Y-m-d'
                        ]
                    ]
                ],
                'bplace' => [
                    'label' => 'Birth Place',
                    'type' => 'text',
                    'rules' => []
                ],
                'gender' => [
                    'label' => 'Gender',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'enum' => 'profile.gender'
                    ]
                ],
                'height' => [
                    'label' => 'Height ( cm )',
                    'type' => 'number',
                    'rules' => [
                        'numeric' => TRUE
                    ],
                    'filters' => [
                        'integer' => TRUE
                    ]
                ],
                'weight' => [
                    'label' => 'Weight ( kg )',
                    'type' => 'number',
                    'rules' => [
                        'numeric' => TRUE
                    ],
                    'filters' => [
                        'integer' => TRUE
                    ]
                ],
                'skin' => [
                    'label' => 'Skin',
                    'type' => 'text',
                    'rules' => []
                ],
                'biography' => [
                    'label' => 'Biography',
                    'type' => 'summernote',
                    'rules' => []
                ]
            ],
            'api.profile.social' => [
                'socials' => [
                    'label' => 'Socials',
                    'type' => 'textarea',
                    'rules' => [
                        'array' => TRUE
                    ],
                    'children' => [
                        '*' => [
                            'rules' => [
                                'object' => true 
                            ],
                            'children' => [
                                'type' => [
                                    'rules' => [
                                        'required' => true
                                    ]
                                ],
                                'url' => [
                                    'rules' => [
                                        'required' => true,
                                        'url' => true 
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];