<?php

namespace MichaelDrennen\Highcharts;

use phpDocumentor\Reflection\Types\Self_;

class Highchart {

    protected $options = [];
    //protected $title    = '';
    //protected $subTitle = '';

    protected function __construct() {

    }

    /**
     * @return \MichaelDrennen\Highcharts\Highchart
     */
    public static function make() {
        return new Highchart();
    }

    public function options(array $options){
        $this->options = $options;
        return $this;
    }

//    public function title( string $title ) {
//        $this->title = $title;
//        return $this;
//    }
//
//    public function subTitle( string $subTitle ) {
//        $this->subTitle = $subTitle;
//        return $this;
//    }


    public function script(): string {
        $script = "var myChart = Highchart.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Fruit Consumption'
        },
        xAxis: {
            categories: ['Apples', 'Bananas', 'Oranges']
        },
        yAxis: {
            title: {
                text: 'Fruit eaten'
            }
        },
        series: [{
            name: 'Jane',
            data: [1, 0, 4]
        }, {
            name: 'John',
            data: [5, 7, 3]
        }]
    });";
        return $script;
    }

    public function chart(): string {
        $chart = '<div id="container" style="width:100%; height:400px;"></div>';

        return $chart;
    }
}