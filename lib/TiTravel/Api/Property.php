<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class Property extends Model
{
    public function fromXML(\SimpleXMLElement $property)
    {
        $this->id = (int)$property['property_id'];
        $this->unit_type = (string)$property['unit_type'];
        $lastUpdate = (string)$property['update_property'];
        // if it's only property info, don't parse other data
        if ($lastUpdate) {
            $this->update_property = $lastUpdate;
            $this->update_prices = (string)$property['update_prices'];
            $this->update_availability = (string)$property['update_availability'];
            return;
        }
    }
}