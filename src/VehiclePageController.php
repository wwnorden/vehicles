<?php

namespace WWN\Vehicles;

use Exception;
use PageController;
use SilverStripe\Core\Convert;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\ArrayData;

/**
 * VehiclePage Controller
 *
 * @package wwn-vehicles
 * @access  public
 */
class VehiclePageController extends PageController
{
    private static $allowed_actions = [
        'showDetailvehicle',
    ];

    private static $url_handlers = [
        '$URLSegment!' => 'showDetailvehicle',
    ];

    /**
     * Overview
     *
     * @return PaginatedList
     * @throws Exception
     */
    public function PaginatedVehicles()
    {
        $vehicles = Vehicle::get()->filter(['ClassName' => Vehicle::class]);
        return new PaginatedList($vehicles, $this->getRequest());
    }

    /**
     * Overview archive
     *
     * @return PaginatedList
     * @throws Exception
     */
    public function PaginatedArchivedVehicles()
    {
        $vehicles = VehicleArchive::get();
        return new PaginatedList($vehicles, $this->getRequest());
    }

    /**
     * Detail view
     *
     * @return DBHTMLText
     * @throws Exception
     */
    public function showDetailvehicle(): DBHTMLText
    {
        $name = Convert::raw2sql($this->getRequest()->param('URLSegment'));
        $filter = array(
            'URLSegment' => $name,
        );

        $vehicle = Vehicle::get()->filter($filter)->first();
        $customise = array(
            'Vehicle' => $vehicle,
            'ExtraBreadcrumb' => ArrayData::create(
                [
                    'Title' => $vehicle->Name,
                    'Link' => $this->Link($name),
                ]
            ),
            'Name' => $vehicle->Name,
        );

        $renderWith = array(
            'WWN/Vehicles/VehicleDetail',
            'Page',
        );

        return $this->customise($customise)->renderWith($renderWith);
    }
}
