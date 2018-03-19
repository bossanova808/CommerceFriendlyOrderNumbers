<?php
/**
 * CommerceFriendlyOrderNumbers plugin for Craft CMS
 *
 * CommerceFriendlyOrderNumbers Service
 *
 * @author    Jeremy Daalder
 * @copyright Copyright (c) 2016 Jeremy Daalder
 * @link      https://github.com/bossanova808
 * @package   CommerceFriendlyOrderNumbers
 * @since     0.0.1
 */

namespace Craft;

class CommerceFriendlyOrderNumbersService extends BaseApplicationComponent
{

    /**
     * Supply the latest unused firendly order number because Commerce order numbers suck for clients
     *
     * @param $increment=true - whether to return the next (new) number, or the current latest (used) order number.  Defaults to next.
     * @return integer
     */
    public function getNextOrderNumber($increment=true)
    {
        if($increment){

            $current = craft()->db->createCommand()
                ->select('orderNumber')
                ->from('commercefriendlyordernumbers_ordernumber')
                ->where('id = 1')
                ->queryColumn();
            $current = reset($current);
            
            $currentStored = craft()->db->createCommand()
                ->select('field_friendlyOrderNumber')
                ->from('content')
                ->where('field_friendlyOrderNumber=:field_friendlyOrderNumber', array(':field_friendlyOrderNumber' => $current))
                ->queryColumn();
            $currentStored = reset($currentStored);
            
            // no entry found with current number; use same number without actually incrementing
            if (empty($currentStored)) {
                return $current;
            }

            craft()->db->createCommand()->setText('update craft_commercefriendlyordernumbers_ordernumber set orderNumber = orderNumber + 1 where id=1')->execute();
        }

        $result = craft()->db->createCommand()->setText('select orderNumber from craft_commercefriendlyordernumbers_ordernumber where id=1')->queryAll();
        $result = $result[0]['orderNumber'];
        return $result;
    
    }

    /**
     * 
     * Sets the Friendly Order Number to the order just as it is saved
     * @param $event
     * @throws Exception
     * @throws \Exception
     * @param $event
     */
    public function onBeforeOrderCompleteHandler($event){

        $order = $event->params['order'];  
        
        $orderNumber = $this->getNextOrderNumber();
        $order->setContentFromPost(array(
            'friendlyOrderNumber' => $orderNumber,
        ));
        craft()->commerce_orders->saveOrder($order);

    }

}
