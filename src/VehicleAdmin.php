<?php

namespace WWN\Vehicles;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\DataList;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Administration Vehicles
 *
 * @package wwn-vehicles
 * @access  public
 */
class VehicleAdmin extends ModelAdmin
{
    private static $menu_icon_class = 'font-icon-sync';

    /**
     * @var string $menu_title
     */
    private static $menu_title = 'Fahrzeuge';

    /**
     * @var string $url_segment
     */
    private static $url_segment = 'fahrzeuge';

    /**
     * @var array $managed_models
     */
    private static $managed_models = array(
        'WWN\Vehicles\Vehicle',
        'WWN\Vehicles\VehicleArchive',
    );

    /**
     * @param null $id
     * @param null $fields
     *
     * @return Form
     */
    public function getEditForm($id = null, $fields = null): Form
    {
        $form = parent::getEditForm($id, $fields);
        $model = singleton($this->modelClass);

        if (class_exists(GridFieldOrderableRows::class)
            && $model->hasField('Sort')
        ) {
            $gridField = $form->Fields()
                ->dataFieldByName($this->sanitiseClassName($this->modelClass));
            if ($gridField instanceof GridField) {
                $gridField->getConfig()
                    ->addComponent(new GridFieldOrderableRows('Sort'));
            }
        }

        return $form;
    }

    /**
     * @return DataList
     */
    public function getList(): DataList
    {
        $list = parent::getList();

        // exclude archived vehicles
        $model = $this->getRequest()->params()['ModelClass'];
        if (! isset($model) || $model === 'WWN-Vehicles-Vehicle') {
            $list = $list->exclude('ClassName', VehicleArchive::class);
        }

        return $list;
    }
}
