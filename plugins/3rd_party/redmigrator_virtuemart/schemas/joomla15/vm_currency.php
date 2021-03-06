<?php
/**
 * @package     RedMIGRATOR.Backend
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2012 - 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * 
 *  redMIGRATOR is based on JUpgradePRO made by Matias Aguirre
 */

class RedMigratorVirtuemartCurrency extends RedMigrator
{
    public function dataHook($rows)
    {
        // Keep fields in new table (2.5.x or 3.x) which have values in old table (1.5.x)
        $arrFields = array('virtuemart_currency_id',
                            'currency_name',
                            'currency_code_2',
                            'currency_code_3'
                        );

        // Do some custom post processing on the list.
        foreach ($rows as &$row)
        {
            $row = (array) $row;

            // Change fields' name
            if (isset($row['currency_id']))
            {
                $row['virtuemart_currency_id'] = $row['currency_id'];
            }

            if (isset($row['currency_code']))
            {
                if (strlen(trim($row['currency_code'])) == 2)
                {
                    $row['currency_code_2'] = $row['currency_code'];
                }
                else
                {
                    $row['currency_code_3'] = $row['currency_code'];
                }
            }

            // Remove fields in old table which are not in new talbe
            foreach ($row as $key => $value)
            {
                if (!in_array($key, $arrFields))
                {
                    unset($row[$key]);
                }
            }
        }

        return $rows;
    }
}
?>