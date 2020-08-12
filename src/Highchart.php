<?php

namespace MichaelDrennen\Highcharts;


/**
 * Class Highchart
 * @package MichaelDrennen\Highcharts
 *
 * Most recent files for Highcharts
 * http://code.highcharts.com/highcharts.js
 * http://code.highcharts.com/highcharts-more.js
 * http://code.highcharts.com/modules/exporting.js
 * http://code.highcharts.com/adapters/mootools-adapter.js
 * http://code.highcharts.com/adapters/prototype-adapter.js
 */
class Highchart {

    /**
     * @var int A pseudo-random number returned by mt_rand to serve as an identifier for a chart on a page.
     */
    protected $id = '';

    /**
     * @var array Options for the chart
     */
    protected $globalOptions = [];

    /**
     * @var array
     */
    protected $localOptions = [];

    /**
     * @var string What type of chart do you want to display?
     */
    protected $type = 'highstock'; // Either 'highstock' or 'highchart'

    /**
     * @var int How tall (in pixels) do you want the container? Set in the constructor.
     */
    protected $height = 400;

    /**
     * @var string How wide do you want the container? Set in the constructor.
     */
    protected $width = '100%';

    /**
     * @var string The javascript that will be included on the page displaying the chart.
     */
    protected $script = '';

    /**
     * @var bool I only need to include the highcharts js files once.
     */
    public static $scriptLoaded = FALSE;

    /**
     * Highchart constructor.
     * @param string $type
     * @param int $height
     * @param string $width
     */
    protected function __construct( string $type = 'highstock', int $height = 400, string $width = '100%' ) {
        $this->type   = $type;
        $this->height = $height;
        $this->width  = $width;
        $this->setIdOfChart();
    }

    /**
     * @param string $type
     * @param int $height
     * @param string $width
     * @return \MichaelDrennen\Highcharts\Highchart
     * @throws \Exception
     */
    public static function make( string $type = 'highstock', $height = 400, $width = '100%' ) {

        $validChartType = [ 'highstock', 'highchart' ];
        if ( FALSE === in_array( $type, $validChartType ) ):
            throw new \Exception( "You tried to set the type of this chart to something that isn't supported." );
        endif;

        return new Highchart( $type, $height, $width );
    }

    /**
     * Highcharts.setOptions
     * This method accepts an array of options to be passed to the setOptions() method of Highcharts before any of your charts are generated.
     * @see https://api.highcharts.com/highcharts/
     * @param array $globalOptions
     * @return $this
     */
    public function setGlobalOptions( array $globalOptions ) {
        $this->globalOptions = $globalOptions;
        return $this;
    }

    /**
     * @param array $localOptions
     * @return $this
     */
    public function setLocalOptions( array $localOptions ) {
        $this->localOptions = $localOptions;
        return $this;
    }

    /**
     * Only load the scripts that you need.
     * TODO Add logic to selectively load the more/panes/exporting scripts if they're not needed.
     * @throws \Exception
     */
    protected function setScripts() {
        $this->script = '';
        switch ( $this->type ):
            case 'highstock':
                $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/highstock.js"></script> ';
                break;
            case 'highchart':
                $this->script .= "\n" . '<script src="https://code.highcharts.com/highcharts.js"></script> ';
                break;
        endswitch;
        //$this->script .= "\n" . '<script src="https://code.highcharts.com/stock/highstock.js"></script> ';
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/highcharts-more.js"></script> ';
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/modules/drag-panes.js"></script> ';
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/modules/exporting.js"></script> ';
        $this->script .= "\n" . '<script src="https://code.highcharts.com/stock/modules/annotations.js"></script> ';
        $this->script .= "\n" . '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>';
    }

    /**
     * Sets the id of the chart to some psuedo-random number. You can have more than one chart per page.
     */
    protected function setIdOfChart() {
        $this->id = mt_rand();
    }


    public function script(): string {
        // Only load these files onto the page once.
        if ( FALSE === self::$scriptLoaded ):
            $this->setScripts();
            self::$scriptLoaded = TRUE;
        endif;

        if ( $this->globalOptions ):
            $this->script .= "<script>Highcharts.setOptions(" . json_encode( $this->globalOptions, JSON_UNESCAPED_SLASHES ) . ");</script>";
        endif;

        if ( 'highstock' === $this->type ):
            $this->script .= "<script>let highchart_" . $this->id . " = Highcharts.stockChart('highchart_container_" . $this->id . "', " . json_encode( $this->localOptions,
                                                                                                                                                        JSON_UNESCAPED_SLASHES ) . ");</script>";
        else:
            $this->script .= "<script>let highchart_" . $this->id . " = Highcharts.chart('highchart_container_" . $this->id . "', " . json_encode( $this->localOptions,
                                                                                                                                                   JSON_UNESCAPED_SLASHES ) . ");</script>";
        endif;


        return $this->script;
    }


    /**
     * @return string Call this where you want your chart container displayed.
     */
    public function chart(): string {
        $chart = '<div id="highchart_container_' . $this->id . '" style="width:' . $this->width . '; height:' . $this->height . 'px;"></div>';
        return $chart;
    }
}