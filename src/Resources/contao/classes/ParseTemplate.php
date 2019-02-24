<?php /** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.09.2018
 * Time: 10:59
 */

namespace Markocupic\NavPageContainer\Contao\Classes;


class ParseTemplate
{
    /**
     * Add .not-clickable-page-container to the nav items
     * @param $objTemplate
     */
    public function parseTemplateHook(\Contao\Template $objTemplate)
    {
        // Check if login is allowed, if not replace the default error message
        if (TL_MODE === 'FE')
        {
            if (strpos($objTemplate->getName(), 'nav_') === 0)
            {
                $items =  $objTemplate->items;
                foreach($items as $k => $v){
                    if($items[$k]['isPageContainer'])
                    {
                        $items[$k]['class'] .= ' not-clickable-page-container';
                    }
                }
                $objTemplate->items = $items;
            }
        }
    }
}