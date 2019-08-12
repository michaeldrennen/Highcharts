<?php

namespace MichaelDrennen\Highcharts\Tests;

use MichaelDrennen\Highcharts\Highchart;
use PHPUnit\Framework\TestCase;

class HighchartsTest extends TestCase {

    protected function getTestStockChart() {
        $globalOptions = [
            'lang' => [
                'thousandsSep' => ",",
            ],
        ];

        $localOptions = [
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


        return Highchart::make()
                        ->setGlobalOptions( $globalOptions )
                        ->setLocalOptions( $localOptions );
    }

    protected function getTestChart() {
        return Highchart::make( 'highchart', 500, '50%' );
    }

    protected function getInvalidChartType() {
        return Highchart::make( 'invalidChartType' );
    }


    /**
     * @test
     */
    public function shouldCreateHighchartsObject() {

        $chart = $this->getTestStockChart();

        $this->assertInstanceOf( Highchart::class, $chart );
    }

    /**
     * @test
     */
    public function scriptShouldEchoJavascript() {
        $chart        = $this->getTestStockChart();
        $scriptOutput = $chart->script();
        $this->assertStringContainsString( '<script', $scriptOutput );
    }


    /**
     * @test
     */
    public function chartShouldEchoDiv() {
        $chart         = $this->getTestStockChart();
        $chartContains = $chart->chart();
        $this->assertStringContainsString( '<div', $chartContains );
    }

    /**
     * @test
     */
    public function shouldReturnHighchartInstance() {
        Highchart::$scriptLoaded = false; // Force Highcharts to run setScripts again to get 100% code coverage.
        $chart = $this->getTestChart();
        $scriptOutput = $chart->script();
        $chartOutput = $chart->chart();
        $this->assertInstanceOf( Highchart::class, $chart );
    }


    /**
     * @test
     */
    public function makeInvalidChartTypeShouldThrowException() {
        $this->expectException( \Exception::class );
        $this->getInvalidChartType();
    }
}