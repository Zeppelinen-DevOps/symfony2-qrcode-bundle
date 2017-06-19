<?php
/**
 * Copyright (C) 2017 [JS]Folio
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


namespace Uc\QCodeBundle\Model;

use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;


/**
 * @author Steve [JS]Folio
 *
 */
class QCodeManager
{

    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     * QCodeManager constructor.
     * @param Kernel $kernel
     */
    function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * $vars = [
     *     'code' => '' // Encode string,
     *     'orderId' => '' // Order ID
     * ]
     * @param array $vars
     * @return string
     */
    public function generateQCode($vars = [])
    {
        $qrCode = new QrCode($vars['code']);
        $qrCode
            ->setSize(150)
            ->setWriterByName('svg')
            ->setMargin(2)
            ->setLabel('Scan the code', 16, $this->kernel->getRootDir() . '/../web/bundles/ucqcode/fonts/noto_sans.otf', LabelAlignment::CENTER);

        $fs = new Filesystem();

        $tmpSource = $this->kernel->getRootDir() . '/../web/uploads/tmp';

        if (!is_dir($tmpSource))
        {
            $fs->mkdir($tmpSource, 0755);
        }
        $tmpSource = realpath($tmpSource);
        $fileName = $vars['orderId'] . date('dmY') . '.svg';
        $filePath = $tmpSource . '/' . $fileName;
        $qrCode->writeFile($filePath);

        return '/uploads/tmp' . '/' . $fileName;
    }
}