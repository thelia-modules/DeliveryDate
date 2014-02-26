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


namespace DeliveryDate\Controller;
use DeliveryDate\Model\ProductDateQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\Translation\Translator;
use Thelia\Model\ProductSaleElementsQuery;


/**
 * Class GetDeliveryDate
 * @package DeliveryDate\Controller 
 * @author Thelia <info@thelia.net>
 */
class GetDeliveryDate extends BaseFrontController {
    public function get($product_sale_element_id) {
        $date = ProductDateQuery::create()
            ->findPk($product_sale_element_id);

        /** @var \Thelia\Core\HttpFoundation\Session\Session $session */
        $session = $this->container->get('request')->getSession();
        $lang = $session->getLang();

        return JsonResponse::create(
            array(
                "date_min"=>$date->getDateMin($lang),
                "date_max"=>$date->getDateMax($lang),
                "quantity"=>ProductSaleElementsQuery::create()->findPk($product_sale_element_id)->getQuantity(),
                "msg"=>Translator::getInstance()->trans("Order this product today and receive it between the"),
                "msg_2"=>Translator::getInstance()->trans("and the")
            )
        );
    }
} 