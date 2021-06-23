<?php

namespace GekoProducts\HttpClient\Resources\Support;

class OrderLine {

    /**
     * @var string $sku
     */
    private $sku;

    /**
     * @var string $detail
     */
    private $detail;

    /**
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @var float $price
     */
    private $price;

    /**
     * @param string $sku
     */
    public function setSku(string $sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @param string $detail
     */
    public function setDetail(string $detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "sku" => $this->sku,
            "detail" => $this->detail,
            "quantity" => $this->quantity,
            "price" => $this->price,
        ];
    }
}
