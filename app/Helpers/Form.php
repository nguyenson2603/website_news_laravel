<?php

namespace App\Helpers;

class Form
{
    public static function show($elements)
    {
        $xhtml = null;
        foreach ($elements as $element) {
            $xhtml .= self::formGroup($element);
        }
        return $xhtml;
    }

    public static function formGroup($element)
    {
        $xhtml = null;
        $type = (isset($element['type'])) ? $element['type'] : 'input';
        switch ($type) {
            case 'input':
                $xhtml .= sprintf('
                <div class="form-group">
                    %s
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        %s
                    </div>
                </div>
                ', $element['label'], $element['element']);
                break;
            case 'btn-submit':
                $xhtml .= ' <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">';
                foreach ($element['elements'] as $element) {
                    $xhtml .= $element;
                }
                $xhtml .= '     </div>
                            </div>';
                break;
            case 'btn-submit-edit':
                $xhtml .= ' <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">';
                foreach ($element['elements'] as $element) {
                    $xhtml .= $element;
                }
                $xhtml .= '     </div>
                                </div>';
                break;
            case 'thumb':
                $xhtml .= sprintf('
                <div class="form-group">
                    %s
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        %s
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        %s
                    </div>
                </div>
                ', $element['label'], $element['element'], $element['thumb']);
                break;
            case 'avatar':
                $xhtml .= sprintf('
                    <div class="form-group">
                        %s
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            %s
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            %s
                        </div>
                    </div>
                    ', $element['label'], $element['element'], $element['avatar']);
                break;
        }
        return $xhtml;
    }
}
