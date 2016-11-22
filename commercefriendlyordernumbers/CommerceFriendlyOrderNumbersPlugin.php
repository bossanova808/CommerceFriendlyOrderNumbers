<?php
/**
 * CommerceFriendlyOrderNumbers plugin for Craft CMS
 *
 * Allows you to use friendly, consecutive order numbers instead of the default Commerce order numbers.
 *
 * @author    Jeremy Daalder
 * @copyright Copyright (c) 2016 Jeremy Daalder
 * @link      https://github.com/bossanova808
 * @package   CommerceFriendlyOrderNumbers
 * @since     0.0.1
 */

namespace Craft;

class CommerceFriendlyOrderNumbersPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
        craft()->on('commerce_orders.onBeforeOrderComplete', 
            [
                craft()->commerceFriendlyOrderNumbers,
                "onBeforeOrderCompleteHandler"
            ]
        );        
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Commerce Friendly Order Numbers');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('Allows you to use friendly, consecutive order numbers instead of the default Commerce order numbers.');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/bossanova808/commercefriendlyordernumbers/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/bossanova808/commercefriendlyordernumbers/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '0.0.2';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '0.0.1';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Jeremy Daalder';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'https://github.com/bossanova808';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     */
    public function onBeforeInstall()
    {
        //Create the world's simplest table - holds one number
        craft()->db->createCommand()->createTable("commercefriendlyordernumbers_ordernumber",["id"=>"pk","orderNumber"=>"int"]);
        craft()->db->createCommand()->insert("commercefriendlyordernumbers_ordernumber",["id"=>"1","orderNumber"=>"0"]);
    }

    /**
     */
    public function onAfterInstall()
    {
    }

    /**
     */
    public function onBeforeUninstall()
    {
        //Tidy up after ourselves
        craft()->db->createCommand()->dropTable("commercefriendlyordernumbers_ordernumber");
    }

    /**
     */
    public function onAfterUninstall()
    {
    }


}