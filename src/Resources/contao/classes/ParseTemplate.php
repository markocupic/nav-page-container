<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 22.09.2018
 * Time: 10:59
 */

namespace Markocupic\NavPageContainer\Contao\Classes;


use Contao\PageModel;

class ParseTemplate
{
    public function parseTemplateHook($objTemplate)
    {
        // Check if login is allowed, if not replace the default error message
        if (TL_MODE === 'FE')
        {
            if (strpos($objTemplate->getName(), 'nav_') !== false)
            {
                global $objPage;

                $pageModel = PageModel::findByPk($objPage->id);
                if ($pageModel !== null)
                {
                    die($pageModel->alias);
                }
            }
        }
    }
}