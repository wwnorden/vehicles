<?php

namespace WWN\Vehicles;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;

/**
 * VehicleImage
 *
 * @package wwn-vehicles
 * @property string $Title
 * @property int    $SortOrder
 * @property bool   $Cover
 * @property string $Content
 * @property string $Category
 */
class VehicleImage extends DataObject implements PermissionProvider
{
    /**
     * @var string
     */
    private static $table_name = 'WWNVehicleImage';

    /**
     * @var string[]
     */
    private static $db = [
        'Title' => 'Varchar(150)',
        'SortOrder' => 'Int',
        'Content' => 'HTMLText',
        'Cover' => 'Boolean',
        'Category' => 'Enum("Vehicle,EquipmentRoom", "Vehicle")',
    ];

    /**
     * @var string[]
     */
    private static $has_one = [
        'Vehicle' => Vehicle::class,
        'Image' => Image::class,
    ];

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder';

    /**
     * @var string[]
     */
    private static $field_labels = [
        'Title' => 'Titel',
        'Thumbnail' => 'Vorschau',
    ];

    /**
     * @var string[]
     */
    private static $searchable_fields = [
        'Title',
    ];

    /**
     * @var string[]
     */
    private static $summary_fields = [
        'Title',
        'Thumbnail',
        'Cover',
        'Category',
    ];

    /**
     * @var string[]
     */
    private static $owns = [
        'Image',
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('VehicleID');
        $fields->removeByName('SortOrder');

        $image = $fields->dataFieldByName('Image');
        $image->setFolderName(
            _t(
                'WWN\Vehicles\Extensions\VehiclesSiteConfigExtension.Foldername',
                'Foldername'
            ).'/'.str_replace(['/', ',', '.', ' ', '_', '(', ')'], '-', $this->Vehicle->Name)
        );

        return $fields;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->Image()->CMSThumbnail();
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canView($member = null)
    {
        if (! $member) {
            $member = Member:: currentUser();
        }

        return Permission:: checkMember($member, 'VehicleImage_VIEW');
    }

    /**
     * @param false $member
     *
     * @return bool|int
     */
    public function canEdit($member = false)
    {
        if (! $member) {
            $member = Member:: currentUser();
        }

        return Permission:: checkMember($member, 'VehicleImage_EDIT');
    }

    /**
     * @param false $member
     * @param array $context
     *
     * @return bool|int
     */
    public function canCreate($member = false, $context = [])
    {
        if (! $member) {
            $member = Member:: currentUser();
        }

        return Permission:: checkMember($member, 'VehicleImage_CREATE');
    }

    /**
     * @param false $member
     *
     * @return bool|int
     */
    public function canDelete($member = false)
    {
        if (! $member) {
            $member = Member:: currentUser();
        }

        return Permission:: checkMember($member, 'VehicleImage_DELETE');
    }

    /**
     * @return string[]
     */
    public function providePermissions()
    {
        return [
            'VehicleImage_VIEW' => 'Einsatzbilder ansehen',
            'VehicleImage_EDIT' => 'Einsatzbilder bearbeiten',
            'VehicleImage_CREATE' => 'Einsatzbilder erstellen',
            'VehicleImage_DELETE' => 'Einsatzbilder löschen',
        ];
    }

    /**
     * set sortorder and title
     */
    protected function onBeforeWrite()
    {
        if (! $this->SortOrder) {
            $this->SortOrder = VehicleImage::get()->max('SortOrder') + 1;
        }

        if (empty($this->Title)) {
            $this->Title = $this->owner->Image()->Title ?? $this->owner->Image()->Name;
        }

        parent::onBeforeWrite();
    }

    /**
     * publish images afterwards
     */
    public function onAfterWrite()
    {
        if ($this->owner->ImageID) {
            $this->owner->Image()->publishSingle();
        }

        parent::onAfterWrite();
    }
}

