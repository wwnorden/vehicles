<?php

namespace WWN\Vehicles;

use Exception;
use PageController;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Convert;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\ArrayData;

/**
 * VehiclePage Controller
 *
 * @package wwn-vehicles
 */
class VehiclePageController extends PageController
{
    private static array $allowed_actions = [
        'showDetailVehicle',
    ];

    private static array $url_handlers = [
        '$URLSegment!' => 'showDetailVehicle',
    ];

    /**
     * Overview vehicles
     *
     * @throws Exception
     */
    public function PaginatedVehicles(int $length = 10): PaginatedList
    {
        $vehicles = Vehicle::get()->filter(['ClassName' => Vehicle::class]);
        $pages = new PaginatedList($vehicles, $this->getRequest());

        return $pages->setPageLength($length);
    }

    /**
     * Overview archived vehicles
     *
     * @throws Exception
     */
    public function PaginatedArchivedVehicles(int $length = 10): PaginatedList
    {
        $vehicles = VehicleArchive::get()->filter(['ClassName' => VehicleArchive::class]);
        $pages = new PaginatedList($vehicles, $this->getRequest());

        return $pages->setPageLength($length);
    }

    /**
     * Detail view
     *
     * @throws Exception
     */
    public function showDetailVehicle(): DBHTMLText
    {
        $name = Convert::raw2sql($this->getRequest()->param('URLSegment'));
        $filter = [
            'URLSegment' => $name,
        ];

        $vehicle = Vehicle::get()->filter($filter)->first();
        $customise = [
            'Vehicle' => $vehicle,
            'ExtraBreadcrumb' => ArrayData::create(
                [
                    'Title' => $vehicle->Name,
                    'Link' => $this->Link($name),
                ]
            ),
            'Name' => $vehicle->Name,
        ];

        $renderWith = [
            'WWN/Vehicles/VehicleDetail',
            'Page',
        ];

        return $this->customise($customise)->renderWith($renderWith);
    }

    public function VehiclePagePath(): ?string
    {
        return $this->getPagePath('WWN\Vehicles\VehiclePage');
    }

    public function VehicleArchivePagePath(): ?string
    {
        return $this->getPagePath('WWN\Vehicles\VehicleArchivePage');
    }

    private function getPagePath(string $pageClassNamespace): string
    {
        $site = SiteTree::get()
            ->filter(['ClassName' => $pageClassNamespace])->first();
        if (!$site) {
            return '';
        }

        return $this->getPagePathById($site->ParentID, $site->URLSegment);
    }

    /**
     * recursive page path function
     */
    private function getPagePathById(int $id, string $url = ''): string
    {
        $site = SiteTree::get()->filter(['ID' => $id])->first();
        if (!$site) {
            return $url;
        }

        if (!$site->ParentID) {
            return $site->URLSegment . '/' . $url;
        } else {
            $url = $site->URLSegment . '/' . $url;
            $this->getPagePathById($site->ParentID, $url);
        }
    }
}
