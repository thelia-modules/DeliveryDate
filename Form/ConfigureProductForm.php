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
use DeliveryDate\Model\Base\ProductDateQuery;
use Thelia\Form\BaseForm;
use Thelia\Model\ProductQuery;
use Thelia\Core\Translation\Translator;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ConfigureProductForm
 * @package DeliveryDate\Form
 * @author Thelia <info@thelia.net>
 */
class ConfigureProductForm extends BaseForm
{
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
        $request = $this->getRequest();

        $product_id = $request->query->get("product_id");
        $product = ProductQuery::create()
            ->findPk($product_id);

        if ($product === null) {
            throw new \Exception("You must use give a GET parameter called product_id and put a valid value in.");
        }

        foreach ($product->getProductSaleElementss() as $sale_element) {
            $data = ProductDateQuery::create()
                ->findPk($sale_element->getId());

            $this->formBuilder
                ->add($sale_element->getId()."minidelivery", "text", array(
                    'constraints'=>array(new NotBlank()),
                    'data'=>$data->getDeliveryTimeMin(),
                    'label'=>Translator::getInstance()->trans("Minimum delivery time (days)"),
                    'label_attr'=>array("for"=>$sale_element->getId()."minideliverytime")
                ))
                ->add($sale_element->getId()."maxidelivery", "text", array(
                    'constraints'=>array(new NotBlank()),
                    'data'=>$data->getDeliveryTimeMax(),
                    'label'=>Translator::getInstance()->trans("Maximum delivery time (days)"),
                    'label_attr'=>array("for"=>$sale_element->getId()."maxideliverytime")
                ))
                ->add($sale_element->getId()."minirestock", "text", array(
                    'constraints'=>array(new NotBlank()),
                    'data'=>$data->getRestockTimeMin(),
                    'label'=>Translator::getInstance()->trans("Minimum restock time (days)"),
                    'label_attr'=>array("for"=>$sale_element->getId()."minirestocktime")
                ))
                ->add($sale_element->getId()."maxirestock", "text", array(
                    'constraints'=>array(new NotBlank()),
                    'data'=>$data->getRestockTimeMax(),
                    'label'=>Translator::getInstance()->trans("Maximum restock time (days)"),
                    'label_attr'=>array("for"=>$sale_element->getId()."maxirestocktime")
                ))
            ;
        }

    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "configureproductform";
    }

}
