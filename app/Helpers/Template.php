<?php

namespace App\Helpers;

class Template
{
    public static function showItemHistory($by, $time)
    {
        $xhtml = sprintf('
            <p><i class="fa fa-user"></i>%s</p>
            <p><i class="fa fa-clock-o"></i>%s</p>
        ', $by, date(config('zvn.format.short_time'), strtotime($time)));
        return $xhtml;
    }

    public static function showItemStatus($controllerName, $id, $status)
    {
        $tmplStatus = config('zvn.template.status');

        $curStatus = array_key_exists($status, $tmplStatus) ? $tmplStatus[$status] : $tmplStatus['default'];
        $linkStatus = route($controllerName . '/status', ['status' => $status, 'id' => $id]);

        $xhtml = sprintf('
            <button data-url="%s" data-class="%s" type="button"
            class="btn btn-round %s status-ajax">%s</button>
        ', $linkStatus, $curStatus['class'], $curStatus['class'], $curStatus['name']);
        return $xhtml;
    }

    public static function showItemIsHome($controllerName, $id, $isHome)
    {
        $tmplIsHome = config('zvn.template.is_home');

        $curIsHome = array_key_exists($isHome, $tmplIsHome) ? $tmplIsHome[$isHome] : $tmplIsHome['default'];
        $linkIsHome = route($controllerName . '/is_home', ['isHome' => $isHome, 'id' => $id]);

        $xhtml = sprintf('
            <button data-url="%s" data-class="%s" type="button"
            class="btn btn-round %s is-home-ajax">%s</button>
        ', $linkIsHome, $curIsHome['class'], $curIsHome['class'], $curIsHome['name']);
        return $xhtml;
    }

    public static function showItemSelect($controllerName, $id, $display, $fieldName)
    {
        $tmplDisplay = config('zvn.template.' . $fieldName);
        $linkDisplay = route($controllerName . '/' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);
        $xhtml = sprintf('<select name="select_change_attr" data-url="%s" class="form-control">', $linkDisplay);
        foreach ($tmplDisplay as $key => $value) {
            $xhtmlSelected = '';
            if ($key == $display) $xhtmlSelected = 'selected';
            $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
        }
        $xhtml .= '</select>';
        return $xhtml;
    }

    public static function showItemThumb($controllerName, $thumb)
    {
        $linkThumb = asset("images/$controllerName/$thumb");
        $xhtml = '<p><img src="' . $linkThumb . '" alt="" width="100%" height="180px"></p>';
        return $xhtml;
    }

    public static function showItemAvatar($controllerName, $avatar)
    {
        $linkAvatar = asset("images/$controllerName/$avatar");
        $xhtml = '<p><img src="' . $linkAvatar . '" alt="" width="100%" height="180px"></p>';
        return $xhtml;
    }

    public static function showButtonAction($controllerName, $id)
    {
        $tmplButton = config('zvn.template.button');
        $buttonInArea = config('zvn.config.button');
        $controllerName = array_key_exists($controllerName, $buttonInArea) ? $controllerName : 'default';
        $listButton = $buttonInArea[$controllerName];
        $xhtml = '<div class="zvn-box-btn-filter">';
        foreach ($listButton as $btn) {
            $curButton = $tmplButton[$btn];
            $class     = $curButton['class'];
            $name      = $curButton['name'];
            $icon      = $curButton['icon'];
            $link      = route($controllerName . $curButton['route-name'], ['id' => $id]);
            $xhtml .= sprintf('
                <a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                    <i class="fa %s"></i>
                </a>
            ', $link, $class, $name, $icon);
        }
        $xhtml .= '</div>';
        return $xhtml;
    }

    public static function showButtonFilter($controllerName, $countItemsStatus, $params)
    {
        $paramsFilterStatus = $params['filter']['status'];
        $paramsSearch = $params['search'];
        $tmplStatus = config('zvn.template.status');
        $xhtml = null;
        if ($countItemsStatus > 0) {
            array_unshift($countItemsStatus, [
                'status' => 'all',
                'count' => array_sum(array_column($countItemsStatus, 'count')),
            ]);
            foreach ($countItemsStatus as $value) {
                $status = $value['status'];
                $curStatus = array_key_exists($status, $tmplStatus) ? $tmplStatus[$status] : $tmplStatus['default'];
                $link = route($controllerName) . '?filter_status=' . $status;
                if ($paramsSearch['value'] !== "") {
                    $link .= '&search_field=' . $paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                }
                $class = ($status == $paramsFilterStatus) ? 'btn-success' : 'btn-primary';
                $xhtml .= sprintf('
                <a href="%s" type="button" class="btn %s">
                    %s <span class="badge bg-white">%s</span>
                </a>
                ', $link, $class, $curStatus['name'], $value['count']);
            }
        }
        return $xhtml;
    }

    public static function showAreaSearch($controllerName, $params)
    {
        $xhtml              = null;
        $xhtmlField         = null;
        $tmplField          = config('zvn.template.search');
        $fieldInController  = config('zvn.config.search');
        $controllerName     = array_key_exists($controllerName, $fieldInController) ? $controllerName : 'default';
        foreach ($fieldInController[$controllerName] as $field) {
            $xhtmlField .= sprintf('
                <li><a href="#" class="select-field" data-field="%s">%s</a></li>
            ', $field, $tmplField[$field]['name']);
        }
        $searchField        = in_array($params['field'], $fieldInController[$controllerName]) ?
            $tmplField[$params['field']]['name'] : $tmplField['all']['name'];
        $xhtml = sprintf('
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle btn-active-field"
                        data-toggle="dropdown" aria-expanded="false">
                        %s <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">%s</ul>
                </div>
                <input type="hidden" name="search_field" value="%s">
                <input type="text" class="form-control" name="search_value" value="%s">
                <span class="input-group-btn">
                    <button id="btn-clear" type="button" class="btn btn-success"
                        style="margin-right: 0px">Xóa tìm kiếm</button>
                    <button id="btn-search" type="button" class="btn btn-primary">Tìm
                        kiếm</button>
                </span>
            </div>
        ', $searchField, $xhtmlField, $params['field'], $params['value']);
        return $xhtml;
    }

    public static function showDatetimeFrontend($dateTime)
    {
        return date_format(date_create($dateTime), config('zvn.format.short_time'));
    }

    public static function showContent($content, $length, $prefix = '...')
    {
        $prefix = ($length == 0) ? '' : $prefix;
        $content = str_replace(['<p>', '</p>'], '', $content);
        return preg_replace('/\s+?(\S+)?$/', '', substr($content, 0, $length)) . $prefix;
    }
}
