<?php

namespace Seo\View\Helper;

use Zend\View\Helper\HtmlTag as BaseHtmlTag;

/**
 * Renders <html> tag (both opening and closing) of a web page, to which some custom
 * attributes can be added dynamically.
 *
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class HtmlTag extends BaseHtmlTag
{
    protected function htmlAttribs($attribs)
    {
        $schemaAttribs = [];

        if (array_key_exists('itemscope', $attribs)) {
            $schemaAttribs['itemscope'] = $attribs['itemscope'];
            unset($attribs['itemscope']);
        } elseif (isset($attribs['itemtype'])) {
            $schemaAttribs['itemscope'] = '';
        }

        if (array_key_exists('itemtype', $attribs)) {
            if (isset($attribs['itemtype'])) {
                $schemaAttribs['itemtype'] = $attribs['itemtype'];
            }
            unset($attribs['itemtype']);
        }

        $xhtml = parent::htmlAttribs($attribs);

        // Now the schema
        $xhtmlSchema = '';
        foreach ($schemaAttribs as $key => $value) {
            $xhtmlSchema .= " " . $key . "=\"" . $value . "\"";
        }

        return $xhtmlSchema . $xhtml;
    }
}