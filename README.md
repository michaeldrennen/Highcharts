# Highcharts
[![Latest Stable Version](https://poser.pugx.org/michaeldrennen/highcharts/version)](https://packagist.org/packages/michaeldrennen/highcharts) [![Total Downloads](https://poser.pugx.org/michaeldrennen/highcharts/downloads)](https://packagist.org/packages/michaeldrennen/highcharts) [![License](https://poser.pugx.org/michaeldrennen/highcharts/license)](https://packagist.org/packages/michaeldrennen/highcharts) [![composer.lock available](https://poser.pugx.org/michaeldrennen/highcharts/composerlock)](https://packagist.org/packages/michaeldrennen/highcharts) 

A PHP library that helps produce Highcharts graphs.

This library is functional, but needs some work before I release a v1.0

## Breaking Change - 2019-05-15
The latest release includes a breaking change to the library that now allows users to include "global" Highcharts options.

```php
// These will be applied to every chart on this page.
$globalOptions = [
            'lang' => [
                'thousandsSep' => ",",
            ],
        ];
        
$localOptions = [
    'title'    => ['text' => "My First Chart"],
    'subtitle' => ['text' => "It needs data"],
    'yAxis'    => [ 
        [
            'title' => [ 
                           'text' => "Scores" 
                       ],
            'type'            => 'linear',
            'floor'           => 0,
            'startOnTick'     => TRUE,
        ]
    ]
];
$chart = Highchart::make( 'highstock', 400, '100%' )
                  ->setGlobalOptions($globalOptions)
                  ->setLocalOptions( $localOptions );
```

## Sample localOptions
```php

[
            'title'         => [ 'text' => "This is the Title of the Graph" ],
            'subtitle'      => [ 'text' => "This is the subtitle of the graph" ],
            'chart'         => [
                'type' => 'column',
            ],
            'navigator'     => [
                'enabled' => FALSE,
            ],
            'scrollbar'     => [
                'enabled' => FALSE,
            ],
            'rangeSelector' => [
                'enabled' => FALSE,
            ],
            'legend'        => FALSE,
            'xAxis'         => [ [
                                     'categories' => $this->categories(),
                                 ],
            ],
            'yAxis'         => [ [
                                     'min'           => 0,
                                     'allowDecimals' => FALSE,
                                     'title'         => [ 'text' => "Total Transactions Checked" ],
                                     'stackLabels'   => [
                                         'enabled' => TRUE,
                                         'style'   => [
                                             'fontWeight' => 'bold',
                                             'color'      => "(Highcharts.theme && Highcharts.theme.textColor) || 'gray'",
                                         ],
                                     ],

                                 ],
            ],
            'series'        => $this->series(),
        ];
```