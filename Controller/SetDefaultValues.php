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
use DeliveryDate\Form\ConfigureForm;
use DeliveryDate\Model\ProductDateQuery;
use Thelia\Controller\Admin\BaseAdminController;

/**
 * Class SetDefaultValues
 * @package DeliveryDate\Controller
 * @author Thelia <info@thelia.net>
 */
class SetDefaultValues extends BaseAdminController
{
    public function set()
    {
        $errmes = "";

        try {
            $form = new ConfigureForm($this->getRequest());
            $vform = $this->validateForm($form);

            $minidelivery = $vform->get('minidelivery')->getData();
            $maxidelivery = $vform->get('maxidelivery')->getData();
            $minirestock = $vform->get('minirestock')->getData();
            $maxirestock = $vform->get('maxirestock')->getData();

            if (preg_match("#^\d+$#", $minidelivery) &&
                preg_match("#^\d+$#", $maxidelivery) &&
                preg_match("#^\d+$#", $minirestock) &&
                preg_match("#^\d+$#", $maxirestock))
            {
                ProductDateQuery::create()
                    ->getDefault()
                    ->setDeliveryTimeMin($minidelivery)
                    ->setDeliveryTimeMax($maxidelivery)
                    ->setRestockTimeMin($minirestock)
                    ->setRestockTimeMax($maxirestock)
                    ->save();
            } else {
                throw new \Exception("Les valeurs doivent être des nombres");
            }
        } catch (\Exception $e) {
            $errmes = $e->getMessage();
        }

        $this->redirectToRoute("admin.module.configure",array("errmes"=>$errmes),
            array ( 'module_code'=>"DeliveryDate",
                '_controller' => 'Thelia\\Controller\\Admin\\ModuleController::configureAction'));
    }
}
