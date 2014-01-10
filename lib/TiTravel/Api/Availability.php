<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class Availability extends Model
{
    public function fromXML(\SimpleXMLElement $property)
    {
        $this->id = (int)$property['property_id'];
        $this->setData(array(
            'id' => $this->id,
            'availability' => $this->availability2array($property),
        ));
    }

    protected function availability2array(\SimpleXMLElement $property)
    {
        $periods = array();
        foreach ($property->children() as $period) {
            $periods[] = array(
                'from' => (string)$period->ArrivalDate,
                'to' => (string)$period->DepartureDate,
            );
        }
        return $periods;
    }
}