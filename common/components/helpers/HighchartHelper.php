<?php

namespace common\components\helpers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class helper for Highchart
 */
class HighchartHelper
{
    /**
     * Get array config chart pie with drilldown
     * @link https://www.highcharts.com/demo/pie-drilldown
     * @return array
     */
    public static function pieWithDrilldown($title, $subtitle, $series, $drilldown)
    {
        $chart = [
            'chart' => ['type' => 'pie'],
            'title' => ['text' => $title],
            'subtitle' => ['subtitle' => $subtitle],
            'plotOptions' => [
                'series' => [
                    'dataLabels' => [
                        'enabled' => true, 'format' => '{point.name}: {point.y:.1f}%'
                    ]
                ]
            ],
            'tooltip' => [
                'headerFormat' => '<span style="font-size:11px">{series.name}</span><br>',
                'pointFormat' => '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            ],
            'series' => $series,
            'drilldown' => $drilldown
        ];
        return $chart;
    }

    /**
     * @param array $datas
     * @param array $list
     * @return array
     */
    public static function pieWithDrilldownData(array $datas, array $list)
    {
        $total = 0;
        foreach ($datas as $key => $data) {
            foreach ($data as $subkey => $dt) {
                $total += $dt;
            }
        }
        $dataSeries = [];
        $drilldownSeries = [];
        foreach ($datas as $key => $data) {
            $subtotal = 0;
            $drillSeriesData = [];
            foreach ($data as $subkey => $val) {
                $perc = round((($val / $total) * 100), 2);
                $subtotal += $perc;
                $drillSeriesData[] = [ArrayHelper::getValue($list, $subkey), $perc];
            }
            $drilldownSeries[] = ['name' => $key, 'id' => $key, 'data' => $drillSeriesData];
            $dataSeries[] = ['name' => $key, 'y' => $subtotal, 'drilldown' => $key];
        }
        return ['series' => $dataSeries, 'drilldown' => $drilldownSeries];
    }

    /**
     * Get array config chart column basic
     * @link https://www.highcharts.com/demo/column-basic
     * @return array
     */
    public static function columnBasic($title, $subtitle, $categories, $series, $yTitle)
    {
        $chart = [
            'chart' => ['type' => 'column'],
            'title' => ['text' => $title],
            'subtitle' => ['text' => $subtitle],
            'plotOptions' => [
                'column' => [
                    'pointPadding' => 0.2,
                    'borderWidth' => 0
                ]
            ],
            'xAxis' => [
                'categories' => $categories,
                'crosshair' => true
            ],
            'yAxis' => [
                'min' => 0,
                'title' => ['text' => $yTitle]
            ],
            'tooltip' => [
                'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
                'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td>'.
                                 '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                'footerFormat' => '</table>',
                'shared' => true,
                'useHTML' => true
            ],
            'series' => $series
        ];
        return $chart;
    }

    /**
     *
     */
    public static function columnBasicData(array $datas)
    {
        $dataSeries = [];
        foreach ($datas as $type => $data) {
            $dataSeries[] = ['name' => $type, 'data' => $data];
        }
        return $dataSeries;
    }
}
