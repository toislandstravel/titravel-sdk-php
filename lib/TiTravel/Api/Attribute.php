<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class Attribute extends Model
{
    public function fromXML(\SimpleXMLElement $attribute)
    {
        $this->id = (int)$attribute['id'];
        $this->title = (string)$attribute['title'];
        $this->setData(array(
            'id' => $this->id,
            'title' => $this->title,
            'object' => $this->xmlAttributes2Array($attribute->Object),
            'unit' => $this->xmlAttributes2Array($attribute->Unit),
        ));
    }

    /**
     * Returns the XML attributes as array
     * @param  SimpleXMLElement $sxe the xml attributes node
     * @return array
     */
    protected function xmlAttributes2Array(\SimpleXMLElement $sxe)
    {
        if (empty($sxe)) {
            return array();
        }
        $attributes = array();
        foreach ($sxe->children() as $group) {
            $id = (string)$group['id'];
            $attributes[$id] = array(
                'label' => (string)$group->Summary['label'],
                'summary' => (string)$group->Summary,
                'attributes' => array(),
            );
            if (empty($group->Attributes)) {
                continue;
            }
            foreach ($group->Attributes->children() as $attribute) {
                $values = (string)$attribute;
                if ($attribute->count()) {
                    $values = array();
                    foreach ($attribute->children() as $value) {
                        $values[(string)$value['id']] = (string)$value;
                    }
                }
                $attributes[$id]['attributes'][(string)$attribute['id']] = $values;
            }
        }
        return $attributes;
    }
}