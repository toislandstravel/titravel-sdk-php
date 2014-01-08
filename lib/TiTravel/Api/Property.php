<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class Property extends Model
{
    public function fromXML(\SimpleXMLElement $property)
    {
        $this->id = (int)$property['property_id'];
        $this->unit_type = (string)$property['unit_type'];
        $this->update_property = (string)$property['update_property'];
        $this->update_prices = (string)$property['update_prices'];
        $this->update_availability = (string)$property['update_availability'];
    }
}