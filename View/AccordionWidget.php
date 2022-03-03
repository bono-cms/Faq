<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Faq\View;

use Krystal\Widget\Bootstrap5\Accordion\AccordionMaker;

final class AccordionWidget
{
    /**
     * Renders accordion
     * 
     * @param array $faqs An array of entities
     * @param array $options Accordion options
     * @return string Rendered accordion
     */
    public static function render(array $faqs, array $options = [])
    {
        $items = [];

        foreach ($faqs as $faq) {
            $items[] = [
                'header' => $faq->getQuestion(), 
                'body' => $faq->getAnswer()
            ];
        }

        $accordion = new AccordionMaker($items, $options);
        return $accordion->render();
    }
}
