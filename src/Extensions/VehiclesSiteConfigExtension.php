<?php

namespace WWN\Vehicles\Extensions;

use SilverStripe\Assets\Folder;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataExtension;

/**
 * Vehicle settings
 *
 * @package wwn-vehicles
 * @access public
 */
class VehiclesSiteConfigExtension extends DataExtension
{
    /**
     * @var array $has_one
     */
    private static $has_one = array(
        'VehiclesImageUploadFolder' => Folder::class,
    );

    /**
     * Set upload folder for vehicles
     *
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        Folder::find_or_make(
            _t(
                'WWN\Vehicles\Extensions\VehiclesSiteConfigExtension.Foldername',
                'Foldername'
            )
        );

        $fields->findOrMakeTab(
            'Root.Uploads',
            _t(
                'WWN\Vehicles\Extensions\VehiclesSiteConfigExtension.SITECONFIGMENUTITLE',
                'Uploads'
            )
        );

        $vehiclesFields = array(
            'VehiclesImageUploadFolderID' => TreeDropdownField::create(
                'VehiclesImageUploadFolderID',
                _t(
                    'WWN\Vehicles\Extensions\VehiclesSiteConfigExtension.has_one_VehiclesImageUploadFolder',
                    'Vehicle images'
                ),
                Folder::class
            ),
        );
        $fields->addFieldsToTab('Root.Uploads', $vehiclesFields);
        $vehiclesHeaders = array(
            'VehiclesImageUploadFolderID' => _t(
                'WWN\Vehicles\Extensions\VehiclesSiteConfigExtension.UploadFolders',
                'UploadFolders'
            ),
        );
        foreach ($vehiclesHeaders as $insertBefore => $header) {
            $fields->addFieldToTab(
                'Root.Uploads',
                HeaderField::create($insertBefore.'Header', $header),
                $insertBefore
            );
        }
    }
}
