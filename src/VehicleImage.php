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
 * @access public
 */
class VehicleImage extends DataObject implements PermissionProvider
{
    /**
     * @var string
     */
    private static $table_name = 'WWNVehicleImage';

    /**
     * @var array $db
     */
    private static $db = array(
        'Title' => 'Varchar(150)',
        'SortOrder' => 'Int',
        'Cover' => 'Boolean',
    );

    /**
     * @var array $has_one
     */
    private static $has_one = array(
        'Vehicle' => Vehicle::class,
        'Image' => Image::class,
    );

    /**
     * @var string|array $default_sort
     */
    private static $default_sort = 'SortOrder';

    /**
     * @var array $field_labels
     */
    private static $field_labels = array(
        'Title' => 'Titel',
        'Thumbnail' => 'Vorschau',
    );

    /**
     * @var array $searchable_fields
     */
    private static $searchable_fields = array(
        'Title',
    );

    /**
     * @var array $summary_fields
     */
    private static $summary_fields = array(
        'Title',
        'Thumbnail',
        'Cover',
    );

    /**
     * @var array $owns
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
            ).'/'. str_replace(['/',',','.',' ','_','(',')'],'-',$this->Vehicle->Name)
        );

        return $fields;
    }

    /**
     * @return Image
     */
    public function getThumbnail()
    {
        return $this->Image()->CMSThumbnail();
    }

    public function canView($member = null)
    {
        if (!$member) {
            $member = Member:: currentUser();
        }
        return Permission:: checkMember($member, 'VehicleImage_VIEW');
    }

    public function canEdit($member = false)
    {
        if (!$member) {
            $member = Member:: currentUser();
        }
        return Permission:: checkMember($member, 'VehicleImage_EDIT');
    }

    public function canCreate($member = false, $context = array())
    {
        if (!$member) {
            $member = Member:: currentUser();
        }
        return Permission:: checkMember($member, 'VehicleImage_CREATE');
    }

    public function canDelete($member = false)
    {
        if (!$member) {
            $member = Member:: currentUser();
        }
        return Permission:: checkMember($member, 'VehicleImage_DELETE');
    }

    public function providePermissions()
    {
        return array(
            'VehicleImage_VIEW' => 'Einsatzbilder ansehen',
            'VehicleImage_EDIT' => 'Einsatzbilder bearbeiten',
            'VehicleImage_CREATE' => 'Einsatzbilder erstellen',
            'VehicleImage_DELETE' => 'Einsatzbilder löschen'
        );
    }

    /**
     * set sortorder
     */
    protected function onBeforeWrite()
    {
        if (! $this->SortOrder) {
            $this->SortOrder = VehicleImage::get()->max('SortOrder') + 1;
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

