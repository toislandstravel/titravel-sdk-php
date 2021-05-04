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
        // if the property update info is found,
        // property details are not available
        if ($lastUpdate) {
            $this->update_property = $lastUpdate;
            $this->update_prices = (string)$property['update_prices'];
            $this->update_availability = (string)$property['update_availability'];
            return;
        }

        $lat = (float)$property->Location->ObjectLatitude;
        $coordinates = !$lat ? array() : array(
            'lat' => $lat,
            'lng' => (float)$property->Location->ObjectLongitude,
        );
        $location = $property->Location;
        $this->setData(array(
            'id' => $this->id,
            'unit_type' => $this->unit_type,
            'name' => (string)$location->UnitName,
            'last_update' => (string)$property['last_update'],
            'photo_base' => (string)$property['photo_base'],
            'url' => (string)$property->URL,
            'location' => array(
                'object' => array(
                    'id' => (int)$location->ObjectID,
                    'name' => (string)$location->ObjectName,
                    'coordinates' => $coordinates,
                ),
                'category' => array(
                    'id' => (int)$location->CategoryID,
                    'name' => (string)$location->Category,
                ),
                'city' => array(
                    'id' => (int)$location->CityID,
                    'name' => (string)$location->City,
                ),
                'region' => array(
                    'id' => (int)$location->RegionID,
                    'name' => (string)$location->Region,
                ),
                'country' => (string)$location->Country,
                'address' => (string)$location->Address,
            ),
            'attributes' => array(
                'object' => $this->xmlAttributes2Array($property->Attributes->Object),
                'unit' => $this->xmlAttributes2Array($property->Attributes->Unit),
            ),
            'photos' => array(
                'object' => $this->xmlPhotos2Array($property->ObjectPhotos),
                'unit' => $this->xmlPhotos2Array($property->UnitPhotos),
            ),
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
            if (empty($group->Values)) {
                continue;
            }
            foreach ($group->Values->children() as $attribute) {
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

    /**
     * Returns the XML photos as array
     * @param  SimpleXMLElement $sxe the xml photos node
     * @return array
     */
    protected function xmlPhotos2Array(\SimpleXMLElement $sxe)
    {
        if (empty($sxe)) {
            return array();
        }
        $photos = array();
        foreach ($sxe->children() as $photo) {
            $photos[] = array(
                'url' => (string)$photo->URL,
                'description' => (string)$photo->Description,
            );
        }
        return $photos;
    }
}