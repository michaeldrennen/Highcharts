<?php

namespace MichaelDrennen\Highcharts;


/**
 * Class Highchart
 *
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

    const DEFAULT_HEIGHT = 400;
    const DEFAULT_WIDTH  = "100%";

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
    protected $height = self::DEFAULT_HEIGHT;

    /**
     * @var string How wide do you want the container? Set in the constructor.
     */
    protected $width = self::DEFAULT_WIDTH;

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
     *
     * @param string $type
     * @param int    $height
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
     * @param int    $height
     * @param string $width
     *
     * @return \MichaelDrennen\Highcharts\Highchart
     * @throws \Exception
     */
    public static function make( string $type = 'highstock',
                                 int    $height = self::DEFAULT_HEIGHT,
                                 string $width = self::DEFAULT_WIDTH ): Highchart {

        $validChartType = [ 'highstock', 'highchart' ];
        if ( FALSE === in_array( $type, $validChartType ) ):
            throw new \Exception( "You tried to set the type of this chart to something that isn't supported." );
        endif;

        return new Highchart( $type, $height, $width );
    }

    /**
     * Highcharts.setOptions
     * This method accepts an array of options to be passed to the setOptions() method of Highcharts before any of your charts are generated.
     *
     * @see https://api.highcharts.com/highcharts/
     *
     * @param array $globalOptions
     *
     * @return $this
     */
    public function setGlobalOptions( array $globalOptions ): Highchart {
        $this->globalOptions = $globalOptions;
        return $this;
    }

    /**
     * @param array $localOptions
     *
     * @return $this
     */
    public function setLocalOptions( array $localOptions ): Highchart {
        $this->localOptions = $localOptions;
        return $this;
    }


    public function setTitle( string $title ): Highchart {
        $this->localOptions[ 'title' ] = $title;
        return $this;
    }

    public function setSubtitle( string $subtitle ): Highchart {
        $this->localOptions[ 'subtitle' ] = $subtitle;
        return $this;
    }

    public function setXAxisValues( array $xAxisValues ): Highchart {
        $this->localOptions[ 'xAxis' ][ 0 ][ 'categories' ] = $xAxisValues;
        return $this;
    }


    /**
     * @param array  $xAxisValues An array of values/tic-marks for the x-axis. See below
     * @param array  $lines       Each element is its own line, with 'name' and 'data' elements. See below
     * @param string $title
     * @param string $subTitle
     * @param int    $height
     * @param string $width
     * @param string $yAxisLabel
     *
     *
     *  $xAxisValues = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',];
     *
     *  $lines = [
     *       [
     *           'name' => 'Installation & Developers',
     *           'data' => [
     *                   43934, 48656, 65165, 81827, 112143, 142383,
     *                   171533, 165174, 155157, 161454, 154610, 168960,
     *           ],
     *       ],
     *       [
     *           'name' => 'Manufacturing',
     *           'data' => [
     *               24916, 37941, 29742, 29851, 32490, 30282,
     *               38121, 36885, 33726, 34243, 31050, 33099,
     *           ],
     *       ]
     *  ];
     *
     * @return \MichaelDrennen\Highcharts\Highchart
     * @throws \Exception
     */
    public static function simpleLine( array  $xAxisValues = [],
                                       array  $lines = [],
                                       string $title = '',
                                       string $subTitle = '',
                                       int    $height = 400,
                                       string $width = '100%',
                                       string $yAxisLabel = '' ): Highchart {

        $localOptions = self::_getLocalOptions( 'line', $title, $subTitle, $xAxisValues, $lines, $yAxisLabel );
        return self::make( 'highchart', $height, $width )->setLocalOptions( $localOptions );
    }


    /**
     * @param array  $dohlcs  Each row is [timestamp, open, high, low, close]
     * @param array  $volumes Each row is [timestamp, intVolume]
     * @param string $title
     * @param string $subTitle
     * @param int    $height
     * @param string $width
     * @param string $yAxisLabel
     *
     * @return \MichaelDrennen\Highcharts\Highchart
     * @throws \Exception
     */
    public static function simpleStock( array  $dohlcs = [],
                                        array  $volumes = [],
                                        string $title = '',
                                        string $subTitle = '',
                                        int    $height = 400,
                                        string $width = '100%',
                                        string $yAxisLabel = '' ) {

        $localOptions = self::_getLocalOptions( null,
                                                $title,
                                                $subTitle,
                                                [],
                                                $dohlcs,
                                                $yAxisLabel );



        return self::make( 'highstock', $height, $width )->setLocalOptions( $localOptions );

    }


    /**
     * @throws \Exception
     */
    public static function simpleColumn( array  $xAxisValues = [],
                                         array  $dataSeries = [],
                                         string $title = '',
                                         string $subTitle = '',
                                         int    $height = 400,
                                         string $width = '100%',
                                         string $yAxisLabel = '' ): Highchart {

        $localOptions = self::_getLocalOptions( 'column', $title, $subTitle, $xAxisValues, $dataSeries, $yAxisLabel );
        return self::make( 'highchart', $height, $width )->setLocalOptions( $localOptions );
    }


    /**
     * Only load the scripts that you need.
     * TODO Add logic to selectively load the more/panes/exporting scripts if they're not needed.
     *
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


    /**
     * @param string      $chartType
     * @param string|NULL $title
     * @param string|NULL $subTitle
     * @param array       $xAxisValues
     * @param array       $dataSeries
     * @param string|NULL $yAxisLabel
     *
     * @return array
     */
    protected static function _getLocalOptions( string $chartType,
                                                string $title = NULL,
                                                string $subTitle = NULL,
                                                array  $xAxisValues = [],
                                                array  $dataSeries = [],
                                                string $yAxisLabel = NULL ): array {
        return [
            'title'         => [ 'text' => $title ],
            'subtitle'      => [ 'text' => $subTitle ],
            'chart'         => [
                'type' => $chartType,
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
                                     'categories' => $xAxisValues,
                                 ],
            ],
            'yAxis'         => [ [
                                     'min'           => 0,
                                     'allowDecimals' => FALSE,
                                     'title'         => [ 'text' => $yAxisLabel ],
                                     'stackLabels'   => [
                                         'enabled' => TRUE,
                                         'style'   => [
                                             'fontWeight' => 'bold',
                                             'color'      => "(Highcharts.theme && Highcharts.theme.textColor) || 'gray'",
                                         ],
                                     ],

                                 ],
            ],
            'series'        => $dataSeries,
        ];
    }
}