<?php

namespace MichaelDrennen\Highcharts;

use phpDocumentor\Reflection\Types\Self_;

class Highchart {

    protected $id = '';

    protected $options = [];
    //protected $title    = '';
    //protected $subTitle = '';

    protected $height = 400;
    protected $width  = '100%';

    public static $scriptLoaded = FALSE;

    protected function __construct() {
        $this->setIdOfChart();
    }

    /**
     * @return \MichaelDrennen\Highcharts\Highchart
     */
    public static function make() {
        return new Highchart();
    }

    public function options( array $options ) {
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
        $script = '';

        // Only load these files onto the page once.
        if ( FALSE === self::$scriptLoaded ):
            //$script = '<script src="https://code.highcharts.com/highcharts.js"></script>';
            $script             .= "\n" . '<script src="https://code.highcharts.com/stock/highstock.js"></script> ';
            $script             .= "\n" . '<script src="https://code.highcharts.com/stock/highcharts-more.js"</script> ';
            $script             .= "\n" . '<script src="https://code.highcharts.com/stock/modules/drag-panes.js"></script> ';
            $script             .= "\n" . '<script src="https://code.highcharts.com/stock/modules/exporting.js"></script> ';
            self::$scriptLoaded = TRUE;
        endif;

        $script .= "<script>var highchart_" . $this->id . " = Highcharts.stockChart('highchart_container_" . $this->id . "', " . json_encode( $this->options ) . ");</script>";
        return $script;
    }

    protected function setIdOfChart() {
        $this->id = mt_rand();
    }

    public function chart(): string {
        $chart = '<div id="highchart_container_' . $this->id . '" style="width:' . $this->width . '; height:' . $this->width . 'px;"></div>';

        return $chart;
    }
}