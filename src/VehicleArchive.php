<?php

namespace WWN\Vehicles;

use SilverStripe\Control\Director;

/**
 * VehicleArchive
 *
 * @package wwn-vehicles
 * @access public
 */
class VehicleArchive extends Vehicle
{
    /**
     * link to backend edit form
     *
     * @return string|null
     */
    public function EditLink(): ?string
    {
        $editLink = false;
        if ($this->canEdit()) {
            $editLink = Director::baseURL() . 'admin/vehicles/VehicleArchive/EditForm/field/VehicleArchive/item/' . $this->ID . '/edit/';
        }
        return $editLink;
    }
}
