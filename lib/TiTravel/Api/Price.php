<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class Price extends Model
{
    /**
     * Node names of basic compensations
     * @var array
     */
    protected $basicCompensations = array(
        'Label',
        'Name',
        'Description',
        'Amount',
        'Unit',
        'AgencyCommission'
    );

    public function fromXML(\SimpleXMLElement $property)
    {
        $this->setData(array(
            'property_id' => (int)$property['property_id'],
            'compensations' => array(
                'info' => $this->compensations2array($property->Compensations),
                'details' => $this->compensationsDetails2array($property->CompensationsDetail),
            ),
            'discounts' => array(
                'info' => $this->discounts2array($property->Discounts),
                'details' => $this->discountsDetails2array($property->DiscountsDetail),
            ),
            'services' => $this->services2array($property->Services),
        ));
    }

    protected function compensations2array(\SimpleXMLElement $compensations)
    {
        $ret = array();
        if (empty($compensations)) {
            return $ret;
        }
        foreach($compensations->children() as $compensation) {
            $ret[] = array(
                'label' => (string)$compensation->Label,
                'description' => (string)$compensation->Description,
            );
        }
        return $ret;
    }

    protected function compensationsDetails2array(\SimpleXMLElement $compensations)
    {
        $ret = array();
        if (empty($compensations)) {
            return $ret;
        }
        foreach($compensations->children() as $compensation) {
            $compensationData = array(
                'id' => (int)$compensation['id'],
                'type' => (string)$compensation['type'],
                'label' => (string)$compensation->Label,
                'name' => (string)$compensation->Name,
                'amount' => array(
                    'type' => (string)$compensation->Amount['type'],
                    'value' => (string)$compensation->Amount,
                ),
                'description' => (string)$compensation->Description,
                'unit' => array(
                    'type' => (string)$compensation->Unit['type'],
                    'label' => (string)$compensation->Unit,
                ),
                'agencyCommision' => (string)$compensation->AgencyCommission,
            );
            foreach ($compensation->children() as $child) {
                $name = $child->getName();
                if ($this->isBasicCompensation($name)) {
                    continue;
                }
                $name = lcfirst($name);
                $id = (int)$child['id'];
                $compensationData[$name] = array(
                    'label' => (string)$child,
                );
                if (!empty($id)) {
                    $compensationData[$name]['id'] = $id;
                }
            }
            $ret[] = $compensationData;
        }
        return $ret;
    }

    /**
     * Returns true if the compensation belongs to basic ones
     * @param  string  $compensation compensation name
     * @return boolean
     */
    protected function isBasicCompensation($compensation)
    {
        return in_array($compensation, $this->basicCompensations);
    }

    protected function discounts2array(\SimpleXMLElement $discounts)
    {
        $ret = array();
        if (empty($discounts)) {
            return $ret;
        }
        foreach($discounts->children() as $discount) {
            $ret[] = array(
                'label' => (string)$discount->Label,
                'value' => (string)$discount->Value,
            );
        }
        return $ret;
    }

    protected function discountsDetails2array(\SimpleXMLElement $discounts)
    {
        $ret = array();
        if (empty($discounts)) {
            return $ret;
        }
        foreach($discounts->children() as $discount) {
            $ret[] = array(
                'label' => (string)$discount->Label,
                'amount' => (string)$discount->Amount,
                'type' => (string)$discount->Amount['type'],
            );
        }
        return $ret;
    }

    protected function services2array(\SimpleXMLElement $services)
    {
        $ret = array();
        if (empty($services)) {
            return $ret;
        }
        foreach($services->children() as $service) {
            $ret[] = array(
                'label' => (string)$service->Label,
                'type' => (string)$service->Type,
                'persons' => (string)$service->NumberPerson,
                'minNights' => (string)$service->MinNights,
                'discounts' => $this->serviceDiscounts2array($service->Discounts),
                'periods' => $this->servicePeriods2array($service->Periods),
            );
        }
        return $ret;
    }

    protected function servicePeriods2array(\SimpleXMLElement $periods)
    {
        $ret = array();
        if (empty($periods)) {
            return $ret;
        }
        foreach($periods->children() as $period) {
            $ret[] = array(
                'id' => isset($period['id']) ? ((string) $period['id']) : '',
                'start' => (string)$period->Start,
                'end' => (string)$period->End,
                'reservationDay' => (string)$period->ReservationDay,
                'minNights' => (string)$period->MinNights,
                'price' => (string)$period->Price,
                'discountPrice' => isset($period->DiscountPrice) ? (string)$period->DiscountPrice : (string)$period->Price,
                'extraPerson' => (string)$period->ExtraPerson,
            );
        }
        return $ret;
    }

    protected function serviceDiscounts2array(\SimpleXMLElement $discounts) {
        $ret = array();

        if (empty($discounts)) {
            return $ret;
        }

        foreach ($discounts->children() as $discount) {
            $ret[] = array(
                "start" => (string)$discount->Start,
                "end" => (string)$discount->End,
                "percent" => (string)$discount->Percent
            );

        }

        return $ret;

    }

}
