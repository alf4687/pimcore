<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Model\GridConfig\Listing;

use Pimcore\Model;

/**
 * @internal
 *
 * @property \Pimcore\Model\GridConfig\Listing $model
 */
class Dao extends Model\Listing\Dao\AbstractDao
{
    /**
     * Loads a list of gridconfigs for the specicified parameters, returns an array of GridConfig elements
     *
     * @return array
     */
    public function load()
    {
        $gridConfigs = [];
        $data = $this->db->fetchAll('SELECT * FROM gridconfigs' . $this->getCondition() . $this->getOrder() . $this->getOffsetLimit(), $this->model->getConditionVariables());

        foreach ($data as $configData) {
            $gridConfig = new Model\GridConfig();
            $gridConfig->setValues($configData);
            $gridConfigs[] = $gridConfig;
        }

        $this->model->setGridConfigs($gridConfigs);

        return $gridConfigs;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        try {
            return (int) $this->db->fetchOne('SELECT COUNT(*) FROM gridconfigs ' . $this->getCondition(), $this->model->getConditionVariables());
        } catch (\Exception $e) {
            return 0;
        }
    }
}
