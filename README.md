# Highcharts
A PHP library that helps produce Highcharts graphs.


```php
$options = [
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
                  ->options( $options );
```