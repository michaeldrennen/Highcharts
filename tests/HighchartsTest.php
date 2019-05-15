<?php

namespace MichaelDrennen\Highcharts\Tests;

use MichaelDrennen\Highcharts\Highchart;
use PHPUnit\Framework\TestCase;

class HighchartsTest extends TestCase {


    /**
     * @test
     */
    public function shouldCreateHighchartsObject() {

        $options = [
            'lang' => [
                'thousandsSep' => ",",
            ],
        ];

        $properties = [
            'title'    => [ 'text' => "My First Chart" ],
            'subtitle' => [ 'text' => "I hope you like it!" ],
            'yAxis'    => [ [
                                'labels'       => [
                                    'formatter' => "function() { return this.value + ' %'; }",
                                ],
                                'title'        => [ 'text' => "The first y axis" ],
                                'type'         => 'linear', // linear, logarithmic, or datetime
                                'tickInterval' => 1,
                            ],
                            [
                                'labels'       => [
                                    'formatter' => "function() { return this.value + ' %'; }",
                                ],
                                'title'        => [ 'text' => "The second y axis" ],
                                'opposite'     => TRUE,
                                'type'         => 'logarithmic',
                                'tickInterval' => 1,
                            ],
            ],
            'xAxis'    => [ [
                                'labels'       => [
                                    'formatter' => "function() { return this.value + ' %'; }",
                                ],
                                'title'        => [ 'text' => "The first y axis" ],
                                'type'         => 'linear', // linear, logarithmic, or datetime
                                'tickInterval' => 1,
                            ],
                            [
                                'labels'       => [
                                    'formatter' => "function() { return this.value + ' %'; }",
                                ],
                                'title'        => [ 'text' => "The second y axis" ],
                                'opposite'     => TRUE,
                                'type'         => 'logarithmic',
                                'tickInterval' => 1,
                            ],
            ],
        ];

//        echo json_encode( $properties, JSON_PRETTY_PRINT );

        $chart = Highchart::make()
                          ->options( $options )
                          ->properties( $properties );

        echo $chart->script();
    }
}