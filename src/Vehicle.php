<?php

namespace WWN\Vehicles;

use SilverStripe\CMS\Forms\SiteTreeURLSegmentField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\View\Requirements;

/**
 * Vehicle
 *
 * @package wwn-vehicles
 * @access  public
 */
class Vehicle extends DataObject
{
    /**
     * @var string
     */
    private static $table_name = 'WWNVehicle';

    /**
     * @var array $db
     */
    private static $db = [
        'Name' => 'Varchar(150)',
        'URLSegment' => 'Varchar(255)',
        'PagingName' => 'Varchar(150)',
        'Manufacturer' => 'Varchar(150)',
        'Model' => 'Varchar(150)',
        'Power' => 'Varchar(150)',
        'ConstructionYear' => 'Date',
        'Weight' => 'Varchar(150)',
        'Consolidation' => 'Varchar(150)',
        'Crew' => 'Varchar(150)',
        'Content' => 'HTMLText',
        'PeriodOfService' => 'Varchar(150)',
        'Sort' => 'Int',
    ];

    private static $has_one = [
        'Successor' => Vehicle::class,
    ];

    private static $belongs_to = [
        'Predecessor' => Vehicle::class,
    ];

    private static $has_many = [
        'VehicleImages' => VehicleImage::class,
    ];

    /**
     * @var array $indexes
     */
    private static $indexes = [
        'SearchFields' => [
            'type' => 'fulltext',
            'columns' => ['Name', 'Content'],
        ],
    ];

    /**
     * @var string $default_sort
     */
    private static $default_sort = [
        'Sort' => 'ASC',
        'ID' => 'DESC',
    ];

    /**
     * @var array $summary_fields
     */
    private static $summary_fields = [
        'Name',
        'PagingName',
        'ConstructionYearFormatted',
        'Crew',
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels(true);
        $labels['ConstructionYearFormatted'] =
            _t('WWN\Vehicles\Vehicle.db_ConstructionYear', 'ConstructionYear');

        return $labels;
    }

    /**
     * format ConstructionYear for overview
     *
     * @return false|string
     */
    public function getConstructionYearFormatted(): ?string
    {
        return date(
            'Y',
            strtotime($this->dbObject('ConstructionYear')->getValue())
        );
    }

    /**
     * @var array $searchable_fields
     */
    private static $searchable_fields = [
        'Name',
        'PagingName',
        'Content',
    ];

    /**
     * @return DataObject|void
     */
    public function populateDefaults()
    {
        parent::populateDefaults();
        $this->ConstructionYear = date('d.m.Y');
    }

    /**
     * @return RequiredFields
     */
    public function getCMSValidator(): RequiredFields
    {
        return RequiredFields::create('Name');
    }

    /**
     * link to backend edit form
     *
     * @return string|null
     */
    public function EditLink(): ?string
    {
        $editLink = false;
        if ($this->canEdit()) {
            $editLink = Director::baseURL()
                .'admin/vehicles/Vehicle/EditForm/field/Vehicle/item/'.$this->ID
                .'/edit/';
        }

        return $editLink;
    }

    /**
     * rewrite urlsegment and sorting
     */
    protected function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if ($this->Name) {
            $filter = URLSegmentFilter::create();
            $filteredTitle = $filter->filter($this->Name);

            // Fallback to generic page name if path is empty (= no valid, convertable characters)
            if (! $filteredTitle || $filteredTitle == '-'
                || $filteredTitle == '-1'
            ) {
                $filteredTitle = "page-$this->ID";
            }
            $this->URLSegment = $filteredTitle;
        }

        if (! $this->Sort) {
            $this->Sort = Vehicle::get()->max('Sort') + 1;
        }

        if ($this->SuccessorID) {
            $this->setClassName('WWN\Vehicles\VehicleArchive');
        }
    }

    /**
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        // remove undefined string from urlsegment in backend
        Requirements::javascript('wwnorden/vehicles:client/dist/js/urlsegmentfield.js');

        // Url segment
        $mainFields = array(
            'URLSegment' => SiteTreeURLSegmentField::create(
                'URLSegment',
                _t('WWN\Vehicles\Vehicle.db_URLSegment', 'URL-segment')
            ),
        );

        // Construction year
        $constructionYear = DateField::create(
            'ConstructionYear',
            _t('WWN\Vehicles\Vehicle.db_ConstructionYear', 'Construction year')
        )
            ->setHTML5(false)
            ->setDateFormat(
                _t('WWN\Vehicles\Vehicle.ConstructionYearFormat',
                    'MM/dd/yyyy'
                )
            );
        $constructionYear->setDescription(
            _t(
                'WWN\Vehicles\Vehicle.ConstructionYearDescription',
                'e.g. {format}',
                ['format' => $constructionYear->getDateFormat()]
            )
        );
        $constructionYear->setAttribute(
            'placeholder',
            $constructionYear->getDateFormat()
        );
        $mainFields['ConstructionYear'] = $constructionYear;

        $fields->addFieldsToTab('Root.Main', $mainFields);
        $fields->removeByName('Sort');

        return $fields;
    }

    /**
     * @return mixed|null
     */
    public function getVehiclePage()
    {
        if ($this->owner->ClassName === 'WWN\Vehicles\VehicleArchive') {
            $site = SiteTree::get()
                ->filter(['ClassName' => 'WWN\Vehicles\VehicleArchivePage'])
                ->first();
            if ($site && ! $site->ParentID) {
                return $site->URLSegment;
            } else {
                $topSite =
                    SiteTree::get()->filter(['ID' => $site->ParentID])->first();
                if ($topSite && $topSite->URLSegment) {
                    return $topSite->URLSegment.'/'.$site->URLSegment;
                }
            }
        } else {
            $site = SiteTree::get()
                ->filter(['ClassName' => 'WWN\Vehicles\VehiclePage'])->first();
            if ($site && ! $site->ParentID) {
                return $site->URLSegment;
            } else {
                $topSite =
                    SiteTree::get()->filter(['ID' => $site->ParentID])->first();
                if ($topSite && $topSite->URLSegment) {
                    return $topSite->URLSegment.'/'.$site->URLSegment;
                }
            }
        }
    }
}
