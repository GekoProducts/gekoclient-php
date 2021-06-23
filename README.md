# Geko Products PHP API Client

This library enables web apps to communicate with the Geko Products Restful API.

__The API Server and Client are still under active development.__

## Examples

### Creating an order:

```
$client = GekoClient::asOrg("YOUR_GEKO_ORG_ID");

// Setup a contact for shipping and billing information
($contact = new Contact())
    ->setFirstName("John")
    ->setLastName("Smith")
    ->setAddressLine1("20 Longbow Street")
    ->setCity("Chesterfield")
    ->setCountry("United Kingdom")
    ->setPostcode("DE451AA")
;

// Make the order object, attach the contact and set the order lines
($order = $client->order()->make())
    ->setShippingContact($contact)
    ->setBillingContact($contact)
    ->setOrderLines([
        (new OrderLine())->setSku("S-OR1423-D")
            ->setDetail("Super awesome cool product")
            ->setQuantity(2)
            ->setPrice(4.99)
    ])
;


// Finally, place the order
$placedOrder = $client->order()->place($order);
```
