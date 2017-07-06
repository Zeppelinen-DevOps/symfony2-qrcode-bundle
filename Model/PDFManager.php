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

use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;


/**
 * @author Steve [JS]Folio
 *
 */
class PDFManager implements ContainerAwareInterface
{

    use ContainerAwareTrait;
    use ControllerTrait;

    /**
     * @var string
     */
    protected $_rootDir;

    /**
     * PDFManager constructor.
     * @param ContainerInterface $container
     * @param $rootDir
     */
    function __construct(ContainerInterface $container, $rootDir)
    {
        $this->setContainer($container);
        $this->_rootDir = $rootDir;
    }

    /**
     * $vars = [
     *     'html'    => '' //Html content which will be processed to pdf
     *     'name'  => '' //PDF name
     * ]
     * @param array $vars
     * @return array
     */
    public function progressPDF($vars = [])
    {
        $pdf = $this->container->get('knp_snappy.pdf')->getOutputFromHtml($vars['html']);

        $fs = new Filesystem();

        $tmpSource = $this->_rootDir . '/../web/uploads/tmp';

        if (!is_dir($tmpSource))
        {
            $fs->mkdir($tmpSource, 0755);
        }
        $tmpSource = realpath($tmpSource);

        $source = $tmpSource . '/' .  $vars['name'] . '.pdf';

        file_put_contents($source, $pdf);
        return [
            'path' => $source,
            'pdf' => $pdf
        ];
    }
}