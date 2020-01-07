<?php
/**
 * Created by PhpStorm.
 * User: anatol
 * Date: 22.07.2019
 * Time: 22:00
 */

namespace App\services;


class TmplRenderService
{
    public function Render($template, $params)
    {
        extract($params);
        $arrStr = [
            'properties',
            'hideProperties',
            'imgSrc',
            'tableName',
            'htmlScripts'
        ];
        $arr = compact($arrStr);

        $menuContent = TmplRenderService::RenderTemplate(
            "layouts/menu", $params);
        $params = [
            'menuContent' => $menuContent
        ];
        if (isset($unit)) {
            $tmpl = 'unit';
            $data = [
                'data' => $unit
            ];
        } else if (isset($units)) {
            $tmpl = 'units';
            $data = [
                'data' => $units];
        }
        $data = array_merge($data, $arr);
        $params['content'] = TmplRenderService::RenderTemplate($tmpl, $data);
        extract($params);
        return TmplRenderService::RenderTemplate($template, $params);
    }

    public function RenderTemplate($template, $params)
    {
        ob_start();
        extract($params);
        include $_SERVER['DOCUMENT_ROOT'] . '/views/' . $template . '.php';
        return ob_get_clean();
    }
}