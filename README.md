# Highcharts
[![Latest Stable Version](https://poser.pugx.org/michaeldrennen/highcharts/version)](https://packagist.org/packages/michaeldrennen/highcharts) [![Total Downloads](https://poser.pugx.org/michaeldrennen/highcharts/downloads)](https://packagist.org/packages/michaeldrennen/highcharts) [![License](https://poser.pugx.org/michaeldrennen/highcharts/license)](https://packagist.org/packages/michaeldrennen/highcharts) [![composer.lock available](https://poser.pugx.org/michaeldrennen/highcharts/composerlock)](https://packagist.org/packages/michaeldrennen/highcharts) 

A PHP library that helps produce Highcharts graphs.

This library is functional, but needs some work before I release a v1.0

## Breaking Change - 2019-05-15
The latest release includes a breaking change to the library that now allows users to include "global" Highcharts options.

```php
$options = [
            'lang' => [
                'thousandsSep' => ",",
            ],
        ];
        
$properties = [
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
                  ->options($options)
                  ->properties( $properties );
```