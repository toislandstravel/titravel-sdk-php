<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class CompensationCode extends Model
{
    public function fromXML(\SimpleXMLElement $compensation)
    {
        $this->id = (int)$compensation['id'];
        $this->code = (int)$compensation['code'];
        $this->description = (string)$compensation->Description;
        $this->compensations = explode(',', trim((string)$compensation->Ids,','));
        $this->value = (string)$compensation->Value;
    }
}