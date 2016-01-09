<?php
/*
 * This file is part of the Hierarchy package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace {

    class WP_Error
    {
    }

    class WP_Query
    {
        public $true;
        public $object;
        public $post = null;

        public function __construct(array $true = [], $object = null, array $vars = [])
        {
            $this->true = $true;
            $this->object = $object ?: new \stdClass();
            $this->vars = $vars;
        }

        public function get_queried_object()
        {
            return $this->object;
        }

        public function get($var)
        {
            return isset($this->vars[$var]) ? $this->vars[$var] : '';
        }

        public function __call($name, $arguments)
        {
            if (! array_key_exists($name, $this->true)) {
                return false;
            }

            $want = $this->true[$name];

            return empty($arguments) || $want === true || $want === $arguments;
        }
    }

}

namespace GM\Hierarchy\Tests\Stubs {

    use GM\Hierarchy\Branch\BranchInterface;
    use WP_Query;

    class BranchStubFoo implements BranchInterface
    {
        public function name()
        {
            return 'foo';
        }

        public function is(WP_Query $query)
        {
            return true;
        }

        /**
         * @return array
         */
        public function leaves(WP_Query $query)
        {
            return ['foo', 'bar'];
        }
    }

    class BranchStubBar implements BranchInterface
    {
        public function name()
        {
            return 'bar';
        }

        public function is(WP_Query $query)
        {
            return true;
        }

        /**
         * @return array
         */
        public function leaves(WP_Query $query)
        {
            return ['baz', 'bar'];
        }
    }

    class BranchStubBar2 implements BranchInterface
    {
        public function name()
        {
            return 'bar';
        }

        public function is(WP_Query $query)
        {
            return true;
        }

        /**
         * @return array
         */
        public function leaves(WP_Query $query)
        {
            return ['a', 'b', 'c'];
        }
    }

    class BranchStubBaz implements BranchInterface
    {
        public function name()
        {
            return 'baz';
        }

        public function is(WP_Query $query)
        {
            return false;
        }

        /**
         * @return array
         */
        public function leaves(WP_Query $query)
        {
            return ['1', '2', 3];
        }
    }
}
