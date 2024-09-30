<?php

declare(strict_types=1);

/**
 * This file is part of the xls2abralexi package
 *
 * https://multiflexi.eu/
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Utopia\Xls2abralexi;

/**
 * Description of Customer.
 *
 * @author Vitex <info@vitexsoftware.cz>
 */
class Customer extends \AbraFlexi\Adresar
{
    public function isKnown($customerIC)
    {
        return $this->recordExists(['ic' => $customerIC]);
    }

    public function createNew($customerInfo)
    {
        return $this->addStatusMessage(sprintf(_('Saving New Customer'), $customerInfo['nazev']), $this->sync($customerInfo) ? 'success' : 'error');
    }

    public function loadByIc($customerIC)
    {
        $candidat = $this->getColumnsFromAbraFlexi('kod', ['ic' => $customerIC]);

        return $this->loadFromAbraFlexi(\AbraFlexi\Functions::code($candidat[0]['kod']));
    }

    // put your code here
}
