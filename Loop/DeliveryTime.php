<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/


namespace DeliveryDate\Loop;
use DeliveryDate\Model\ProductDateQuery;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;

use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\ProductSaleElementsQuery;


/**
 * Class DeliveryTime
 * @package DeliveryDate\Loop
 * @author Thelia <info@thelia.net>
 */
class DeliveryTime extends BaseLoop implements PropelSearchLoopInterface {

    protected $stock = 0;

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var \Thelia\Core\HttpFoundation\Session\Session $session */
        $session = $this->container->get('request')->getSession();
        $lang = $session->getLang();
        /** @var \DeliveryDate\Model\ProductDate $product_date */
        foreach($loopResult->getResultDataCollection() as $product_date) {
            $loopResultRow = new LoopResultRow();

            $parent = ProductSaleElementsQuery::create()
                ->findPk($this->getProductid());

            $quantity = 0;
            if($parent !== null) {
                $quantity = $parent->getQuantity();
            }

            $loopResultRow->set('DATE_MIN',$quantity ? $product_date->computeDeliveryTimeMin($lang):$product_date->computeRestockTimeMin($lang));
            $loopResultRow->set('DATE_MAX',$quantity ? $product_date->computeDeliveryTimeMax($lang):$product_date->computeRestockTimeMax($lang));

            $loopResultRow->set('QUANTITY', $quantity);

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    /**
     *
     * define all args used in your loop
     *
     *
     * example :
     *
     * public function getArgDefinitions()
     * {
     *  return new ArgumentCollection(
     *       Argument::createIntListTypeArgument('id'),
     *           new Argument(
     *           'ref',
     *           new TypeCollection(
     *               new Type\AlphaNumStringListType()
     *           )
     *       ),
     *       Argument::createIntListTypeArgument('category'),
     *       Argument::createBooleanTypeArgument('new'),
     *       Argument::createBooleanTypeArgument('promo'),
     *       Argument::createFloatTypeArgument('min_price'),
     *       Argument::createFloatTypeArgument('max_price'),
     *       Argument::createIntTypeArgument('min_stock'),
     *       Argument::createFloatTypeArgument('min_weight'),
     *       Argument::createFloatTypeArgument('max_weight'),
     *       Argument::createBooleanTypeArgument('current'),
     *
     *   );
     * }
     *
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument("productid",0)
        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $product_id = $this->getProductid();

        $search = ProductDateQuery::create()
            ->filterById($product_id);

        return $search;
    }
}