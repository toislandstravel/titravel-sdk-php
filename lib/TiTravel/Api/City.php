<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class City extends Model
{
    public function fromXML(\SimpleXMLElement $city)
    {
        $this->id = (int)$city['id'];
        $this->parent_id = (int)$city['parent_id'];
        $this->zip = (int)$city['zip'];
        $this->title = (string)$city;
    }
}