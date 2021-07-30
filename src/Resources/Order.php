<?php

namespace GekoProducts\HttpClient\Resources;

use GekoProducts\HttpClient\Resources\Support\Contact;
use GekoProducts\HttpClient\Resources\Support\OrderLine;

class Order extends Resource
{
    protected $requiredAttributes = [
        "contacts",
        "contacts.billing",
        "contacts.shipping",
        "lines",
    ];

    /**
     * @param string $poNumber
     * @return $this
     */
    public function setPoNumber(string $poNumber)
    {
        $this->attributes["po_number"] = $poNumber;

        return $this;
    }

    /**
     * @param string $poDate
     * @return $this
     * format required: Y-m-d
     */
    public function setPoDate(string $poDate)
    {
        $this->attributes["po_date"] = $poDate;

        return $this;
    }

    /**
     * @param string $comments
     * @return $this
     */
    public function setComments(string $comments)
    {
        $this->attributes["comments"] = $comments;

        return $this;
    }

    /**
     * @param array[OrderLine] $orderLines
     * @return $this
     */
    public function setOrderLines(array $orderLines)
    {
        $this->attributes["lines"] = array_map(
            function (OrderLine $orderLine) {
                return $orderLine->toArray();
            },
            $orderLines
        );

        return $this;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function setBillingContact(Contact $contact)
    {
        $this->attributes["contacts"]["billing"] = $contact->toArray();

        return $this;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function setShippingContact(Contact $contact)
    {
        $this->attributes["contacts"]["shipping"] = $contact->toArray();

        return $this;
    }
}
