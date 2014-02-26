<?php

namespace DeliveryDate\Model;

use DeliveryDate\Model\Base\ProductDate as BaseProductDate;
use Thelia\Model\Base\ProductSaleElementsQuery;
use Thelia\Model\Lang;
use Thelia\Model\ProductSaleElements;

class ProductDate extends BaseProductDate
{
    const DAY_IN_SEC = 86400;
    protected $real_id = 0;

    /**
     * @param int $real_id
     */
    public function setRealId($real_id)
    {
        $this->real_id = $real_id;
    }

    /**
     * @return int
     */
    public function getRealId()
    {
        return $this->real_id;
    }
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

    public function getDateMin(Lang $lang) {
        $ret = "";
        if($this->getParent()->getQuantity()) {
            $ret = $this->computeDeliveryTimeMin($lang);
        } else {
            $ret = $this->computeRestockTimeMin($lang);
        }
        return $ret;
    }

    public function getDateMax(Lang $lang) {
        $ret = "";
        if($this->getParent()->getQuantity()) {
            $ret = $this->computeDeliveryTimeMax($lang);
        } else {
            $ret = $this->computeRestockTimeMax($lang);
        }
        return $ret;
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
            ->findPk($this->getRealId());

        return $query;
    }
}
