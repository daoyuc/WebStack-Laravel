<?php
/**
 * 通用配置
 */
return [
    'theme' => env('THEME', 'default'),
    'github'   => env('GITHUB', 'https://github.com/hui-ho/WebStack-Laravel'),
    'default_img' => '/img/default.png',
    'switch_yn'               => [
        'on'  => ['value' => 'Y', 'text' => '✔', 'color' => 'primary'],
        'off' => ['value' => 'N', 'text' => '✖', 'color' => 'default'],
    ],
    'time_particles' => [
        'hour' => '小时',
        'day' => '天',
        'week' => '周',
        'month'=>'月',
        'year' => '年',
        'unknown' => '未知',
    ],
];
