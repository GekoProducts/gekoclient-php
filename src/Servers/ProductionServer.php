<?php

namespace GekoProducts\HttpClient\Servers;

class ProductionServer extends Server {

    protected $address = "https://api.gekoproducts.co.uk";

    /**
     * ProductionServer constructor.
     * @param string $orgId
     */
    public function __construct(string $orgId)
    {
        parent::__construct($orgId, $this->address);
    }
}
