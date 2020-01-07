<?php

namespace App\services\render;

class TvigRenderTemplate
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

        $menuContent = TvigRenderTemplate::RenderTemplate(
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
        $params['content'] = TvigRenderTemplate::RenderTemplate($tmpl, $data);
        extract($params);
        $params['htmlScripts'] = $htmlScripts;
        return TvigRenderTemplate::RenderTemplate($template, $params);
    }

    public function RenderTemplate($template, $params)
    {
        ob_start();
        extract($params);
        include $_SERVER['DOCUMENT_ROOT'] . '/../views/' . $template . '.php';
        return ob_get_clean();
    }
}