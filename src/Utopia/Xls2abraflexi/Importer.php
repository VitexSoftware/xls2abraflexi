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

use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * This file is part of the vitexsoftware_xls2abralexi package.
 *
 * https://github.com/VitexSoftware/
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of Importer.
 *
 * @author Vitex <info@vitexsoftware.cz>
 */
class Importer extends \AbraFlexi\FakturaVydana
{
    public function import(string $inputDirectory): void
    {
        $files = glob($inputDirectory.'/excel/*.xlsx');

        foreach ($files as $file) {
            $customer = new Customer();
            $invoicer = new Invoice(['typDokl' => \AbraFlexi\Functions::code(\Ease\Shared::cfg('ABRAFLEXI_INVOICE_TYPE', 'FAKTURA'))]);
            $productor = new Product();
            $constantor = new ConstSym();

            $this->addStatusMessage('Loading: '.$file);
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();

            $customerName = $sheet->getCell('K5')->getCalculatedValue();
            $customerIC = $sheet->getCell('K11')->getCalculatedValue();

            $invoiceNumber = $sheet->getCell('M1')->getValue();
            $consSym = $sheet->getCell('E19')->getCalculatedValue();

            if ($constantor->recordExists(\AbraFlexi\Functions::code((string) $consSym)) === false) {
                $constantor->insertToAbraFlexi(['kod' => $consSym, 'nazev' => $consSym]);
                $constantor->addStatusMessage($consSym.' created', 'success');
            }

            if ($invoicer->isKnown($invoiceNumber) === false) {
                [$celkem, $currency] = explode(' ', $sheet->getCell('Q23')->getCalculatedValue());
                $this->addStatusMessage($invoiceNumber.' '.$customerName.' ic: '.$customerIC, 'success');
                $iban = $sheet->getCell('E18')->getCalculatedValue();

                $invoicer->setDataValue('varSym', $sheet->getCell('E20')->getCalculatedValue());
                $invoicer->setDataValue('konSym', \AbraFlexi\Functions::code((string) $consSym));
                $invoicer->setDataValue('kod', $invoiceNumber);

                if ($customer->isKnown($customerIC)) {
                    $customer->loadByIc($customerIC);
                } else {
                    $pscCity = $sheet->getCell('K10')->getCalculatedValue();
                    [$psc, $city] = explode(' ', $pscCity);

                    $dic = (string) $sheet->getCell('K12')->getCalculatedValue();

                    if (strstr($dic, ',')) {
                        [$dic] = explode(',', $dic);
                        $dic = trim($dic);
                    }

                    $customer->createNew([
                        'nazev' => $customerName,
                        'ulice' => $sheet->getCell('K8')->getCalculatedValue(),
                        'psc' => $psc,
                        'mesto' => $city,
                        'ic' => $customerIC,
                        'dic' => $dic,
                    ]);
                }

                $invoicer->setDataValue('firma', $customer);

                $row = 25;
                $items = [];

                while ($sheet->getCell('B'.$row)->getValue() !== null) {
                    $productor->dataReset();
                    $itemDescription = $sheet->getCell('B'.$row)->getValue();
                    $itemQuantity = $sheet->getCell('H'.$row)->getCalculatedValue();
                    $itemUnitPrice = $sheet->getCell('I'.$row)->getCalculatedValue();
                    $itemTotalPrice = $sheet->getCell('Q'.$row)->getCalculatedValue();

                    if (($itemQuantity === 0) || ((int) $itemUnitPrice === 0)) {
                        ++$row;
                        $invoicer->addStatusMessage('Skipping Item: '.$itemDescription.', Quantity: '.$itemQuantity.', Unit Price: '.$itemUnitPrice, 'warning');

                        continue;
                    }

                    [$ean, $itemName] = explode(' ', $itemDescription, 2);

                    if ($productor->recordExists(['eanKod' => $ean]) === false) {
                        $productor->createNew(
                            [
                                'eanKod' => $ean,
                                'nazev' => $itemName,
                            ],
                        );
                    } else {
                        $productor->loadByEan($ean);
                    }

                    $itemData = [
                        'cenik' => $productor->getRecordCode(),
                        'mnozMj' => $itemQuantity,
                        'cenaMj' => $itemUnitPrice,
                        'typCenyDphK' => 'typCeny.sDph',
                        'mena' => \AbraFlexi\Functions::code($currency),
                    ];

                    if ($productor->getDataValue('skladove')) {
                        $itemData['sklad'] = \AbraFlexi\Functions::code(\Ease\Shared::cfg('ABRAFLEXI_WAREHOUSE', 'SKLAD'));
                    }

                    $invoicer->addArrayToBranch($itemData);
                    $invoicer->addStatusMessage('Item: '.$itemDescription.', Quantity: '.$itemQuantity.', Unit Price: '.$itemUnitPrice.', Code: '.$productor);
                    ++$row;
                }

                $saved = $invoicer->sync();
                $this->addStatusMessage(_('New Invoice').': '.$invoicer->getRecordIdent(), $saved ? 'success' : 'error');
            } else {
                $invoicer->addStatusMessage('Skipping '.$invoiceNumber, 'warning');
            }
        }
    }
}
