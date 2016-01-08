<?php
/*
 * This file is part of the Hierarchy package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GM\Hierarchy\Branch;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package Hierarchy
 */
final class BranchTag implements BranchInterface
{
    /**
     * @inheritdoc
     */
    public function name()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function is(\WP_Query $query)
    {
        return $query->is_tag();
    }

    /**
     * @inheritdoc
     */
    public function leaves()
    {
        /** @var \stdClass $term */
        $term = get_queried_object();

        if ( ! isset($term->slug) || ! isset($term->term_id)) {
            return ['tag'];
        }

        return [
            "tag-{$term->slug}",
            "tag-{$term->term_id}",
            'tag'
        ];
    }
}