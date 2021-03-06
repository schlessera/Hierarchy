<?php
/*
 * This file is part of the Hierarchy package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brain\Hierarchy\Finder;

use ArrayIterator;

/**
 * Very similar the way WordPress core works, however, it allows to search templates arbitrary
 * folders and to use a custom file extension (default to php). By default, stylesheet and template
 * folders and file extension to php, so it acts exactly like core.
 *
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package Hierarchy
 */
final class FoldersTemplateFinder implements TemplateFinderInterface
{
    use FindFirstTemplateTrait;

    /**
     * @var \ArrayIterator
     */
    private $folders;

    /**
     * @var string
     */
    private $extension;

    /**
     * @param array  $folders
     * @param string $extension
     */
    public function __construct(array $folders = [], $extension = 'php')
    {
        if (empty($folders)) {
            $stylesheet = get_stylesheet_directory();
            $template = get_template_directory();
            $folders = [$stylesheet];
            ($stylesheet !== $template) and $folders[] = $template;
        }

        $this->folders = array_map('trailingslashit', $folders);
        $this->extension = $extension;
    }

    /**
     * @inheritdoc
     */
    public function find($template, $type)
    {
        foreach ($this->folders as $folder) {
            if (file_exists($folder.$template.'.'.$this->extension)) {
                return $folder.$template.'.'.$this->extension;
            }
        }

        return '';
    }
}
