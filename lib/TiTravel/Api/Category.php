<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class Category extends Model
{
    public function fromXML(\SimpleXMLElement $category)
    {
        $this->id = (int)$category['id'];
        $this->parent_id = (int)$category['parent_id'];
        $this->title = (string)$category;
    }
}