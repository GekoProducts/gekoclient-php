<?php

namespace GekoProducts\HttpClient\Resources\Support;

class Contact {

    /**
     * @var string $firstName
     */
    private $firstName;

    /**
     * @var string $lastName
     */
    private $lastName;

    /**
     * @var string $companyName
     */
    private $companyName;

    /**
     * @var string $addressLine1
     */
    private $addressLine1;

    /**
     * @var string $addressLine2
     */
    private $addressLine2;

    /**
     * @var string $city
     */
    private $city;

    /**
     * @var string $postcode
     */
    private $postcode;

    /**
     * @var string $country
     */
    private $country;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $phone
     */
    private $phone;

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @param string $addressLine1
     */
    public function setAddressLine1(string $addressLine1)
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    /**
     * @param string $addressLine2
     */
    public function setAddressLine2(string $addressLine2)
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode(string $postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $attributes = [
            "first_name" => $this->firstName,
            "last_name" => $this->lastName,
            "address_line_1" => $this->addressLine1,
            "city" => $this->city,
            "postcode" => $this->postcode,
            "country" => $this->country,
        ];

        // These fields are optional, and not included unless set
        if (! is_null($this->companyName) && strlen(trim($this->companyName)) > 0) {
            $attributes["company_name"] = $this->companyName;
        }

        if (! is_null($this->addressLine2) && strlen(trim($this->addressLine2)) > 0) {
            $attributes["address_line_2"] = $this->addressLine2;
        }

        if (! is_null($this->email) && strlen(trim($this->email)) > 0) {
            $attributes["email"] = $this->email;
        }

        if (! is_null($this->phone) && strlen(trim($this->phone)) > 0) {
            $attributes["phone"] = $this->phone;
        }

        return $attributes;
    }
}
