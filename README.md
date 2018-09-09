# Highcharts
A PHP library that helps produce Highcharts graphs.


```php
$options = [
    'title' => ['text' => "My First Chart"],
    'subtitle' => ['text' => "My First Chart"],
    'yAxis' => [
        'labels' => [
            'formatter' => "function() { return this.value + ' %'; }"
            ]
        ],
        'gridLineWidth' => 1
    },
    
];
$chart = Highchart::make()
                  ->options($options);```