<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class Compensation extends Model
{
    public function fromXML(\SimpleXMLElement $compensation)
    {
        $this->id = (int)$compensation['id'];
        $this->kat = (int)$compensation['kat'];
        $this->title = (string)$compensation;
    }
}