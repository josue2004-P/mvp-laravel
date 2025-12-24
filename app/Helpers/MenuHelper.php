<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMainNavItems()
    {
        return [
            [
                'icon' => 'dashboard',
                'name' => 'Dashboard',
                'path' => '/dashboard',
            ],
            [
                'icon' => 'book-medical',
                'name' => 'Clientes',
                'path' => '/clientes',
            ],
            [
                'icon' => 'doctor',
                'name' => 'Doctores',
                'path' => '/doctores',
            ],
            [
                'name' => 'Analisis',
                'icon' => 'analysis',
                'subItems' => [
                    ['name' => 'Analisis', 'path' => '/analisis'],
                    ['name' => 'Tipo de Analisis', 'path' => '/tipo_analisis'],
                    ['name' => 'Tipo de Muestra', 'path' => '/tipo_muestra'],
                    ['name' => 'Tipo de Metodo', 'path' => '/tipo_metodo'],
                    ['name' => 'Unidades', 'path' => '/unidades'],
                ],
            ],
            [
                'name' => 'Hemograma Completo',
                'icon' => 'dna',
                'subItems' => [
                    ['name' => 'Hemograma Completo', 'path' => '/hemograma_completo'],
                    ['name' => 'Categoria Hemograma Completo', 'path' => '/categoria_hemograma_completo'],
                ],
            ],
            [
                'name' => 'Usuarios',
                'icon' => 'users',
                'subItems' => [
                    ['name' => 'Usuarios', 'path' => '/usuarios'],
                    ['name' => 'Perfiles', 'path' => '/perfiles'],
                    ['name' => 'Permisos', 'path' => '/permisos'],

                ],
            ]
        ];
    }

    public static function getOthersItems()
    {
        return [
            [
                'icon' => 'charts',
                'name' => 'Charts',
                'subItems' => [
                    ['name' => 'Line Chart', 'path' => '/line-chart', 'pro' => false],
                    ['name' => 'Bar Chart', 'path' => '/bar-chart', 'pro' => false]
                ],
            ],
            [
                'icon' => 'ui-elements',
                'name' => 'UI Elements',
                'subItems' => [
                    ['name' => 'Alerts', 'path' => '/alerts', 'pro' => false],
                    ['name' => 'Avatar', 'path' => '/avatars', 'pro' => false],
                    ['name' => 'Badge', 'path' => '/badge', 'pro' => false],
                    ['name' => 'Buttons', 'path' => '/buttons', 'pro' => false],
                    ['name' => 'Images', 'path' => '/image', 'pro' => false],
                    ['name' => 'Videos', 'path' => '/videos', 'pro' => false],
                ],
            ],
            [
                'icon' => 'authentication',
                'name' => 'Authentication',
                'subItems' => [
                    ['name' => 'Sign In', 'path' => '/signin', 'pro' => false],
                    ['name' => 'Sign Up', 'path' => '/signup', 'pro' => false],
                ],
            ],
        ];
    }

    public static function getMenuGroups()
    {
        return [
            [
                'title' => 'Menu',
                'items' => self::getMainNavItems()
            ],
            // [
            //     'title' => 'Others',
            //     'items' => self::getOthersItems()
            // ]
        ];
    }

    public static function isActive($path)
    {
        return request()->is(ltrim($path, '/'));
    }

    public static function getIconSvg($iconName)
    {
        $icons = [
            'dashboard' => '<i class="text-xl fa-solid fa-gauge-high"></i>',

            'book-medical' => '<i class="text-xl fa-solid fa-book-medical"></i>',

            'users' => '<i class="text-xl fa-solid fa-user"></i>',

            'analysis' => '<i class=" text-xl fa-solid fa-flask"></i>',

            'dna' => '<i class="text-xl fa-solid fa-dna"></i>',

            'doctor' => '<i class="text-xl fa-solid fa-user-doctor"></i>',



        ];

        return $icons[$iconName] ?? '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/></svg>';
    }
}
