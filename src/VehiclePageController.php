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
    /**
     * @var string[]
     */
    private static $allowed_actions = [
        'showDetailvehicle',
    ];

    /**
     * @var string[]
     */
    private static $url_handlers = [
        '$URLSegment!' => 'showDetailvehicle',
    ];

    /**
     * Overview
     *
     * @param int $length
     *
     * @return PaginatedList
     * @throws Exception
     */
    public function PaginatedVehicles($length = 10): PaginatedList
    {
        $vehicles = Vehicle::get()->filter(['ClassName' => Vehicle::class]);
        $pages = new PaginatedList($vehicles, $this->getRequest());

        return $pages->setPageLength($length);
    }

    /**
     * Overview archive
     *
     * @return PaginatedList
     * @throws Exception
     */
    public function PaginatedArchivedVehicles(): PaginatedList
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

    /**
     * @return mixed|string|null
     */
    public function VehiclePagePath(): ?string
    {
        return $this->getPagePath('WWN\Vehicles\VehiclePage');
    }

    /**
     * @return mixed|string|null
     */
    public function VehicleArchivePagePath(): ?string
    {
        return $this->getPagePath('WWN\Vehicles\VehicleArchivePage');
    }

    /**
     * @param string $pageClassNamespace
     *
     * @return string
     */
    private function getPagePath($pageClassNamespace): string
    {
        $site = SiteTree::get()
            ->filter(['ClassName' => $pageClassNamespace])->first();
        if (! $site) {
            return '';
        }

        return $this->getPagePathById($site->ParentID, $site->URLSegment);
    }

    /**
     * recursive page path function
     *
     * @param integer $id
     * @param string  $url
     *
     * @return string
     */
    private function getPagePathById($id, $url = ''): string
    {
        $site = SiteTree::get()->filter(['ID' => $id])->first();
        if (! $site) {
            return $url;
        }

        if ($site && ! $site->ParentID) {
            $url = $site->URLSegment.'/'.$url;

            return $url;
        } else {
            $url = $site->URLSegment.'/'.$url;
            $this->getPagePathById($site->ParentID, $url);
        }
    }
}
