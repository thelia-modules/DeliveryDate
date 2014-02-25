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

namespace DeliveryDate\Form;


use DeliveryDate\Model\ProductDateQuery;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

/**
 * Class ConfigureForm
 * @package DeliveryDate\Form
 * @author Thelia <info@thelia.net>
 */
class ConfigureForm extends BaseForm {
    /**
     *
     * in this function you add all the fields you need for your Form.
     * Form this you have to call add method on $this->formBuilder attribute :
     *
     * $this->formBuilder->add("name", "text")
     *   ->add("email", "email", array(
     *           "attr" => array(
     *               "class" => "field"
     *           ),
     *           "label" => "email",
     *           "constraints" => array(
     *               new \Symfony\Component\Validator\Constraints\NotBlank()
     *           )
     *       )
     *   )
     *   ->add('age', 'integer');
     *
     * @return null
     */
    protected function buildForm()
    {
        $data = ProductDateQuery::create()
            ->getDefault();

        $this->formBuilder
            ->add("minidelivery", "text", array(
                'constraints'=>array(new NotBlank()),
                'data'=>$data->getDeliveryTimeMin(),
                'label'=>Translator::getInstance()->trans("Minimum delivery time (days)"),
                'label_attr'=>array("for"=>"minideliverytime")
            ))
            ->add("maxidelivery", "text", array(
                'constraints'=>array(new NotBlank()),
                'data'=>$data->getDeliveryTimeMax(),
                'label'=>Translator::getInstance()->trans("Maximum delivery time (days)"),
                'label_attr'=>array("for"=>"maxideliverytime")
            ))
            ->add("minirestock", "text", array(
                'constraints'=>array(new NotBlank()),
                'data'=>$data->getRestockTimeMin(),
                'label'=>Translator::getInstance()->trans("Minimum restock time (days)"),
                'label_attr'=>array("for"=>"minirestocktime")
            ))
            ->add("maxirestock", "text", array(
                'constraints'=>array(new NotBlank()),
                'data'=>$data->getRestockTimeMax(),
                'label'=>Translator::getInstance()->trans("Maximum restock time (days)"),
                'label_attr'=>array("for"=>"maxirestocktime")
            ))
        ;
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "deliverydateconfigureform";
    }

}