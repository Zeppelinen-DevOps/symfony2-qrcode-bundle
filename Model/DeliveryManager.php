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
use Symfony\Component\HttpKernel\Kernel;


/**
 * @author Steve [JS]Folio
 *
 */
class DeliveryManager
{
    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     * DeliveryManager constructor.
     * @param Kernel $kernel
     */
    function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * $vars = [
     *     'sender'    => '' //Email sender
     *     'recipient' => '' //Email recipient
     *     'subject'   => '' //Email subject
     *     'body'      => '' //Email body
     *     'pdf'       => '' //Attachment pdf file
     * ]
     * @param array $vars
     */
    function onSendEmail($vars = [])
    {
        $formData = array(
            'from_email' => $vars['sender'],
            'email' => $vars['recipient'],
            'subject' => $vars['subject'],
            'body' => $vars['body']
        );

        $template = $this->kernel->getContainer()->get('sfk_email_template.loader')
            ->load('UcQCodeBundle:Email:OnlineOrder.html.twig', $formData);
        $message = \Swift_Message::newInstance()
            ->setSubject($template->getSubject())
            ->setFrom($template->getFrom())
            ->setBody($template->getBody(), 'text/html')
            ->setTo($formData['email'])
            ->attach(\Swift_Attachment::fromPath($vars['pdf']));
        // send email
        $mailer = $this->kernel->getContainer()->get('mailer');
        $mailer->send($message);
    }
}