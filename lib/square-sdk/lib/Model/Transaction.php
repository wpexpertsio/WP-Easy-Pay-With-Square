<?php
/**
 * Transaction
 *
 * PHP version 5
 *
 * @category Class
 * @package  SquareConnect
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
/**
 *  Copyright 2016 Square, Inc.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * Transaction Class Doc Comment
 *
 * @category    Class
 * @description Represents a transaction processed with Square, either with the Connect API or with Square Register.  The &#x60;tenders&#x60; field of this object lists all methods of payment used to pay in the transaction.
 * @package     SquareConnect
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Transaction implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'id' => 'string',
        'location_id' => 'string',
        'created_at' => 'string',
        'tenders' => '\SquareConnect\Model\Tender[]',
        'refunds' => '\SquareConnect\Model\Refund[]',
        'reference_id' => 'string',
        'product' => 'string',
        'client_id' => 'string',
        'order' => '\SquareConnect\Model\Order',
        'shipping_address' => '\SquareConnect\Model\Address'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'id' => 'id',
        'location_id' => 'location_id',
        'created_at' => 'created_at',
        'tenders' => 'tenders',
        'refunds' => 'refunds',
        'reference_id' => 'reference_id',
        'product' => 'product',
        'client_id' => 'client_id',
        'order' => 'order',
        'shipping_address' => 'shipping_address'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'id' => 'setId',
        'location_id' => 'setLocationId',
        'created_at' => 'setCreatedAt',
        'tenders' => 'setTenders',
        'refunds' => 'setRefunds',
        'reference_id' => 'setReferenceId',
        'product' => 'setProduct',
        'client_id' => 'setClientId',
        'order' => 'setOrder',
        'shipping_address' => 'setShippingAddress'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'id' => 'getId',
        'location_id' => 'getLocationId',
        'created_at' => 'getCreatedAt',
        'tenders' => 'getTenders',
        'refunds' => 'getRefunds',
        'reference_id' => 'getReferenceId',
        'product' => 'getProduct',
        'client_id' => 'getClientId',
        'order' => 'getOrder',
        'shipping_address' => 'getShippingAddress'
    );
  
    /**
      * $id The transaction's unique ID, issued by Square payments servers.
      * @var string
      */
    protected $id;
    /**
      * $location_id The ID of the transaction's associated location.
      * @var string
      */
    protected $location_id;
    /**
      * $created_at The time when the transaction was created, in RFC 3339 format.
      * @var string
      */
    protected $created_at;
    /**
      * $tenders The tenders used to pay in the transaction.
      * @var \SquareConnect\Model\Tender[]
      */
    protected $tenders;
    /**
      * $refunds Refunds that have been applied to any tender in the transaction.
      * @var \SquareConnect\Model\Refund[]
      */
    protected $refunds;
    /**
      * $reference_id If the transaction was created with the [Charge](#endpoint-charge) endpoint, this value is the same as the value provided for the `reference_id` parameter in the request to that endpoint. Otherwise, it is not set.
      * @var string
      */
    protected $reference_id;
    /**
      * $product The Square product that processed the transaction.
      * @var string
      */
    protected $product;
    /**
      * $client_id If the transaction was created in the Square Register app, this value is the ID generated for the transaction by Square Register.  This ID has no relationship to the transaction's canonical `id`, which is generated by Square's backend servers. This value is generated for bookkeeping purposes, in case the transaction cannot immediately be completed (for example, if the transaction is processed in offline mode).  It is not currently possible with the Connect API to perform a transaction lookup by this value.
      * @var string
      */
    protected $client_id;
    /**
      * $order The order associated with this transaction, if any.
      * @var \SquareConnect\Model\Order
      */
    protected $order;
    /**
      * $shipping_address The shipping address provided in the request, if any.
      * @var \SquareConnect\Model\Address
      */
    protected $shipping_address;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->id = $data["id"];
            $this->location_id = $data["location_id"];
            $this->created_at = $data["created_at"];
            $this->tenders = $data["tenders"];
            $this->refunds = $data["refunds"];
            $this->reference_id = $data["reference_id"];
            $this->product = $data["product"];
            $this->client_id = $data["client_id"];
            $this->order = $data["order"];
            $this->shipping_address = $data["shipping_address"];
        }
    }
    /**
     * Gets id
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
  
    /**
     * Sets id
     * @param string $id The transaction's unique ID, issued by Square payments servers.
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Gets location_id
     * @return string
     */
    public function getLocationId()
    {
        return $this->location_id;
    }
  
    /**
     * Sets location_id
     * @param string $location_id The ID of the transaction's associated location.
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    /**
     * Gets created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
  
    /**
     * Sets created_at
     * @param string $created_at The time when the transaction was created, in RFC 3339 format.
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    /**
     * Gets tenders
     * @return \SquareConnect\Model\Tender[]
     */
    public function getTenders()
    {
        return $this->tenders;
    }
  
    /**
     * Sets tenders
     * @param \SquareConnect\Model\Tender[] $tenders The tenders used to pay in the transaction.
     * @return $this
     */
    public function setTenders($tenders)
    {
        $this->tenders = $tenders;
        return $this;
    }
    /**
     * Gets refunds
     * @return \SquareConnect\Model\Refund[]
     */
    public function getRefunds()
    {
        return $this->refunds;
    }
  
    /**
     * Sets refunds
     * @param \SquareConnect\Model\Refund[] $refunds Refunds that have been applied to any tender in the transaction.
     * @return $this
     */
    public function setRefunds($refunds)
    {
        $this->refunds = $refunds;
        return $this;
    }
    /**
     * Gets reference_id
     * @return string
     */
    public function getReferenceId()
    {
        return $this->reference_id;
    }
  
    /**
     * Sets reference_id
     * @param string $reference_id If the transaction was created with the [Charge](#endpoint-charge) endpoint, this value is the same as the value provided for the `reference_id` parameter in the request to that endpoint. Otherwise, it is not set.
     * @return $this
     */
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;
        return $this;
    }
    /**
     * Gets product
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }
  
    /**
     * Sets product
     * @param string $product The Square product that processed the transaction.
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }
    /**
     * Gets client_id
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }
  
    /**
     * Sets client_id
     * @param string $client_id If the transaction was created in the Square Register app, this value is the ID generated for the transaction by Square Register.  This ID has no relationship to the transaction's canonical `id`, which is generated by Square's backend servers. This value is generated for bookkeeping purposes, in case the transaction cannot immediately be completed (for example, if the transaction is processed in offline mode).  It is not currently possible with the Connect API to perform a transaction lookup by this value.
     * @return $this
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }
    /**
     * Gets order
     * @return \SquareConnect\Model\Order
     */
    public function getOrder()
    {
        return $this->order;
    }
  
    /**
     * Sets order
     * @param \SquareConnect\Model\Order $order The order associated with this transaction, if any.
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
    /**
     * Gets shipping_address
     * @return \SquareConnect\Model\Address
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }
  
    /**
     * Sets shipping_address
     * @param \SquareConnect\Model\Address $shipping_address The shipping address provided in the request, if any.
     * @return $this
     */
    public function setShippingAddress($shipping_address)
    {
        $this->shipping_address = $shipping_address;
        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }
  
    /**
     * Gets offset.
     * @param  integer $offset Offset 
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
  
    /**
     * Sets value based on offset.
     * @param  integer $offset Offset 
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }
  
    /**
     * Unsets offset.
     * @param  integer $offset Offset 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
  
    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        } else {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
        }
    }
}
