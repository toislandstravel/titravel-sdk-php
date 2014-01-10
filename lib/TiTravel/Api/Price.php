<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;

class Price extends Model
{
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
            $ret[] = array(
                'id' => (int)$compensation['id'],
                'type' => (string)$compensation['type'],
                'label' => (string)$compensation->Label,
                'name' => (string)$compensation->Name,
                'amount' => array(
                    'type' => (string)$compensation->Amount['type'],
                    'value' => (string)$compensation->Amount,
                ),
                'description' => (string)$compensation->Description,
                'code' => array(
                    'id' => (string)$compensation->Code['id'],
                    'label' => (string)$compensation->Code,
                ),
                'unit' => array(
                    'type' => (string)$compensation->Unit['type'],
                    'label' => (string)$compensation->Unit,
                ),
                'stayLessOrEqual' => (string)$compensation->StayLessOrEqual,
                'agencyCommision' => (string)$compensation->AgencyCommission,
            );
        }
        return $ret;
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
                'start' => (string)$period->Start,
                'end' => (string)$period->End,
                'reservationDay' => (string)$period->ReservationDay,
                'minNights' => (string)$period->MinNights,
                'price' => (string)$period->Price,
                'discountPrice' => (string)$period->DiscountPrice,
            );
        }
        return $ret;
    }
}