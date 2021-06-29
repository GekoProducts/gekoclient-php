<?php

namespace GekoProducts\HttpClient\Tests\Unit\Resources\Support;

use GekoProducts\HttpClient\Resources\Support\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase {

    private function contact()
    {
        return new Contact();
    }

    public function testToArrayReturnsArray()
    {
        $contact = $this->contact();

        $this->assertIsArray($contact->toArray());
    }

    public function testToArrayHasRequiredAttributes()
    {
        $contact = $this->contact();

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("first_name", $attributes);
        $this->assertArrayHasKey("last_name", $attributes);
        $this->assertArrayHasKey("address_line_1", $attributes);
        $this->assertArrayHasKey("city", $attributes);
        $this->assertArrayHasKey("postcode", $attributes);
        $this->assertArrayHasKey("country", $attributes);
    }

    public function testItCanSetFirstName()
    {
        $contact = $this->contact();

        $contact->setFirstName("John");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("first_name", $attributes);
        $this->assertSame("John", $attributes["first_name"]);
    }

    public function testItCanSetLastName()
    {
        $contact = $this->contact();

        $contact->setLastName("Smith");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("last_name", $attributes);
        $this->assertSame("Smith", $attributes["last_name"]);
    }

    public function testItCanSetCompanyName()
    {
        $contact = $this->contact();

        // optional field
        $this->assertArrayNotHasKey("company_name", $contact->toArray());
        $contact->setCompanyName("ACME Ltd");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("company_name", $attributes);
        $this->assertSame("ACME Ltd", $attributes["company_name"]);
    }

    public function testItCanSetAddressLine1()
    {
        $contact = $this->contact();

        $contact->setAddressLine1("20 Longbow Street");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("address_line_1", $attributes);
        $this->assertSame("20 Longbow Street", $attributes["address_line_1"]);
    }

    public function testItCanSetAddressLine2()
    {
        $contact = $this->contact();

        // optional field
        $this->assertArrayNotHasKey("address_line_2", $contact->toArray());

        $contact->setAddressLine2("Baslow");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("address_line_2", $attributes);
        $this->assertSame("Baslow", $attributes["address_line_2"]);
    }

    public function testItCanSetCity()
    {
        $contact = $this->contact();

        $contact->setCity("Chesterfield");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("city", $attributes);
        $this->assertSame("Chesterfield", $attributes["city"]);
    }

    public function testItCanSetPostcode()
    {
        $contact = $this->contact();

        $contact->setPostcode("DE451AA");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("postcode", $attributes);
        $this->assertSame("DE451AA", $attributes["postcode"]);
    }

    public function testItCanSetCountry()
    {
        $contact = $this->contact();

        $contact->setCountry("United Kingdom");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("country", $attributes);
        $this->assertSame("United Kingdom", $attributes["country"]);
    }

    public function testItCanSetEmail()
    {
        $contact = $this->contact();

        // optional field
        $this->assertArrayNotHasKey("email", $contact->toArray());
        $contact->setEmail("john.smith@geko-client.local");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("email", $attributes);
        $this->assertSame("john.smith@geko-client.local", $attributes["email"]);
    }

    public function testItCanSetPhone()
    {
        $contact = $this->contact();

        // optional field
        $this->assertArrayNotHasKey("phone", $contact->toArray());
        $contact->setPhone("+447890000000");

        $attributes = $contact->toArray();

        $this->assertArrayHasKey("phone", $attributes);
        $this->assertSame("+447890000000", $attributes["phone"]);
    }
}
