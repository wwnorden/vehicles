<?php

namespace WWN\Vehicles;

use Page;

/**
 * VehicleArchivePage
 *
 * @package wwn-vehicles
 * @access public
 */
class VehicleArchivePage extends Page
{
    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return VehiclePageController::class;
    }
}
