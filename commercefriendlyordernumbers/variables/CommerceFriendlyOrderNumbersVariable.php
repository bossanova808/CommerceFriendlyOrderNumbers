<?php
/**
 * CommerceFriendlyOrderNumbers plugin for Craft CMS
 *
 * CommerceFriendlyOrderNumbers Variable
 *
 * @author    Jeremy Daalder
 * @copyright Copyright (c) 2016 Jeremy Daalder
 * @link      https://github.com/bossanova808
 * @package   CommerceFriendlyOrderNumbers
 * @since     0.0.1
 */

namespace Craft;

class CommerceFriendlyOrderNumbersVariable
{
    /** Returns the latest used order number
     */
    public function latestOrderNumber()
    {
        return craft()->commerceFriendlyOrderNumbers->getNextOrderNumber(false);
    }
 
}