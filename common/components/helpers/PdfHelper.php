<?php

namespace common\components\helpers;

use Yii;
use Mpdf\Mpdf;
use yii\helpers\Html;

/**
 * Class helper for pdf
 */
class PdfHelper
{
    /**
     * Create instance Mpdf
     */
    public static function createInstance(array $config = [])
    {
        $defaultConfig = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 0,
            'default_font' => '',
            'mgl' => 15,
            'mgr' => 15,
            'mgt' => 25,
            'mgb' => 16,
            'mgh' => 4,
            'mgf' => 9,
            'orientation' => 'P',
        ];
        $config = array_merge($defaultConfig, $config);
        $mpdf = new Mpdf($config);
        $mpdf->SetAuthor('This is author');
        $mpdf->SetCreator('This is creator');
        return $mpdf;
    }

    /**
     * Create pdf file for general purpose
     */
    public static function create
    (
        $content,
        array $config = [],
        $filename,
        $title = '',
        $subject = '',
        $pages = [],
        $mode = 'D'
    ) {
        $mpdf = self::createInstance($config);
        $mpdf->SetTitle($title);
        $mpdf->SetSubject($subject);
        $mpdf->WriteHTML($content);
        if (!empty($pages) && is_array($pages)) {
            foreach ($pages as $key => $page) {
                if (is_array($page)) {
                    $mpdf->AddPageByArray($page['config']);
                    $mpdf->WriteHTML($page['content']);
                }
            }
        }
        $mpdf->Output($filename . '.pdf', $mode);
        if ($mode === 'D' or $mode === 'I') {
            exit;
        }
    }
}
