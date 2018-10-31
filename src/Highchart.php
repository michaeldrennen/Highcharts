<?php

namespace MichaelDrennen\Highcharts;


/**
 * Class Highchart
 * @package MichaelDrennen\Highcharts
 *
 *          Most recent files for Highcharts
 * http://code.highcharts.com/highcharts.js
 * http://code.highcharts.com/highcharts-more.js
 * http://code.highcharts.com/modules/exporting.js
 * http://code.highcharts.com/adapters/mootools-adapter.js
 * http://code.highcharts.com/adapters/prototype-adapter.js
 */
class Highchart {

    protected $id = '';

    protected $options = [];
    //protected $title    = '';
    //protected $subTitle = '';

    protected $type   = 'highstock'; // highstock, highchart
    protected $height = 400;
    protected $width  = '100%';
    protected $script = '';

    /**
     * @var bool I only need to include the highcharts js files once.
     */
    public static $scriptLoaded = FALSE;

    /**
     * Highchart constructor.
     * @param string $type
     * @param int    $height
     * @param string $width
     */
    protected function __construct( string $type = 'highstock', $height = 400, $width = '100%' ) {
        $this->type   = $type;
        $this->height = $height;
        $this->width  = $width;
        $this->setIdOfChart();
    }

    /**
     * @param string $type
     * @param int    $height
     * @param string $width
     * @return \MichaelDrennen\Highcharts\Highchart
     */
    public static function make( string $type = 'highstock', $height = 400, $width = '100%' ) {
        return new Highchart( $type, $height, $width );
    }

    /**
     * @param array $options
     * @return $this
     */
    public function options( array $options ) {
        $this->options = $options;
        return $this;
    }

    /**
     * Only load the scripts that you need.
     * TODO Add logic to selectively load the more/panes/exporting scripts if they're not needed.
     * @throws \Exception
     */
    protected function setScripts() {
        $this->script = '';
//        switch ( $this->type ):
//            case 'highstock':
//                $this->script .= "\n" . '<script src="http://code.highcharts.com/highcharts.js"></script> ';
//                break;
//            case 'highchart':
//                $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/highstock.js"></script> ';
//                break;
//            default:
//                throw new \Exception( "You tried to set the type of this chart to something that isn't supported." );
//        endswitch;
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/highstock.js"></script> ';
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/highcharts-more.js"></script> ';
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/modules/drag-panes.js"></script> ';
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/modules/exporting.js"></script> ';
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/modules/annotations.js"></script> ';
        $this->script .= "\n" . '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>';
    }


    public function script(): string {
        // Only load these files onto the page once.
        if ( FALSE === self::$scriptLoaded ):
            $this->setScripts();
            self::$scriptLoaded = TRUE;
        endif;

        if ( 'highstock' == $this->type ):
            $this->script .= "<script>var highchart_" . $this->id . " = Highcharts.stockChart('highchart_container_" . $this->id . "', " . json_encode( $this->options,
                                                                                                                                                        JSON_UNESCAPED_SLASHES ) . ");</script>";
        else:
            $this->script .= "<script>var highchart_" . $this->id . " = Highcharts.chart('highchart_container_" . $this->id . "', " . json_encode( $this->options,
                                                                                                                                                   JSON_UNESCAPED_SLASHES ) . ");</script>";
        endif;


        return $this->script;
    }

    protected function setIdOfChart() {
        $this->id = mt_rand();
    }

    public function chart(): string {
        $chart = '<div id="highchart_container_' . $this->id . '" style="width:' . $this->width . '; height:' . $this->width . 'px;"></div>';

        return $chart;
    }
}