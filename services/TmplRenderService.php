<?php
/**
 * Created by PhpStorm.
 * User: anatol
 * Date: 22.07.2019
 * Time: 22:00
 */

namespace App\services;


use App\models\Event;

class TmplRenderService
{
    public function Render($template, $params)
    {
        if (empty($params)) {
            $params = ['content' => null];
//        } else {
//            $params['content'] = TmplRenderService::RenderTemplate($tmpl, $data);
//            $params['content'] = $params['data'];
        }
//        elseif (is_array($params)) {
//            $params['content'] = $this->RenderArray($params['content']);
//        }
        /*
                $params = [
                    'menuContent' => TmplRenderService::RenderTemplate("layouts/menu", $params)
                ];
                extract($params);
                */
        return TmplRenderService::RenderTemplate($template, $params);
    }

    public function RenderTemplate($template, $params)
    {
        ob_start();
        extract($params);
        include $_SERVER['DOCUMENT_ROOT'] . '/views/' . $template . '.php';
        return ob_get_clean();
    }

    public function RenderArray($arr)
    {
        $html = '';
        foreach ($arr as $key => $value) {
            $html .= '<p>' . $key . ' => ' . $value . '</p>';
        }
        return $html;
    }
}