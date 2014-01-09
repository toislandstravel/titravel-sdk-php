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
            $att = array(
                'id' => $id,
                'title' => (string)$group['title'],
                'attributes' => array(),
            );
            if (empty($group->Attributes)) {
                continue;
            }
            foreach ($group->Attributes->children() as $attribute) {
                $id = (string)$attribute['id'];
                $info = array(
                    'id' => $id,
                    'type' => (string)$attribute['type'],
                    'title' => (string)$attribute['title'],
                    'values' => array(),
                );
                if ($attribute->count()) {
                    foreach ($attribute->children() as $value) {
                        $info['values'][] = array(
                            'id' => (string)$value['id'],
                            'title' => (string)$value,
                        );
                    }
                }
                $att['attributes'][] = $info;
            }
            $attributes[] = $att;
        }
        return $attributes;
    }
}