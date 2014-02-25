<?php

namespace DeliveryDate\Model;

use DeliveryDate\Model\Base\ProductDateQuery as BaseProductDateQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Model\Product;
use Thelia\Model\ProductSaleElements;


/**
 * Skeleton subclass for performing query and update operations on the 'product_date' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ProductDateQuery extends BaseProductDateQuery
{
    /**
     * @param ProductSaleElements $sale_element
     * @return array|ProductDate|null
     */
    public function getProductDate(ProductSaleElements $sale_element) {
        $ret = $this->findPk($sale_element->getId());

        if($ret->getId() === 0) {
            $ret = new ProductDate();
            $ret->setId($sale_element->getId());
        }

        return $ret;
    }

    /**
     * @param Product $product
     * @return array
     */
    public function getProductDates(Product $product) {
        $ret = array();

        foreach($product->getProductSaleElementss() as $sale_element) {
            $ret[]  = $this->getProductDate($sale_element);
        }

        return $ret;
    }

    /**
     * @param null $id
     * @param null $comparison
     * @return ProductDateQuery
     */
    public function filterById($id = null, $comparison = null)
    {
        $query = parent::filterById($id, $comparison); // TODO: Change the autogenerated stub
        if($query->findOne() === null) {
            $query = ProductDateQuery::create()->
                filterById(0, Criteria::EQUAL);
        }
        return $query;
    }


    /**
     * @param mixed $key
     * @param null $con
     * @return ProductDate|array
     */
    public function findPk($key, $con = null)
    {
        $query = parent::findPk($key, $con); // TODO: Change the autogenerated stub

        if($query === null) {
            $query = $this->getDefault();
        }

        return $query;
    }


    /**
     * @return array|ProductDate|mixed
     * @throws \Exception
     */
    public function getDefault() {
        $query = parent::findPk(0);

        if($query === null) {
            throw new \Exception("Default value has to be set before using the plugin");
        }

        return $query;
    }


} // ProductDateQuery
