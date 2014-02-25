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
use DeliveryDate\Form\ConfigureProductForm;
use DeliveryDate\Model\ProductDateQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Base\ProductQuery;
use Thelia\Tools\Redirect;
use Thelia\Tools\URL;


/**
 * Class SetProductValues
 * @package DeliveryDate\Controller 
 * @author Thelia <info@thelia.net>
 */
class SetProductValues extends BaseAdminController {
    public function set($product_id) {
        $errmes="";

        try {
            /*
             * Check if product exists
             */
            $product = ProductQuery::create()
                ->findPk($product_id);
            if($product === null) {
                throw new \Exception("This product doesn't exist");
            }

            /*
             * Validate form
             */
            $form = new ConfigureProductForm($this->getRequest());
            $vform = $this->validateForm($form);

            /*
             * Validate values
             */
            $product_dates = ProductDateQuery::create()
                ->getProductDates($product);

            $entries = array("minidelivery","maxidelivery","minirestock","maxirestock");
            /** @var \DeliveryDate\Model\ProductDate $product_date */
            foreach($product_dates as $product_date) {
                $form_entries = array();
                $cond = true;

                foreach($entries as $entry) {
                    $form_entries[$entry] = ($tmp=$vform->get($product_date->getId().$entry)->getData());
                    $cond &= preg_match("#^\d+$#",$tmp);
                }

                if($cond) {
                    /*
                     * If everything is valid, save the entry ! ;)
                     */
                    $product_date
                        ->setDeliveryTimeMin($form_entries["minidelivery"])
                        ->setDeliveryTimeMax($form_entries["maxidelivery"])
                        ->setRestockTimeMin($form_entries["minirestock"])
                        ->setRestockTimeMax($form_entries["maxirestock"])
                        ->save();
                } else {
                    throw new \Exception("Your values must be numbers.");
                }
            }
        } catch(\Exception $e) {
            $errmes = $e->getMessage();
        }

        Redirect::exec(
            URL::getInstance()->absoluteUrl(
                $this->getRoute(
                    "admin.products.update",
                    array(
                        "product_id"=>$product_id,
                        "current_tab"=>"modules",
                        "errmes"=>$errmes,
                    )
                )
            )
        );
    }
} 