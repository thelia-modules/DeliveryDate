<?php

namespace DeliveryDate\Model;

use DeliveryDate\Model\Base\ProductDate as BaseProductDate;
use Thelia\Model\Base\ProductSaleElementsQuery;
use Thelia\Model\Lang;

class ProductDate extends BaseProductDate
{
    const DAY_IN_SEC = 86400;

    /**
     * @param $days
     * @param null|int $time
     */
    protected function computeTime($days, $timestamp=null) {

        if($timestamp === null) {
            $timestamp = time();
        }

        return $timestamp + self::DAY_IN_SEC * $days;
    }

    protected function getFormat(Lang $lang) {
        return $lang->getDateFormat();
    }

    /**
     * @param Lang $lang
     * @return bool|string
     */
    public function computeDeliveryTimeMin(Lang $lang) {

        return date(
            $this->getFormat($lang),
            $this->computeTime($this->getDeliveryTimeMin())
        );
    }

    /**
     * @param Lang $lang
     * @return bool|string
     */
    public function computeDeliveryTimeMax(Lang $lang) {
        return date(
            $this->getFormat($lang),
            $this->computeTime($this->getDeliveryTimeMax())
        );
    }

    /**
     * @param Lang $lang
     * @return bool|string
     */
    public function computeRestockTimeMin(Lang $lang) {

        return date(
            $this->getFormat($lang),
            $this->computeTime($this->getRestockTimeMin())
        );
    }

    /**
     * @param Lang $lang
     * @return bool|string
     */
    public function computeRestockTimeMax(Lang $lang) {
        return date(
            $this->getFormat($lang),
            $this->computeTime($this->getRestockTimeMax())
        );
    }

    /**
     * @return array|mixed|\Thelia\Model\ProductSaleElements
     */
    public function getParent() {
        $query = ProductSaleElementsQuery::create()
            ->findPk($this->getId());

        return $query;
    }
}
